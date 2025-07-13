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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin: 0.125rem 0;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255,255,255,.1);
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
                    <h1 class="h2">Tagihan Listrik - Status: <?= $status ?></h1>
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

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Filter Summary -->
                <div class="alert alert-info">
                    <i class="fas fa-filter me-2"></i>
                    <strong>Filter Aktif:</strong> Status "<?= $status ?>" 
                    (<?= count($tagihan) ?> tagihan ditemukan)
                </div>

                <!-- Filter Options -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="btn-group" role="group">
                            <a href="<?= base_url('admin/tagihan') ?>" class="btn btn-outline-primary">Semua</a>
                            <a href="<?= base_url('admin/tagihan/by_status/Lunas') ?>" 
                               class="btn <?= $status == 'Lunas' ? 'btn-success' : 'btn-outline-success' ?>">Lunas</a>
                            <a href="<?= base_url('admin/tagihan/by_status/Belum Lunas') ?>" 
                               class="btn <?= $status == 'Belum Lunas' ? 'btn-warning' : 'btn-outline-warning' ?>">Belum Lunas</a>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="<?= base_url('admin/tagihan/statistics') ?>" class="btn btn-info">
                            <i class="fas fa-chart-bar me-2"></i>Statistik
                        </a>
                    </div>
                </div>

                <!-- Statistics Cards for Filtered Data -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-file-invoice-dollar fa-2x text-primary mb-2"></i>
                                <h5 class="card-title">Total Tagihan</h5>
                                <h3 class="text-primary"><?= count($tagihan) ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-money-bill-wave fa-2x text-info mb-2"></i>
                                <h5 class="card-title">Total Nilai</h5>
                                <h3 class="text-info">
                                    <?php 
                                    $total_nilai = 0;
                                    foreach ($tagihan as $t) {
                                        $total_nilai += $t->total_tagihan;
                                    }
                                    echo 'Rp ' . number_format($total_nilai, 0, ',', '.');
                                    ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-bolt fa-2x text-success mb-2"></i>
                                <h5 class="card-title">Total KWH</h5>
                                <h3 class="text-success">
                                    <?php 
                                    $total_kwh = 0;
                                    foreach ($tagihan as $t) {
                                        $total_kwh += $t->total_kwh;
                                    }
                                    echo number_format($total_kwh, 0);
                                    ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar-alt fa-2x text-warning mb-2"></i>
                                <h5 class="card-title">Rata-rata/Tagihan</h5>
                                <h3 class="text-warning">
                                    <?php 
                                    $avg_per_bill = count($tagihan) > 0 ? $total_nilai / count($tagihan) : 0;
                                    echo 'Rp ' . number_format($avg_per_bill, 0, ',', '.');
                                    ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tagihan Table -->
                <div class="card border-0 shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>Daftar Tagihan - Status: <?= $status ?>
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
                                        <th>Total KWH</th>
                                        <th>Total Tagihan</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($tagihan)): ?>
                                        <?php $no = 1; foreach ($tagihan as $t): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><?= $t->nama_pelanggan ?></strong><br>
                                                <small class="text-muted"><?= $t->alamat ?></small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= date('F Y', mktime(0, 0, 0, $t->bulan, 1, $t->tahun)) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    <?= number_format($t->total_kwh, 0) ?> KWH
                                                </span>
                                            </td>
                                            <td>
                                                <strong class="text-primary">
                                                    Rp <?= number_format($t->total_tagihan, 0, ',', '.') ?>
                                                </strong>
                                            </td>
                                            <td>
                                                <span class="badge <?= $t->status == 'Lunas' ? 'bg-success' : 'bg-warning' ?>">
                                                    <?= $t->status ?>
                                                </span>
                                            </td>
                                            <td><?= date('F Y', mktime(0, 0, 0, $t->bulan, 1, $t->tahun)) ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/tagihan/view/' . $t->tagihan_id) ?>" 
                                                   class="btn btn-sm btn-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url('admin/tagihan/print_bill/' . $t->tagihan_id) ?>" 
                                                   class="btn btn-sm btn-secondary" title="Print" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                                <?php if ($t->status == 'Belum Lunas'): ?>
                                                <a href="<?= base_url('admin/tagihan/update_status/' . $t->tagihan_id) ?>" 
                                                   class="btn btn-sm btn-success" title="Mark as Paid"
                                                   onclick="return confirm('Tandai tagihan ini sebagai lunas?')">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <?php endif; ?>
                                                <a href="<?= base_url('admin/tagihan/edit/' . $t->tagihan_id) ?>" 
                                                   class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('admin/tagihan/delete/' . $t->tagihan_id) ?>" 
                                                   class="btn btn-sm btn-danger" title="Hapus"
                                                   onclick="return confirm('Yakin ingin menghapus tagihan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">
                                                <i class="fas fa-file-invoice-dollar fa-3x mb-3"></i>
                                                <p>Tidak ada tagihan dengan status "<?= $status ?>"</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Bulk Actions -->
                <?php if (!empty($tagihan)): ?>
                <div class="card border-0 shadow mt-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-tasks me-2"></i>Aksi Massal
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="<?= base_url('admin/tagihan/print_bulk/' . urlencode($status)) ?>" 
                                   class="btn btn-primary" target="_blank">
                                    <i class="fas fa-print me-2"></i>Print Semua Tagihan
                                </a>
                                <a href="<?= base_url('admin/tagihan/export_excel/' . urlencode($status)) ?>" 
                                   class="btn btn-success">
                                    <i class="fas fa-file-excel me-2"></i>Export Excel
                                </a>
                            </div>
                            <div class="col-md-6 text-end">
                                <?php if ($status == 'Belum Lunas'): ?>
                                <a href="<?= base_url('admin/tagihan/mark_all_paid/' . urlencode($status)) ?>" 
                                   class="btn btn-success"
                                   onclick="return confirm('Tandai semua tagihan sebagai lunas?')">
                                    <i class="fas fa-check me-2"></i>Mark All as Paid
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 