<?php

namespace App\Observers;

use App\Models\Log;
use App\Models\User;
use App\Services\LogService;

class UserObserver
{
    private array $data = [
        'model' => 'App\\\User',
        'text' => 'Администрирование',
    ];

    public function __construct(public LogService $logService)
    {
    }

    public function created(User $user)
    {
        $this->logService->create(
            array_merge($this->data, [
                'model_id' => $user->id,
                'action' => Log::ACTION_CREATE,
            ])
        );
    }

    public function updated(User $user)
    {
        $this->logService->create(
            array_merge($this->data, [
                'model_id' => $user->id,
                'action' => Log::ACTION_UPDATE,
            ])
        );
    }

    public function deleted(User $user)
    {
        $this->logService->create(
            array_merge($this->data, [
                'model_id' => $user->id,
                'action' => Log::ACTION_DELETE,
            ])
        );
    }
}
