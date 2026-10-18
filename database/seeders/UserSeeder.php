<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_user')->truncate();
        
        DB::table('tb_user')->insert([
            'nama_user' => 'Administator',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'telpon' => '0874537328',
            'email' => 'admin@gmail.com',
            'level' => 'admin',
        ]);

        DB::table('tb_user')->insert([
            'nama_user' => 'User',
            'username' => 'user',
            'password' => Hash::make('user'),
            'telpon' => '0875638594',
            'email' => 'user@gmail.com',
            'level' => 'user',
        ]);

        DB::table('tb_user')->insert([
            'nama_user' => 'Pembeli Demo',
            'username' => 'pembeli',
            'password' => Hash::make('pembeli'),
            'telpon' => '081234567890',
            'email' => 'pembeli@gmail.com',
            'level' => 'pembeli',
        ]);
    }
}
