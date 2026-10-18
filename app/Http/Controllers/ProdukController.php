<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Data Produk';
        $q = request()->query('q');
        $produks = Produk::select('tb_produk.*', 'tb_kategori.nama_kategori')
            ->where('nama_produk','like','%'.$q.'%')
            ->leftjoin('tb_kategori','tb_kategori.id_kategori','tb_produk.id_kategori')
            ->paginate(10)
            ->withQueryString();
        $no = $produks->firstItem();
        return view('produk.index',compact('title','produks','q','no'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Produk';
        $kategoris = kategori::orderBy('nama_kategori')->get();
        return view('produk.create', compact('title','kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'id_kategori' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);
        $produk = new Produk($request->all());

        if ($request->hasFile('gambar')){
            $gambar = $request->file('gambar');
            $filename = rand(1000, 9999) . '_' . time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('images/produk'), $filename);
            $produk->gambar = $filename;
        }

        if ($request->hasFile('file_buku')){
            $fileBuku = $request->file('file_buku');
            $filenameBuku = 'ebook_' . rand(1000, 9999) . '_' . time() . '.' . $fileBuku->getClientOriginalExtension();
            $fileBuku->move(public_path('files/buku'), $filenameBuku);
            $produk->file_buku = $filenameBuku;
        }
        
        $produk->save();
        return redirect()->route('produk.index')->with(['message' => 'Data berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $title = 'Ubah Produk';
        $kategoris = kategori::orderBy('nama_kategori')->get();
        return view('produk.edit', compact('title','produk','kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required',
            'id_kategori' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')){
            $gambar = $request->file('gambar');
            $filename = rand(1000, 9999) . '_' . time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('images/produk'), $filename);
            $data['gambar'] = $filename;
        }

        if ($request->hasFile('file_buku')){
            $fileBuku = $request->file('file_buku');
            $filenameBuku = 'ebook_' . rand(1000, 9999) . '_' . time() . '.' . $fileBuku->getClientOriginalExtension();
            $fileBuku->move(public_path('files/buku'), $filenameBuku);
            $data['file_buku'] = $filenameBuku;
        }

        $produk->update($data);
        return redirect()->route('produk.index')->with(['message' => 'Data berhasil diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index')->with(['message' => 'Data berhasil dihapus!']);
    }
}