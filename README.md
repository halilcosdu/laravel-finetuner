# Laravel Finetuner is a package designed for the Laravel framework that automates the fine-tuning of OpenAI models. It simplifies the process of adjusting model parameters to optimize performance, tailored specifically for Laravel applications. This tool is ideal for developers looking to enhance AI capabilities in their projects efficiently, with minimal manual intervention.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/halilcosdu/laravel-finetuner.svg?style=flat-square)](https://packagist.org/packages/halilcosdu/laravel-finetuner)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/halilcosdu/laravel-finetuner/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/halilcosdu/laravel-finetuner/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/halilcosdu/laravel-finetuner/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/halilcosdu/laravel-finetuner/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/halilcosdu/laravel-finetuner.svg?style=flat-square)](https://packagist.org/packages/halilcosdu/laravel-finetuner)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require halilcosdu/laravel-finetuner
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="finetuner-config"
```

This is the contents of the published config file:

```php
return [
    'api_key' => env('OPENAI_API_KEY'),
    'organization' => env('OPENAI_ORGANIZATION'),
    'request_timeout' => env('OPENAI_TIMEOUT'),
    'use_storage' => env('FINE_TUNER_USE_STORAGE', false),
    'storage' => [
        'disk' => env('FINE_TUNER_STORAGE', 'local'),
    ],
```

## Usage

```php
$fineTuner = new HalilCosdu\FineTuner();
echo $fineTuner->echoPhrase('Hello, HalilCosdu!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Halil Cosdu](https://github.com/halilcosdu)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
