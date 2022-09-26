<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(array $params): array
    {
        if (!Auth::attempt($params)) {
            return ['errors' => [
                'email' => [__('messages.wrong_credentials')],
                'password' => [],
            ]];
        }

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
