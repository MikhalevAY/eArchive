<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $menuItems = [
            ['number' => 1, 'title' => 'Поиск в архиве', 'url' => 'archive-search'],
            ['number' => 2, 'title' => 'Регистрация документов', 'url' => 'registration-of-documents'],
            ['number' => 3, 'title' => 'Читальный зал', 'url' => 'reading-room'],
            ['number' => 4, 'title' => 'Администрирование', 'url' => 'administration'],
            ['number' => 5, 'title' => 'Журнал логов', 'url' => 'system-logs'],
            ['number' => 6, 'title' => 'Запросы', 'url' => 'access-requests'],
            ['number' => 7, 'title' => 'Справочники', 'url' => 'dictionaries'],
            ['number' => 8, 'title' => 'Настройка системы', 'url' => 'system-settings'],
        ];

        collect($menuItems)->each(function ($menuItem) {
            MenuItem::create($menuItem);
        });
    }
}
