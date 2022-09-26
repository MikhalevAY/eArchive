<?php

namespace App\RepositoryInterfaces;

use App\Repositories\AccountRepository;

/**
 * @see AccountRepository
 **/
interface AccountRepositoryInterface
{
    public function update(array $data): array;

    public function updatePassword(array $data): array;

    public function updatePhoto(array $data): array;
}
