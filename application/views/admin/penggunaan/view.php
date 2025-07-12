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
            background: linear-gradient(135deg, #22304a 0%, #22304a 100%);
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
                    <h1 class="h2">Detail Penggunaan Listrik</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="<?= base_url('admin/penggunaan') ?>" class="btn btn-secondary">
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

                <!-- Usage Information -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 shadow mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-bolt me-2"></i>Informasi Penggunaan
                                </h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%"><strong>Pelanggan:</strong></td>
                                        <td><?= $penggunaan->nama_pelanggan ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alamat:</strong></td>
                                        <td><?= $penggunaan->alamat ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Periode:</strong></td>
                                        <td><?= date('F Y', mktime(0, 0, 0, $penggunaan->bulan, 1, $penggunaan->tahun)) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Meter Awal:</strong></td>
                                        <td><?= number_format($penggunaan->meter_awal, 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Meter Akhir:</strong></td>
                                        <td><?= number_format($penggunaan->meter_akhir, 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total KWH:</strong></td>
                                        <td>
                                            <span class="badge bg-success fs-6">
                                                <?= number_format($penggunaan->meter_akhir - $penggunaan->meter_awal, 0) ?> KWH
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card border-0 shadow mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-calculator me-2"></i>Perhitungan Tagihan
                                </h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%"><strong>Level Daya:</strong></td>
                                        <td><?= $penggunaan->daya ?> Watt</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tarif/KWH:</strong></td>
                                        <td>Rp <?= number_format($penggunaan->tarif_per_kwh, 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total KWH:</strong></td>
                                        <td><?= number_format($penggunaan->meter_akhir - $penggunaan->meter_awal, 0) ?> KWH</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Tagihan:</strong></td>
                                        <td>
                                            <strong class="text-primary fs-5">
                                                Rp <?= number_format(($penggunaan->meter_akhir - $penggunaan->meter_awal) * $penggunaan->tarif_per_kwh, 0, ',', '.') ?>
                                            </strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Bill -->
                <?php if (isset($tagihan) && $tagihan): ?>
                <div class="card border-0 shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-invoice-dollar me-2"></i>Tagihan Terkait
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID Tagihan</th>
                                        <th>Total KWH</th>
                                        <th>Total Tagihan</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $tagihan->tagihan_id ?></td>
                                        <td><?= number_format($tagihan->total_kwh, 0) ?> KWH</td>
                                        <td>Rp <?= number_format($tagihan->total_tagihan, 0, ',', '.') ?></td>
                                        <td>
                                            <span class="badge <?= $tagihan->status == 'Lunas' ? 'bg-success' : 'bg-warning' ?>">
                                                <?= $tagihan->status ?>
                                            </span>
                                        </td>
                                        <td><?= date('d/m/Y H:i', strtotime($tagihan->created_at)) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="card border-0 shadow">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>Tagihan Belum Dibuat
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="text-muted mb-3">Tagihan untuk penggunaan ini belum dibuat.</p>
                        <a href="<?= base_url('admin/tagihan/generate/' . $penggunaan->penggunaan_id) ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Buat Tagihan
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="mt-4">
                    <a href="<?= base_url('admin/penggunaan/edit/' . $penggunaan->penggunaan_id) ?>" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Penggunaan
                    </a>
                    <a href="<?= base_url('admin/penggunaan/delete/' . $penggunaan->penggunaan_id) ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Yakin ingin menghapus data penggunaan ini?')">
                        <i class="fas fa-trash me-2"></i>Hapus Penggunaan
                    </a>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 