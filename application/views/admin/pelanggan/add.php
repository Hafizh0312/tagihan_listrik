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
                    <h1 class="h2">Tambah Pelanggan</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <!-- Flash Messages -->
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Form Tambah Pelanggan</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('admin/pelanggan/add') ?>" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="username" name="username" 
                                               value="<?= set_value('username') ?>" required>
                                        <?= form_error('username', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                        <?= form_error('confirm_password', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nama_pelanggan" class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" 
                                               value="<?= set_value('nama_pelanggan') ?>" required>
                                        <?= form_error('nama_pelanggan', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nomor_kwh" class="form-label">Nomor KWH <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nomor_kwh" name="nomor_kwh" 
                                               value="<?= set_value('nomor_kwh') ?>" required>
                                        <?= form_error('nomor_kwh', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="id_tarif" class="form-label">Tarif Listrik <span class="text-danger">*</span></label>
                                        <select class="form-select" id="id_tarif" name="id_tarif" required>
                                            <option value="">Pilih Tarif</option>
                                            <?php foreach ($tarifs as $tarif): ?>
                                                <option value="<?= $tarif->id_tarif ?>" <?= set_select('id_tarif', $tarif->id_tarif) ?>>
                                                    <?= $tarif->daya ?> VA - Rp <?= number_format($tarif->tarifperkwh, 0, ',', '.') ?>/KWH
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?= form_error('id_tarif', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="4" required><?= set_value('alamat') ?></textarea>
                                        <?= form_error('alamat', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 