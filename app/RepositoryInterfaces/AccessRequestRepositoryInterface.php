<?php

namespace App\RepositoryInterfaces;

use App\Models\AccessRequest;
use App\Repositories\AccessRequestRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * @see AccessRequestRepository
 **/
interface AccessRequestRepositoryInterface
{
    public function getPaginated(array $params): LengthAwarePaginator;

    public function getAll(array $params): Collection;

    public function update(array $params, AccessRequest $accessRequest): array;
}
