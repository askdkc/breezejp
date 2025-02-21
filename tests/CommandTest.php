<?php

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

test('breezejp command successfully update env or config/app.php locale to ja', function () {
    $this->artisan('breezejp')
        ->expectsOutput('Laravel Breeze用に日本語翻訳ファイルを準備します')
        ->expectsConfirmation('GitHubリポジトリにスターの御協力をお願いします🙏', 'no')
        ->expectsOutput('日本語ファイルのインストールが完了しました!')
        ->assertExitCode(0);

    if ((int) substr(Illuminate\Foundation\Application::VERSION, 0, 2) < 11) {
        $configfile = file_get_contents(base_path('config/app.php'));
        $this->assertStringContainsString("'locale' => 'ja'", $configfile);
        $this->assertStringContainsString("'faker_locale' => 'ja_JP'", $configfile);
        $this->assertStringContainsString("'timezone' => 'Asia/Tokyo'", $configfile);
    } else { // For Laravel 11 and above
        $envfile = file_get_contents(base_path('.env'));
        // For Stupid Laravel 11 Breaking Changes
        $configfile = file_get_contents(base_path('config/app.php'));
        if (!strpos($configfile, "'timezone' => env")) {
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

    if ((int) substr(Illuminate\Foundation\Application::VERSION, 0, 2) < 11) {
        $configfile = file_get_contents(base_path('config/app.php'));
        $this->assertStringContainsString("'timezone' => 'Asia/Tokyo'", $configfile);
    } else { // For Laravel 11 and above
        $configfile = file_get_contents(base_path('config/app.php'));
        // For Stupid Laravel 11 Breaking Changes
        if (!strpos($configfile, "'timezone' => env")) {
            $this->assertStringContainsString("'timezone' => 'Asia/Tokyo'", $configfile);
        } else {
            $envfile = file_get_contents(base_path('.env'));
            $this->assertStringContainsString('APP_TIMEZONE=Asia/Tokyo', $envfile);
        }
    }
});
