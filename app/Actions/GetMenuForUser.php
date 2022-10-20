<?php

namespace App\Actions;

use App\Models\MenuItem;
use Illuminate\Support\Collection;

class GetMenuForUser
{
    public static function handle(): Collection
    {
        return MenuItem::whereIn('id', function ($query) {
            $query->select('menu_item_id')
                ->from('menu_item_user')
                ->where('user_role', '?')
                ->setBindings([auth()->user()->role]);
        })->orderBy('number', 'asc')->get();
    }
}
