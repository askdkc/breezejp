<?php

it('setup command failed with an error', closure: function () {
    $this->artisan('breezejp')
        ->expectsOutput('Laravel Breeze用に日本語翻訳ファイルを準備します')
        ->expectsOutput('Laravel BreezeのProfile用に翻訳可能なbladeを準備します')
        ->assertExitCode(1);
});

// この下のテスト後で修正

//it('runs setup command without error', closure: function () {
//    $this->artisan('breezejp')
//        ->expectsOutput('Laravel Breeze用に日本語翻訳ファイルを準備します')
//        ->expectsOutput('Laravel BreezeのProfile用に翻訳可能なbladeを準備します')
//        ->expectsConfirmation('GitHubリポジトリにスターの御協力をお願いします🙏', 'no')
//        ->expectsOutput('日本語ファイルのインストールが完了しました!')
//        ->assertExitCode(0);
//});
//
//it('can see published files', closure: function () {
//    $this->artisan('breezejp')
//        ->expectsOutput('Laravel Breeze用に日本語翻訳ファイルを準備します')
//        ->expectsConfirmation('GitHubリポジトリにスターの御協力をお願いします🙏', 'no')
//        ->expectsOutput('日本語ファイルのインストールが完了しました!')
//        ->assertExitCode(0);
//
//    $this->assertFileExists(base_path('lang/ja.json'));
//    $this->assertFileExists(base_path('lang/ja/auth.php'));
//    $this->assertFileExists(base_path('lang/ja/pagination.php'));
//    $this->assertFileExists(base_path('lang/ja/passwords.php'));
//    $this->assertFileExists(base_path('lang/ja/validation.php'));
//});
