<?php

it('runs setup command without error', function () {

    $this->artisan('breezejp')
        ->expectsOutput('Laravel Breeze用に日本語翻訳ファイルを準備します')
        ->expectsConfirmation("GitHubリポジトリにスターの御協力をお願いします🙏", 'no')
        ->expectsOutput('日本語ファイルのインストールが完了しました!')
        ->assertExitCode(0);
});
