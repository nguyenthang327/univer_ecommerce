<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Language::insert([
            [
                'name' => 'vi',
                'display_name' => 'Tiếng Việt',
            ],
            [
                'name' => 'en',
                'display_name' => 'English',
            ],
        ]);
    }
}
