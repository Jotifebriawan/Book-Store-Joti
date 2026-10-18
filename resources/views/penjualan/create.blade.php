@extends('layout.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1 text-white">
                <i class="fa-solid fa-cart-plus text-primary me-2"></i>Catat Transaksi Penjualan
            </h2>
            <p class="text-muted mb-0">Input transaksi penjualan buku kasir dengan pemotongan stok otomatis</p>
        </div>
        <a class="btn btn-outline-secondary" href="{{ route('penjualan.index') }}">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat
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

    <div class="row g-4">
        <!-- Input Form -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header py-3">
                    <span class="fw-bold text-white"><i class="fa-solid fa-file-invoice-dollar text-primary me-2"></i>Formulir Transaksi</span>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('penjualan.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Tanggal Transaksi</label>
                            <input class="form-control" type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pilih Buku / Produk</label>
                            <select class="form-select form-select-lg" name="id_produk" id="selectProduk" onchange="hitung()" required>
                                <option value="">-- Pilih Buku yang Dibeli --</option>
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->id_produk }}" 
                                            data-harga="{{ $produk->harga_jual }}"
                                            data-nama="{{ $produk->nama_produk }}"
                                            data-stok="{{ $produk->stok }}"
                                            {{ old('id_produk') == $produk->id_produk ? 'selected' : '' }}>
                                        {{ $produk->nama_produk }} (Stok: {{ $produk->stok }} | Rp {{ number_format($produk->harga_jual, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Harga Satuan (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">Rp</span>
                                    <input class="form-control border-start-0" type="number" name="harga" id="inputHarga" value="{{ old('harga') }}" readonly required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jumlah Beli (Qty)</label>
                                <div class="input-group">
                                    <input class="form-control form-control-lg fw-bold" type="number" min="1" name="jumlah" id="inputJumlah" value="{{ old('jumlah', 1) }}" oninput="hitung()" required />
                                    <span class="input-group-text">pcs</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Total Pembayaran (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white border-primary fs-5">Rp</span>
                                <input class="form-control form-control-lg fs-4 fw-bold text-success border-primary" type="number" name="total" id="inputTotal" value="{{ old('total') }}" readonly required />
                            </div>
                        </div>

                        <div class="d-flex gap-2 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Proses & Simpan Transaksi
                            </button>
                            <a class="btn btn-outline-secondary btn-lg" href="{{ route('penjualan.index') }}">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- POS Live Preview Receipt (Dark Digital Terminal) -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header py-3 border-bottom d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-white"><i class="fa-solid fa-receipt text-success me-2"></i>Ringkasan Transaksi</span>
                    <span class="badge-soft badge-soft-success px-2 py-1">Kasir Siap</span>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="text-center pb-3 border-bottom mb-3" style="border-color: #334155 !important;">
                            <h5 class="fw-bold mb-0 text-white">BOOK STORE JOTI</h5>
                            <small class="text-muted">Struk Nota Digital Transaksi</small>
                        </div>

                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Operator:</span>
                            <span class="fw-bold text-white">{{ Auth::user()->nama_user }}</span>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Tanggal:</span>
                            <span class="fw-bold text-white" id="previewTanggal">{{ date('d M Y') }}</span>
                        </div>

                        <div class="p-3 rounded-3 my-3 border" style="background: #0f172a; border-color: #334155 !important;">
                            <div class="small text-muted mb-1">Item Buku:</div>
                            <div class="fw-bold fs-6 text-white" id="previewBuku">Belum dipilih</div>
                            <div class="d-flex justify-content-between small text-muted mt-2">
                                <span id="previewHargaSatuan" class="text-secondary">Rp 0 x 0 pcs</span>
                                <span class="fw-bold text-info" id="previewSubtotal">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-top mt-auto" style="border-color: #334155 !important;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold text-muted">TOTAL AKHIR:</span>
                            <span class="fs-3 fw-bold text-success" id="previewTotal">Rp 0</span>
                        </div>
                        <small class="text-muted d-block text-center mt-3">
                            <i class="fa-solid fa-shield-check text-primary me-1"></i> Stok otomatis terpotong saat transaksi disimpan
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
    }

    function hitung() {
        const select = document.getElementById('selectProduk');
        const selectedOption = select.options[select.selectedIndex];
        
        const harga = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
        const nama = selectedOption.getAttribute('data-nama') || 'Belum dipilih';
        const jumlahInput = document.getElementById('inputJumlah');
        let jumlah = parseInt(jumlahInput.value) || 0;

        if (jumlah < 1 && select.value !== '') {
            jumlah = 1;
            jumlahInput.value = 1;
        }

        const total = harga * jumlah;

        document.getElementById('inputHarga').value = harga;
        document.getElementById('inputTotal').value = total;

        // Update Live Receipt Preview
        document.getElementById('previewBuku').innerText = nama;
        document.getElementById('previewHargaSatuan').innerText = formatRupiah(harga) + ' x ' + jumlah + ' pcs';
        document.getElementById('previewSubtotal').innerText = formatRupiah(total);
        document.getElementById('previewTotal').innerText = formatRupiah(total);
    }

    document.addEventListener('DOMContentLoaded', function() {
        hitung();
    });
</script>
@endpush