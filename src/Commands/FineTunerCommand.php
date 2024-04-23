<?php

namespace HalilCosdu\FineTuner\Commands;

use HalilCosdu\FineTuner\Facades\FineTuner;
use Illuminate\Console\Command;

class FineTunerCommand extends Command
{
    public $signature = 'laravel-finetuner';

    public $description = 'Command to generate examples, upload them, and start a fine-tuning job with Laravel Finetuner';

    public function handle(): void
    {
        $prompt = $this->ask('Prompt?', "A versatile AI assistant designed to provide personalized support across all aspects of life, from physical health and mental wellness to emotional well-being, adapting its guidance to the user's unique situation and needs. It offers practical advice, empathetic support, and proactive reminders, all while ensuring privacy and security, and continuously evolving through feedback and research.");
        $temperature = (float) $this->ask('Temperature', '.4');
        $numberOfExamples = (int) $this->ask('Number of examples?', '1');

        if (! $this->confirm('Do you wish to continue?', true)) {
            return;
        }

        $this->info('Generating examples...');
        $this->warn('This may take a while. Please be patient.');

        try {
            $response = FineTuner::generateExamples($prompt, $temperature, $numberOfExamples);
            $this->info("\n{$response['url']}");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
