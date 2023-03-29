<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try{
            $this->call(AdminSeeder::class);
            $this->call(LanguageSeeder::class);
            $this->call(UserSeeder::class);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            Log::error('[DatabaseSeeder][run] error '. $e->getMessage());
        }
    }
}
