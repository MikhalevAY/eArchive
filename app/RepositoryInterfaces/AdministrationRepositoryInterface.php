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

    public function update(array $data, User $user): User;

    public function updateQuietly(array $data, User $user): void;

    public function store(array $data): User;

    public function delete(User $user): void;

    public function deleteSelected(array $userIds): void;
}
