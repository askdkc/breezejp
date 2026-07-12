<?php

use Illuminate\Filesystem\Filesystem;

beforeEach(function () {
    $this->bootstrapBackup = file_get_contents(base_path('bootstrap/app.php'));
    $this->routesBackup = file_get_contents(base_path('routes/web.php'));
});

afterEach(function () {
    file_put_contents(base_path('bootstrap/app.php'), $this->bootstrapBackup);
    file_put_contents(base_path('routes/web.php'), $this->routesBackup);
    (new Filesystem)->delete(base_path('app/Http/Middleware/Localization.php'));
});

test('langswitch registers middleware in starter kit shaped bootstrap', function () {
    file_put_contents(base_path('bootstrap/app.php'), <<<'PHP'
<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn () => false,
        );
    })->create();
PHP);

    $this->artisan('breezejp --langswitch')->assertExitCode(0);

    $bootstrap = file_get_contents(base_path('bootstrap/app.php'));
    expect($bootstrap)->toContain('App\Http\Middleware\Localization::class,')
        ->and(file_exists(base_path('app/Http/Middleware/Localization.php')))->toBeTrue()
        ->and(file_get_contents(base_path('routes/web.php')))->toContain('language/{locale}');

    // Localization must be inside the existing web(append: [...]) list
    expect($bootstrap)->toContain("\$middleware->web(append: [\n            App\Http\Middleware\Localization::class,");
});

test('langswitch is idempotent on starter kit shaped bootstrap', function () {
    file_put_contents(base_path('bootstrap/app.php'), <<<'PHP'
<?php

use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);
    })->create();
PHP);

    $this->artisan('breezejp --langswitch')->assertExitCode(0);
    $this->artisan('breezejp --langswitch')->assertExitCode(0);

    expect(substr_count(file_get_contents(base_path('bootstrap/app.php')), 'Localization::class'))->toBe(1);
});
