@extends('layout.app')

@section('content')
    <!-- Header & Action Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1 text-white">
                <i class="fa-solid fa-users-gear text-primary me-2"></i>Manajemen Data Pengguna
            </h2>
            <p class="text-muted mb-0">Kelola akun administrator dan operator kasir sistem</p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-primary" href="{{ route('user.create') }}">
                <i class="fa-solid fa-user-plus"></i> Tambah User Baru
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header py-3">
            <form method="GET" action="{{ route('user.index') }}" class="row g-2 align-items-center w-100 m-0">
                <div class="col-md-5 col-lg-4 p-0">
                    <div class="input-group">
                        <span class="input-group-text border-end-0">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input class="form-control border-start-0 ps-0" name="q" value="{{ $q }}" placeholder="Cari nama pengguna..." />
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-light border">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                    @if ($q)
                        <a href="{{ route('user.index') }}" class="btn btn-danger">
                            <i class="fa-solid fa-xmark"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-custom align-middle">
                <thead>
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Pengguna</th>
                        <th>Username</th>
                        <th>Kontak</th>
                        <th class="text-center">Level / Role</th>
                        <th width="120" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td class="text-center fw-semibold text-muted">{{ $no++ }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="user-avatar-circle" style="width: 38px; height: 38px; font-size: 0.95rem;">
                                    {{ strtoupper(substr($user->nama_user, 0, 1)) }}
                                </span>
                                <div>
                                    <div class="fw-bold text-white fs-6">{{ $user->nama_user }}</div>
                                    <small class="text-muted"><i class="fa-regular fa-envelope me-1"></i>{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge px-2 py-1 font-monospace" style="background: #0f172a; color: #cbd5e1; border: 1px solid #334155;">
                                {{ $user->username }}
                            </span>
                        </td>
                        <td>
                            <span class="text-secondary">
                                <i class="fa-solid fa-phone me-1 text-primary"></i> {{ $user->telpon ?? '-' }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if ($user->level == 'admin')
                                <span class="badge-soft badge-soft-primary">
                                    <i class="fa-solid fa-shield-halved"></i> Administrator
                                </span>
                            @else
                                <span class="badge-soft badge-soft-success">
                                    <i class="fa-solid fa-user-tag"></i> Operator Kasir
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="btn btn-warning" href="{{ route('user.edit', $user) }}" title="Ubah User">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @if (Auth::id() != $user->id_user)
                                <form method="POST" class="d-inline" action="{{ route('user.destroy', $user) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')" title="Hapus User">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-users fs-1 text-muted opacity-50 mb-3 d-block"></i>
                            <div class="fw-semibold text-white">Tidak ada data pengguna</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="card-footer py-3">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection