@extends('layout.app')

@section('content')
    <!-- Header & Action Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1 text-white">
                <i class="fa-solid fa-layer-group text-primary me-2"></i>Kategori Buku
            </h2>
            <p class="text-muted mb-0">Kelola kelompok genre atau kategori koleksi buku</p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-primary" href="{{ route('kategori.create') }}">
                <i class="fa-solid fa-plus"></i> Tambah Kategori
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header py-3">
            <form method="GET" action="{{ route('kategori.index') }}" class="row g-2 align-items-center w-100 m-0">
                <div class="col-md-5 col-lg-4 p-0">
                    <div class="input-group">
                        <span class="input-group-text border-end-0">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input class="form-control border-start-0 ps-0" name="q" value="{{ $q }}" placeholder="Cari nama kategori..." />
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-light border">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                    @if ($q)
                        <a href="{{ route('kategori.index') }}" class="btn btn-danger">
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
                        <th width="80" class="text-center">No</th>
                        <th>Nama Kategori</th>
                        <th width="140" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategoris as $kategori)
                    <tr>
                        <td class="text-center fw-semibold text-muted">{{ $no++ }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge-soft badge-soft-primary p-2">
                                    <i class="fa-solid fa-folder-open"></i>
                                </span>
                                <div>
                                    <span class="fw-bold text-white fs-6">{{ $kategori->nama_kategori }}</span>
                                    <div class="small text-muted">ID: #{{ $kategori->id_kategori }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="btn btn-warning" href="{{ route('kategori.edit', $kategori) }}" title="Ubah Kategori">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form method="POST" class="d-inline" action="{{ route('kategori.destroy', $kategori) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')" title="Hapus Kategori">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-folder-open fs-1 text-muted opacity-50 mb-3 d-block"></i>
                            <div class="fw-semibold text-white">Belum Ada Kategori</div>
                            <p class="small text-muted mb-3">Tambahkan kategori buku pertama Anda.</p>
                            <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-plus"></i> Tambah Kategori
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($kategoris->hasPages())
            <div class="card-footer py-3">
                {{ $kategoris->links() }}
            </div>
        @endif
    </div>
@endsection
