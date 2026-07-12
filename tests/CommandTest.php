<?php

use Illuminate\Foundation\Application;

test('.env file exists', function () {
    $this->assertFileExists(base_path('.env'));
});

test('breezejp command successfully run and see all the published files', closure: function () {
    $this->artisan('breezejp')
        ->expectsOutput('Laravel Breeze用に日本語翻訳ファイルを準備します')
        ->expectsConfirmation('GitHubリポジトリにスターの御協力をお願いします🙏', 'no')
        ->expectsOutput('日本語ファイルのインストールが完了しました!')
        ->assertExitCode(0);

    $this->assertFileExists(base_path('lang/ja.json'));
    $this->assertFileExists(base_path('lang/ja/auth.php'));
    $this->assertFileExists(base_path('lang/ja/pagination.php'));
    $this->assertFileExists(base_path('lang/ja/passwords.php'));
    $this->assertFileExists(base_path('lang/ja/validation.php'));
});

test('published ja.json contains svelte starter kit translations', function () {
    $this->artisan('breezejp')
        ->expectsOutput('Laravel Breeze用に日本語翻訳ファイルを準備します')
        ->expectsConfirmation('GitHubリポジトリにスターの御協力をお願いします🙏', 'no')
        ->expectsOutput('日本語ファイルのインストールが完了しました!')
        ->assertExitCode(0);

    $translations = json_decode(file_get_contents(base_path('lang/ja.json')), true, 512, JSON_THROW_ON_ERROR);

    expect($translations)
        ->toHaveKey('Sign in with a passkey', 'パスキーでサインイン')
        ->toHaveKey('Authentication code', '認証コード')
        ->toHaveKey('Enter the authentication code provided by your authenticator application.', '認証アプリに表示された認証コードを入力してください')
        ->toHaveKey('Two-factor authentication enabled', '2段階認証が有効になりました')
        ->toHaveKey('Profile settings', 'アカウント設定')
        ->toHaveKey('Toggle sidebar', 'サイドバーを切り替え')
        ->toHaveKey('Please proceed with caution, this cannot be undone.', 'この操作は取り消せません。十分ご注意ください。')
        ->toHaveKey("Let's get started", 'さあ、始めましょう')
        ->toHaveKey('Password updated.', 'パスワードを更新しました')
        ->toHaveKey('Profile updated.', 'アカウント情報を更新しました');
});

test('breezejp command successfully update env or config/app.php locale to ja', function () {
    $this->artisan('breezejp')
        ->expectsOutput('Laravel Breeze用に日本語翻訳ファイルを準備します')
        ->expectsConfirmation('GitHubリポジトリにスターの御協力をお願いします🙏', 'no')
        ->expectsOutput('日本語ファイルのインストールが完了しました!')
        ->assertExitCode(0);

    if ((int) substr(Application::VERSION, 0, 2) < 11) {
        $configfile = file_get_contents(base_path('config/app.php'));
        $this->assertStringContainsString("'locale' => 'ja'", $configfile);
        $this->assertStringContainsString("'faker_locale' => 'ja_JP'", $configfile);
        $this->assertStringContainsString("'timezone' => 'Asia/Tokyo'", $configfile);
    } else { // For Laravel 11 and above
        $envfile = file_get_contents(base_path('.env'));
        // For Stupid Laravel 11 Breaking Changes
        $configfile = file_get_contents(base_path('config/app.php'));
        if (! strpos($configfile, "'timezone' => env")) {
            $this->assertStringContainsString('APP_LOCALE=ja', $envfile);
            $this->assertStringContainsString('APP_FAKER_LOCALE=ja_JP', $envfile);
            $this->assertStringContainsString("'timezone' => 'Asia/Tokyo'", $configfile);
        } else {
            $this->assertStringContainsString('APP_LOCALE=ja', $envfile);
            $this->assertStringContainsString('APP_FAKER_LOCALE=ja_JP', $envfile);
            $this->assertStringContainsString('APP_TIMEZONE=Asia/Tokyo', $envfile);
        }

    }
});

test('breezejp command successfully update env or config/app.php timezone to Asia/Tokyo', function () {
    $this->artisan('breezejp')
        ->expectsOutput('Laravel Breeze用に日本語翻訳ファイルを準備します')
        ->expectsConfirmation('GitHubリポジトリにスターの御協力をお願いします🙏', 'no')
        ->expectsOutput('日本語ファイルのインストールが完了しました!')
        ->assertExitCode(0);

    if ((int) substr(Application::VERSION, 0, 2) < 11) {
        $configfile = file_get_contents(base_path('config/app.php'));
        $this->assertStringContainsString("'timezone' => 'Asia/Tokyo'", $configfile);
    } else { // For Laravel 11 and above
        $configfile = file_get_contents(base_path('config/app.php'));
        // For Stupid Laravel 11 Breaking Changes
        if (! strpos($configfile, "'timezone' => env")) {
            $this->assertStringContainsString("'timezone' => 'Asia/Tokyo'", $configfile);
        } else {
            $envfile = file_get_contents(base_path('.env'));
            $this->assertStringContainsString('APP_TIMEZONE=Asia/Tokyo', $envfile);
        }
    }
});
