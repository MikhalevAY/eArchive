<?php

namespace App\RepositoryInterfaces;

use Illuminate\Support\Collection;

interface MenuItemRepositoryInterface
{
    public function availableForUser(): Collection;
}
