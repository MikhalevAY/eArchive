<?php

namespace App\RepositoryInterfaces;

use App\Repositories\PasswordRepository;

/**
 * @see PasswordRepository
 **/
interface PasswordRepositoryInterface
{
    public function check(string $md5Email): bool;

    public function get(string $md5Email): object|null;

    public function deleteRow(string $email): void;

    public function insertRow(string $email, string $md5Email): void;
}
