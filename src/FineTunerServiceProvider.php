<?php

namespace HalilCosdu\FineTuner;

use HalilCosdu\FineTuner\Commands\FineTunerCommand;
use InvalidArgumentException;
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
            $apiKey = config('finetuner.api_key');
            $organization = config('finetuner.organization');
            $timeout = config('finetuner.request_timeout', 30);

            if (! is_string($apiKey) || ($organization !== null && ! is_string($organization))) {
                throw new InvalidArgumentException(
                    'The OpenAI API Key is missing. Please publish the [finetuner.php] configuration file and set the [api_key].'
                );
            }

            return new FineTuner(
                OpenAI::factory()
                    ->withApiKey($apiKey)
                    ->withOrganization($organization)
                    ->withHttpClient(new \GuzzleHttp\Client(['timeout' => $timeout]))
                    ->make()
            );
        });
    }
}
