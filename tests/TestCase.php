<?php

namespace Askdkc\Breezejp\Tests;

use Askdkc\Breezejp\BreezejpServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        copy(__DIR__.'/../vendor/orchestra/testbench-core/laravel/.env.example', __DIR__.'/../vendor/orchestra/testbench-core/laravel/.env');

        // テスト用のファイルが残ってたら消す(app.php)
        if (is_file(__DIR__.'/../vendor/orchestra/testbench-core/laravel/config/app.php')) {
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/config/app.php');
        }

        // テスト用のファイル作成(app.php)
        if (strtok(app()->version(), ".") >= 12) {
            if (! is_file(__DIR__.'/../vendor/orchestra/testbench-core/laravel/config/app.php')) {
                copy(__DIR__.'/laravel12/app.php', __DIR__.'/../vendor/orchestra/testbench-core/laravel/config/app.php');
            }
        } else {
            if (! is_file(__DIR__.'/../vendor/orchestra/testbench-core/laravel/config/app.php')) {
                copy(__DIR__.'/laravel11/app.php', __DIR__.'/../vendor/orchestra/testbench-core/laravel/config/app.php');
            }
        }


        // テスト用のファイルが残ってたら消す(web.php)
        if (is_file(__DIR__.'/../vendor/orchestra/testbench-core/laravel/routes/web.php')) {
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/routes/web.php');
        }

        // テスト用のファイル作成(web.php)
        if (! is_file(__DIR__.'/../vendor/orchestra/testbench-core/laravel/routes/web.php')) {
            copy(__DIR__.'/web.php.stub', __DIR__.'/../vendor/orchestra/testbench-core/laravel/routes/web.php');
        }

        // テスト用のファイルが残ってたら消す(Kernel.php)
        if (is_file(__DIR__.'/../vendor/orchestra/testbench-core/laravel/app/Http/Kernel.php')) {
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/app/Http/Kernel.php');
        }

        // テスト用のファイル作成(Kernel.php)
        if (! is_file(__DIR__.'/../vendor/orchestra/testbench-core/laravel/app/Http/Kernel.php')) {
            copy(__DIR__.'/Kernel.php.stub', __DIR__.'/../vendor/orchestra/testbench-core/laravel/app/Http/Kernel.php');
        }

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Askdkc\\Breezejp\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        // コマンドが出力したファイルがテスト前に残っていたら消す
        if (is_dir(__DIR__.'/../vendor/orchestra/testbench-core/laravel/lang/ja')) {
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/lang/ja.json');
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/lang/ja/auth.php');
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/lang/ja/pagination.php');
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/lang/ja/passwords.php');
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/lang/ja/validation.php');
            rmdir(__DIR__.'/../vendor/orchestra/testbench-core/laravel/lang/ja');
        }

        if (is_file(__DIR__.'/../vendor/orchestra/testbench-core/laravel/app/Http/Middleware/Localization.php')) {
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/app/Http/Middleware/Localization.php');
        }

        // config/app.phpのlocaleをenに戻す
        $configfile = file_get_contents(__DIR__.'/../vendor/orchestra/testbench-core/laravel/config/app.php');
        $configfile = str_replace("'locale' => 'ja'", "'locale' => 'en'", $configfile);
        file_put_contents(__DIR__.'/../vendor/orchestra/testbench-core/laravel/config/app.php', $configfile);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // テスト用のファイルが残ってたら消す(.env)
        if (is_file(__DIR__.'/../vendor/orchestra/testbench-core/laravel/.env')) {
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/.env');
        }

    }

    protected function getPackageProviders($app)
    {
        return [
            BreezejpServiceProvider::class,
        ];
    }
}
