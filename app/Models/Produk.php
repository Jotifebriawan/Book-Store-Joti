<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'tb_produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'nama_produk',
        'id_kategori',
        'harga_beli',
        'harga_jual',
        'stok',
        'gambar',
        'file_buku'
    ];

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'id_kategori', 'id_kategori');
    }

    public function getImage()
    {
        if ($this->gambar && file_exists(public_path('images/produk/' . $this->gambar))) {
            return asset('images/produk/' . $this->gambar);
        } else {
            return asset('images/no_image.png');
        }
    }

    public function hasFileBuku()
    {
        return !empty($this->file_buku) && file_exists(public_path('files/buku/' . $this->file_buku));
    }

    public function getFileBukuUrl()
    {
        if ($this->hasFileBuku()) {
            return asset('files/buku/' . $this->file_buku);
        }
        return null;
    }
}
