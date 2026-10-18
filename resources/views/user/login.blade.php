<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Book Store Joti</title>
    
    <!-- Google Fonts & Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-theme.css') }}" rel="stylesheet">
</head>

<body class="login-body">
    <div class="login-card">
        <div class="login-card-header text-center pt-4 pb-2">
            <div class="login-brand-logo mx-auto">
                <i class="fa-solid fa-book-open-reader"></i>
            </div>
            <h1 class="login-title h3 fw-bold mt-2 mb-1 text-white">Book Store <span class="text-primary">Joti</span></h1>
            <p class="login-subtitle small text-muted">Silakan masuk untuk mengelola toko buku</p>
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

            <form method="POST" action="{{ route('user.login.action') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-icon-group position-relative">
                        <i class="fa-solid fa-user position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input id="inputUsername" class="form-control ps-5" type="text" placeholder="Masukkan username" name="username" value="{{ old('username') }}" required autofocus />
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-icon-group position-relative">
                        <i class="fa-solid fa-lock position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input id="inputPassword" class="form-control ps-5" type="password" placeholder="Masukkan password" name="password" required />
                    </div>
                </div>

                <!-- Quick Fill Demo Accounts -->
                <div class="mb-4 p-3 rounded-3 border" style="background: #0f172a; border-color: #334155 !important;">
                    <div class="small fw-semibold mb-2 d-flex align-items-center gap-1 text-secondary">
                        <i class="fa-solid fa-wand-magic-sparkles text-primary"></i> Klik Akun Cepat (Demo):
                    </div>
                    <div class="row g-2">
                        <div class="col-4">
                            <button type="button" class="demo-account-badge w-100 justify-content-center px-1 py-2" onclick="fillAccount('admin', 'admin')">
                                <i class="fa-solid fa-shield-halved text-primary me-1"></i> <b>Admin</b>
                            </button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="demo-account-badge w-100 justify-content-center px-1 py-2" onclick="fillAccount('user', 'user')">
                                <i class="fa-solid fa-user-tag text-success me-1"></i> <b>Kasir</b>
                            </button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="demo-account-badge w-100 justify-content-center px-1 py-2" onclick="fillAccount('pembeli', 'pembeli')">
                                <i class="fa-solid fa-cart-shopping text-warning me-1"></i> <b>Pembeli</b>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fs-6 fw-bold mb-3">
                    <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk Sekarang
                </button>

                <div class="text-center small text-muted">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-info fw-bold">Daftar sebagai Pembeli</a>
                </div>
            </form>

            <div class="text-center mt-3 pt-3 border-top" style="border-color: #334155 !important;">
                <small class="text-muted">
                    <i class="fa-solid fa-shield-halved text-success me-1"></i> Sistem Autentikasi Aman &bull; Laravel 10
                </small>
            </div>
        </div>
    </div>

    <script>
        function fillAccount(username, password) {
            document.getElementById('inputUsername').value = username;
            document.getElementById('inputPassword').value = password;
        }
    </script>
</body>
</html>