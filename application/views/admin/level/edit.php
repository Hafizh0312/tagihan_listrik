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
                    <h1 class="h2">Edit Level Daya</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="<?= base_url('admin/level') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
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

                <!-- Form -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Form Edit Level Daya</h6>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('admin/level/edit/' . $level->level_id) ?>" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="daya" class="form-label">Level Daya (VA) <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control <?= form_error('daya') ? 'is-invalid' : '' ?>" 
                                                       id="daya" name="daya" value="<?= set_value('daya', $level->daya) ?>" 
                                                       placeholder="Contoh: 900, 1300, 2200" min="1" required>
                                                <?php if (form_error('daya')): ?>
                                                    <div class="invalid-feedback">
                                                        <?= form_error('daya') ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="form-text">Masukkan level daya dalam VA (Volt Ampere)</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tarif_per_kwh" class="form-label">Tarif per KWH (Rp) <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control <?= form_error('tarif_per_kwh') ? 'is-invalid' : '' ?>" 
                                                       id="tarif_per_kwh" name="tarif_per_kwh" value="<?= set_value('tarif_per_kwh', $level->tarif_per_kwh) ?>" 
                                                       placeholder="Contoh: 1352, 1444" min="1" step="0.01" required>
                                                <?php if (form_error('tarif_per_kwh')): ?>
                                                    <div class="invalid-feedback">
                                                        <?= form_error('tarif_per_kwh') ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="form-text">Masukkan tarif per KWH dalam Rupiah</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Preview Tarif</label>
                                        <div class="alert alert-info">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Level Daya:</strong> <span id="preview-daya"><?= $level->daya ?></span> VA
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Tarif per KWH:</strong> Rp <span id="preview-tarif"><?= number_format($level->tarif_per_kwh, 0, ',', '.') ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="<?= base_url('admin/level') ?>" class="btn btn-secondary">
                                            <i class="fas fa-times me-1"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Update Level Daya
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Informasi Level</h6>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle me-2"></i>Data Saat Ini</h6>
                                    <ul class="mb-0">
                                        <li><strong>ID Level:</strong> <?= $level->level_id ?></li>
                                        <li><strong>Level Daya:</strong> <?= number_format($level->daya, 0, ',', '.') ?> VA</li>
                                        <li><strong>Tarif per KWH:</strong> Rp <?= number_format($level->tarif_per_kwh, 0, ',', '.') ?></li>
                                    </ul>
                                </div>

                                <div class="alert alert-warning">
                                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Perhatian</h6>
                                    <p class="mb-0">Perubahan tarif akan mempengaruhi perhitungan tagihan pelanggan yang menggunakan level ini.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Live preview
        document.getElementById('daya').addEventListener('input', function() {
            const daya = this.value;
            document.getElementById('preview-daya').textContent = daya || '-';
        });

        document.getElementById('tarif_per_kwh').addEventListener('input', function() {
            const tarif = this.value;
            document.getElementById('preview-tarif').textContent = tarif ? new Intl.NumberFormat('id-ID').format(tarif) : '-';
        });
    </script>
</body>
</html> 