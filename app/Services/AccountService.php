<?php

namespace App\Services;

use App\RepositoryInterfaces\AccountRepositoryInterface;
use Intervention\Image\Facades\Image;

class AccountService
{
    public function __construct(public AccountRepositoryInterface $repository)
    {
    }

    public function update(array $data): array
    {
        return $this->repository->update($data);
    }

    public function updatePassword(array $data): array
    {
        return $this->repository->updatePassword($data);
    }

    public function updatePhoto(array $data): array
    {
        $photo = $data['photo']->store('avatars', 'public');

        Image::make(public_path("storage/{$photo}"))
            ->orientate()
            ->fit(100, 100)
            ->save();

        return $this->repository->updatePhoto(['photo' => $photo]);
    }
}
