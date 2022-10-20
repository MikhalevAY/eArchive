<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menu_item_user')->insert([
            ['menu_item_id' => 1, 'user_role' => 'admin'],
            ['menu_item_id' => 2, 'user_role' => 'admin'],
            ['menu_item_id' => 3, 'user_role' => 'admin'],
            ['menu_item_id' => 4, 'user_role' => 'admin'],
            ['menu_item_id' => 5, 'user_role' => 'admin'],
            ['menu_item_id' => 6, 'user_role' => 'admin'],
            ['menu_item_id' => 7, 'user_role' => 'admin'],
            ['menu_item_id' => 8, 'user_role' => 'admin'],
            ['menu_item_id' => 1, 'user_role' => 'archivist'],
            ['menu_item_id' => 2, 'user_role' => 'archivist'],
            ['menu_item_id' => 3, 'user_role' => 'archivist'],
            ['menu_item_id' => 6, 'user_role' => 'archivist'],
            ['menu_item_id' => 7, 'user_role' => 'admin'],
            ['menu_item_id' => 1, 'user_role' => 'reader'],
            ['menu_item_id' => 3, 'user_role' => 'reader'],
            ['menu_item_id' => 1, 'user_role' => 'guest'],
            ['menu_item_id' => 3, 'user_role' => 'guest'],
        ]);
    }
}
