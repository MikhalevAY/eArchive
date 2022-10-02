<?php

namespace App\Observers;

use App\Models\AccessRequest;
use App\Models\Log;
use App\Services\LogService;

class AccessRequestObserver
{
    private array $data = [
        'model' => 'App\\\AccessRequest',
        'text' => 'Запросы',
    ];

    public function __construct(public LogService $logService)
    {
    }

    public function created(AccessRequest $accessRequest)
    {
        $this->logService->create(
            array_merge($this->data, [
                'model_id' => $accessRequest->id,
                'action' => Log::ACTION_CREATE,
            ])
        );
    }
}
