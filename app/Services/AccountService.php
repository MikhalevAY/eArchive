<?php

namespace App\Services;

use App\RepositoryInterfaces\AccountRepositoryInterface;
use Intervention\Image\Facades\Image;

class AccountService
{
    private const AVATAR_SIZE = 100;

    public function __construct(public AccountRepositoryInterface $repository)
    {
    }

    public function update(array $data): array
    {
        $this->repository->update($data);

        return [
            'message' => __('messages.data_updated'),
        ];
    }

    public function updatePassword(array $data): array
    {
        $this->repository->updatePassword($data);

        return [
            'message' => __('messages.data_updated'),
        ];
    }

    public function updatePhoto(array $data): array
    {
        $photo = $data['photo']->store('avatars', 'public');

        Image::make(public_path("storage/{$photo}"))
            ->orientate()
            ->fit(self::AVATAR_SIZE, self::AVATAR_SIZE)
            ->save();

        $this->repository->updatePhoto(['photo' => $photo]);

        return [
            'message' => __('messages.data_updated'),
        ];
    }
}
