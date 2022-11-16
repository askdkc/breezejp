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

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Askdkc\\Breezejp\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        // コマンドが出力したファイルがテスト前に残っていたら消す
        if(is_dir(__DIR__.'/../vendor/orchestra/testbench-core/laravel/lang/ja')) {
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/lang/ja.json');
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/lang/ja/auth.php');
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/lang/ja/pagination.php');
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/lang/ja/passwords.php');
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/lang/ja/validation.php');
            rmdir(__DIR__.'/../vendor/orchestra/testbench-core/laravel/lang/ja');
        }

        if(is_dir(__DIR__.'/../vendor/orchestra/testbench-core/laravel/resources/views/profile')) {
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/resources/views/profile/edit.blade.php');
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/resources/views/profile/partials/delete-user-form.blade.php');
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/resources/views/profile/partials/update-password-form.blade.php');
            unlink(__DIR__.'/../vendor/orchestra/testbench-core/laravel/resources/views/profile/partials/update-profile-information-form.blade.php');
            rmdir(__DIR__.'/../vendor/orchestra/testbench-core/laravel/resources/views/profile/partials');
            rmdir(__DIR__.'/../vendor/orchestra/testbench-core/laravel/resources/views/profile');
        }
    }

    protected function getPackageProviders($app)
    {
        return [
            BreezejpServiceProvider::class,
        ];
    }
}
