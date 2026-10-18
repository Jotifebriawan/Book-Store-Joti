<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Data Kategori';
        $q = $request->query('q');
        $kategoris = kategori::where('nama_kategori', 'like', '%' . $q . '%')
            ->paginate(10)
            ->withQueryString();
        $no = $kategoris->firstItem();
        return view('kategori.index', compact('title', 'kategoris', 'q', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah kategori';
        $kategoris = kategori::orderBy('nama_kategori')->get();
        return view('kategori.create', compact('title', 'kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
        ]);
        $kategori = new kategori($request->all());
        $kategori->save();
        return redirect()->route('kategori.index')->with(['message' => 'Data berhasil ditambah!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(kategori $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(kategori $kategori)
    {
        $title = 'Ubah kategori';
        return view('kategori.edit', compact('title', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required',
        ]);
        $kategori->update($request->all());
        return redirect()->route('kategori.index')->with(['message' => 'Data Berhasil diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with(['message' => 'Data berhasil dihapus!']);
    }
}
