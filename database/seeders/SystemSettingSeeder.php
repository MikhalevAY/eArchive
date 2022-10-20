<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        if (!File::exists(public_path('storage/logos'))) {
            File::makeDirectory(public_path('storage/logos'));
        }
        File::copy(public_path('images/samruk-logo.svg'), public_path('storage/logos/samruk-logo.svg'));

        SystemSetting::withoutEvents(function () {
            SystemSetting::create([
                'logo' => 'logos/samruk-logo.svg',
                'color' => '#0065AE',
            ]);
        });
    }
}
