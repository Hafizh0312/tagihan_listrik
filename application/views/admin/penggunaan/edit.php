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
                    <h1 class="h2">Edit Penggunaan Listrik</h1>
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

                <!-- Form -->
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <form action="<?= base_url('admin/penggunaan/edit/' . $penggunaan->penggunaan_id) ?>" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="pelanggan_id" class="form-label">Pelanggan <span class="text-danger">*</span></label>
                                        <select class="form-select" id="pelanggan_id" name="pelanggan_id" required>
                                            <option value="">Pilih Pelanggan</option>
                                            <?php foreach ($pelanggan as $p): ?>
                                                <option value="<?= $p->pelanggan_id ?>" <?= set_select('pelanggan_id', $p->pelanggan_id, ($penggunaan->pelanggan_id == $p->pelanggan_id)) ?>>
                                                    <?= $p->nama ?> - <?= $p->alamat ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?= form_error('pelanggan_id', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bulan" class="form-label">Bulan <span class="text-danger">*</span></label>
                                        <select class="form-select" id="bulan" name="bulan" required>
                                            <option value="">Pilih Bulan</option>
                                            <option value="1" <?= set_select('bulan', '1', ($penggunaan->bulan == 1)) ?>>Januari</option>
                                            <option value="2" <?= set_select('bulan', '2', ($penggunaan->bulan == 2)) ?>>Februari</option>
                                            <option value="3" <?= set_select('bulan', '3', ($penggunaan->bulan == 3)) ?>>Maret</option>
                                            <option value="4" <?= set_select('bulan', '4', ($penggunaan->bulan == 4)) ?>>April</option>
                                            <option value="5" <?= set_select('bulan', '5', ($penggunaan->bulan == 5)) ?>>Mei</option>
                                            <option value="6" <?= set_select('bulan', '6', ($penggunaan->bulan == 6)) ?>>Juni</option>
                                            <option value="7" <?= set_select('bulan', '7', ($penggunaan->bulan == 7)) ?>>Juli</option>
                                            <option value="8" <?= set_select('bulan', '8', ($penggunaan->bulan == 8)) ?>>Agustus</option>
                                            <option value="9" <?= set_select('bulan', '9', ($penggunaan->bulan == 9)) ?>>September</option>
                                            <option value="10" <?= set_select('bulan', '10', ($penggunaan->bulan == 10)) ?>>Oktober</option>
                                            <option value="11" <?= set_select('bulan', '11', ($penggunaan->bulan == 11)) ?>>November</option>
                                            <option value="12" <?= set_select('bulan', '12', ($penggunaan->bulan == 12)) ?>>Desember</option>
                                        </select>
                                        <?= form_error('bulan', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="tahun" name="tahun" 
                                               value="<?= set_value('tahun', $penggunaan->tahun) ?>" min="2000" max="2100" required>
                                        <?= form_error('tahun', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="meter_awal" class="form-label">Meter Awal <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="meter_awal" name="meter_awal" 
                                               value="<?= set_value('meter_awal', $penggunaan->meter_awal) ?>" min="0" step="0.01" required>
                                        <?= form_error('meter_awal', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="meter_akhir" class="form-label">Meter Akhir <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="meter_akhir" name="meter_akhir" 
                                               value="<?= set_value('meter_akhir', $penggunaan->meter_akhir) ?>" min="0" step="0.01" required>
                                        <?= form_error('meter_akhir', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Total KWH</label>
                                        <input type="text" class="form-control" id="total_kwh" readonly>
                                        <small class="text-muted">Akan dihitung otomatis</small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Penggunaan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Calculate Total KWH -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const meterAwal = document.getElementById('meter_awal');
            const meterAkhir = document.getElementById('meter_akhir');
            const totalKwh = document.getElementById('total_kwh');
            
            function calculateTotal() {
                const awal = parseFloat(meterAwal.value) || 0;
                const akhir = parseFloat(meterAkhir.value) || 0;
                const total = akhir - awal;
                
                if (total >= 0) {
                    totalKwh.value = total.toFixed(2) + ' KWH';
                } else {
                    totalKwh.value = 'Meter akhir harus lebih besar dari meter awal';
                }
            }
            
            meterAwal.addEventListener('input', calculateTotal);
            meterAkhir.addEventListener('input', calculateTotal);
            
            // Calculate on page load
            calculateTotal();
        });
    </script>
</body>
</html> 