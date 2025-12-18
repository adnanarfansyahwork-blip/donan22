<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_name',
                'value' => 'Donan22',
            ],
            [
                'key' => 'site_description',
                'value' => 'Download Software, Games, and Apps',
            ],
            [
                'key' => 'google_site_verification',
                'value' => '57FjeBMKdUbN9FCNyR8ChLgsWir5KB4IWo21JzdPLPw',
            ],
            [
                'key' => 'contact_email',
                'value' => 'admin@donan22.com',
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
