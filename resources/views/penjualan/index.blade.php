@extends('layout.app')

@section('content')
    <!-- Header & Action Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1 text-white">
                <i class="fa-solid fa-cash-register text-success me-2"></i>Transaksi Penjualan
            </h2>
            <p class="text-muted mb-0">Catatan riwayat transaksi penjualan buku dan kasir</p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-primary" href="{{ route('penjualan.create') }}">
                <i class="fa-solid fa-cart-plus"></i> Catat Transaksi Baru
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header py-3">
            <form method="GET" action="{{ route('penjualan.index') }}" class="row g-2 align-items-center w-100 m-0">
                <div class="col-md-5 col-lg-4 p-0">
                    <div class="input-group">
                        <span class="input-group-text border-end-0">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input class="form-control border-start-0 ps-0" name="q" value="{{ $q }}" placeholder="Cari nama produk..." />
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-light border">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                    @if ($q)
                        <a href="{{ route('penjualan.index') }}" class="btn btn-danger">
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
                        <th>Tanggal</th>
                        <th>Buku / Produk</th>
                        <th>Harga Satuan</th>
                        <th class="text-center">Qty</th>
                        <th>Total Bayar</th>
                        <th>Kasir / Operator</th>
                        <th width="120" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penjualans as $penjualan)
                    <tr>
                        <td class="text-center fw-semibold text-muted">{{ $no++ }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-regular fa-calendar-check text-muted"></i>
                                <span class="fw-medium text-white">{{ date('d M Y', strtotime($penjualan->tanggal)) }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-white fs-6">{{ $penjualan->nama_produk }}</div>
                            <small class="text-muted">ID Transaksi: #{{ $penjualan->id_penjualan }}</small>
                        </td>
                        <td class="text-secondary">
                            Rp {{ number_format($penjualan->harga, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <span class="badge px-2 py-1" style="background: #0f172a; color: #cbd5e1; border: 1px solid #334155;">
                                {{ number_format($penjualan->jumlah) }} pcs
                            </span>
                        </td>
                        <td>
                            <span class="fw-bold text-success fs-6">
                                Rp {{ number_format($penjualan->total, 0, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-soft badge-soft-info">
                                <i class="fa-solid fa-user-circle"></i> {{ $penjualan->nama_user ?? 'Kasir' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="btn btn-warning" href="{{ route('penjualan.edit', $penjualan) }}" title="Ubah Data">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form method="POST" class="d-inline" action="{{ route('penjualan.destroy', $penjualan) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')" title="Hapus Data">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-receipt fs-1 text-muted opacity-50 mb-3 d-block"></i>
                            <div class="fw-semibold text-white">Belum Ada Transaksi</div>
                            <p class="small text-muted mb-3">Catat penjualan buku pertama Anda sekarang.</p>
                            <a href="{{ route('penjualan.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-cart-plus"></i> Catat Transaksi Baru
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($penjualans->hasPages())
            <div class="card-footer py-3">
                {{ $penjualans->links() }}
            </div>
        @endif
    </div>
@endsection