@extends('layout.app')

@section('content')
    <!-- Storefront Header Banner -->
    <div class="hero-banner mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill small mb-2" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);">
                    <span class="badge bg-primary rounded-pill px-2 py-1"><i class="fa-solid fa-qrcode me-1"></i> QRIS</span>
                    <span class="text-white-50">Pembayaran Cepat & Download E-Book Instan</span>
                </div>
                <h1 class="hero-title">
                    Katalog Buku Digital Book Store Joti 📚
                </h1>
                <p class="hero-subtitle mb-0">
                    Pilih buku favorit Anda, bayar dengan QRIS secara instan, dan langsung baca atau unduh file bukunya!
                </p>
            </div>
            <div class="col-lg-4 text-center text-lg-end d-none d-lg-block">
                <i class="fa-solid fa-book-open-reader text-white opacity-25" style="font-size: 7.5rem;"></i>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('pembeli.katalog') }}" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text border-end-0">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input class="form-control border-start-0 ps-0" name="q" value="{{ $q }}" placeholder="Cari judul buku favorit Anda..." />
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="kategori" onchange="this.form.submit()">
                        <option value="">Semua Kategori Genre</option>
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ $id_kategori == $kat->id_kategori ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="fa-solid fa-filter"></i> Cari
                    </button>
                    @if ($q || $id_kategori)
                        <a href="{{ route('pembeli.katalog') }}" class="btn btn-danger">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Book Grid Cards -->
    <div class="row g-4 mb-4">
        @forelse ($produks as $produk)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm d-flex flex-column justify-content-between p-3" style="transition: transform 0.25s ease;">
                    <div>
                        <!-- Cover Image -->
                        <div class="position-relative text-center mb-3 p-2 rounded-3" style="background: #0f172a;">
                            <img src="{{ $produk->getImage() }}" alt="{{ $produk->nama_produk }}" 
                                 class="rounded-3 shadow" 
                                 style="height: 190px; width: 100%; object-fit: contain;" />
                            
                            @if ($produk->hasFileBuku())
                                <span class="badge position-absolute top-0 end-0 m-2" style="background: rgba(16, 185, 129, 0.9); font-size: 0.725rem;">
                                    <i class="fa-solid fa-file-pdf me-1"></i> E-Book
                                </span>
                            @endif
                        </div>

                        <!-- Category Pill -->
                        <span class="badge-soft badge-soft-primary mb-2">
                            <i class="fa-solid fa-tag"></i> {{ $produk->nama_kategori ?? 'Koleksi' }}
                        </span>

                        <!-- Title -->
                        <h5 class="fw-bold text-white mb-2 fs-6" style="line-height: 1.35; height: 2.7rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                            {{ $produk->nama_produk }}
                        </h5>

                        <!-- Price & Stock -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="text-muted small d-block">Harga</span>
                                <span class="fw-bold text-success fs-5">
                                    Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="text-end">
                                <span class="text-muted small d-block">Stok</span>
                                @if ($produk->stok > 0)
                                    <span class="badge-soft badge-soft-success py-1 px-2">{{ $produk->stok }} pcs</span>
                                @else
                                    <span class="badge-soft badge-soft-danger py-1 px-2">Habis</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Buy via QRIS Button -->
                    <div class="pt-2 border-top" style="border-color: #334155 !important;">
                        @if ($produk->stok > 0)
                            <a href="{{ route('pembeli.checkout', $produk->id_produk) }}" class="btn btn-primary w-100 py-2">
                                <i class="fa-solid fa-qrcode me-1"></i> Beli Buku (QRIS)
                            </a>
                        @else
                            <button class="btn btn-outline-secondary w-100 py-2" disabled>
                                <i class="fa-solid fa-ban me-1"></i> Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="card border-0 py-5">
                    <i class="fa-solid fa-book-open fs-1 text-muted opacity-50 mb-3 d-block"></i>
                    <h5 class="fw-bold text-white">Tidak ada buku yang sesuai</h5>
                    <p class="text-muted small mb-3">Coba gunakan kata kunci lain atau pilih semua kategori.</p>
                    <a href="{{ route('pembeli.katalog') }}" class="btn btn-primary btn-sm mx-auto">
                        Lihat Semua Buku
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if ($produks->hasPages())
        <div class="d-flex justify-content-center">
            {{ $produks->links() }}
        </div>
    @endif
@endsection
