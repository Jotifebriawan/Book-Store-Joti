<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home()
    {
        if (Auth::check() && Auth::user()->level === 'pembeli') {
            return redirect()->route('pembeli.katalog');
        }

        $title = "Dashboard";

        $jumlah_user = User::count();
        $jumlah_produk = Produk::count();
        $jumlah_transaksi = Penjualan::count();
        $total_transaksi = Penjualan::sum('total');

        $penjualans = Penjualan::selectRaw('tanggal, SUM(total) AS total')->groupBy('tanggal')->limit(30)->get();
        $data = [];
        $categories = [];
        foreach ($penjualans as $penjualan) {
            $data[] = $penjualan->total * 1;
            $categories[] = $penjualan->tanggal;
        }

        return view('home', compact('title', 'jumlah_user', 'jumlah_produk', 'jumlah_transaksi', 'total_transaksi', 'data', 'categories'));
    }
}
