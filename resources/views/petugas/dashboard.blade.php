@extends('layouts.petugas')
@section('content')
<div class="container-fluid px-4">
    <!-- Page Title -->
    <div class="d-flex align-items-center mb-4">
        <h1 class="h4 font-weight-bold mb-0">Dashboard Petugas</h1>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <!-- Jumlah Keterlambatan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-stat shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <p class="stat-label mb-0">Jumlah Keterlambatan</p>
                        <div class="stat-icon-small" style="background-color: #e0e7ff;">
                            <i class="fas fa-clock" style="color: #6366f1;"></i>
                        </div>
                    </div>
                    <h2 class="stat-number mb-0">15</h2>
                </div>
            </div>
        </div>

        <!-- Jumlah Buku Hilang -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-stat shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <p class="stat-label mb-0">Jumlah Buku Hilang</p>
                        <div class="stat-icon-small" style="background-color: #fee2e2;">
                            <i class="fas fa-book-skull" style="color: #ef4444;"></i>
                        </div>
                    </div>
                    <h2 class="stat-number mb-0">8</h2>
                </div>
            </div>
        </div>

        <!-- Jumlah Denda diberikan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-stat shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <p class="stat-label mb-0">Jumlah Denda diberikan</p>
                        <div class="stat-icon-small" style="background-color: #fef3c7;">
                            <i class="fas fa-hand-holding-dollar" style="color: #f59e0b;"></i>
                        </div>
                    </div>
                    <h2 class="stat-number mb-0">5</h2>
                </div>
            </div>
        </div>

        <!-- Total Denda -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card-stat shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <p class="stat-label mb-0">Total Denda</p>
                        <div class="stat-icon-small" style="background-color: #d1fae5;">
                            <i class="fas fa-money-bill-wave" style="color: #10b981;"></i>
                        </div>
                    </div>
                    <h2 class="stat-number mb-0">Rp.320,000</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Statistik Peminjaman -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold" style="color: #1f2937;">Statistik peminjaman</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Aktivitas -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold" style="color: #1f2937;">Riwayat Aktivitas</h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <div class="chart-donut mb-3">
                        <canvas id="donutChart"></canvas>
                    </div>

                    <!-- Custom Legend -->
                    <div class="d-flex flex-wrap justify-content-center align-items-center mt-3">
                        <div class="d-flex align-items-center mx-3 mb-2">
                            <span class="legend-dot" style="background-color: #6366f1;"></span>
                            <span class="ml-2 small">Pinjaman</span>
                        </div>
                        <div class="d-flex align-items-center mx-3 mb-2">
                            <span class="legend-dot" style="background-color: #10b981;"></span>
                            <span class="ml-2 small">Pengembalian</span>
                        </div>
                        <div class="d-flex align-items-center mx-3 mb-2">
                            <span class="legend-dot" style="background-color: #14b8a6;"></span>
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
    /* Overall Styling */
    body {
        background-color: #f9fafb;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    /* User Info */
    .user-info {
        font-size: 0.875rem;
        color: #374151;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
    }

    /* Card Stats Styling */
    .card-stat {
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        background: white;
        transition: all 0.3s ease;
    }

    .card-stat:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08) !important;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #111827;
    }

    .stat-icon-small {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon-small i {
        font-size: 1.5rem;
    }

    /* Chart Styling */
    .card {
        border-radius: 16px;
        border: 1px solid #e5e7eb;
    }

    .card-header {
        border-radius: 16px 16px 0 0 !important;
        border-bottom: 1px solid #f3f4f6 !important;
    }

    .chart-area {
        position: relative;
        height: 320px;
        padding: 10px;
    }

    .chart-donut {
        position: relative;
        height: 240px;
        width: 240px;
        max-width: 100%;
    }

    .legend-dot {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    canvas {
        max-height: 100%;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .stat-number {
            font-size: 1.5rem;
        }

        .chart-area {
            height: 250px;
        }
    }
</style>
@endpush

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
    // Line Chart - Statistik Peminjaman
    const ctx = document.getElementById('lineChart').getContext('2d');

    // Create gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.1)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0.01)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],
            datasets: [{
                label: 'Peminjaman',
                data: [30, 45, 35, 55, 70, 50, 45, 60, 75, 65, 55, 60],
                borderColor: '#6366f1',
                backgroundColor: gradient,
                tension: 0.4,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#6366f1',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 2,
                fill: true,
                borderWidth: 3
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.98)',
                    titleColor: '#111827',
                    bodyColor: '#6b7280',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    titleFont: {
                        size: 13,
                        weight: '600'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            return 'Peminjaman: ' + context.parsed.y + ' buku';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    min: 20,
                    max: 80,
                    grid: {
                        color: '#f3f4f6',
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10,
                        color: '#9ca3af',
                        font: {
                            size: 11
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: '#9ca3af',
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });

    // Donut Chart - Riwayat Aktivitas
    new Chart(document.getElementById('donutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pinjaman','Pengembalian','Buku Hilang'],
            datasets: [{
                data: [45, 42, 13],
                backgroundColor: ['#6366f1','#10b981','#14b8a6'],
                borderWidth: 0,
                spacing: 2
            }]
        },
        options: {
            cutout: '75%',
            maintainAspectRatio: true,
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.98)',
                    titleColor: '#111827',
                    bodyColor: '#6b7280',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: true,
                    boxWidth: 12,
                    boxHeight: 12,
                    usePointStyle: true,
                    titleFont: {
                        size: 13,
                        weight: '600'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return ' ' + context.label + ': ' + percentage + '%';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
