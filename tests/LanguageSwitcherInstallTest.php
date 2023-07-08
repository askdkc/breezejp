<?php

test('breezejp language switcher command successfully', closure: function () {
    $this->artisan('breezejp --langswitch')
        ->expectsOutput('言語切替用のRoute language/{locale} を準備します')
        ->expectsOutput('言語切替用の Middleware を準備します')
        ->expectsOutput('Kernel に Middleware を登録します')
        ->expectsOutput('Language Switherのインストールが完了しました!')
        ->assertExitCode(0);

    $this->assertFileExists(base_path('app/Http/Middleware/Localization.php'));
    $webfile = file_get_contents(base_path('routes/web.php'));
    $this->assertStringContainsString('// Language Switcher Route 言語切替用ルートだよ', $webfile);
});
