<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Data Transaksi';
        $q = $request->query('q');
        $penjualans = Penjualan::select('tb_penjualan.*', 'tb_produk.nama_produk', 'tb_user.nama_user')
            ->where('nama_produk', 'like', '%' . $q . '%')
            ->leftjoin('tb_produk', 'tb_produk.id_produk', 'tb_penjualan.id_produk')
            ->leftjoin('tb_user', 'tb_user.id_user', 'tb_penjualan.id_user')
            ->paginate(10)
            ->withQueryString();
        $no = $penjualans->firstItem();
        return view('penjualan.index', compact('title', 'penjualans', 'q', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Transaksi';
        $produks = Produk::orderBy('nama_produk')->get();
        return view('penjualan.create', compact('title', 'produks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_produk' => 'required',
            'harga' => 'required|numeric',
            'jumlah' => 'required|numeric|min:1',
            'total' => 'required|numeric',
        ]);

        $produk = Produk::find($request->id_produk);
        if (!$produk) {
            return back()->withErrors(['id_produk' => 'Produk tidak ditemukan!'])->withInput();
        }

        if ($produk->stok < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi! Sisa stok: ' . $produk->stok])->withInput();
        }

        $penjualan = new Penjualan($request->all());
        $penjualan->id_user = Auth::id();
        $penjualan->save();

        // Kurangi stok produk
        $produk->decrement('stok', $request->jumlah);

        return redirect()->route('penjualan.index')->with(['message' => 'Transaksi Berhasil']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        $title = 'Ubah Transaksi';
        $produks = Produk::orderBy('nama_produk')->get();
        return view('penjualan.edit', compact('title', 'produks', 'penjualan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_produk' => 'required',
            'harga' => 'required|numeric',
            'jumlah' => 'required|numeric|min:1',
            'total' => 'required|numeric',
        ]);

        $penjualan->update($request->all());
        return redirect()->route('penjualan.index')->with(['message' => 'Transaksi Berhasil Diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        // Kembalikan stok produk jika transaksi dihapus
        $produk = Produk::find($penjualan->id_produk);
        if ($produk) {
            $produk->increment('stok', $penjualan->jumlah);
        }

        $penjualan->delete();
        return redirect()->route('penjualan.index')->with(['message' => 'Transaksi Berhasil Dihapus']);
    }
}