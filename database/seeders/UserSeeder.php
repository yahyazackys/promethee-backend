<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin 123',
            'email' => 'admin@gmail.com',
            'no_hp' => '0812782121',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'pelaksana 123',
            'email' => 'pelaksana@gmail.com',
            'no_hp' => '0812782121',
            'password' => Hash::make('pelaksana'),
            'role' => 'pelaksana_proyek',
        ]);

        User::create([
            'name' => 'direktur 123',
            'email' => 'direktur@gmail.com',
            'no_hp' => '0812782121',
            'password' => Hash::make('direktur'),
            'role' => 'direktur',
        ]);
    }
}
