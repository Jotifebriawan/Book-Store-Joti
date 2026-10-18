@extends('layout.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1 text-white">
                <i class="fa-solid fa-book-open-reader text-primary me-2"></i>Membaca E-Book Online
            </h2>
            <p class="text-muted mb-0">Judul: <strong class="text-white">{{ $produk->nama_produk }}</strong></p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('pembeli.koleksi') }}">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Koleksi
            </a>
            <a class="btn btn-success" href="{{ route('pembeli.download', $penjualan->id_penjualan) }}">
                <i class="fa-solid fa-download me-1"></i> Unduh PDF
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-lg overflow-hidden">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <span class="text-white fw-bold">
                <i class="fa-solid fa-file-pdf text-danger me-2"></i>{{ $produk->nama_produk }}.pdf
            </span>
            <span class="badge-soft badge-soft-success">Akses Resmi Terverifikasi</span>
        </div>
        <div class="card-body p-0" style="height: 780px;">
            <iframe src="{{ asset('files/buku/' . $produk->file_buku) }}#toolbar=1" 
                    width="100%" 
                    height="100%" 
                    style="border: none; background: #1e293b;">
                <div class="p-5 text-center text-muted">
                    <p>Browser Anda tidak mendukung preview PDF langsung.</p>
                    <a href="{{ route('pembeli.download', $penjualan->id_penjualan) }}" class="btn btn-primary">
                        Unduh File PDF Buku
                    </a>
                </div>
            </iframe>
        </div>
    </div>
@endsection
