@extends('layouts.admin')
@section('content')
<div class="container-fluid px-4">
    <!-- Page Title -->
    <h1 class="h4 font-weight-bold mb-4">Dashboard</h1>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <!-- Total Buku - Biru -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white shadow h-100 border-0">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 font-weight-light" style="font-size: 0.875rem;">Total Buku</p>
                        <h2 class="mb-2 font-weight-bold" style="font-size: 2rem;">{{ $totalBooks }}</h2>
                        <a href="{{ route('book.list') }}" class="text-white small font-weight-bold">Lihat →</a>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded p-3" style="width: 56px; height: 56px;">
                        <i class="fas fa-book fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Dipinjam - Ungu -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card text-white shadow h-100 border-0" style="background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%);">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 font-weight-light" style="font-size: 0.875rem;">Total Dipinjam</p>
                        <h2 class="mb-2 font-weight-bold" style="font-size: 2rem;">{{ $totalBorrowed }}</h2>
                        <a href="{{ route('admin.peminjaman.index') }}" class="text-white small font-weight-bold">Lihat →</a>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded p-3" style="width: 56px; height: 56px;">
                        <i class="fas fa-book-open fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pengembalian - Hijau -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white shadow h-100 border-0">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 font-weight-light" style="font-size: 0.875rem;">Total Pengembalian</p>
                        <h2 class="mb-2 font-weight-bold" style="font-size: 2rem;">{{ $totalReturned }}</h2>
                        <a href="{{ route('admin.pengembalian.index') }}" class="text-white small font-weight-bold">Lihat →</a>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded p-3" style="width: 56px; height: 56px;">
                        <i class="fas fa-rotate-left fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total User - Orange -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white shadow h-100 border-0">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 font-weight-light" style="font-size: 0.875rem;">Total User</p>
                        <h2 class="mb-2 font-weight-bold" style="font-size: 2rem;">{{ $totalUsers }}</h2>
                        <a href="{{ route('user.list') }}" class="text-white small font-weight-bold">Lihat →</a>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded p-3" style="width: 56px; height: 56px;">
                        <i class="fas fa-users fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Statistik Peminjaman -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="m-0 font-weight-bold text-dark">Statistik peminjaman</h6>
                </div>
                <div class="card-body">
                    <div style="height: 300px; position: relative;">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Aktivitas -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="m-0 font-weight-bold text-dark">Riwayat Aktivitas</h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <div style="height: 250px; width: 250px; max-width: 100%; position: relative;" class="mb-3">
                        <canvas id="donutChart"></canvas>
                    </div>

                    <!-- Custom Legend -->
                    <div class="d-flex flex-wrap justify-content-center align-items-center mt-3">
                        <div class="d-flex align-items-center mx-2 mb-2">
                            <span class="rounded-circle d-inline-block" style="width: 12px; height: 12px; background-color: #5b7ee8;"></span>
                            <span class="ml-2 small">Peminjaman</span>
                        </div>
                        <div class="d-flex align-items-center mx-2 mb-2">
                            <span class="rounded-circle d-inline-block" style="width: 12px; height: 12px; background-color: #22c55e;"></span>
                            <span class="ml-2 small">Pengembalian</span>
                        </div>
                        <div class="d-flex align-items-center mx-2 mb-2">
                            <span class="rounded-circle d-inline-block" style="width: 12px; height: 12px; background-color: #2dd4bf;"></span>
                            <span class="ml-2 small">Buku Hilang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Minimal custom styling - most using Bootstrap */
    .card:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    .bg-opacity-25 {
        opacity: 0.25;
    }

    canvas {
        max-height: 100%;
    }
</style>
@endpush

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
    // Line Chart - Statistik Peminjaman (Data dari Database)
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],
            datasets: [{
                label: 'Peminjaman',
                data: {!! json_encode($monthlyBorrowings) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#3b82f6',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true
            }]
        },
        options: {
            animation: {
                duration: 3000,
                easing: 'easeOutBounce',
                delay: (context) => {
                    let delay = 0;
                    if (context.type === 'data' && context.mode === 'default') {
                        delay = context.dataIndex * 200;
                    }
                    return delay;
                },
                y: {
                    type: 'number',
                    easing: 'easeOutBounce',
                    duration: 800,
                    from: (ctx) => {
                        if (ctx.type === 'data') {
                            return ctx.chart.scales.y.getPixelForValue(0);
                        }
                    },
                    delay: (context) => {
                        if (context.type !== 'data' || context.mode !== 'default') {
                            return 0;
                        }
                        return context.dataIndex * 200;
                    }
                }
            },
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#1f2937',
                    bodyColor: '#4b5563',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Peminjaman: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e5e7eb',
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10,
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            }
        }
    });

    // Donut Chart - Riwayat Aktivitas (Data dari Database)
    new Chart(document.getElementById('donutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Peminjaman','Pengembalian','Buku Hilang'],
            datasets: [{
                data: [{{ $totalPeminjaman }}, {{ $totalPengembalian }}, {{ $totalBukuHilang }}],
                backgroundColor: ['#5b7ee8','#22c55e','#2dd4bf'],
                borderWidth: 6,
                borderColor: '#ffffff',
                spacing: 2
            }]
        },
        options: {
            cutout: '70%',
            maintainAspectRatio: true,
            responsive: true,
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1500,
                easing: 'easeInOutQuart'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#1f2937',
                    bodyColor: '#4b5563',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
