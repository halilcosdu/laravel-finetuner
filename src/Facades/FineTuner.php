<?php

namespace HalilCosdu\FineTuner\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \HalilCosdu\FineTuner\FineTuner
 *
 * @method static \HalilCosdu\FineTuner\FineTuner generateExamples($prompt, $temperature = .4, $numberOfExamples = 2): array
 * @method static \HalilCosdu\FineTuner\FineTuner upload(string $file): string
 * @method static \HalilCosdu\FineTuner\FineTuner fineTune(string $fileId, string $model = 'gpt-3.5-turbo'): string
 */
class FineTuner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \HalilCosdu\FineTuner\FineTuner::class;
    }
}
