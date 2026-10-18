@extends('layout.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1">
                <i class="fa-solid fa-key text-warning me-2"></i>Ubah Password Akun
            </h2>
            <p class="text-muted mb-0">Perbarui kata sandi akun Anda demi keamanan transaksi</p>
        </div>
        <a class="btn btn-outline-secondary" href="{{ route('home') }}">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check fs-5 me-2"></i>
            <div>{{ session('message') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation fs-5 me-2"></i>
            <div>
                <strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <span class="fw-bold"><i class="fa-solid fa-lock text-warning me-2"></i>Formulir Keamanan Akun</span>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('user.password.action') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Password Saat Ini</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-lock-open text-muted"></i></span>
                                <input class="form-control" type="password" name="pass1" placeholder="Masukkan password lama" required autofocus />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-key text-muted"></i></span>
                                <input class="form-control" type="password" name="pass2" placeholder="Masukkan password baru" required />
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted">Ulangi Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-shield-check text-muted"></i></span>
                                <input class="form-control" type="password" name="pass3" placeholder="Konfirmasi password baru" required />
                            </div>
                        </div>

                        <div class="d-flex gap-2 pt-2 border-top">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa-solid fa-check me-1"></i> Perbarui Password
                            </button>
                            <a class="btn btn-light border px-4" href="{{ route('home') }}">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection