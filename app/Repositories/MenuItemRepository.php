<?php

namespace App\Repositories;

use App\Models\MenuItem;
use App\RepositoryInterfaces\MenuItemRepositoryInterface;
use Illuminate\Support\Collection;

class MenuItemRepository implements MenuItemRepositoryInterface
{
    public function availableForUser(): Collection
    {
        return MenuItem::whereIn('id', function ($query) {
            $query->select('menu_item_id')
                ->from('menu_item_user')
                ->where('user_role', '?')
                ->setBindings([auth()->user()->role]);
        })->orderBy('number', 'asc')->get();
    }
}
