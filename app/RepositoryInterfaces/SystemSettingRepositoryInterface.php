<?php

namespace App\RepositoryInterfaces;

use App\Models\SystemSetting;
use App\Repositories\SystemSettingRepository;

/**
 * @see SystemSettingRepository
 **/
interface SystemSettingRepositoryInterface
{
    public function update(array $data): array;

    public function get(int $id): SystemSetting;
}
