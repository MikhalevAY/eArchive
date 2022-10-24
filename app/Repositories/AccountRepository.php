<?php

namespace App\Repositories;

use App\RepositoryInterfaces\AccountRepositoryInterface;

class AccountRepository implements AccountRepositoryInterface
{
    public function update(array $data): void
    {
        auth()->user()->update($data);
    }

    public function updatePassword(array $data): void
    {
        auth()->user()->update(['password' => $data['password']]);
    }

    public function updatePhoto(array $data): void
    {
        auth()->user()->update($data);
    }
}
