@extends('layout.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1 text-white">
                <i class="fa-solid fa-pen-to-square text-warning me-2"></i>Ubah Data Buku
            </h2>
            <p class="text-muted mb-0">Perbarui informasi, harga, dan stok buku: <strong class="text-white">{{ $produk->nama_produk }}</strong></p>
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
                    <span class="fw-bold text-white"><i class="fa-solid fa-file-pen text-warning me-2"></i>Formulir Perubahan Buku</span>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('produk.update', $produk) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Judul Buku <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori Buku <span class="text-danger">*</span></label>
                            <select class="form-select" name="id_kategori" required>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori', $produk->id_kategori) == $kategori->id_kategori ? 'selected' : '' }}>
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
                                    <input class="form-control" type="number" name="harga_beli" value="{{ old('harga_beli', $produk->harga_beli) }}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Harga Jual <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input class="form-control" type="number" name="harga_jual" value="{{ old('harga_jual', $produk->harga_jual) }}" required />
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok Persediaan <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" min="0" name="stok" value="{{ old('stok', $produk->stok) }}" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ganti Cover Buku</label>
                            <input class="form-control" type="file" name="gambar" accept="image/*" />
                            <small class="text-muted d-block mt-1">Biarkan kosong jika tidak ingin mengubah cover gambar.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-warning"><i class="fa-solid fa-file-pdf me-1"></i> File E-Book Digital (PDF/Epub)</label>
                            @if ($produk->hasFileBuku())
                                <div class="mb-2 small text-success">
                                    <i class="fa-solid fa-circle-check"></i> File saat ini terpasang: <b>{{ $produk->file_buku }}</b>
                                </div>
                            @endif
                            <input class="form-control" type="file" name="file_buku" accept=".pdf,.epub,.doc,.docx" />
                            <small class="text-muted d-block mt-1">Unggah file baru jika ingin mengganti file e-book yang dapat diakses pembeli.</small>
                        </div>

                        <div class="d-flex gap-2 pt-2 border-top" style="border-color: #334155 !important;">
                            <button type="submit" class="btn btn-warning px-4 text-white">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
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
            <div class="card border-0 shadow-sm text-center p-4">
                <h6 class="fw-bold text-white mb-3">Cover Buku Saat Ini</h6>
                <div class="d-inline-block p-2 rounded-3 border mb-3" style="background: #0f172a; border-color: #334155 !important;">
                    <img src="{{ $produk->getImage() }}" alt="{{ $produk->nama_produk }}" 
                         class="rounded shadow-sm" 
                         style="max-height: 180px; width: auto; max-width: 100%; object-fit: contain;" />
                </div>
                <div class="small text-muted">
                    ID Produk: #{{ $produk->id_produk }}<br>
                    Terakhir diperbarui: {{ $produk->updated_at ? $produk->updated_at->diffForHumans() : '-' }}
                </div>
            </div>
        </div>
    </div>
@endsection