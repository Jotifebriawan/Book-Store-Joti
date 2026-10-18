@extends('layout.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1 text-white">
                <i class="fa-solid fa-user-plus text-primary me-2"></i>Tambah Pengguna Baru
            </h2>
            <p class="text-muted mb-0">Daftarkan akun administrator atau operator kasir baru ke dalam sistem</p>
        </div>
        <a class="btn btn-outline-secondary" href="{{ route('user.index') }}">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar User
        </a>
    </div>

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

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header py-3">
                    <span class="fw-bold text-white"><i class="fa-solid fa-id-card text-primary me-2"></i>Formulir Data Pengguna</span>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('user.store') }}">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="nama_user" value="{{ old('nama_user') }}" placeholder="Contoh: Budi Santoso" required autofocus />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="username" value="{{ old('username') }}" placeholder="Contoh: budi123" required />
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Kata Sandi (Password) <span class="text-danger">*</span></label>
                                <input class="form-control" type="password" name="password" placeholder="Minimal 4 karakter" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Level / Hak Akses <span class="text-danger">*</span></label>
                                <select class="form-select" name="level" required>
                                    @foreach ($levels as $level)
                                        <option value="{{ $level }}" {{ old('level') == $level ? 'selected' : '' }}>
                                            {{ ucfirst($level) }} {{ $level == 'admin' ? '(Akses Penuh)' : '(Akses Kasir & Transaksi)' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">No. Telepon / WhatsApp <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="telpon" value="{{ old('telpon') }}" placeholder="08xxxxxxxxxx" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alamat Email <span class="text-danger">*</span></label>
                                <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="email@domain.com" required />
                            </div>
                        </div>

                        <div class="d-flex gap-2 pt-2 border-top" style="border-color: #334155 !important;">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Daftarkan Pengguna
                            </button>
                            <a class="btn btn-outline-secondary px-4" href="{{ route('user.index') }}">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-white mb-3">
                        <i class="fa-solid fa-shield-halved text-primary me-2"></i>Tentang Hak Akses
                    </h6>
                    <div class="mb-3">
                        <span class="badge-soft badge-soft-primary mb-1">Admin</span>
                        <p class="small text-muted mb-0">Dapat mengelola katalog buku, kategori, transaksi, dan seluruh data pengguna.</p>
                    </div>
                    <div>
                        <span class="badge-soft badge-soft-success mb-1">User / Kasir</span>
                        <p class="small text-muted mb-0">Hanya dapat mengelola transaksi penjualan dan melihat katalog buku serta kategori.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection