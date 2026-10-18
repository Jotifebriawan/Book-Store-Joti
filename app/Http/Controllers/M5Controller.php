<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class M5Controller extends Controller
{

    public function lat1()
    {
        $nama = 'Johan N.S.S Kale';
        $alamat = 'Jln Tukad Pakerisan Gang 20A No.17';

        return view('m5.lat1', compact('nama','alamat'));
    }

    public function lat2()
    {
        $nama = 'Johan N.S.S Kale';
        $nilai = 100;
        return view('m5.lat2', compact('nama','nilai'));
    }
    
    public function lat3()
    {
        $nama = 'Johan N.S.S Kale';
        $skor = 100;
        return view('m5.lat3', compact('nama','skor'));
    }
    public function lat4()
    {
        $nama = 'Johan N.S.S Kale';
        $hobi = ['Emel','HSR','Turu','makan','belajar kalo niat'];
        $skill = ['Penjoki','Service Komptr','Mangan Dikit','Turu 24 jam','Badminton'];

        return view('m5.lat4', compact('nama','hobi','skill'));
    }
}

