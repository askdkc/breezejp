<?php

namespace Askdkc\Breezejp\Commands;

use Illuminate\Filesystem\Filesystem;

trait InstallLanguageSwitcher
{
    /**
     * Install the Language Switcher stack.
     */
    public function installLanguageSwitcher(): int
    {
        $this->info('言語切替用のRoute language/{locale} を準備します');

        // 実行済みなら実行しない
        $routesFile = file_get_contents(base_path('routes/web.php'));
        if (strpos($routesFile, '// Language Switcher Route 言語切替用ルートだよ') !== false) {
            $this->info('言語切替用の Route は既に登録済みです');
        } else {
            file_put_contents(
                base_path('routes/web.php'),
                file_get_contents(__DIR__.'/../../stubs/default/routes/web.stub'),
                FILE_APPEND
            );
        }

        // If Middleware Localization is already installed, skip
        if (file_exists(base_path('app/Http/Middleware/Localization.php'))) {
            $this->info('言語切替用の Middleware は既に登録済みです');
        } else {
            $this->info('言語切替用の Middleware を準備します');
            copy(__DIR__.'/../../stubs/app/Http/Middleware/Localization.php', base_path('app/Http/Middleware/Localization.php'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/lang/', lang_path());
        }

        $this->info('Kernel に Middleware を登録します');
        // Read the contents of the file into a string
        $file = base_path('app/Http/Kernel.php');
        $contents = file_get_contents($file);

        // 実行済みなら実行しない
        if (strpos($contents, '\App\Http\Middleware\Localization::class,') !== false) {
            $this->info('言語切替用の Middleware は Kernel に既に登録済みです');

            return self::SUCCESS;
        }
        // Kernel内の既存の \App\Http\Middleware\VerifyCsrfToken::class の位置を取得
        $position = strpos($contents, '\App\Http\Middleware\VerifyCsrfToken::class,');
        if ($position !== false) {
            $appendText = file_get_contents(__DIR__.'/../../stubs/app/Http/Kernel.stub');

            $contents = substr_replace($contents, $appendText, $position, 0);
            file_put_contents($file, $contents);

            $this->info('Language Switherのインストールが完了しました!');

            return self::SUCCESS;
        }

        $this->error('Language Switherのインストールが失敗しました!');

        return self::FAILURE;
    }
}
