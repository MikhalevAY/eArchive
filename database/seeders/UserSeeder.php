<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::createQuietly([
            'email' => 'admin@earchive.kz',
            'is_active' => 1,
            'name' => 'Админ',
            'surname' => 'Админов',
            'role' => 'admin',
            'password' => bcrypt('123qwe'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
