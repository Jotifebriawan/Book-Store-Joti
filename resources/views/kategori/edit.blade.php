@extends('layout.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1">
                <i class="fa-solid fa-pen-to-square text-warning me-2"></i>Ubah Kategori Buku
            </h2>
            <p class="text-muted mb-0">Perbarui nama kategori: <strong>{{ $kategori->nama_kategori }}</strong></p>
        </div>
        <a class="btn btn-outline-secondary" href="{{ route('kategori.index') }}">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
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

    <div class="row">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <span class="fw-bold"><i class="fa-solid fa-pen-to-square text-warning me-2"></i>Formulir Perubahan Kategori</span>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('kategori.update', $kategori) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted">Nama Kategori <span class="text-danger">*</span></label>
                            <input class="form-control form-control-lg" type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required autofocus />
                        </div>
                        <div class="d-flex gap-2 pt-2 border-top">
                            <button type="submit" class="btn btn-warning px-4 text-white">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                            </button>
                            <a class="btn btn-light border px-4" href="{{ route('kategori.index') }}">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
