<?php

namespace App\Repositories;

use App\RepositoryInterfaces\PasswordRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PasswordRepository implements PasswordRepositoryInterface
{
    public function check(string $md5Email): bool
    {
        return DB::table('password_resets')->where('token', $md5Email)->exists();
    }

    public function get(string $md5Email): object|null
    {
        return DB::table('password_resets')->where('token', $md5Email)->first();
    }

    public function deleteRow(string $email): void
    {
        DB::table('password_resets')->where('email', $email)->delete();
    }

    public function insertRow(string $email, string $md5Email): bool
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $md5Email,
            'created_at' => now()
        ]);
        return true;
    }
}
