@extends('layout.app')

@section('content')
    <!-- Page Header & Action Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1 text-white">
                <i class="fa-solid fa-book text-primary me-2"></i>Katalog Produk Buku
            </h2>
            <p class="text-muted mb-0">Kelola informasi buku, stok persediaan, dan harga jual</p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-primary" href="{{ route('produk.create') }}">
                <i class="fa-solid fa-plus"></i> Tambah Buku Baru
            </a>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header py-3">
            <form method="GET" action="{{ route('produk.index') }}" class="row g-2 align-items-center w-100 m-0">
                <div class="col-md-5 col-lg-4 p-0">
                    <div class="input-group">
                        <span class="input-group-text border-end-0">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input class="form-control border-start-0 ps-0" name="q" value="{{ $q }}" placeholder="Cari judul buku..." />
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-light border">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                    @if ($q)
                        <a href="{{ route('produk.index') }}" class="btn btn-danger">
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
                        <th width="80">Cover</th>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th class="text-center">Stok</th>
                        <th width="140" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produks as $produk)
                    <tr>
                        <td class="text-center fw-semibold text-muted">{{ $no++ }}</td>
                        <td>
                            <img src="{{ $produk->getImage() }}" alt="{{ $produk->nama_produk }}" 
                                 class="rounded-3 shadow-sm border border-secondary" 
                                 style="width: 50px; height: 65px; object-fit: cover;" />
                        </td>
                        <td>
                            <div class="fw-bold text-white fs-6">{{ $produk->nama_produk }}</div>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <small class="text-muted">ID: #{{ $produk->id_produk }}</small>
                                @if ($produk->hasFileBuku())
                                    <a href="{{ asset('files/buku/' . $produk->file_buku) }}" target="_blank" class="badge-soft badge-soft-success text-decoration-none py-0 px-2" title="Unduh File E-Book">
                                        <i class="fa-solid fa-file-pdf"></i> E-Book
                                    </a>
                                @else
                                    <span class="badge-soft badge-soft-warning py-0 px-2" title="Belum diunggah">
                                        <i class="fa-solid fa-circle-exclamation"></i> Belum Ada File
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge-soft badge-soft-primary">
                                <i class="fa-solid fa-tag"></i> {{ $produk->nama_kategori ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="text-muted">
                            Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="fw-bold text-info fs-6">
                                Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if ($produk->stok > 5)
                                <span class="badge-soft badge-soft-success">
                                    <i class="fa-solid fa-circle-check"></i> {{ $produk->stok }} Tersedia
                                </span>
                            @elseif ($produk->stok > 0)
                                <span class="badge-soft badge-soft-warning">
                                    <i class="fa-solid fa-triangle-exclamation"></i> Sisa {{ $produk->stok }}
                                </span>
                            @else
                                <span class="badge-soft badge-soft-danger">
                                    <i class="fa-solid fa-circle-xmark"></i> Habis
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="btn btn-warning" href="{{ route('produk.edit', $produk) }}" title="Ubah Data">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form method="POST" class="d-inline" action="{{ route('produk.destroy', $produk) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')" title="Hapus Data">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-book-open fs-1 text-muted opacity-50 mb-3 d-block"></i>
                            <div class="fw-semibold text-white">Belum ada data buku</div>
                            <p class="small text-muted mb-3">Tambahkan buku pertama Anda untuk mulai mengisi katalog toko.</p>
                            <a href="{{ route('produk.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-plus"></i> Tambah Buku
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($produks->hasPages())
            <div class="card-footer py-3">
                {{ $produks->links() }}
            </div>
        @endif
    </div>
@endsection
