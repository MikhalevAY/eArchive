<?php

namespace App\RepositoryInterfaces;

use App\Models\User;
use App\Repositories\AdministrationRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * @see AdministrationRepository
 **/
interface AdministrationRepositoryInterface
{
    public function getPaginated(array $params): LengthAwarePaginator;

    public function getAll(array $params): Collection;

    public function update(array $data, User $user): array;

    public function updateQuietly(array $data, User $user): array;

    public function store(array $data): array;

    public function delete(User $user): array;

    public function deleteSelected(array $userIds): array;
}
