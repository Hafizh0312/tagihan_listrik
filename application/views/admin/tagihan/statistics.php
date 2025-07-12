<?php
// Tambahkan di awal file (setelah <?php jika ada logic PHP di atas)
$total_tagihan = isset($total_tagihan) ? $total_tagihan : 0;
$tagihan_lunas = isset($tagihan_lunas) ? $tagihan_lunas : 0;
$tagihan_belum_lunas = isset($tagihan_belum_lunas) ? $tagihan_belum_lunas : 0;
$total_pendapatan = isset($total_pendapatan) ? $total_pendapatan : 0;
$monthly_stats = isset($monthly_stats) && is_array($monthly_stats) ? $monthly_stats : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Sistem Pembayaran Listrik</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            background: #22304a;
        }
        .sidebar .nav-link {
            color: #ecf0f1;
            font-weight: 500;
            border-radius: 6px;
            margin-bottom: 6px;
            padding: 0.75rem 1rem;
            transition: background 0.2s, color 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .sidebar .nav-link:hover {
            background: #2d4063;
            color: #fff;
        }
        .sidebar .nav-link.active {
            background: #2196f3;
            color: #fff;
        }
        .sidebar .nav-link i {
            color: #fff;
            min-width: 22px;
            text-align: center;
        }
        .sidebar .nav-item {
            margin-bottom: 2px;
        }
        .sidebar h4, .sidebar small {
            color: #fff;
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
        .chart-container {
            position: relative;
            height: 300px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Admin Panel</h4>
                        <small class="text-muted">Sistem Pembayaran Listrik</small>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/pelanggan') ?>">
                                <i class="fas fa-users me-2"></i>
                                Kelola Pelanggan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/penggunaan') ?>">
                                <i class="fas fa-bolt me-2"></i>
                                Kelola Penggunaan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url('admin/tagihan') ?>">
                                <i class="fas fa-file-invoice-dollar me-2"></i>
                                Kelola Tagihan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/level') ?>">
                                <i class="fas fa-cog me-2"></i>
                                Kelola Tarif
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a class="nav-link" href="<?= base_url('admin/dashboard/profile') ?>">
                                <i class="fas fa-user me-2"></i>
                                Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('auth/logout') ?>">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Statistik Tagihan Listrik</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="<?= base_url('admin/tagihan') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <!-- Flash Messages -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Summary Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-file-invoice-dollar fa-2x text-primary mb-2"></i>
                                <h5 class="card-title">Total Tagihan</h5>
                                <h3 class="text-primary"><?= $total_tagihan ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                <h5 class="card-title">Lunas</h5>
                                <h3 class="text-success"><?= $tagihan_lunas ?></h3>
                                <?php
                                    $persen_lunas = $total_tagihan > 0 ? round(($tagihan_lunas / $total_tagihan) * 100, 1) : 0;
                                ?>
                                <small class="text-muted"><?= $persen_lunas ?>%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                <h5 class="card-title">Belum Lunas</h5>
                                <h3 class="text-warning"><?= $tagihan_belum_lunas ?></h3>
                                <?php
                                    $persen_belum_lunas = $total_tagihan > 0 ? round(($tagihan_belum_lunas / $total_tagihan) * 100, 1) : 0;
                                ?>
                                <small class="text-muted"><?= $persen_belum_lunas ?>%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-money-bill-wave fa-2x text-info mb-2"></i>
                                <h5 class="card-title">Total Pendapatan</h5>
                                <h3 class="text-info">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-pie me-2"></i>Status Tagihan
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="statusChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-bar me-2"></i>Pendapatan Bulanan
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="revenueChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monthly Statistics -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-calendar-alt me-2"></i>Statistik Bulanan
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Bulan</th>
                                                <th>Total Tagihan</th>
                                                <th>Lunas</th>
                                                <th>Belum Lunas</th>
                                                <th>Total KWH</th>
                                                <th>Pendapatan</th>
                                                <th>Persentase Lunas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($monthly_stats as $stat): ?>
                                            <tr>
                                                <td>
                                                    <strong><?= date('F Y', mktime(0, 0, 0, $stat->bulan, 1, $stat->tahun)) ?></strong>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary"><?= $stat->total_tagihan ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success"><?= $stat->lunas ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-warning"><?= $stat->belum_lunas ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?= number_format($stat->total_kwh, 0) ?> KWH</span>
                                                </td>
                                                <td>
                                                    <strong class="text-primary">
                                                        Rp <?= number_format($stat->pendapatan, 0, ',', '.') ?>
                                                    </strong>
                                                </td>
                                                <td>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar bg-success" 
                                                             style="width: <?= ($stat->total_tagihan > 0) ? round(($stat->lunas / $stat->total_tagihan) * 100, 1) : 0 ?>%">
                                                            <?= ($stat->total_tagihan > 0) ? round(($stat->lunas / $stat->total_tagihan) * 100, 1) : 0 ?>%
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Customers -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-trophy me-2"></i>Top 5 Pelanggan Terbesar
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($top_customers)): ?>
                                    <?php foreach ($top_customers as $index => $customer): ?>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <span class="badge bg-warning me-2">#<?= $index + 1 ?></span>
                                            <strong><?= $customer->nama_pelanggan ?></strong>
                                            <br><small class="text-muted"><?= $customer->alamat ?></small>
                                        </div>
                                        <div class="text-end">
                                            <strong class="text-primary">Rp <?= number_format($customer->total_tagihan, 0, ',', '.') ?></strong>
                                            <br><small class="text-muted"><?= number_format($customer->total_kwh, 0) ?> KWH</small>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted text-center">Belum ada data pelanggan</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow">
                            <div class="card-header bg-danger text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Tagihan Tertunda
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($overdue_bills)): ?>
                                    <?php foreach ($overdue_bills as $bill): ?>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <strong><?= $bill->nama_pelanggan ?></strong>
                                            <br><small class="text-muted"><?= date('F Y', mktime(0, 0, 0, $bill->bulan, 1, $bill->tahun)) ?></small>
                                        </div>
                                        <div class="text-end">
                                            <strong class="text-danger">Rp <?= number_format($bill->total_tagihan, 0, ',', '.') ?></strong>
                                            <br><small class="text-muted"><?= $bill->days_overdue ?> hari terlambat</small>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted text-center">Tidak ada tagihan tertunda</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Charts Script -->
    <script>
        // Status Chart (Pie Chart)
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: ['Lunas', 'Belum Lunas'],
                datasets: [{
                    data: [<?= $tagihan_lunas ?>, <?= $tagihan_belum_lunas ?>],
                    backgroundColor: ['#28a745', '#ffc107'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Revenue Chart (Bar Chart)
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($monthly_stats, 'bulan_tahun')) ?>,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: <?= json_encode(array_column($monthly_stats, 'pendapatan')) ?>,
                    backgroundColor: 'rgba(102, 126, 234, 0.8)',
                    borderColor: 'rgba(102, 126, 234, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html> 