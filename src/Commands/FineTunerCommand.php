<?php

namespace HalilCosdu\FineTuner\Commands;

use Illuminate\Console\Command;

class FineTunerCommand extends Command
{
    public $signature = 'laravel-finetuner';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
