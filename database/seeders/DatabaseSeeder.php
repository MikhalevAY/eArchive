<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SystemSettingSeeder::class,
            MenuItemSeeder::class,
            DictionarySeeder::class,
            MenuItemUserSeeder::class,
            StopWordsSeeder::class,
        ]);

        if (app()->isLocal()) {
            Document::factory(1000)->createQuietly();
        }
    }
}
