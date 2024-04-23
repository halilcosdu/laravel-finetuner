<?php

namespace HalilCosdu\FineTuner;

use HalilCosdu\FineTuner\Commands\FineTunerCommand;
use OpenAI;
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

    public function packageRegistered(): void
    {
        $this->app->singleton(FineTuner::class, function ($app) {
            return new FineTuner(
                OpenAI::factory()
                    ->withApiKey(config('finetuner.api_key'))
                    ->withOrganization(config('finetuner.organization'))
                    ->withHttpClient(new \GuzzleHttp\Client(['timeout' => config('finetuner.request_timeout', 600)]))
                    ->make()
            );
        });
    }
}
