# Changelog

All notable changes to `laravel-finetuner` will be documented in this file.

## v1.0.2 - 2024-04-22

Release v1.0.2 of the Laravel Finetuner package includes the following changes:

1. Addition of the `FineTunerCommand`: This new command provides an interface for generating examples, uploading them, and starting a fine-tuning job with Laravel Finetuner. It includes options for specifying a prompt, temperature, and number of examples.
   
2. Bug Fix: An issue was resolved where the `array_rand` function was returning random keys from the array, not the values. This was causing incorrect data to be added to the `messages` array. The code has been corrected to use the returned keys to get the actual values from the `prevExamples` array.
   

This release enhances the functionality of the package and improves its reliability by fixing a known bug.

## v1.0.1 - 2024-04-19

Default storage updated.

## v1.0.0 - 2024-04-19

It simplifies the process of adjusting model parameters to optimize performance, tailored specifically for Laravel applications. This tool is ideal for developers looking to enhance AI capabilities in their projects efficiently, with minimal manual intervention.
