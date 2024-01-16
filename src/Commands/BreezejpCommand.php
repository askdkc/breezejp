<?php

namespace Askdkc\Breezejp\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class BreezejpCommand extends Command
{
    use InstallLanguageSwitcher;

    public $signature = 'breezejp {--langswitch : Install Language Switcher 言語切替機能のインストール}';

    public $description = 'Add Japanese Translation files for Laravel Breeze';

    public function handle(): int
    {
        // Install Language Switcher 言語切替機能をインストール
        if ($this->option('langswitch')) {
            return $this->installLanguageSwitcher();
        }

        $this->info('Laravel Breeze用に日本語翻訳ファイルを準備します');

        (new Filesystem)->ensureDirectoryExists(lang_path());
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/lang/', lang_path());

        if (file_exists(base_path('config/app.php'))) {
            $this->info('config/app.phpのlocaleをjaにします');
            // Read the contents of the file into a string
            $configfile = file_get_contents(base_path('config/app.php'));

            // Modify the contents of the string
            $configfile = str_replace("'locale' => 'en'", "'locale' => 'ja'", $configfile);
            $configfile = str_replace("'faker_locale' => 'en_US'", "'faker_locale' => 'ja_JP'", $configfile);
            $configfile = str_replace("'timezone' => 'UTC'", "'timezone' => 'Asia/Tokyo'", $configfile);

            // Save the modified contents back to the file
            file_put_contents(base_path('config/app.php'), $configfile);

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

        // For Laravel 11 and above
        $this->info('.envのAPP_LOCALEやTAPP_IMEZONEを日本にします');
        // Read the contents of the file into a string
        $configfile = file_get_contents(base_path('.env'));

        // Modify the contents of the string
        $configfile = str_replace('APP_LOCALE=en', 'APP_LOCALE=ja', $configfile);
        $configfile = str_replace('APP_FAKER_LOCALE=en', 'APP_FAKER_LOCALE=ja_JP', $configfile);
        $configfile = str_replace('APP_TIMEZONE=UTC', 'APP_TIMEZONE=Asia/Tokyo', $configfile);

        // Save the modified contents back to the file
        file_put_contents(base_path('.env'), $configfile);

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

    }
}
