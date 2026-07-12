<?php

namespace Askdkc\Breezejp\Commands;

use Illuminate\Filesystem\Filesystem;

trait InstallSvelteI18n
{
    /**
     * Svelte/HTML attribute names whose literal English values should be translated.
     */
    protected string $svelteI18nAttributes = 'placeholder|aria-label|alt|title|description|label|loadingLabel|separator';

    public function svelteKitDetected(): bool
    {
        $packageJson = base_path('package.json');

        return file_exists($packageJson)
            && str_contains((string) file_get_contents($packageJson), '@inertiajs/svelte');
    }

    public function maybeOfferSvelteI18n(): void
    {
        if ($this->svelteKitDetected() && $this->confirm('Svelteテンプレートも日本語化しますか？', true)) {
            $this->installSvelteI18n();
        }
    }

    /**
     * Patch the Svelte starter kit so its templates render through Laravel translations.
     */
    public function installSvelteI18n(): int
    {
        $this->info('Svelteテンプレートを日本語化(ランタイム翻訳化)します');
        $this->line('resources/js 以下の .svelte ファイルを書き換えます');

        (new Filesystem)->ensureDirectoryExists(resource_path('js/lib'));
        copy(__DIR__.'/../../stubs/js/i18n.ts', resource_path('js/lib/i18n.ts'));

        $this->shareTranslationsViaInertia();

        $keys = $this->translationKeys();
        $patched = 0;

        foreach ($this->svelteFiles() as $file) {
            if ($this->patchSvelteFile($file, $keys)) {
                $this->line('  patched: '.ltrim(str_replace(base_path(), '', $file), '/'));
                $patched++;
            }
        }

        $this->info("Svelteテンプレートの日本語化が完了しました! (patched: {$patched} files)");

        return self::SUCCESS;
    }

    /**
     * Share lang/{locale}.json through Inertia props via HandleInertiaRequests.
     */
    protected function shareTranslationsViaInertia(): void
    {
        $path = base_path('app/Http/Middleware/HandleInertiaRequests.php');

        if (! file_exists($path)) {
            $this->warn('app/Http/Middleware/HandleInertiaRequests.php が見つからないため、translationsの共有をスキップします');

            return;
        }

        $contents = (string) file_get_contents($path);

        if (str_contains($contents, "'translations'")) {
            $this->info('translations は既に共有済みです');

            return;
        }

        $anchor = '...parent::share($request),';

        if (! str_contains($contents, $anchor)) {
            $this->warn('HandleInertiaRequests::share() に想定アンカーが無いため、translationsの共有をスキップします（手動で追加してください）');

            return;
        }

        $injection = <<<'PHP'
...parent::share($request),
            'translations' => fn (): array => is_file(lang_path(app()->getLocale().'.json'))
                ? json_decode((string) file_get_contents(lang_path(app()->getLocale().'.json')), true, 512, JSON_THROW_ON_ERROR)
                : [],
PHP;

        file_put_contents($path, str_replace($anchor, $injection, $contents));
        $this->info('HandleInertiaRequests に translations の共有を追加しました');
    }

    /**
     * Catalog keys, longest first so anchored patterns never hit substrings of longer keys.
     *
     * @return list<string>
     */
    protected function translationKeys(): array
    {
        $catalog = file_exists(lang_path('ja.json'))
            ? lang_path('ja.json')
            : __DIR__.'/../../stubs/lang/ja.json';

        $keys = array_keys(json_decode((string) file_get_contents($catalog), true) ?? []);

        usort($keys, fn (string $a, string $b): int => strlen($b) <=> strlen($a));

        return $keys;
    }

