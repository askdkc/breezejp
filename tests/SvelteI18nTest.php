<?php

use Illuminate\Filesystem\Filesystem;

beforeEach(function () {
    $fs = new Filesystem;
    $fs->ensureDirectoryExists(base_path('resources/js/pages/auth'));
    $fs->ensureDirectoryExists(base_path('resources/js/components'));
    $fs->ensureDirectoryExists(base_path('app/Http/Middleware'));

    file_put_contents(base_path('package.json'), '{"devDependencies": {"@inertiajs/svelte": "^3.0.0"}}');

    file_put_contents(base_path('resources/js/pages/auth/Login.svelte'), <<<'SVELTE'
<script module lang="ts">
    export const layout = {
        title: 'Log in to your account',
        description: 'Enter your email and password below to log in',
    };
</script>

<script lang="ts">
    import { Form } from '@inertiajs/svelte';

    interface Props {
        status?: string;
        action: 'Log in' | 'Register';
        kind: 'Password';
    }

    let { status, action, kind }: Props = $props();

    let processing = false;
</script>

<Label for="email">Email address</Label>
<Input placeholder="email@example.com" />
<PasswordInput placeholder="Password" />
<Button disabled={processing}>
    {#if processing}<Spinner />{/if}
    Log in
</Button>
<div class="text-center">
    Don't have an account?
</div>
SVELTE);

    file_put_contents(base_path('resources/js/components/PasskeyItem.svelte'), <<<'SVELTE'
<script lang="ts">
    let { passkey } = $props();
</script>

<p class="text-sm">
    Added {passkey.created_at_diff}
</p>
<DialogDescription>
    Are you sure you want to remove the "{passkey.name}" passkey?
    You will no longer be able to use it to sign in.
</DialogDescription>
<Button>{passkey.deleting ? 'Removing...' : 'Remove passkey'}</Button>
SVELTE);

    file_put_contents(base_path('app/Http/Middleware/HandleInertiaRequests.php'), <<<'PHP'
<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'name' => config('app.name'),
        ];
    }
}
PHP);
});

afterEach(function () {
    $fs = new Filesystem;
    $fs->delete(base_path('package.json'));
    $fs->delete(base_path('app/Http/Middleware/HandleInertiaRequests.php'));
    $fs->deleteDirectory(base_path('resources/js/pages'));
    $fs->deleteDirectory(base_path('resources/js/components'));
    $fs->deleteDirectory(base_path('resources/js/lib'));
});

test('breezejp --svelte publishes the helper and patches templates', function () {
    $this->artisan('breezejp --svelte')->assertExitCode(0);

    expect(file_exists(base_path('resources/js/lib/i18n.ts')))->toBeTrue();

    $login = file_get_contents(base_path('resources/js/pages/auth/Login.svelte'));
    expect($login)
        ->toContain("import { t } from '@/lib/i18n';")
        ->toContain("{t('Email address')}")
        ->toContain("placeholder={t('Password')}")
        ->toContain('placeholder="email@example.com"')
        ->toContain("{t('Log in')}")
        ->toContain("{t('Don\\'t have an account?')}")
        // <script module> constants stay untouched (translated at render sites)
        ->toContain("title: 'Log in to your account',")
        ->toContain("description: 'Enter your email and password below to log in',")
        // TS type annotations stay untouched (wrapping them breaks the build)
        ->toContain("action: 'Log in' | 'Register';")
        ->toContain("kind: 'Password';");

    $passkey = file_get_contents(base_path('resources/js/components/PasskeyItem.svelte'));
    expect($passkey)
        ->toContain("{t('Added :time', { time: passkey.created_at_diff })}")
        ->toContain('{ name: passkey.name })}')
        ->toContain("t('Removing...')")
        ->toContain("t('Remove passkey')");

    expect(file_get_contents(base_path('app/Http/Middleware/HandleInertiaRequests.php')))
        ->toContain("'translations' => fn (): array =>");
});

test('breezejp --svelte is idempotent', function () {
    $this->artisan('breezejp --svelte')->assertExitCode(0);

    $login = file_get_contents(base_path('resources/js/pages/auth/Login.svelte'));
    $passkey = file_get_contents(base_path('resources/js/components/PasskeyItem.svelte'));
    $middleware = file_get_contents(base_path('app/Http/Middleware/HandleInertiaRequests.php'));

    $this->artisan('breezejp --svelte')->assertExitCode(0);

    expect(file_get_contents(base_path('resources/js/pages/auth/Login.svelte')))->toBe($login)
        ->and(file_get_contents(base_path('resources/js/components/PasskeyItem.svelte')))->toBe($passkey)
        ->and(file_get_contents(base_path('app/Http/Middleware/HandleInertiaRequests.php')))->toBe($middleware)
        ->and($login)->not->toContain('t(t(');
});

test('plain breezejp offers svelte patching when the kit is detected', function () {
    $this->artisan('breezejp')
        ->expectsOutput('Laravel Breeze用に日本語翻訳ファイルを準備します')
        ->expectsConfirmation('Svelteテンプレートも日本語化しますか？', 'yes')
        ->expectsConfirmation('GitHubリポジトリにスターの御協力をお願いします🙏', 'no')
        ->assertExitCode(0);

    expect(file_get_contents(base_path('resources/js/pages/auth/Login.svelte')))
        ->toContain("{t('Log in')}");
});

test('plain breezejp skips the svelte prompt when no kit is present', function () {
    (new Filesystem)->delete(base_path('package.json'));

    $this->artisan('breezejp')
        ->expectsOutput('Laravel Breeze用に日本語翻訳ファイルを準備します')
        ->expectsConfirmation('GitHubリポジトリにスターの御協力をお願いします🙏', 'no')
        ->expectsOutput('日本語ファイルのインストールが完了しました!')
        ->assertExitCode(0);
});
