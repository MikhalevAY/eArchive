<?php

namespace App\Services;

use App\Models\SystemSetting;
use App\RepositoryInterfaces\SystemSettingRepositoryInterface;

class SystemSettingService
{
    public function __construct(public SystemSettingRepositoryInterface $repository)
    {
    }

    public function update(array $data): array
    {
        if (isset($data['logo'])) {
            $logo = $data['logo']->store('logos', 'public');
            $data['logo'] = $logo;
        }
        return $this->repository->update($data);
    }

    public function get(int $id): SystemSetting
    {
        return $this->repository->get($id);
    }

    public function getLogoParams(string $logo): array
    {
        $size = filesize(public_path('storage/' . $logo)) / 1024;
        $size = round($size, 2);
        $ext = explode('.', $logo);

        return [
            'size' => $size,
            'ext' => end($ext),
            'name' => str_replace('logos/', '', $logo)
        ];
    }
}
