<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


    DB::table('countries')->insert([



        ['name' => 'مصر', 'code' => 'EG', 'currency' => 'EGP'],
        ['name' => 'السعودية', 'code' => 'SA', 'currency' => 'SAR'],
        ['name' => 'الإمارات', 'code' => 'AE', 'currency' => 'AED'],
        ['name' => 'الكويت', 'code' => 'KW', 'currency' => 'KWD'],
        ['name' => 'البحرين', 'code' => 'BH', 'currency' => 'BHD'],
        ['name' => 'قطر', 'code' => 'QA', 'currency' => 'QAR'],
        ['name' => 'عمان', 'code' => 'OM', 'currency' => 'OMR'],
        ['name' => 'الأردن', 'code' => 'JO', 'currency' => 'JOD'],
        ['name' => 'فلسطين', 'code' => 'PS', 'currency' => 'ILS'],
        ['name' => 'لبنان', 'code' => 'LB', 'currency' => 'LBP'],
        ['name' => 'سوريا', 'code' => 'SY', 'currency' => 'SYP'],
        ['name' => 'العراق', 'code' => 'IQ', 'currency' => 'IQD'],
        ['name' => 'اليمن', 'code' => 'YE', 'currency' => 'YER'],
        ['name' => 'ليبيا', 'code' => 'LY', 'currency' => 'LYD'],
        ['name' => 'تونس', 'code' => 'TN', 'currency' => 'TND'],
        ['name' => 'الجزائر', 'code' => 'DZ', 'currency' => 'DZD'],
        ['name' => 'المغرب', 'code' => 'MA', 'currency' => 'MAD'],
        ['name' => 'السودان', 'code' => 'SD', 'currency' => 'SDG'],
        ['name' => 'موريتانيا', 'code' => 'MR', 'currency' => 'MRU'],

    ]);

    }
}
