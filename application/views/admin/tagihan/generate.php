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
                    <h1 class="h2">Generate Tagihan Listrik</h1>
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

                <!-- Generate Options -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 shadow mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-magic me-2"></i>Generate Tagihan Manual
                                </h5>
                            </div>
                            <div class="card-body">
                                <?= form_open('admin/tagihan/generate_manual') ?>
                                    <div class="mb-3">
                                        <label for="pelanggan_id" class="form-label">Pilih Pelanggan</label>
                                        <select class="form-select" id="pelanggan_id" name="pelanggan_id" required>
                                            <option value="">Pilih Pelanggan</option>
                                            <?php foreach ($pelanggan as $p): ?>
                                                <option value="<?= $p->pelanggan_id ?>">
                                                    <?= $p->nama_pelanggan ?> - <?= $p->alamat ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?= form_error('pelanggan_id', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="bulan" class="form-label">Bulan</label>
                                                <select class="form-select" id="bulan" name="bulan" required>
                                                    <option value="">Pilih Bulan</option>
                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                        <option value="<?= $i ?>">
                                                            <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                                                        </option>
                                                    <?php endfor; ?>
                                                </select>
                                                <?= form_error('bulan', '<small class="text-danger">', '</small>') ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tahun" class="form-label">Tahun</label>
                                                <select class="form-select" id="tahun" name="tahun" required>
                                                    <option value="">Pilih Tahun</option>
                                                    <?php for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++): ?>
                                                        <option value="<?= $i ?>"><?= $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                                <?= form_error('tahun', '<small class="text-danger">', '</small>') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-magic me-2"></i>Generate Tagihan
                                    </button>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 shadow mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-bolt me-2"></i>Generate Semua Tagihan
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">
                                    Generate tagihan untuk semua pelanggan yang belum memiliki tagihan pada periode tertentu.
                                </p>
                                
                                <?= form_open('admin/tagihan/generate_all') ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="bulan_all" class="form-label">Bulan</label>
                                                <select class="form-select" id="bulan_all" name="bulan" required>
                                                    <option value="">Pilih Bulan</option>
                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                        <option value="<?= $i ?>">
                                                            <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                                                        </option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tahun_all" class="form-label">Tahun</label>
                                                <select class="form-select" id="tahun_all" name="tahun" required>
                                                    <option value="">Pilih Tahun</option>
                                                    <?php for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++): ?>
                                                        <option value="<?= $i ?>"><?= $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Info:</strong> Sistem akan otomatis menghitung meter akhir berdasarkan meter awal bulan sebelumnya.
                                    </div>

                                    <button type="submit" class="btn btn-success" 
                                            onclick="return confirm('Yakin ingin generate tagihan untuk semua pelanggan?')">
                                        <i class="fas fa-bolt me-2"></i>Generate Semua
                                    </button>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usage Data Preview -->
                <div class="card border-0 shadow">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-table me-2"></i>Data Penggunaan Tersedia
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Pelanggan</th>
                                        <th>Periode</th>
                                        <th>Meter Awal</th>
                                        <th>Meter Akhir</th>
                                        <th>Total KWH</th>
                                        <th>Status Tagihan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($penggunaan_data)): ?>
                                        <?php foreach ($penggunaan_data as $p): ?>
                                        <tr>
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
                                                    <?= number_format($p->total_kwh, 0) ?> KWH
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($p->tagihan_exists): ?>
                                                    <span class="badge bg-success">Tagihan Ada</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Belum Ada Tagihan</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!$p->tagihan_exists): ?>
                                                <a href="<?= base_url('admin/tagihan/generate_single/' . $p->penggunaan_id) ?>" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-plus me-1"></i>Generate
                                                </a>
                                                <?php else: ?>
                                                <span class="text-muted">Sudah ada tagihan</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                <i class="fas fa-table fa-3x mb-3"></i>
                                                <p>Belum ada data penggunaan</p>
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