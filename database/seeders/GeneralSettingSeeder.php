<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralSetting::create([
            'name'=>'Master-sam Techcons LTD',
            'support_email' => 'support@mastertechcons.com',
            'support_phone' => '23484648567458',
            'address' =>'Lagos State',
            'logo' =>'logo.png',
            'favicon' =>'favicon.png',
            'registration_number' => 'RG: 1132606',
        ]);
    }
}
