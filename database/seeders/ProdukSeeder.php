<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_produk')->insert([
            'nama_produk' => 'The Alchemist',
            'id_kategori' => 1, //Fiksi
            'harga_beli' => 15000,
            'harga_jual' => 20000,
            'stok' => 10,
        ]);
        DB::table('tb_produk')->insert([
            'nama_produk' => 'Sapiens: A Brief History of Humankind ',
            'id_kategori' => 2, //Sejarah
            'harga_beli' => 10000,
            'harga_jual' => 12000,
            'stok' => 15,
        ]);
        DB::table('tb_produk')->insert([
            'nama_produk' => 'Harry Potter and the Sorcerer s Stone',
            'id_kategori' => 3, //Fantasi
            'harga_beli' => 20000,
            'harga_jual' => 25000,
            'stok' => 5,
        ]);
        DB::table('tb_produk')->insert([
            'nama_produk' => 'Si kancil pintar',
            'id_kategori' => 4, //Dongeng
            'harga_beli' => 20000,
            'harga_jual' => 25000,
            'stok' => 5,
        ]);
        
    }
}
