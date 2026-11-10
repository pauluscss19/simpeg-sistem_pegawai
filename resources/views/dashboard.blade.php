@extends('layouts.app')

@section('title', 'Dashboard Statistik Pegawai')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h2 class="h3 fw-bold mb-1">Dashboard Statistik Pegawai</h2>
        <p class="text-muted mb-0">Visualisasi data demografi pegawai secara aktual berdasarkan database.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('pegawai.create') }}" class="btn btn-primary d-flex align-items-center gap-1 shadow-sm">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span>Tambah Pegawai Baru</span>
        </a>
        <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="8" y1="6" x2="21" y2="6"></line>
                <line x1="8" y1="12" x2="21" y2="12"></line>
                <line x1="8" y1="18" x2="21" y2="18"></line>
                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                <line x1="3" y1="18" x2="3.01" y2="18"></line>
            </svg>
            <span>Kelola Data Pegawai</span>
        </a>
    </div>
</div>

<!-- Kartu Ringkasan Statistik -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card blue">
            <div class="stat-label">Total Pegawai</div>
            <div class="stat-number">{{ $totalPegawai }}</div>
            <small class="text-muted">Orang terdaftar di sistem</small>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card blue">
            <div class="stat-label">Pegawai Laki-laki</div>
            <div class="stat-number text-primary">{{ $totalLakiLaki }}</div>
            <small class="text-muted">
                {{ $totalPegawai > 0 ? round(($totalLakiLaki / $totalPegawai) * 100, 1) : 0 }}% dari total pegawai
            </small>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card purple">
            <div class="stat-label">Pegawai Perempuan</div>
            <div class="stat-number text-danger">{{ $totalPerempuan }}</div>
            <small class="text-muted">
                {{ $totalPegawai > 0 ? round(($totalPerempuan / $totalPegawai) * 100, 1) : 0 }}% dari total pegawai
            </small>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card amber">
            <div class="stat-label">Rata-Rata Usia</div>
            <div class="stat-number text-warning">{{ $rataRataUsia }} <span class="fs-6 fw-normal text-muted">Tahun</span></div>
            <small class="text-muted">Dihitung dari tanggal lahir</small>
        </div>
    </div>
</div>

@if ($totalPegawai === 0)
    <!-- Pesan Jelas Jika Data Masih Kosong -->
    <div class="main-card p-5 text-center my-4">
        <div class="mb-3">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
        </div>
        <h4 class="fw-bold text-slate-700">Belum Ada Data Pegawai di Database</h4>
        <p class="text-muted max-w-md mx-auto" style="max-width: 500px;">
            Grafik statistik belum dapat ditampilkan karena tabel pegawai masih kosong. Silakan tambahkan data pegawai baru untuk melihat visualisasi aktual.
        </p>
        <div class="d-flex justify-content-center gap-2 mt-3">
            <a href="{{ route('pegawai.create') }}" class="btn btn-primary px-4">
                + Tambah Pegawai Pertama
            </a>
        </div>
    </div>
