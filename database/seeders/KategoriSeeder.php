<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_kategori')->insert([
            'nama_kategori' => 'Fiksi',
        ]);
        DB::table('tb_kategori')->insert([
            'nama_kategori' => 'Sejarah',
        ]);
        DB::table('tb_kategori')->insert([
            'nama_kategori' => 'Fantasi',
        ]);
        DB::table('tb_kategori')->insert([
            'nama_kategori' => 'Dongeng',
        ]);
    }
}
