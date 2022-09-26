<?php

namespace App\Observers;

use App\Models\Log;
use App\Models\SystemSetting;
use App\Services\LogService;

class SystemSettingObserver
{
    public function __construct(public LogService $logService)
    {
    }

    public function updated(SystemSetting $systemSetting)
    {
        $this->logService->create([
            'action' => Log::ACTION_UPDATE,
            'model' => 'App\\\SystemSetting',
            'model_id' => $systemSetting->id,
            'text' => 'Настройки системы',
        ]);
    }
}
