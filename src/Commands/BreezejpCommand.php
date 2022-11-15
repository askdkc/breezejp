<?php

namespace Askdkc\Breezejp\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class BreezejpCommand extends Command
{
    public $signature = 'breezejp';

    public $description = 'Add Japanese Translation files for Laravel Breeze';

    public function handle(): int
    {
        $this->info('Laravel Breeze用に日本語翻訳ファイルを準備します');

        (new Filesystem)->ensureDirectoryExists(lang_path());
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/lang/', lang_path());

        $this->info('Laravel BreezeのProfile用に翻訳可能なbladeを準備します');
        if (! (new Filesystem)->exists(resource_path('views/profile/'))) {
            $this->warn('先にLaravel Breezeをインストールしてください');
            $this->warn('その後、breezejpコマンドの再実行をお願いします');

            return self::FAILURE;
        }
        (new Filesystem)->ensureDirectoryExists(resource_path('views/profile/'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/resources/views', resource_path('views'));

        if ($this->confirm('GitHubリポジトリにスターの御協力をお願いします🙏', true)) {
            $repoUrl = 'https://github.com/askdkc/breezejp';

            if (PHP_OS_FAMILY == 'Darwin') {
                exec("open {$repoUrl}");
            }
            if (PHP_OS_FAMILY == 'Windows') {
                exec("start {$repoUrl}");
            }
            if (PHP_OS_FAMILY == 'Linux') {
                exec("xdg-open {$repoUrl}");
            }

            $this->line('Thank you! / ありがとう💓');
        }

        $this->info('日本語ファイルのインストールが完了しました!');

        return self::SUCCESS;
    }
}
