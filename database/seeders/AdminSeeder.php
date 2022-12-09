<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'email' => 'thangPro@gmail.com',
                'user_name' => 'Admin Thang Dz',
                'first_name' => 'Thang',
                'last_name' => 'Nguyen',
                'phone' => '0123456789',
                'identity_card' => '001101101231',
                'password' => Hash::make('!Abc123'),
            ],
            [
                'email' => 'admin@gmail.com',
                'user_name' => 'Admin',
                'first_name' => 'Thang',
                'last_name' => 'Nguyen',
                'phone' => '0123456788',
                'identity_card' => '001101101254',
                'password' => Hash::make('!Abc123'),
            ],
        ];

        foreach($data as $key => $val){
            Admin::create($val);
        }
    }
}
