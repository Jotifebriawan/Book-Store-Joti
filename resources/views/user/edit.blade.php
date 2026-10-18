@extends('layout.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1">
                <i class="fa-solid fa-user-pen text-warning me-2"></i>Ubah Data Pengguna
            </h2>
            <p class="text-muted mb-0">Perbarui profil dan wewenang akun: <strong>{{ $user->nama_user }}</strong></p>
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
                <div class="card-header bg-white py-3">
                    <span class="fw-bold"><i class="fa-solid fa-id-card-clip text-warning me-2"></i>Formulir Perubahan Akun</span>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('user.update', $user) }}">
                        @csrf
                        @method('PUT')
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Nama Lengkap <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="nama_user" value="{{ old('nama_user', $user->nama_user) }}" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Username <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="username" value="{{ old('username', $user->username) }}" required />
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Kata Sandi Baru</label>
                                <input class="form-control" type="password" name="password" placeholder="Kosongkan jika tidak diubah" />
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password akun ini.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Level / Hak Akses <span class="text-danger">*</span></label>
                                <select class="form-select" name="level" required>
                                    @foreach ($levels as $level)
                                        <option value="{{ $level }}" {{ old('level', $user->level) == $level ? 'selected' : '' }}>
                                            {{ ucfirst($level) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">No. Telepon / WhatsApp <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="telpon" value="{{ old('telpon', $user->telpon) }}" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Alamat Email <span class="text-danger">*</span></label>
                                <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required />
                            </div>
                        </div>

                        <div class="d-flex gap-2 pt-2 border-top">
                            <button type="submit" class="btn btn-warning px-4 text-white">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                            </button>
                            <a class="btn btn-light border px-4" href="{{ route('user.index') }}">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm text-center p-4">
                <span class="user-avatar-circle mx-auto mb-3" style="width: 64px; height: 64px; font-size: 1.6rem;">
                    {{ strtoupper(substr($user->nama_user, 0, 1)) }}
                </span>
                <h5 class="fw-bold mb-1">{{ $user->nama_user }}</h5>
                <span class="badge-role {{ $user->level == 'admin' ? 'badge-role-admin' : 'badge-role-user' }} mx-auto mb-3">
                    {{ ucfirst($user->level) }}
                </span>
                <div class="text-muted small">
                    Username: <strong>{{ $user->username }}</strong><br>
                    ID Akun: #{{ $user->id_user }}
                </div>
            </div>
        </div>
    </div>
@endsection