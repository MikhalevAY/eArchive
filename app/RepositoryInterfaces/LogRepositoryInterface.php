<?php

namespace App\RepositoryInterfaces;

use App\Repositories\LogRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * @see LogRepository
 **/
interface LogRepositoryInterface
{
    public function getPaginated(array $params): LengthAwarePaginator;

    public function getAll(array $params): Collection;

    public function create(array $data): void;
}
