<?php

namespace App\Services;

use App\Models\Log;
use App\Models\User;
use App\RepositoryInterfaces\AdministrationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class AdministrationService
{
    private const PASSWORD_LENGTH = 8;

    public function __construct(
        public AdministrationRepositoryInterface $repository,
        public MailService $mailService,
        public PasswordService $passwordService,
        public LogService $logService,
    ) {
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
        $user = $this->repository->update($data, $user);

        return [
            'updateRow' => view('components.user-row', [
                'user' => $user,
                'role' => User::ROLE_TITLES[$user->role],
            ])->render(),
            'row_id' => $user->id,
            'message' => __('messages.data_updated'),
        ];
    }

    /**
     * @throws PHPMailerException
     */
    public function store(array $data): array
    {
        $message = view('emails.registration', [
            'email' => $data['email'],
            'password' => $data['password'],
            'surname' => $data['surname'],
            'name' => $data['name'],
        ])->render();
        $this->mailService->send([$data['email']], $message, __('messages.registration'));

        $data['password'] = bcrypt($data['password']);

        $user = $this->repository->store($data);

        return [
            'newRow' => view('components.user-row', [
                'user' => $user,
                'role' => User::ROLE_TITLES[$user->role],
            ])->render(),
            'message' => __('messages.user_stored'),
        ];
    }

    public function delete(User $user): array
    {
        $this->repository->delete($user);

        return [
            'message' => __('messages.user_deleted'),
            'rowsToDelete' => [$user->id],
        ];
    }

    public function deleteSelected(array $userIds): array
    {
        $this->repository->deleteSelected($userIds);

        return [
            'message' => __('messages.users_deleted'),
            'rowsToDelete' => $userIds,
        ];
    }

    /**
     * @throws PHPMailerException
     */
    public function resetPassword(User $user): array
    {
        $newPassword = Str::random(self::PASSWORD_LENGTH);
        $message = view('emails.password-reset', [
            'email' => $user->email,
            'password' => $newPassword,
        ])->render();

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
            'message' => __('messages.new_password_sent'),
        ];
    }
}