    /**
     * @return list<string>
     */
    protected function svelteFiles(): array
    {
        if (! is_dir(resource_path('js'))) {
            return [];
        }

        $files = [];

        foreach ((new Filesystem)->allFiles(resource_path('js')) as $file) {
            if ($file->getExtension() === 'svelte') {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    /**
     * @param  list<string>  $keys
     */
    protected function patchSvelteFile(string $path, array $keys): bool
    {
        $original = (string) file_get_contents($path);

        $contents = $this->applyFileOverrides(basename($path), $original);
        $contents = $this->applyRenderSitePatches(basename($path), $contents);

        [$contents, $masked] = $this->maskModuleScripts($contents);

        foreach ($keys as $key) {
            $contents = $this->patchAttributes($contents, $key);
            $contents = $this->patchMarkupText($contents, $key);
            $contents = $this->patchJsLiterals($contents, $key);
        }

        $contents = strtr($contents, $masked);

        if ($contents === $original) {
            return false;
        }

        $contents = $this->ensureHelperImport($contents);

        file_put_contents($path, $contents);

        return true;
    }

    /**
     * Interpolated or tag-split texts that the generic passes cannot match.
     * Keyed by file basename: [search text (spaces match any whitespace), replacement].
     *
     * @return array<string, list<array{string, string}>>
     */
    protected function fileOverrides(): array
    {
        return [
            'PasskeyItem.svelte' => [
                [
                    'Added {passkey.created_at_diff}',
                    "{t('Added :time', { time: passkey.created_at_diff })}",
                ],
                [
                    'Last used {passkey.last_used_at_diff}',
                    "{t('Last used :time', { time: passkey.last_used_at_diff })}",
                ],
                [
                    'Are you sure you want to remove the "{passkey.name}" passkey? You will no longer be able to use it to sign in.',
                    "{t('Are you sure you want to remove the \":name\" passkey? You will no longer be able to use it to sign in.', { name: passkey.name })}",
                ],
            ],
            'TwoFactorRecoveryCodes.svelte' => [
                [
                    "{isRecoveryCodesVisible ? 'Hide' : 'View'} recovery codes",
                    "{isRecoveryCodesVisible ? t('Hide recovery codes') : t('View recovery codes')}",
                ],
                [
                    'Each recovery code can be used once to access your account and will be removed after use. If you need more, click <span class="font-bold">Regenerate codes</span> above.',
                    "{t('Each recovery code can be used once to access your account and will be removed after use. If you need more, click Regenerate codes above.')}",
                ],
            ],
            'Welcome.svelte' => [
                [
                    'Laravel has an incredibly rich ecosystem. <br />We suggest starting with the following.',
                    "{t('Laravel has an incredibly rich ecosystem. We suggest starting with the following.')}",
                ],
            ],
        ];
    }

    protected function applyFileOverrides(string $basename, string $contents): string
    {
        foreach ($this->fileOverrides()[$basename] ?? [] as [$search, $replace]) {
            if (str_contains($contents, $replace)) {
                continue;
            }

            $pattern = '/'.str_replace(' ', '\s+', preg_quote($search, '/')).'/';

            $contents = preg_replace_callback(
                $pattern,
                fn (): string => $replace,
                $contents
            ) ?? $contents;
        }

        return $contents;
    }

    /**
     * Texts defined in <script module> constants (layout titles, nav items, breadcrumbs)
     * are translated where they are rendered, not where they are defined.
     */
    protected function applyRenderSitePatches(string $basename, string $contents): string
    {
        $patches = [
            'Breadcrumbs.svelte' => ['{item.title}' => '{t(item.title)}'],
            'NavMain.svelte' => ['{item.title}' => '{t(item.title)}'],
            'NavFooter.svelte' => ['{item.title}' => '{t(item.title)}'],
            'AppHeader.svelte' => ['{item.title}' => '{t(item.title)}'],
            'AuthSimpleLayout.svelte' => ['{title}' => '{t(title)}', '{description}' => '{t(description)}'],
            'AuthCardLayout.svelte' => ['{title}' => '{t(title)}', '{description}' => '{t(description)}'],
            'AuthSplitLayout.svelte' => ['{title}' => '{t(title)}', '{description}' => '{t(description)}'],
        ];

        return strtr($contents, $patches[$basename] ?? []);
    }

    /**
     * Mask <script module> blocks: t() must not run at module scope where
     * Inertia page props are not initialized yet.
     *
     * @return array{string, array<string, string>}
     */
    protected function maskModuleScripts(string $contents): array
    {
        $masked = [];

        $contents = preg_replace_callback(
            '/<script\s+module\b.*?<\/script>/s',
            function (array $match) use (&$masked): string {
                $token = '___BREEZEJP_MODULE_'.count($masked).'___';
                $masked[$token] = $match[0];

                return $token;
            },
            $contents
        ) ?? $contents;

        return [$contents, $masked];
    }

    protected function patchAttributes(string $contents, string $key): string
    {
        $pattern = '/\b('.$this->svelteI18nAttributes.')="'.preg_quote($key, '/').'"/';
        $js = $this->jsString($key);

        return preg_replace_callback(
            $pattern,
            fn (array $match): string => $match[1].'={t('.$js.')}',
            $contents
        ) ?? $contents;
    }

    protected function patchMarkupText(string $contents, string $key): string
    {
        // Text nodes sit between tags (>) or block closings like {/if} (}),
        // and Prettier hard-wraps them, so spaces in the key match any whitespace.
        // Surrounding whitespace is kept: it separates adjacent inline elements.
        $pattern = '/(?<=[>}])(\s*)'.str_replace(' ', '\s+', preg_quote($key, '/')).'(\s*)(?=[<{])/';
        $js = $this->jsString($key);

        return preg_replace_callback(
            $pattern,
            fn (array $match): string => $match[1].'{t('.$js.')}'.$match[2],
            $contents
        ) ?? $contents;
    }

    protected function patchJsLiterals(string $contents, string $key): string
    {
        $js = $this->jsString($key);
        $pattern = '/(?<!t\()'.preg_quote($js, '/').'/';

        return preg_replace_callback(
            $pattern,
            fn (): string => 't('.$js.')',
            $contents
        ) ?? $contents;
    }

    protected function ensureHelperImport(string $contents): string
    {
        if (str_contains($contents, '@/lib/i18n')) {
            return $contents;
        }

        $import = "import { t } from '@/lib/i18n';";
        $count = 0;

        $contents = (string) preg_replace(
            '/<script(?![^>]*\bmodule\b)[^>]*>/',
            '$0'."\n    ".$import,
            $contents,
            1,
            $count
        );

        if ($count === 0) {
            $contents = "<script lang=\"ts\">\n    ".$import."\n</script>\n\n".$contents;
        }

        return $contents;
    }

    protected function jsString(string $key): string
    {
        return "'".str_replace("'", "\\'", $key)."'";
    }
}
