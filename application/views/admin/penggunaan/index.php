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
                            <a class="nav-link" href="<?= base_url('admin/pelanggan') ?>">
                                <i class="fas fa-users me-2"></i>
                                Kelola Pelanggan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url('admin/penggunaan') ?>">
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
                    <h1 class="h2">Kelola Penggunaan Listrik</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="<?= base_url('admin/penggunaan/add') ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Penggunaan
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

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-bolt fa-2x text-primary mb-2"></i>
                                <h5 class="card-title">Total Penggunaan</h5>
                                <h3 class="text-primary"><?= count($penggunaan) ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-2x text-success mb-2"></i>
                                <h5 class="card-title">Pelanggan Aktif</h5>
                                <h3 class="text-success"><?= count($pelanggan) ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar fa-2x text-info mb-2"></i>
                                <h5 class="card-title">Periode Terbaru</h5>
                                <h3 class="text-info"><?= date('M Y') ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-chart-line fa-2x text-warning mb-2"></i>
                                <h5 class="card-title">Rata-rata KWH</h5>
                                <h3 class="text-warning">
                                    <?php 
                                    $total_kwh = 0;
                                    $count = 0;
                                    foreach ($penggunaan as $p) {
                                        $total_kwh += ($p->meter_akhir - $p->meter_awal);
                                        $count++;
                                    }
                                    echo $count > 0 ? number_format($total_kwh / $count, 0) : '0';
                                    ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Penggunaan Table -->
                <div class="card border-0 shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>Daftar Penggunaan Listrik
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Pelanggan</th>
                                        <th>Periode</th>
                                        <th>Meter Awal</th>
                                        <th>Meter Akhir</th>
                                        <th>Total KWH</th>
                                        <th>Tarif/KWH</th>
                                        <th>Total Tagihan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($penggunaan)): ?>
                                        <?php $no = 1; foreach ($penggunaan as $p): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><?= $p->nama_pelanggan ?></strong><br>
                                                <small class="text-muted"><?= $p->alamat ?></small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= date('F Y', mktime(0, 0, 0, $p->bulan, 1, $p->tahun)) ?>
                                                </span>
                                            </td>
                                            <td><?= number_format($p->meter_awal, 0) ?></td>
                                            <td><?= number_format($p->meter_akhir, 0) ?></td>
                                            <td>
                                                <span class="badge bg-success">
                                                    <?= number_format($p->meter_akhir - $p->meter_awal, 0) ?> KWH
                                                </span>
                                            </td>
                                            <td>Rp <?= number_format($p->tarif_per_kwh, 0, ',', '.') ?></td>
                                            <td>
                                                <strong class="text-primary">
                                                    Rp <?= number_format(($p->meter_akhir - $p->meter_awal) * $p->tarif_per_kwh, 0, ',', '.') ?>
                                                </strong>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('admin/penggunaan/view/' . $p->penggunaan_id) ?>" 
                                                   class="btn btn-sm btn-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url('admin/penggunaan/edit/' . $p->penggunaan_id) ?>" 
                                                   class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('admin/penggunaan/delete/' . $p->penggunaan_id) ?>" 
                                                   class="btn btn-sm btn-danger" title="Hapus"
                                                   onclick="return confirm('Yakin ingin menghapus data penggunaan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">
                                                <i class="fas fa-bolt fa-3x mb-3"></i>
                                                <p>Belum ada data penggunaan listrik</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 