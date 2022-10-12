<?php

namespace App\Services;

use App\Models\Log;
use App\Models\User;
use App\RepositoryInterfaces\AdministrationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class AdministrationService
{
    private const PASSWORD_LENGTH = 8;

    public function __construct(
        public AdministrationRepositoryInterface $repository,
        public MailService                       $mailService,
        public PasswordService                   $passwordService,
        public LogService                        $logService,
    )
    {
    }

    public function getPaginated(array $params): LengthAwarePaginator
    {
        return $this->repository->getPaginated($params);
    }

    public function getAll(array $params): Collection
    {
        return $this->repository->getAll($params);
    }

    public function getOrderBy(array $params): array
    {
        return $this->repository->getOrderBy($params);
    }

    public function update(array $data, User $user): array
    {
        return $this->repository->update($data, $user);
    }

    public function store(array $data): array
    {
        $message = View::make('emails.registration', [
            'email' => $data['email'],
            'password' => $data['password'],
            'surname' => $data['surname'],
            'name' => $data['name']
        ]);
        $message->render();

        $this->mailService->send([$data['email']], $message, __('messages.registration'));

        $data['password'] = bcrypt($data['password']);

        return $this->repository->store($data);
    }

    public function delete(User $user): array
    {
        return $this->repository->delete($user);
    }

    public function deleteSelected(array $userIds): array
    {
        return $this->repository->deleteSelected($userIds);
    }

    public function resetPassword(User $user): array
    {
        $newPassword = Str::random(self::PASSWORD_LENGTH);
        $message = View::make('emails.password-reset', [
            'email' => $user->email,
            'password' => $newPassword
        ]);
        $message->render();

        $this->mailService->send([$user->email], $message, __('messages.reset_password'));

        $this->logService->create([
            'action' => Log::ACTION_PASSWORD_RESET,
            'model' => 'App\\\User',
            'model_id' => $user->id,
            'text' => 'Сброс пароля пользователя',
        ]);

        $data['password'] = bcrypt($newPassword);
        $this->repository->updateQuietly($data, $user);

        return [
            'message' => __('messages.new_password_sent')
        ];
    }
}
