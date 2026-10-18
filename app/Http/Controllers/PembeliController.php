<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembeliController extends Controller
{
    /**
     * Storefront Catalog for Buyers
     */
    public function katalog(Request $request)
    {
        $title = 'Katalog Toko Buku';
        $q = $request->query('q');
        $id_kategori = $request->query('kategori');

        $query = Produk::select('tb_produk.*', 'tb_kategori.nama_kategori')
            ->leftJoin('tb_kategori', 'tb_kategori.id_kategori', '=', 'tb_produk.id_kategori');

        if ($q) {
            $query->where('nama_produk', 'like', '%' . $q . '%');
        }

        if ($id_kategori) {
            $query->where('tb_produk.id_kategori', $id_kategori);
        }

        $produks = $query->paginate(12)->withQueryString();
        $kategoris = kategori::orderBy('nama_kategori')->get();

        return view('pembeli.katalog', compact('title', 'produks', 'kategoris', 'q', 'id_kategori'));
    }

    /**
     * Checkout page with QRIS Payment
     */
    public function checkout($id)
    {
        $produk = Produk::findOrFail($id);
        $title = 'Checkout Pembelian Buku';

        if ($produk->stok < 1) {
            return redirect()->route('pembeli.katalog')->withErrors(['stok' => 'Maaf, stok buku ini sedang habis.']);
        }

        return view('pembeli.checkout', compact('title', 'produk'));
    }

    /**
     * Process QRIS Payment and grant book access
     */
    public function prosesBayar(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:tb_produk,id_produk',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $produk = Produk::findOrFail($request->id_produk);

        if ($produk->stok < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stok buku tidak mencukupi! Sisa stok: ' . $produk->stok]);
        }

        $total = $produk->harga_jual * $request->jumlah;

        $penjualan = new Penjualan();
        $penjualan->tanggal = date('Y-m-d');
        $penjualan->id_produk = $produk->id_produk;
        $penjualan->id_user = Auth::id();
        $penjualan->harga = $produk->harga_jual;
        $penjualan->jumlah = $request->jumlah;
        $penjualan->total = $total;
        $penjualan->status = 'berhasil';
        $penjualan->metode_pembayaran = 'qris';
        $penjualan->save();

        // Reduce inventory stock
        $produk->decrement('stok', $request->jumlah);

        return redirect()->route('pembeli.koleksi')->with([
            'message' => 'Pembayaran QRIS Berhasil! Buku digital Anda sekarang sudah bisa dibaca dan diunduh.'
        ]);
    }

    /**
     * Buyer's Book Library (Books they own)
     */
    public function koleksi()
    {
        $title = 'Koleksi Buku Saya';

        $pembelians = Penjualan::with('produk')
            ->where('id_user', Auth::id())
            ->where('status', 'berhasil')
            ->orderBy('id_penjualan', 'desc')
            ->get();

        return view('pembeli.koleksi', compact('title', 'pembelians'));
    }

    /**
     * Download Purchased Book
     */
    public function download($id)
    {
        $penjualan = Penjualan::with('produk')->findOrFail($id);

        // Security check: Only the buyer or admin can download
        if (Auth::user()->level !== 'admin' && $penjualan->id_user !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengunduh buku ini.');
        }

        $produk = $penjualan->produk;

        if (!$produk || !$produk->hasFileBuku()) {
            return back()->withErrors(['download' => 'File buku digital belum tersedia untuk diunduh.']);
        }

        $filePath = public_path('files/buku/' . $produk->file_buku);
        return response()->download($filePath, $produk->nama_produk . '.pdf');
    }

    /**
     * Read Book Online
     */
    public function baca($id)
    {
        $penjualan = Penjualan::with('produk')->findOrFail($id);

        // Security check
        if (Auth::user()->level !== 'admin' && $penjualan->id_user !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $produk = $penjualan->produk;
        $title = 'Membaca: ' . $produk->nama_produk;

        if (!$produk || !$produk->hasFileBuku()) {
            return back()->withErrors(['baca' => 'File buku digital belum tersedia untuk dibaca online.']);
        }

        return view('pembeli.baca', compact('title', 'penjualan', 'produk'));
    }
}
