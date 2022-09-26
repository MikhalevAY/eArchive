<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menuItems = [
            ['number' => 1, 'title' => 'Поиск в архиве', 'url' => 'archive-search'],
            ['number' => 2, 'title' => 'Регистрация документов', 'url' => 'registration-of-documents'],
            ['number' => 3, 'title' => 'Читальный зал', 'url' => 'reading-room'],
            ['number' => 4, 'title' => 'Администрирование', 'url' => 'administration'],
            ['number' => 5, 'title' => 'Журнал логов', 'url' => 'system-logs'],
            ['number' => 6, 'title' => 'Запросы', 'url' => 'requests'],
            ['number' => 7, 'title' => 'Настройка системы', 'url' => 'system-settings'],
        ];

        collect($menuItems)->each(function ($menuItem) {
            MenuItem::create($menuItem);
        });
    }
}
