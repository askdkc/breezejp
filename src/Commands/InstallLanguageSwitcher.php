<?php

namespace Askdkc\Breezejp\Commands;

use Illuminate\Filesystem\Filesystem;

trait InstallLanguageSwitcher
{
    /**
     * Install the Language Switcher stack.
     */
    public function installLanguageSwitcher(): int
    {
        $this->info('言語切替用のRoute language/{locale} を準備します');

        // 実行済みなら実行しない
        $routesFile = file_get_contents(base_path('routes/web.php'));
        if (strpos($routesFile, '// Language Switcher Route 言語切替用ルートだよ') !== false) {
            $this->info('言語切替用の Route は既に登録済みです');
        } else {
            file_put_contents(
                base_path('routes/web.php'),
                file_get_contents(__DIR__.'/../../stubs/default/routes/web.stub'),
                FILE_APPEND
            );
        }

        // If Middleware Localization is already installed, skip
        if (file_exists(base_path('app/Http/Middleware/Localization.php'))) {
            $this->info('言語切替用の Middleware は既に登録済みです');
        } else {
            $this->info('言語切替用の Middleware を準備します');
            (new Filesystem)->ensureDirectoryExists(base_path('app/Http/Middleware'));
            copy(__DIR__.'/../../stubs/app/Http/Middleware/Localization.php', base_path('app/Http/Middleware/Localization.php'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/lang/', lang_path());
        }

        $this->info('bootstrap/app.php に Middleware を登録します');
        // Read the contents of the file into a string
        $file = base_path('bootstrap/app.php');
        $contents = file_get_contents($file);

        // 実行済みなら実行しない
        if (strpos($contents, '\App\Http\Middleware\Localization::class,') !== false) {
            $this->info('言語切替用の Middleware は Bootstrap に既に登録済みです');

            return self::SUCCESS;
        }

        $position = strpos($contents, '//');
        if ($position !== false) {
            // bootstrap/app.php に Middleware を登録
            $replacement = implode("\n", [
                str_repeat(' ', 4).'// Append by Breezejp',
                str_repeat(' ', 8).'$middleware->web(append:[',
                str_repeat(' ', 12)."App\Http\Middleware\Localization::class,",
                str_repeat(' ', 8).']);',
            ]);

            $updatedCode = preg_replace(
                '/->withMiddleware\(function\s*\(Middleware\s+\$middleware\)\s*{\s*\/\/\s*}/',
                "->withMiddleware(function (Middleware \$middleware) {\n    $replacement\n    }",
                $contents
            );
            file_put_contents($file, $updatedCode);

            $this->info('Language Switherのインストールが完了しました!');

            return self::SUCCESS;
        }

        $this->error('Language Switherのインストールが失敗しました!');

        return self::FAILURE;
    }
}
