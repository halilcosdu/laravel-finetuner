<?php

namespace HalilCosdu\FineTuner;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Sleep;
use Illuminate\Support\Str;
use OpenAI\Client;

class FineTuner
{
    public function __construct(public Client $client)
    {
        //
    }

    private function example(string $prompt, array $prevExamples, float $temperature = .5): ?string
    {
        $messages = [
            [
                'role' => 'system',
                'content' => "You are generating data which will be used to train a machine learning model.\n\nYou will be given a high-level description of the model we want to train, and from that, you will generate data samples, each with a prompt/response pair.\n\nYou will do so in this format:\n```\nprompt\n-----------\n\$prompt_goes_here\n-----------\n\nresponse\n-----------\n\$response_goes_here\n-----------\n```\n\nOnly one prompt/response pair should be generated per turn.\n\nFor each turn, make the example slightly more complex than the last, while ensuring diversity.\n\nMake sure your samples are unique and diverse, yet high-quality and complex enough to train a well-performing model.\n\nHere is the type of model we want to train:\n`{$prompt}`"],
        ];

        if (count($prevExamples) > 0) {
            if (count($prevExamples) > 8) {
                $keys = array_rand($prevExamples, 8);
                $prevExamples = array_intersect_key($prevExamples, array_flip($keys));
            }
            foreach ($prevExamples as $example) {
                $messages[] = [
                    'role' => 'assistant',
                    'content' => $example,
                ];
            }
        }

        $response = $this->client->chat()->create([
            'model' => 'gpt-4',
            'messages' => $messages,
            'temperature' => $temperature,
        ]);

        return $response->choices[0]->message->content;
    }

    public function generateExamples(string $prompt, float $temperature = .4, int $numberOfExamples = 1): array
    {
        $prevExamples = [];
        for ($i = 0; $i < $numberOfExamples; $i++) {
            Sleep::sleep(config('finetuner.sleep_seconds', .1));
            $example = $this->example($prompt, $prevExamples, $temperature);
            $prevExamples[] = $example;
        }

        return $this->saveTrainingExamples($prevExamples, $this->generateSystemMessage($prompt, $temperature));
    }

    public function save(array $data, string $fileName): string
    {
        Storage::disk(config('finetuner.storage.disk'))->put($fileName, json_encode($data));

        return Storage::disk(config('finetuner.storage.disk'))->url($fileName);
    }

    private function generateSystemMessage(string $prompt, float $temperature = .5): ?string
    {
        $response = $this->client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "You will be given a high-level description of the model we are training, and from that, you will generate a simple system prompt for that model to use. Remember, you are not generating the system message for data generation -- you are generating the system message to use for inference. A good format to follow is `Given \$INPUT_DATA, you will \$WHAT_THE_MODEL_SHOULD_DO.`.\n\nMake it as concise as possible. Include nothing but the system prompt in your response.\n\nFor example, never write: `\"\$SYSTEM_PROMPT_HERE\"`.\n\nIt should be like: `\$SYSTEM_PROMPT_HERE`.",
                ],
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
            'temperature' => $temperature,
        ]);

        return $response->choices[0]->message->content;
    }

    private function saveTrainingExamples(array $prevExamples, string $systemMessage): array
    {
        $trainingExamples = [];
        foreach ($prevExamples as $example) {
            $splitExample = explode('-----------', $example);
            if (count($splitExample) >= 4) {
                $trainingExample = [
                    'messages' => [
                        ['role' => 'system', 'content' => $systemMessage],
                        ['role' => 'user', 'content' => trim($splitExample[1])],
                        ['role' => 'assistant', 'content' => trim($splitExample[3])],
                    ],
                ];
                $trainingExamples[] = $trainingExample;
            }
        }
        $fileName = Str::random(40).'.jsonl';

        if (app()->runningInConsole()) {
            return ['url' => $this->save($trainingExamples, $fileName)];
        }

        $url = null;

        if (config('finetuner.use_storage')) {
            $fileName = Str::random(40).'.jsonl';
            Storage::disk(config('finetuner.storage.disk'))->put($fileName, json_encode($trainingExamples));
            $url = Storage::disk(config('finetuner.storage.disk'))->url($fileName);
        }

        return ['training_data' => $trainingExamples, 'file_url' => $url];
    }

    public function upload(string $file): string
    {
        $file = $this->client->files()->upload([
            'file' => fopen($file, 'r'),
            'purpose' => 'fine-tune',
        ]);

        return $file->id;
    }

    public function fineTune(string $fileId, string $model = 'gpt-3.5-turbo'): string
    {
        $fineTune = $this->client->fineTuning()->createJob([
            'model' => $model,
            'training_file' => $fileId,
        ]);

        return $fineTune->id;
    }
}
