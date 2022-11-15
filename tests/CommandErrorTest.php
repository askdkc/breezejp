<?php

it('setup command failed with an error', closure: function () {
    $this->artisan('breezejp')
        ->expectsOutput('Laravel Breeze用に日本語翻訳ファイルを準備します')
        ->expectsOutput('Laravel BreezeのProfile用に翻訳可能なbladeを準備します')
        ->assertExitCode(1);
});
