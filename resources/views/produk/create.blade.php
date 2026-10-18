@extends('layout.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1 text-white">
                <i class="fa-solid fa-plus text-primary me-2"></i>Tambah Buku Baru
            </h2>
            <p class="text-muted mb-0">Lengkapi formulir di bawah ini untuk menambahkan koleksi buku baru</p>
        </div>
        <a class="btn btn-outline-secondary" href="{{ route('produk.index') }}">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog
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
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header py-3">
                    <span class="fw-bold text-white"><i class="fa-solid fa-book-medical text-primary me-2"></i>Informasi Buku</span>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Judul Buku <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="nama_produk" value="{{ old('nama_produk') }}" placeholder="Contoh: Laskar Pelangi" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori Buku <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Harga Beli (Modal) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input class="form-control" type="number" name="harga_beli" value="{{ old('harga_beli') }}" placeholder="0" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Harga Jual <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input class="form-control" type="number" name="harga_jual" value="{{ old('harga_jual') }}" placeholder="0" required />
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok Awal <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" min="0" name="stok" value="{{ old('stok', 0) }}" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto / Cover Buku</label>
                            <input class="form-control" type="file" name="gambar" accept="image/*" />
                            <small class="text-muted">Format yang didukung: JPG, PNG, WEBP (Maksimal 2MB).</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-warning"><i class="fa-solid fa-file-pdf me-1"></i> File E-Book Digital (PDF/Epub)</label>
                            <input class="form-control" type="file" name="file_buku" accept=".pdf,.epub,.doc,.docx" />
                            <small class="text-muted">File ini yang akan dapat langsung dibaca dan diunduh oleh pembeli setelah pembayaran QRIS berhasil.</small>
                        </div>

                        <div class="d-flex gap-2 pt-2 border-top" style="border-color: #334155 !important;">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Buku
                            </button>
                            <a class="btn btn-outline-secondary px-4" href="{{ route('produk.index') }}">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-white mb-3">
                        <i class="fa-solid fa-circle-info text-primary me-2"></i>Petunjuk Input
                    </h6>
                    <ul class="text-muted small ps-3 mb-0 d-flex flex-column gap-2">
                        <li>Pastikan harga jual lebih tinggi dari harga beli untuk menjaga margin keuntungan.</li>
                        <li>Stok awal minimal bernilai 0. Jika stok 0, status produk otomatis bertanda <b>Habis</b>.</li>
                        <li>Cover buku direkomendasikan memiliki rasio 3:4 atau format potret agar terlihat serasi di katalog.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