@else
    <!-- Tiga Grafik Berdasarkan Data Aktual di Database -->
    <div class="row g-4">
        <!-- 1. Grafik Batang Perbandingan Jenis Kelamin -->
        <div class="col-lg-6">
            <div class="card main-card h-100">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-bold mb-0">1. Perbandingan Jenis Kelamin</h5>
                        <small class="text-muted">Grafik batang perbandingan jumlah laki-laki dan perempuan</small>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border">Grafik Batang</span>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chartGenderCanvas"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-light border-top py-2">
                    <div class="d-flex justify-content-around text-center small">
                        <div>
                            <span class="d-inline-block rounded-circle me-1" style="width: 10px; height: 10px; background-color: #3b82f6;"></span>
                            <strong>Laki-laki:</strong> {{ $genderCounts['Laki-laki'] }} orang
                        </div>
                        <div>
                            <span class="d-inline-block rounded-circle me-1" style="width: 10px; height: 10px; background-color: #ec4899;"></span>
                            <strong>Perempuan:</strong> {{ $genderCounts['Perempuan'] }} orang
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Grafik Berdasarkan Pendidikan Terakhir -->
        <div class="col-lg-6">
            <div class="card main-card h-100">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-bold mb-0">2. Jenjang Pendidikan Terakhir</h5>
                        <small class="text-muted">Distribusi pegawai berdasarkan kualifikasi pendidikan</small>
                    </div>
                    <span class="badge bg-success-subtle text-success border">Grafik Batang</span>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chartPendidikanCanvas"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-light border-top py-2 text-muted small text-center">
                    Semua jenjang (termasuk bernilai nol) ditampilkan secara konsisten
                </div>
            </div>
        </div>

        <!-- 3. Grafik Berdasarkan Kelompok Usia -->
        <div class="col-12">
            <div class="card main-card">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-bold mb-0">3. Kelompok Usia Pegawai</h5>
                        <small class="text-muted">Distribusi usia dihitung dari tanggal lahir terhadap tanggal hari ini ({{ date('d-m-Y') }})</small>
                    </div>
                    <span class="badge bg-warning-subtle text-warning border">Kelompok Usia</span>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 320px;">
                        <canvas id="chartUsiaCanvas"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-light border-top py-2">
                    <div class="row text-center small text-muted g-2">
                        @foreach ($usiaCounts as $kategori => $jumlah)
                            <div class="col">
                                <strong>{{ $kategori }}:</strong> {{ $jumlah }} orang
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
@if ($totalPegawai > 0)
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Data yang dikirim dari controller melalui serialisasi JSON aman
        const dataGender = {!! $chartGenderJson !!};
        const dataPendidikan = {!! $chartPendidikanJson !!};
        const dataUsia = {!! $chartUsiaJson !!};

        // Konfigurasi umum Chart.js
        Chart.defaults.font.family = 'system-ui, -apple-system, sans-serif';
        Chart.defaults.font.size = 12;
        Chart.defaults.color = '#475569';

        // 1. Inisialisasi Grafik Batang Jenis Kelamin
        const ctxGender = document.getElementById('chartGenderCanvas');
        if (ctxGender) {
            new Chart(ctxGender, {
                type: 'bar',
                data: {
                    labels: dataGender.labels,
                    datasets: [{
                        label: 'Jumlah Pegawai',
                        data: dataGender.data,
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.85)', // Biru untuk Laki-laki
                            'rgba(236, 72, 153, 0.85)'  // Pink untuk Perempuan
                        ],
                        borderColor: [
                            '#2563eb',
                            '#db2777'
                        ],
                        borderWidth: 2,
                        borderRadius: 8,
                        maxBarThickness: 70
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.parsed.y + ' Pegawai';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            },
                            grid: { color: '#f1f5f9' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // 2. Inisialisasi Grafik Batang Pendidikan Terakhir
        const ctxPendidikan = document.getElementById('chartPendidikanCanvas');
        if (ctxPendidikan) {
            new Chart(ctxPendidikan, {
                type: 'bar',
                data: {
                    labels: dataPendidikan.labels,
                    datasets: [{
                        label: 'Jumlah Pegawai',
                        data: dataPendidikan.data,
                        backgroundColor: 'rgba(16, 185, 129, 0.85)',
                        borderColor: '#059669',
                        borderWidth: 2,
                        borderRadius: 6,
                        maxBarThickness: 50
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.parsed.y + ' Pegawai';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            },
                            grid: { color: '#f1f5f9' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // 3. Inisialisasi Grafik Kelompok Usia
        const ctxUsia = document.getElementById('chartUsiaCanvas');
        if (ctxUsia) {
            new Chart(ctxUsia, {
                type: 'bar',
                data: {
                    labels: dataUsia.labels,
                    datasets: [{
                        label: 'Jumlah Pegawai',
                        data: dataUsia.data,
                        backgroundColor: [
                            'rgba(14, 165, 233, 0.85)',
                            'rgba(99, 102, 241, 0.85)',
                            'rgba(168, 85, 247, 0.85)',
                            'rgba(245, 158, 11, 0.85)',
                            'rgba(239, 68, 68, 0.85)'
                        ],
                        borderColor: [
                            '#0284c7',
                            '#4f46e5',
                            '#9333ea',
                            '#d97706',
                            '#dc2626'
                        ],
                        borderWidth: 2,
                        borderRadius: 8,
                        maxBarThickness: 65
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.parsed.y + ' Pegawai';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            },
                            grid: { color: '#f1f5f9' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }
    });
</script>
@endif
@endpush

