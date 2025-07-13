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
            background: #2c3e50;
        }
        .sidebar .nav-link {
            color: #ecf0f1;
        }
        .sidebar .nav-link:hover {
            background: #34495e;
            color: #fff;
        }
        .sidebar .nav-link.active {
            background: #3498db;
        }
        .card-stats {
            border-left: 4px solid #3498db;
        }
        .card-stats.success {
            border-left-color: #27ae60;
        }
        .card-stats.warning {
            border-left-color: #f39c12;
        }
        .card-stats.danger {
            border-left-color: #e74c3c;
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
                            <a class="nav-link" href="<?= base_url('admin/tagihan') ?>">
                                <i class="fas fa-file-invoice-dollar me-2"></i>
                                Kelola Tagihan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url('admin/level') ?>">
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
                    <h1 class="h2">Detail Level Daya</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="<?= base_url('admin/level') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <a href="<?= base_url('admin/level/edit/' . $level->id_tarif) ?>" class="btn btn-warning">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
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

                <!-- Level Information -->
                <div class="row mb-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Informasi Level Daya</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%"><strong>ID Level:</strong></td>
                                                <td><?= $level->id_tarif ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Level Daya:</strong></td>
                                                <td>
                                                    <span class="badge bg-primary fs-6">
                                                        <?= number_format($level->daya, 0, ',', '.') ?> VA
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tarif per KWH:</strong></td>
                                                <td>
                                                    <span class="badge bg-success fs-6">
                                                        Rp <?= number_format($level->tarifperkwh, 0, ',', '.') ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-info">
                                            <h6><i class="fas fa-calculator me-2"></i>Contoh Perhitungan</h6>
                                            <p class="mb-2">Untuk penggunaan 100 KWH:</p>
                                            <p class="mb-0">
                                                <strong>Total Tagihan:</strong><br>
                                                Rp <?= number_format($level->tarifperkwh, 0, ',', '.') ?> × 100 KWH = 
                                                <strong>Rp <?= number_format($level->tarifperkwh * 100, 0, ',', '.') ?></strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border rounded p-3">
                                            <i class="fas fa-users fa-2x text-primary mb-2"></i>
                                            <h4 class="mb-0"><?= count($customers) ?></h4>
                                            <small class="text-muted">Pelanggan</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border rounded p-3">
                                            <i class="fas fa-bolt fa-2x text-warning mb-2"></i>
                                            <h4 class="mb-0"><?= $level->daya ?></h4>
                                            <small class="text-muted">VA</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customers List -->
                <div class="card border-0 shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Pelanggan</h6>
                        <span class="badge bg-info"><?= count($customers) ?> pelanggan</span>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($customers)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>ID Pelanggan</th>
                                            <th>Nama</th>
                                            <th>Nomor Meter</th>
                                            <th>Alamat</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($customers as $customer): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    <?= $customer->pelanggan_id ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong><?= $customer->nama ?></strong>
                                            </td>
                                            <td><?= $customer->nomor_meter ?></td>
                                            <td><?= $customer->alamat ?></td>
                                            <td>
                                                <?php if ($customer->status == 'aktif'): ?>
                                                    <span class="badge bg-success">Aktif</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Nonaktif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('admin/pelanggan/view/' . $customer->pelanggan_id) ?>" 
                                                   class="btn btn-sm btn-info" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada pelanggan</h5>
                                <p class="text-muted">Tidak ada pelanggan yang menggunakan level daya ini</p>
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