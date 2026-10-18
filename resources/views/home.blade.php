@extends('layout.app')

@section('content')
    <!-- Hero Welcome Banner -->
    <div class="hero-banner">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill small mb-2" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);">
                    <span class="badge bg-success rounded-pill px-2 py-1">Sistem Online</span>
                    <span class="text-white-50"><i class="fa-regular fa-calendar me-1"></i> {{ date('l, d F Y') }}</span>
                </div>
                <h1 class="hero-title">
                    Selamat Datang, {{ Auth::user()->nama_user }}! 👋
                </h1>
                <p class="hero-subtitle">
                    Kelola inventaris toko buku, pantau performa penjualan, dan catat transaksi harian dengan mudah dan cepat.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-cart-plus"></i> Transaksi Baru
                    </a>
                    <a href="{{ route('produk.create') }}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-plus"></i> Tambah Buku
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end d-none d-lg-block">
                <i class="fa-solid fa-book-bookmark text-white opacity-25" style="font-size: 8.5rem;"></i>
            </div>
        </div>
    </div>

    <!-- 4 KPI Stat Cards Row -->
    <div class="row g-3 mb-4">
        <!-- Total Produk -->
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card stat-card-blue">
                <div>
                    <div class="stat-header">
                        <span class="stat-title">Total Produk Buku</span>
                        <div class="stat-icon">
                            <i class="fa-solid fa-book"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ number_format($jumlah_produk) }}</div>
                    <div class="small text-white-50">Katalog buku terdaftar</div>
                </div>
                <div class="mt-3 pt-3 border-top border-white border-opacity-10">
                    <a href="{{ route('produk.index') }}" class="stat-link">
                        Lihat Katalog <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Transaksi (Rupiah) -->
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card stat-card-green">
                <div>
                    <div class="stat-header">
                        <span class="stat-title">Total Pendapatan</span>
                        <div class="stat-icon">
                            <i class="fa-solid fa-money-bill-wave"></i>
                        </div>
                    </div>
                    <div class="stat-value" style="font-size: 1.55rem;">Rp {{ number_format($total_transaksi, 0, ',', '.') }}</div>
                    <div class="small text-white-50">Akumulasi penjualan</div>
                </div>
                <div class="mt-3 pt-3 border-top border-white border-opacity-10">
                    <a href="{{ route('penjualan.index') }}" class="stat-link">
                        Riwayat Transaksi <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Jumlah Transaksi -->
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card stat-card-cyan">
                <div>
                    <div class="stat-header">
                        <span class="stat-title">Jumlah Transaksi</span>
                        <div class="stat-icon">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ number_format($jumlah_transaksi) }}</div>
                    <div class="small text-white-50">Total struk terbit</div>
                </div>
                <div class="mt-3 pt-3 border-top border-white border-opacity-10">
                    <a href="{{ route('penjualan.index') }}" class="stat-link">
                        Kelola Transaksi <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total User -->
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card stat-card-amber">
                <div>
                    <div class="stat-header">
                        <span class="stat-title">Total Pengguna</span>
                        <div class="stat-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ number_format($jumlah_user) }}</div>
                    <div class="small text-white-50">Admin & Kasir</div>
                </div>
                <div class="mt-3 pt-3 border-top border-white border-opacity-10">
                    @if (Auth::user()->level == 'admin')
                        <a href="{{ route('user.index') }}" class="stat-link">
                            Kelola Pengguna <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    @else
                        <span class="small text-white-50">Level: {{ ucfirst(Auth::user()->level) }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chart & Analytics Section -->
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 rounded-3" style="background: rgba(99, 102, 241, 0.2); color: #818cf8;">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-white">Grafik Tren Penjualan</h6>
                            <small class="text-muted">Aktivitas penjualan per tanggal</small>
                        </div>
                    </div>
                    <div>
                        <span class="badge border" style="background: #0f172a; color: #94a3b8; border-color: #334155 !important;">30 Hari Terakhir</span>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div id="containerChart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Highcharts Lib -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Highcharts.chart('containerChart', {
                chart: {
                    type: 'areaspline',
                    style: {
                        fontFamily: "'Plus Jakarta Sans', sans-serif"
                    },
                    backgroundColor: 'transparent'
                },
                title: {
                    text: null
                },
                xAxis: {
                    categories: {!! json_encode($categories) !!},
                    labels: {
                        style: {
                            color: '#94a3b8',
                            fontSize: '12px'
                        }
                    },
                    lineColor: '#334155',
                    tickColor: '#334155'
                },
                yAxis: {
                    title: {
                        text: 'Total Penjualan (Rp)',
                        style: {
                            color: '#cbd5e1',
                            fontWeight: '600'
                        }
                    },
                    gridLineColor: '#273549',
                    labels: {
                        formatter: function () {
                            return 'Rp ' + Highcharts.numberFormat(this.value, 0, ',', '.');
                        },
                        style: {
                            color: '#94a3b8'
                        }
                    }
                },
                tooltip: {
                    shared: true,
                    useHTML: true,
                    headerFormat: '<small style="color:#94a3b8">{point.key}</small><br/>',
                    pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: <b style="color:#38bdf8;">Rp {point.y:,.0f}</b>',
                    backgroundColor: '#0f172a',
                    borderColor: '#334155',
                    borderWidth: 1,
                    style: {
                        color: '#f8fafc'
                    },
                    borderRadius: 10,
                    shadow: true
                },
                plotOptions: {
                    areaspline: {
                        fillColor: {
                            linearGradient: {
                                x1: 0,
                                y1: 0,
                                x2: 0,
                                y2: 1
                            },
                            stops: [
                                [0, 'rgba(99, 102, 241, 0.45)'],
                                [1, 'rgba(99, 102, 241, 0.00)']
                            ]
                        },
                        marker: {
                            radius: 4,
                            lineColor: '#818cf8',
                            lineWidth: 2,
                            fillColor: '#1e293b'
                        },
                        lineWidth: 3,
                        states: {
                            hover: {
                                lineWidth: 3
                            }
                        },
                        threshold: null
                    }
                },
                colors: ['#818cf8'],
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Total Penjualan',
                    data: {!! json_encode($data) !!}
                }]
            });
        });
    </script>
@endpush