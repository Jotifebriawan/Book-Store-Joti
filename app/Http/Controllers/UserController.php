<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
    public function loginAction(Request $request)
    {    
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt(['username'=> $request->username,'password'=> $request->password])) {
            $request->session()->regenerate();
            if (Auth::user()->level === 'pembeli') {
                return redirect()->route('pembeli.katalog');
            }
            return redirect()->route('home');
        }
        return back()->withErrors([
            'username' => 'Salah Kombinasi Username dan Password'
        ]);
    }

    public function login()
    {
        $title = 'Login';
        return view('user.login', compact('title'));
    }

    public function register()
    {
        $title = 'Daftar Akun Pembeli';
        return view('user.register', compact('title'));
    }

    public function registerAction(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:tb_user,username',
            'password' => 'required|min:4',
            'telpon' => 'required|string|max:20',
            'email' => 'required|email|max:100|unique:tb_user,email',
        ]);

        $user = new User($request->all());
        $user->password = Hash::make($request->password);
        $user->level = 'pembeli';
        $user->save();

        Auth::login($user);
        return redirect()->route('pembeli.katalog')->with([
            'message' => 'Pendaftaran akun berhasil! Selamat datang di Toko Buku Joti.'
        ]);
    }

    public function index(Request $request)
    {
        $title = 'Data User';
        $q =  $request->query('q');
        $users = User::where('nama_user','like','%'. $q .'%')
            ->paginate(10)
            ->withQueryString();
        $no = $users->firstItem();
        return view('user.index', compact('title','users','q','no'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah User';
        $levels = ['admin', 'user', 'pembeli'];
        return view('user.create', compact('title','levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_user' => 'required',
            'username' => 'required',
            'password' => 'required',
            'telpon' => 'required',
            'email' => 'required',
            'level' => 'required',
        ]);

        if (User::where('username',$request->username)->first())
            return back()->withErrors(['username' => 'Username sudah terdaftar!']);

        $user = new User($request->all());
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('user.index')->with(['message' => 'Data berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $title = 'Ubah User';
        $levels = ['admin','user'];
        return view('user.edit', compact('title', 'user', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, Request $request)
    {
        $request->validate([
            'nama_user' => 'required',
            'username' => 'required',
            'telpon' => 'required',
            'email' => 'required',
            'level' => 'required',
        ]);

        if (User::where('username',$request->username)->where('id_user','<>', $user->id_user)->first())
            return back()->withErrors(['username' => 'Username sudah terdaftar!']);
        
        $user->nama_user = $request->nama_user;
        $user->username = $request->username;
        $user->telpon = $request->telpon;
        $user->email = $request->email;
        if ($request->password)
            $user->password = Hash::make($request->password);
        $user->level = $request->level;
        $user->save();
        return redirect()->route('user.index')->with(['message' => 'Data Berhasil diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with(['message' => 'Data berhasil dihapus!']);

    }
    public function passwordAction(Request $request)
    {
        $request->validate([
            'pass1' => 'required',
            'pass2' => 'required',
            'pass3' => 'required',
            ]);

            if (!Hash::check($request->pass1, Auth::user()->password))
                return back()->withErrors(['pass1' => 'Password Lama Salah']);
            
            if ($request->pass2 != $request->pass3)
            return back()->withErrors(['pass2' => 'Password Baru dan Konfirmasi Password Harus Sama']);
            
            User::where('id_user', Auth::id())->update([
                'password' => Hash::make($request->pass2)
            ]);
            return redirect()->route('user.password')->with(['message'=>'Password Berhasil Dirubah']);
    }
    public function password()
    {
        $title = 'Ubah Password';
        return view('user.password', compact('title'));
    }
}