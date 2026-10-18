<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class M6Controller extends Controller
{   
    public function lat1(Request $request)
    {
        return $request->all();
    }


    public function lat2()
    {
        return view('m6.lat2');

    }

    public function lat2Action(Request $request)
    {
        $request->validate([
            'nama'=> 'required|min:5',
            'nilai'=> 'required|numeric',
        ]);

        $nama = $request->input('nama');
        $nilai = $request->input('nilai');

        if ($nilai >= 60)
            $ket = 'Lulus';
        else
            $ket = 'Ulang';
          
        return view('m6.lat2_hasil', compact('nama', 'nilai', 'ket'));
    }
}
