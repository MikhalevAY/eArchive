<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            SystemSettingSeeder::class,
            MenuItemSeeder::class,
            DictionarySeeder::class,
            MenuItemUserSeeder::class,
            StopWordsSeeder::class,
        ]);
        //Document::factory(1000)->createQuietly();
    }
}
