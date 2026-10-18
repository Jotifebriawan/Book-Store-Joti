<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Akun Pembeli - Book Store Joti</title>
    
    <!-- Google Fonts & Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-theme.css') }}" rel="stylesheet">
</head>

<body class="login-body">
    <div class="login-card" style="max-width: 500px;">
        <div class="login-card-header text-center pt-4 pb-2">
            <div class="login-brand-logo mx-auto">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h1 class="login-title h3 fw-bold mt-2 mb-1 text-white">Daftar Akun <span class="text-primary">Pembeli</span></h1>
            <p class="login-subtitle small text-muted">Buat akun untuk mulai membeli dan mengunduh e-book</p>
        </div>

        <div class="login-card-body p-4 pt-2">
            @if ($errors->any())
                <div class="alert alert-danger py-2 px-3 mb-3 small" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i>
                    <div>
                        @foreach ($errors->all() as $err)
                            <div>{{ $err }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('user.register.action') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-icon-group position-relative">
                        <i class="fa-solid fa-user position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input class="form-control ps-5" type="text" name="nama_user" value="{{ old('nama_user') }}" placeholder="Contoh: Rian Pratama" required autofocus />
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <div class="input-icon-group position-relative">
                            <i class="fa-solid fa-at position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <input class="form-control ps-5" type="text" name="username" value="{{ old('username') }}" placeholder="Username unik" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <div class="input-icon-group position-relative">
                            <i class="fa-solid fa-lock position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <input class="form-control ps-5" type="password" name="password" placeholder="Min. 4 karakter" required />
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Email</label>
                    <div class="input-icon-group position-relative">
                        <i class="fa-solid fa-envelope position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input class="form-control ps-5" type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required />
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Nomor WhatsApp / Telepon</label>
                    <div class="input-icon-group position-relative">
                        <i class="fa-solid fa-phone position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input class="form-control ps-5" type="text" name="telpon" value="{{ old('telpon') }}" placeholder="08xxxxxxxxxx" required />
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fs-6 fw-bold mb-3">
                    <i class="fa-solid fa-check me-1"></i> Buat Akun Pembeli Sekarang
                </button>

                <div class="text-center small text-muted">
                    Sudah memiliki akun? <a href="{{ route('login') }}" class="text-info fw-bold">Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
