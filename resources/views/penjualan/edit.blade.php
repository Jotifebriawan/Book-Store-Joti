@extends('layout.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1">
                <i class="fa-solid fa-pen-to-square text-warning me-2"></i>Ubah Transaksi Penjualan
            </h2>
            <p class="text-muted mb-0">Perbarui data item atau kuantitas transaksi: <strong>#{{ $penjualan->id_penjualan }}</strong></p>
        </div>
        <a class="btn btn-outline-secondary" href="{{ route('penjualan.index') }}">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat
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
        <!-- Input Form -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <span class="fw-bold"><i class="fa-solid fa-file-pen text-warning me-2"></i>Formulir Perubahan Transaksi</span>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('penjualan.update', $penjualan) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Tanggal Transaksi</label>
                            <input class="form-control" type="date" name="tanggal" value="{{ old('tanggal', $penjualan->tanggal) }}" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Buku / Produk</label>
                            <select class="form-select form-select-lg" name="id_produk" id="selectProduk" onchange="hitung()" required>
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->id_produk }}" 
                                            data-harga="{{ $produk->harga_jual }}"
                                            data-nama="{{ $produk->nama_produk }}"
                                            {{ old('id_produk', $penjualan->id_produk) == $produk->id_produk ? 'selected' : '' }}>
                                        {{ $produk->nama_produk }} (Rp {{ number_format($produk->harga_jual, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Harga Satuan (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">Rp</span>
                                    <input class="form-control bg-light border-start-0" type="number" name="harga" id="inputHarga" value="{{ old('harga', $penjualan->harga) }}" readonly required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Jumlah Beli (Qty)</label>
                                <div class="input-group">
                                    <input class="form-control form-control-lg fw-bold" type="number" min="1" name="jumlah" id="inputJumlah" value="{{ old('jumlah', $penjualan->jumlah) }}" oninput="hitung()" required />
                                    <span class="input-group-text bg-light">pcs</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted">Total Pembayaran (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-warning text-white border-warning fs-5">Rp</span>
                                <input class="form-control form-control-lg bg-light fs-4 fw-bold text-dark border-warning" type="number" name="total" id="inputTotal" value="{{ old('total', $penjualan->total) }}" readonly required />
                            </div>
                        </div>

                        <div class="d-flex gap-2 pt-2 border-top">
                            <button type="submit" class="btn btn-warning btn-lg px-4 text-white">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                            </button>
                            <a class="btn btn-light border btn-lg px-4" href="{{ route('penjualan.index') }}">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- POS Live Preview Receipt -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100 bg-white">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <span class="fw-bold"><i class="fa-solid fa-receipt text-warning me-2"></i>Nota Perubahan</span>
                    <span class="badge bg-warning-subtle text-warning px-2 py-1">Mode Edit</span>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="text-center pb-3 border-bottom mb-3">
                            <h5 class="fw-bold mb-0">BOOK STORE JOTI</h5>
                            <small class="text-muted">Perubahan Transaksi #{{ $penjualan->id_penjualan }}</small>
                        </div>

                        <div class="p-3 bg-light rounded-3 my-3 border">
                            <div class="small text-muted mb-1">Item Buku:</div>
                            <div class="fw-bold fs-6 text-dark" id="previewBuku">...</div>
                            <div class="d-flex justify-content-between small text-muted mt-2">
                                <span id="previewHargaSatuan">Rp 0 x 0 pcs</span>
                                <span class="fw-bold text-dark" id="previewSubtotal">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-top mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold text-muted">TOTAL SETELAH EDIT:</span>
                            <span class="fs-3 fw-bold text-success" id="previewTotal">Rp 0</span>
                        </div>
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