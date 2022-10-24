<?php

namespace App\RepositoryInterfaces;

use App\Repositories\AccountRepository;

/**
 * @see AccountRepository
 **/
interface AccountRepositoryInterface
{
    public function update(array $data): void;

    public function updatePassword(array $data): void;

    public function updatePhoto(array $data): void;
}
