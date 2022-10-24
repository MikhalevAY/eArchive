<?php

namespace App\RepositoryInterfaces;

use App\Repositories\MenuItemRepository;
use Illuminate\Support\Collection;

/**
 * @see MenuItemRepository
 */
interface MenuItemRepositoryInterface
{
    public function availableForUser(): Collection;
}
