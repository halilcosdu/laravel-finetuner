<?php

namespace HalilCosdu\FineTuner;

use HalilCosdu\FineTuner\Commands\FineTunerCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FineTunerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-finetuner')
            ->hasConfigFile()
            ->hasCommand(FineTunerCommand::class);
    }
}
