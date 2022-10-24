<?php

namespace App\Repositories;

use App\Models\SystemSetting;
use App\RepositoryInterfaces\SystemSettingRepositoryInterface;

class SystemSettingRepository implements SystemSettingRepositoryInterface
{
    public function update(array $data): bool
    {
        return SystemSetting::query()->find(1)->update($data);
    }

    public function get(int $id): SystemSetting
    {
        return SystemSetting::query()->find($id);
    }
}
