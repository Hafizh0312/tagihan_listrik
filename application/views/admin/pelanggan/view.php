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
                            <a class="nav-link active" href="<?= base_url('admin/pelanggan') ?>">
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
                            <a class="nav-link" href="<?= base_url('admin/tagihan') ?>">
                                <i class="fas fa-file-invoice-dollar me-2"></i>
                                Kelola Tagihan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/tarif') ?>">
                                <i class="fas fa-cog me-2"></i>
                                Kelola Tarif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/level') ?>">
                                <i class="fas fa-user-shield me-2"></i>
                                Kelola Level
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
                    <h1 class="h2">Detail Pelanggan</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="<?= base_url('admin/pelanggan/edit/' . $pelanggan->id_pelanggan) ?>" class="btn btn-warning me-2">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Pelanggan</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Nama Pelanggan</strong></td>
                                        <td>: <?= $pelanggan->nama_pelanggan ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Username</strong></td>
                                        <td>: <?= $pelanggan->username ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nomor KWH</strong></td>
                                        <td>: <span class="badge bg-info"><?= $pelanggan->nomor_kwh ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alamat</strong></td>
                                        <td>: <?= $pelanggan->alamat ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Daya Listrik</strong></td>
                                        <td>: <span class="badge bg-primary"><?= $pelanggan->daya ?> VA</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tarif per KWH</strong></td>
                                        <td>: <span class="badge bg-success">Rp <?= number_format($pelanggan->tarifperkwh, 0, ',', '.') ?></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <h4 class="text-primary"><?= count($penggunaan) ?></h4>
                                        <small class="text-muted">Total Penggunaan</small>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="text-warning"><?= count($tagihan) ?></h4>
                                        <small class="text-muted">Total Tagihan</small>
                                    </div>
                                </div>
                                <hr>
                                <div class="row text-center">
                                    <div class="col-6">
                                        <h4 class="text-success"><?= count(array_filter($tagihan, function($t) { return $t->status == 'sudah_bayar'; })) ?></h4>
                                        <small class="text-muted">Tagihan Lunas</small>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="text-danger"><?= count(array_filter($tagihan, function($t) { return $t->status == 'belum_bayar'; })) ?></h4>
                                        <small class="text-muted">Tagihan Belum Bayar</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usage History -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Riwayat Penggunaan</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($penggunaan)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Periode</th>
                                            <th>Meter Awal</th>
                                            <th>Meter Akhir</th>
                                            <th>Total KWH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($penggunaan as $p): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><strong><?= $p->bulan ?> <?= $p->tahun ?></strong></td>
                                            <td><?= number_format($p->meter_awal, 0, ',', '.') ?> KWH</td>
                                            <td><?= number_format($p->meter_ahir, 0, ',', '.') ?> KWH</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= number_format($p->meter_ahir - $p->meter_awal, 0, ',', '.') ?> KWH
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-bolt fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada data penggunaan</h5>
                                <p class="text-muted">Pelanggan ini belum memiliki riwayat penggunaan listrik</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Bill History -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-file-invoice-dollar me-2"></i>Riwayat Tagihan</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($tagihan)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Periode</th>
                                            <th>Jumlah Meter</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($tagihan as $t): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><strong><?= $t->bulan ?> <?= $t->tahun ?></strong></td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= number_format($t->jumlah_meter, 0, ',', '.') ?> KWH
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($t->status == 'sudah_bayar'): ?>
                                                    <span class="badge bg-success">Lunas</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Belum Bayar</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-file-invoice-dollar fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada data tagihan</h5>
                                <p class="text-muted">Pelanggan ini belum memiliki riwayat tagihan</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 