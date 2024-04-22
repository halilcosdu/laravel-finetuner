# Laravel Finetuner is a package designed for the Laravel framework that automates the fine-tuning of OpenAI models.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/halilcosdu/laravel-finetuner.svg?style=flat-square)](https://packagist.org/packages/halilcosdu/laravel-finetuner)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/halilcosdu/laravel-finetuner/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/halilcosdu/laravel-finetuner/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/halilcosdu/laravel-finetuner/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/halilcosdu/laravel-finetuner/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/halilcosdu/laravel-finetuner.svg?style=flat-square)](https://packagist.org/packages/halilcosdu/laravel-finetuner)

It simplifies the process of adjusting model parameters to optimize performance, tailored specifically for Laravel applications. This tool is ideal for developers looking to enhance AI capabilities in their projects efficiently, with minimal manual intervention.
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
        'disk' => env('FINE_TUNER_STORAGE', 'public'),
    ],
```

## Usage

```php
use HalilCosdu\FineTuner\Facades\FineTuner;

FineTuner::generateExamples($prompt, $temperature = .4, $numberOfExamples = 2): array
FineTuner::upload(string $file): string
FineTuner::fineTune(string $fileId, string $model = 'gpt-3.5-turbo'): string
```
```php
use HalilCosdu\FineTuner\Facades\FineTuner;

// Generate examples for fine-tuning
$trainingExamples = FineTuner::generateExamples("A versatile AI assistant designed to provide personalized support across all aspects of life, from physical health and mental wellness to emotional well-being, adapting its guidance to the user's unique situation and needs. It offers practical advice, empathetic support, and proactive reminders, all while ensuring privacy and security, and continuously evolving through feedback and research.")

array:2 [▼
  "training_data" => array:1 [▼
    0 => array:1 [▼
      "messages" => array:3 [▼
        0 => array:2 [▼
          "role" => "system"
          "content" => "Given your current situation and needs, how can I assist you today?"
        ]
        1 => array:2 [▼
          "role" => "user"
          "content" => "Hey AI, I've been feeling really stressed out lately because of work. Any advice on how I can manage this better?"
        ]
        2 => array:2 [▼
          "role" => "assistant"
          "content" => """
            I'm really sorry to hear that you're feeling this way, but please know that it's okay to feel stressed. Here are a few suggestions that might help:

            

            1. Mindfulness and Relaxation: Try techniques like deep breathing, meditation, or yoga. They can help you to stay calm and focused.

            

            2. Time Management: Prioritize your tasks and break them down into manageable chunks. Remember, it's okay to say no to tasks that are not a priority.

            

            3. Physical Activity: Regular exercise can help reduce stress levels. Even a short walk can make a difference.

            

            4. Connect with Others: Talk to someone you trust about your stress. It can often help to share what you're experiencing.

            

            5. Professional Help: If your stress continues or leads to feelings of despair, it might be helpful to speak with a mental health professional.

            

            Remember, everyone experiences stress differently and different techniques work for different people. It's important to find what works best for you.
            """
        ]
      ]
    ]
  ]
  "file_url" => null
]

// If the `FINE_TUNER_USE_STORAGE` environment variable is set to `true`, the `file_url` will be returned for the upload function. Alternatively, you can create your own training `.jsonl` file using the `training_data`.

// Upload the training data
$fileId = FineTuner::upload($trainingExamples['file_url'])

// Fine-tune the model
FineTuner::fineTune($fileId, 'gpt-3.5-turbo')
```

The `php artisan laravel-finetuner` command is used to interact with the Laravel Finetuner package. This command initiates a process that generates examples.

Here's a detailed explanation of how to use this command:

1. Open your terminal.

2. Navigate to your Laravel project directory.

3. Run the command `php artisan laravel-finetuner`.

4. The command will first ask for a `Prompt`. This is a string that will be used to generate examples for fine-tuning. If you don't provide a prompt, it will use a default one.

5. Next, it will ask for the `Temperature`. This is a float value that controls the randomness of the examples generated. A higher value will result in more random examples. If you don't provide a temperature, it will use a default value of `.4`.

6. Then, it will ask for the `Number of examples`. This is an integer that specifies how many examples to generate. If you don't provide a number, it will use a default value of `1`.

7. After you've provided these inputs, the command will ask for your confirmation to continue. If you confirm, it will start generating examples, which may take a while.

8. Once the examples are generated, they will be uploaded. If there's an error during this process, the command will display an error message.

9. If everything goes well, the command will display a URL. This URL points to the location where the generated examples were uploaded.

Remember, this command is part of the Laravel Finetuner package, which is designed to automate the fine-tuning of OpenAI models in Laravel applications.

```php
php artisan laravel-finetuner
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
