<?php

test('breezejp command stop successfully because Breeze is not installed', closure: function () {
    $this->artisan('breezejp')
        ->expectsOutput('Laravel Breeze用に日本語翻訳ファイルを準備します')
        ->expectsOutput('Laravel BreezeのProfile用に翻訳可能なbladeを準備します')
        ->expectsOutput('先にLaravel Breezeをインストールしてください')
        ->expectsConfirmation('強制的に実行しますか？(Breezeを使わずバリデーションの日本語化利用時等はyesを選択)', 'no')
        ->assertExitCode(1);
});

test('breezejp command forcefully run and see all the published files', closure: function () {
    $this->artisan('breezejp')
        ->expectsOutput('Laravel Breeze用に日本語翻訳ファイルを準備します')
        ->expectsOutput('Laravel BreezeのProfile用に翻訳可能なbladeを準備します')
        ->expectsOutput('先にLaravel Breezeをインストールしてください')
        ->expectsConfirmation('強制的に実行しますか？(Breezeを使わずバリデーションの日本語化利用時等はyesを選択)', 'yes')
        ->expectsOutput('実行完了')
        ->expectsConfirmation('GitHubリポジトリにスターの御協力をお願いします🙏', 'no')
        ->expectsOutput('日本語ファイルのインストールが完了しました!')
        ->assertExitCode(0);

    $this->assertFileExists(base_path('lang/ja.json'));
    $this->assertFileExists(base_path('lang/ja/auth.php'));
    $this->assertFileExists(base_path('lang/ja/pagination.php'));
    $this->assertFileExists(base_path('lang/ja/passwords.php'));
    $this->assertFileExists(base_path('lang/ja/validation.php'));
});
