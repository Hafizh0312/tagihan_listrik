<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Sistem Pembayaran Listrik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            background: linear-gradient(135deg, #22304a 0%, #22304a 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #22304a 0%, #22304a 100%);
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
                        <h4 class="text-white">Pelanggan Panel</h4>
                        <small class="text-muted">Sistem Pembayaran Listrik</small>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url('pelanggan/dashboard') ?>">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('pelanggan/penggunaan') ?>">
                                <i class="fas fa-bolt me-2"></i>
                                Penggunaan Listrik
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('pelanggan/tagihan') ?>">
                                <i class="fas fa-file-invoice-dollar me-2"></i>
                                Tagihan Listrik
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a class="nav-link" href="<?= base_url('pelanggan/profil') ?>">
                                <i class="fas fa-user me-2"></i>
                                Profil Saya
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
                    <h1 class="h2">Dashboard Pelanggan</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <span class="text-muted">Selamat datang, <?= $user['nama'] ?></span>
                        </div>
                    </div>
                </div>

                <!-- Flash Messages -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($pelanggan)): ?>
                <!-- Customer Information -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Informasi Pelanggan</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="150"><strong>Nama:</strong></td>
                                                <td><?= $pelanggan->nama ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Alamat:</strong></td>
                                                <td><?= $pelanggan->alamat ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Level Daya:</strong></td>
                                                <td><?= $pelanggan->daya ?> Watt</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tarif per KWH:</strong></td>
                                                <td>Rp <?= number_format($pelanggan->tarif_per_kwh, 0, ',', '.') ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <i class="fas fa-user-circle fa-5x text-primary mb-3"></i>
                                            <h5><?= $pelanggan->nama ?></h5>
                                            <p class="text-muted">Pelanggan Listrik</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card card-stats border-0 shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Penggunaan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?= isset($usage_stats->total_usage) ? number_format($usage_stats->total_usage, 2) : '0' ?> KWH
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-bolt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card card-stats success border-0 shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Tagihan Lunas</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?= isset($bill_stats->paid_bills) ? $bill_stats->paid_bills : '0' ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card card-stats warning border-0 shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Tagihan Belum Lunas</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?= isset($bill_stats->unpaid_bills) ? $bill_stats->unpaid_bills : '0' ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card card-stats danger border-0 shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            Total Tagihan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            Rp <?= isset($bill_stats->total_amount) ? number_format($bill_stats->total_amount, 0, ',', '.') : '0' ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Data -->
                <div class="row">
                    <!-- Recent Usage -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow mb-4">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Penggunaan Terbaru</h6>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($recent_usage)): ?>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Periode</th>
                                                    <th>Meter Awal</th>
                                                    <th>Meter Akhir</th>
                                                    <th>Total KWH</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach (array_slice($recent_usage, 0, 5) as $penggunaan): ?>
                                                <tr>
                                                    <td><?= $penggunaan->bulan ?>/<?= $penggunaan->tahun ?></td>
                                                    <td><?= number_format($penggunaan->meter_awal, 2) ?></td>
                                                    <td><?= number_format($penggunaan->meter_akhir, 2) ?></td>
                                                    <td><?= number_format($penggunaan->meter_akhir - $penggunaan->meter_awal, 2) ?> KWH</td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">Belum ada data penggunaan</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Bills -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow mb-4">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Tagihan Terbaru</h6>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($recent_bills)): ?>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Periode</th>
                                                    <th>Total KWH</th>
                                                    <th>Total Tagihan</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach (array_slice($recent_bills, 0, 5) as $tagihan): ?>
                                                <tr>
                                                    <td><?= $tagihan->bulan ?>/<?= $tagihan->tahun ?></td>
                                                    <td><?= number_format($tagihan->total_kwh, 2) ?> KWH</td>
                                                    <td>Rp <?= number_format($tagihan->total_tagihan, 0, ',', '.') ?></td>
                                                    <td>
                                                        <span class="badge bg-<?= $tagihan->status == 'Lunas' ? 'success' : 'warning' ?>">
                                                            <?= $tagihan->status ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">Belum ada data tagihan</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Latest Usage -->
                <?php if (isset($latest_usage)): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Penggunaan Terakhir</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-primary"><?= $latest_usage->bulan ?>/<?= $latest_usage->tahun ?></h4>
                                            <small class="text-muted">Periode</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-info"><?= number_format($latest_usage->meter_awal, 2) ?></h4>
                                            <small class="text-muted">Meter Awal</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-success"><?= number_format($latest_usage->meter_akhir, 2) ?></h4>
                                            <small class="text-muted">Meter Akhir</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-warning"><?= number_format($latest_usage->meter_akhir - $latest_usage->meter_awal, 2) ?> KWH</h4>
                                            <small class="text-muted">Total Penggunaan</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Data Pelanggan Tidak Ditemukan!</h4>
                    <p>Mohon hubungi administrator untuk mengaktifkan akun pelanggan Anda.</p>
                </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 