<?php

namespace App\Repositories;

use App\RepositoryInterfaces\AccountRepositoryInterface;

class AccountRepository implements AccountRepositoryInterface
{
    public function update(array $data): array
    {
        auth()->user()->update($data);

        return [
            'message' => __('messages.data_updated')
        ];
    }

    public function updatePassword(array $data): array
    {
        auth()->user()->update(['password' => $data['password']]);

        return [
            'message' => __('messages.data_updated')
        ];
    }

    public function updatePhoto(array $data): array
    {
        auth()->user()->update($data);

        return [
            'message' => __('messages.data_updated')
        ];
    }
}
