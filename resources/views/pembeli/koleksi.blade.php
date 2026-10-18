@extends('layout.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1 text-white">
                <i class="fa-solid fa-book-bookmark text-warning me-2"></i>Koleksi E-Book Saya
            </h2>
            <p class="text-muted mb-0">Daftar buku digital yang telah Anda beli. Akses baca dan download kapan saja!</p>
        </div>
        <a class="btn btn-primary" href="{{ route('pembeli.katalog') }}">
            <i class="fa-solid fa-cart-plus me-1"></i> Beli Buku Lainnya
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation fs-5 me-2"></i>
            <div>
                @foreach ($errors->all() as $err)
                    <div>{{ $err }}</div>
                @endforeach
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse ($pembelians as $item)
            @php $buku = $item->produk; @endphp
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm p-3 d-flex flex-column justify-content-between">
                    <div>
                        <!-- Book Cover and Status -->
                        <div class="d-flex gap-3 mb-3">
                            <div class="position-relative" style="width: 85px; flex-shrink: 0;">
                                <img src="{{ $buku ? $buku->getImage() : asset('images/no_image.png') }}" 
                                     alt="{{ $buku->nama_produk ?? 'Buku' }}" 
                                     class="rounded-3 shadow border border-secondary w-100" 
                                     style="height: 120px; object-fit: cover;" />
                            </div>
                            <div class="flex-grow-1">
                                <span class="badge-soft badge-soft-success mb-1">
                                    <i class="fa-solid fa-circle-check"></i> Lunas (QRIS)
                                </span>
                                <h5 class="fw-bold text-white mb-1 fs-6" style="line-height: 1.35;">
                                    {{ $buku->nama_produk ?? 'Buku Digital' }}
                                </h5>
                                <div class="small text-muted mb-1">
                                    <i class="fa-regular fa-calendar me-1"></i> Beli: {{ date('d M Y', strtotime($item->tanggal)) }}
                                </div>
                                <div class="small text-success fw-bold">
                                    Total: Rp {{ number_format($item->total, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <div class="p-2 rounded-2 mb-3 small text-muted border" style="background: #0f172a; border-color: #334155 !important;">
                            <i class="fa-solid fa-circle-info text-primary me-1"></i> 
                            Status file: 
                            @if ($buku && $buku->hasFileBuku())
                                <span class="text-success fw-semibold">E-Book Siap Diunduh (PDF)</span>
                            @else
                                <span class="text-warning fw-semibold">Menunggu Unggahan File Admin</span>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 pt-2 border-top" style="border-color: #334155 !important;">
                        @if ($buku && $buku->hasFileBuku())
                            <a href="{{ route('pembeli.baca', $item->id_penjualan) }}" class="btn btn-outline-secondary flex-grow-1 py-2">
                                <i class="fa-solid fa-eye me-1"></i> Baca Online
                            </a>
                            <a href="{{ route('pembeli.download', $item->id_penjualan) }}" class="btn btn-success flex-grow-1 py-2">
                                <i class="fa-solid fa-download me-1"></i> Download PDF
                            </a>
                        @else
                            <button class="btn btn-outline-secondary w-100 py-2" disabled>
                                <i class="fa-solid fa-clock me-1"></i> File Sedang Diproses
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="card border-0 py-5">
                    <i class="fa-solid fa-book-bookmark fs-1 text-muted opacity-50 mb-3 d-block"></i>
                    <h5 class="fw-bold text-white">Belum Ada Buku yang Dibeli</h5>
                    <p class="text-muted small mb-4">Anda belum melakukan pembelian buku. Beli buku sekarang menggunakan pembayaran QRIS yang cepat dan aman.</p>
                    <a href="{{ route('pembeli.katalog') }}" class="btn btn-primary px-4 py-2 mx-auto">
                        <i class="fa-solid fa-store me-1"></i> Jelajahi Katalog Buku
                    </a>
                </div>
            </div>
        @endforelse
    </div>
@endsection
