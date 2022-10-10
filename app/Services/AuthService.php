<?php

namespace App\Services;

use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(public LogService $logService)
    {
    }

    public function login(array $params): array
    {
        if (!Auth::attempt($params)) {
            return ['errors' => [
                'email' => [__('messages.wrong_credentials')],
                'password' => [],
            ]];
        }

        $this->logService->create([
            'action' => Log::ACTION_AUTH,
            'model' => 'App\\\SystemSetting',
            'model_id' => auth()->id(),
            'text' => 'Вход в систему',
        ]);

        return [
            'reset' => true,
            'url' => route('archiveSearch'),
        ];
    }

    public function loginWithEmail(string $email): void
    {
        $user = User::whereEmail($email)->first();
        Auth::loginUsingId($user->id);
    }
}
