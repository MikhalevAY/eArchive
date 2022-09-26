<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemSetting::withoutEvents(function () {
            SystemSetting::create([
                'logo' => 'logos/samruk-logo.svg',
                'color' => '#0065AE',
            ]);
        });
    }
}
