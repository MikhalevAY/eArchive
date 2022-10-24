<?php

namespace App\Repositories;

use App\Models\SystemSetting;
use App\RepositoryInterfaces\SystemSettingRepositoryInterface;

class SystemSettingRepository implements SystemSettingRepositoryInterface
{
    public function update(array $data): array
    {
        SystemSetting::query()->find(1)->update($data);

        return [
            'message' => __('messages.data_updated'),
        ];
    }

    public function get(int $id): SystemSetting
    {
        return SystemSetting::findOrFail($id);
    }
}
