@extends('layout.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1 text-white">
                <i class="fa-solid fa-qrcode text-primary me-2"></i>Pembayaran QRIS Instan
            </h2>
            <p class="text-muted mb-0">Selesaikan pembayaran untuk langsung mendapatkan akses baca dan unduh e-book</p>
        </div>
        <a class="btn btn-outline-secondary" href="{{ route('pembeli.katalog') }}">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation fs-5 me-2"></i>
            <div>
                <strong>Perhatian:</strong>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4 justify-content-center">
        <!-- Order Detail Form -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header py-3">
                    <span class="fw-bold text-white"><i class="fa-solid fa-book text-primary me-2"></i>Detail Pembelian Buku</span>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <!-- Book Info Card -->
                        <div class="d-flex gap-3 p-3 rounded-3 mb-4 border" style="background: #0f172a; border-color: #334155 !important;">
                            <img src="{{ $produk->getImage() }}" alt="{{ $produk->nama_produk }}" 
                                 class="rounded-3 shadow" 
                                 style="width: 75px; height: 105px; object-fit: cover;" />
                            <div>
                                <span class="badge-soft badge-soft-primary mb-1">
                                    {{ $produk->kategori->nama_kategori ?? 'Buku' }}
                                </span>
                                <h5 class="fw-bold text-white mb-1 fs-6">{{ $produk->nama_produk }}</h5>
                                <div class="text-success fw-bold fs-5">
                                    Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                                </div>
                                <small class="text-muted d-block mt-1">
                                    <i class="fa-solid fa-circle-check text-success me-1"></i> File E-Book Siap Diunduh
                                </small>
                            </div>
                        </div>

                        <!-- Quantity Selector Form -->
                        <div class="mb-4">
                            <label class="form-label">Jumlah Pembelian (Qty)</label>
                            <div class="input-group input-group-lg">
                                <button class="btn btn-outline-secondary" type="button" onclick="ubahJumlah(-1)">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <input class="form-control text-center fw-bold fs-5" type="number" min="1" max="{{ $produk->stok }}" id="inputQty" value="1" readonly />
                                <button class="btn btn-outline-secondary" type="button" onclick="ubahJumlah(1)">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                            <small class="text-muted mt-1 d-block">Stok tersedia: {{ $produk->stok }} pcs</small>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="p-3 rounded-3 border mb-3" style="background: #162032; border-color: #334155 !important;">
                            <div class="d-flex justify-content-between small text-muted mb-2">
                                <span>Harga Satuan:</span>
                                <span class="fw-bold text-white">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between small text-muted mb-2">
                                <span>Biaya Layanan QRIS:</span>
                                <span class="fw-bold text-success">GRATIS (Rp 0)</span>
                            </div>
                            <hr style="border-color: #334155 !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-white">Total Tagihan:</span>
                                <span class="fs-4 fw-bold text-success" id="textTotal">
                                    Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Assurance -->
                    <div class="text-center text-muted small mt-3">
                        <i class="fa-solid fa-shield-halved text-success me-1"></i> Transaksi terenkripsi aman &bull; Akses langsung otomatis
                    </div>
                </div>
            </div>
        </div>

        <!-- Realistic QRIS Payment Terminal Card -->
        <div class="col-lg-6 col-xl-5">
            <div class="card border-0 shadow-lg text-center" style="background: #ffffff !important; color: #1e293b !important; border-radius: 20px !important;">
                <div class="p-4">
                    <!-- QRIS Header -->
                    <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3">
                        <div class="text-start">
                            <span class="badge bg-danger text-white fw-bold px-2 py-1" style="font-size: 0.9rem; letter-spacing: 0.05em;">
                                QRIS
                            </span>
                            <span class="small text-muted d-block mt-1" style="font-size: 0.725rem;">QR Code Indonesian Standard</span>
                        </div>
                        <div class="text-end">
                            <span class="fw-bold text-dark fs-6">BOOK STORE JOTI</span>
                            <span class="small text-muted d-block" style="font-size: 0.7rem;">NMID: ID1020261800091</span>
                        </div>
                    </div>

                    <!-- Countdown Timer -->
                    <div class="d-inline-flex align-items-center gap-1 bg-light px-3 py-1 rounded-pill small mb-3 border">
                        <i class="fa-regular fa-clock text-danger"></i>
                        <span class="text-muted">Selesaikan dalam:</span>
                        <strong class="text-danger" id="timer">14:59</strong>
                    </div>

                    <!-- QR Code Frame -->
                    <div class="p-3 bg-white rounded-3 shadow-sm d-inline-block border mb-3">
                        <img id="qrisImage" 
                             src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=00020101021126610014ID.LINKAJA.WWW01189360091100202618005204581453033605802ID5915BOOK+STORE+JOTI6007BANDUNG61054011562070703A016304" 
                             alt="QRIS Code Pembayaran" 
                             style="width: 200px; height: 200px; object-fit: contain;" />
                    </div>

                    <!-- Total Amount Display -->
                    <div class="mb-3">
                        <small class="text-muted d-block text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Jumlah Pembayaran</small>
                        <h3 class="fw-bold text-danger mb-0" id="qrisTotalDisplay">
                            Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                        </h3>
                    </div>

                    <!-- Supported E-Wallets -->
                    <div class="d-flex justify-content-center align-items-center gap-2 mb-4 flex-wrap">
                        <span class="badge bg-light text-dark border">BCA</span>
                        <span class="badge bg-light text-dark border">Mandiri</span>
                        <span class="badge bg-light text-dark border">BRI</span>
                        <span class="badge bg-light text-dark border">GoPay</span>
                        <span class="badge bg-light text-dark border">OVO</span>
                        <span class="badge bg-light text-dark border">Dana</span>
                        <span class="badge bg-light text-dark border">ShopeePay</span>
                    </div>

                    <!-- Submit Payment Confirmation -->
                    <form method="POST" action="{{ route('pembeli.bayar.qris') }}">
                        @csrf
                        <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}" />
                        <input type="hidden" name="jumlah" id="formJumlah" value="1" />

                        <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-bold shadow">
                            <i class="fa-solid fa-circle-check me-2"></i> Saya Sudah Bayar via QRIS
                        </button>
                    </form>

                    <small class="text-muted d-block mt-3" style="font-size: 0.75rem;">
                        Setelah mengklik tombol konfirmasi, buku Anda otomatis masuk ke menu <b>Koleksi E-Book Saya</b>.
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const hargaSatuan = {{ $produk->harga_jual }};
    const maxStok = {{ $produk->stok }};

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
    }

    function ubahJumlah(delta) {
        const input = document.getElementById('inputQty');
        let val = parseInt(input.value) || 1;
        val += delta;
        if (val < 1) val = 1;
        if (val > maxStok) val = maxStok;

        input.value = val;
        document.getElementById('formJumlah').value = val;

        const total = val * hargaSatuan;
        document.getElementById('textTotal').innerText = formatRupiah(total);
        document.getElementById('qrisTotalDisplay').innerText = formatRupiah(total);
    }

    // Countdown Timer Demo
    let timeLeft = 15 * 60;
    const timerElem = document.getElementById('timer');
    setInterval(function() {
        if (timeLeft <= 0) return;
        timeLeft--;
        const m = Math.floor(timeLeft / 60);
        const s = timeLeft % 60;
        timerElem.innerText = (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
    }, 1000);
</script>
@endpush
