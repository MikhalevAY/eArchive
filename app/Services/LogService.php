<?php

namespace App\Services;

use App\RepositoryInterfaces\LogRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class LogService
{
    public function __construct(public LogRepositoryInterface $repository)
    {
    }

    public function getPaginated(array $params): LengthAwarePaginator
    {
        return $this->repository->getPaginated($params);
    }

    public function getOrderBy(array $params): array
    {
        return $this->repository->getOrderBy($params);
    }

    public function create(array $data): void
    {
        $this->repository->create(
            array_merge($data, [
                'user_id' => !isset($data['user_id']) ? auth()->id() : $data['user_id'],
                'device_ip' => request()->ip(),
            ])
        );
    }
}
