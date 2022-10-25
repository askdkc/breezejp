<?php

namespace Askdkc\Breezejp;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Askdkc\Breezejp\Commands\BreezejpCommand;

class BreezejpServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('breezejp')
            ->hasCommand(BreezejpCommand::class);
    }
}
