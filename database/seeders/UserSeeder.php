<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'email' => 'UserUOa@gmail.com',
                'user_name' => 'User Thang Dz',
                'first_name' => 'Thang',
                'last_name' => 'Nguyen',
                'phone' => '0123456789',
                'identity_card' => '001101101231',
                'password' => Hash::make('!Abc123'),
            ],
            [
                'email' => 'user@gmail.com',
                'user_name' => 'User',
                'first_name' => 'Thang',
                'last_name' => 'Nguyen',
                'phone' => '0123456788',
                'identity_card' => '001101101254',
                'password' => Hash::make('!Abc123'),
            ],
        ];

        foreach($data as $key => $val){
            User::create($val);
        }

        for($i=1; $i<15; ++$i){
            User::create([
                'email' => "User$i@gmail.com",
                'user_name' => 'User Thang Dz',
                'first_name' => 'Thang',
                'last_name' => 'Nguyen',
                'phone' => "01234567$",
                'identity_card' => "0011011012$i",
                'password' => Hash::make('!Abc123'),
            ]);
        }
    }
}
