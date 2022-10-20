<?php

namespace App\Observers;

use App\Models\Dictionary;
use App\Models\Log;
use App\Services\LogService;

class DictionaryObserver
{
    private array $data = [
        'model' => 'App\\\Dictionary',
        'text' => 'Справочник',
    ];

    public function __construct(public LogService $logService)
    {
    }

    public function created(Dictionary $dictionary): void
    {
        $this->logService->create(
            array_merge($this->data, [
                'model_id' => $dictionary->id,
                'action' => Log::ACTION_CREATE,
            ])
        );
    }

    public function deleted(Dictionary $dictionary): void
    {
        $this->logService->create(
            array_merge($this->data, [
                'model_id' => $dictionary->id,
                'action' => Log::ACTION_DELETE,
            ])
        );
    }
}
