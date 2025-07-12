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
                    <h1 class="h2">Tambah Tagihan Listrik</h1>
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

                <!-- Add Form -->
                <div class="card border-0 shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-plus me-2"></i>Tambah Data Tagihan
                        </h5>
                    </div>
                    <div class="card-body">
                        <?= form_open('admin/tagihan/store') ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="pelanggan_id" class="form-label">Pelanggan</label>
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
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="meter_awal" class="form-label">Meter Awal</label>
                                        <input type="number" class="form-control" id="meter_awal" name="meter_awal" 
                                               value="<?= set_value('meter_awal') ?>" required>
                                        <?= form_error('meter_awal', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="meter_akhir" class="form-label">Meter Akhir</label>
                                        <input type="number" class="form-control" id="meter_akhir" name="meter_akhir" 
                                               value="<?= set_value('meter_akhir') ?>" required>
                                        <?= form_error('meter_akhir', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="Belum Lunas" <?= set_select('status', 'Belum Lunas') ?>>Belum Lunas</option>
                                            <option value="Lunas" <?= set_select('status', 'Lunas') ?>>Lunas</option>
                                        </select>
                                        <?= form_error('status', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Calculation Preview -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <h6 class="mb-0">
                                                <i class="fas fa-calculator me-2"></i>Preview Perhitungan
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label">Total KWH:</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="total_kwh_preview" readonly>
                                                        <span class="input-group-text">KWH</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Tarif/KWH:</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Rp</span>
                                                        <input type="text" class="form-control" id="tarif_preview" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Total Tagihan:</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Rp</span>
                                                        <input type="text" class="form-control" id="total_tagihan_preview" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Level Daya:</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="daya_preview" readonly>
                                                        <span class="input-group-text">Watt</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Simpan Tagihan
                                    </button>
                                    <a href="<?= base_url('admin/tagihan') ?>" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                </div>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Calculation Script -->
    <script>
        // Update calculation when meter readings change
        document.getElementById('meter_awal').addEventListener('input', updateCalculation);
        document.getElementById('meter_akhir').addEventListener('input', updateCalculation);

        // Update customer info when selection changes
        document.getElementById('pelanggan_id').addEventListener('change', function() {
            const pelangganId = this.value;
            if (pelangganId) {
                // You can add AJAX call here to get customer details
                // For now, we'll use default values
                updateCalculation();
            }
        });

        function updateCalculation() {
            const meterAwal = parseInt(document.getElementById('meter_awal').value) || 0;
            const meterAkhir = parseInt(document.getElementById('meter_akhir').value) || 0;
            
            const totalKwh = Math.max(0, meterAkhir - meterAwal);
            const tarifPerKwh = 1500; // Default tarif, bisa diambil dari database
            const totalTagihan = totalKwh * tarifPerKwh;
            const daya = 900; // Default daya, bisa diambil dari database

            document.getElementById('total_kwh_preview').value = totalKwh.toLocaleString();
            document.getElementById('tarif_preview').value = tarifPerKwh.toLocaleString();
            document.getElementById('total_tagihan_preview').value = totalTagihan.toLocaleString();
            document.getElementById('daya_preview').value = daya.toLocaleString();
        }

        // Initialize calculation on page load
        updateCalculation();
    </script>
</body>
</html> 