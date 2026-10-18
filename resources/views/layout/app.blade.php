<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Book Store Joti' }}</title>
    
    <!-- Google Fonts & Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-theme.css') }}" rel="stylesheet">
</head>
<body>

    <!-- Header Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ Auth::check() && Auth::user()->level === 'pembeli' ? route('pembeli.katalog') : route('home') }}">
                <span class="brand-icon">
                    <i class="fa-solid fa-book-open"></i>
                </span>
                <span>Book Store <span class="text-primary-subtle fw-light">Joti</span></span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3 gap-1">
                    @auth
                        @if (Auth::user()->level === 'pembeli')
                            <!-- Menu Pembeli / Customer -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pembeli.katalog') || request()->routeIs('pembeli.checkout') ? 'active' : '' }}" href="{{ route('pembeli.katalog') }}">
                                    <i class="fa-solid fa-store"></i> Belanja Buku (QRIS)
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pembeli.koleksi') || request()->routeIs('pembeli.baca') ? 'active' : '' }}" href="{{ route('pembeli.koleksi') }}">
                                    <i class="fa-solid fa-book-bookmark text-warning"></i> Koleksi E-Book Saya
                                </a>
                            </li>
                        @else
                            <!-- Menu Admin & Kasir -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                                </a>
                            </li>

                            @if (Auth::user()->level === 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                                    <i class="fa-solid fa-users-gear"></i> Kelola User
                                </a>
                            </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                                    <i class="fa-solid fa-layer-group"></i> Kategori
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('produk.*') ? 'active' : '' }}" href="{{ route('produk.index') }}">
                                    <i class="fa-solid fa-book"></i> Katalog Buku
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('penjualan.*') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">
                                    <i class="fa-solid fa-cash-register"></i> Transaksi Kasir
                                </a>
                            </li>

                            <li class="nav-item ms-lg-2">
                                <a class="nav-link text-info {{ request()->routeIs('pembeli.*') ? 'active' : '' }}" href="{{ route('pembeli.katalog') }}">
                                    <i class="fa-solid fa-bag-shopping"></i> Mode Pembeli
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link user-dropdown-btn dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="user-avatar-circle">
                                {{ strtoupper(substr(Auth::user()->nama_user, 0, 1)) }}
                            </span>
                            <span class="d-flex flex-column text-start me-1">
                                <span class="fw-bold" style="font-size: 0.85rem; line-height: 1.1;">{{ Auth::user()->nama_user }}</span>
                                <span class="badge-role 
                                    @if(Auth::user()->level == 'admin') badge-role-admin 
                                    @elseif(Auth::user()->level == 'pembeli') badge-role-pembeli
                                    @else badge-role-user @endif mt-1">
                                    {{ ucfirst(Auth::user()->level) }}
                                </span>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2">
                            <li class="dropdown-header text-muted small">Akun Anda</li>
                            @if(Auth::user()->level === 'pembeli')
                                <li><a class="dropdown-item py-2" href="{{ route('pembeli.koleksi') }}"><i class="fa-solid fa-book-bookmark text-warning me-2"></i> Buku Saya</a></li>
                            @endif
                            <li><a class="dropdown-item py-2" href="{{ route('user.password') }}"><i class="fa-solid fa-key text-warning me-2"></i> Ubah Password</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item py-2 text-danger fw-semibold" href="{{ route('user.logout') }}">
                                    <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item d-flex gap-2">
                        <a class="btn btn-outline-secondary btn-sm px-3" href="{{ route('login') }}">
                            <i class="fa-solid fa-right-to-bracket"></i> Masuk
                        </a>
                        <a class="btn btn-primary btn-sm px-3" href="{{ route('register') }}">
                            <i class="fa-solid fa-user-plus"></i> Daftar
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container Content -->
    <main class="container my-4 flex-grow-1">
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check fs-5 me-2"></i>
                <div>{{ session('message') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold text-white">Book Store Joti</span>
                <span>&copy; {{ date('Y') }} • Toko Buku Digital & Pembayaran QRIS</span>
            </div>
            <div class="d-flex align-items-center gap-3 small">
                <span class="text-success d-inline-flex align-items-center gap-1">
                    <i class="fa-solid fa-qrcode text-primary"></i> QRIS Ready
                </span>
                <span class="text-muted">Akses & Download E-Book Instan</span>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
