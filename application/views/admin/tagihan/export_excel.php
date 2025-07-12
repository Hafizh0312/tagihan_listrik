<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Excel Tagihan - Sistem Pembayaran Listrik</title>
    
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
                    <h1 class="h2">Export Excel Tagihan</h1>
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

                <!-- Export Options -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 shadow mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-file-excel me-2"></i>Export Excel
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">
                                    Export data tagihan ke format Excel (.xlsx) untuk analisis atau laporan.
                                </p>
                                
                                <?= form_open('admin/tagihan/process_export_excel') ?>
                                    <div class="mb-3">
                                        <label for="export_type" class="form-label">Tipe Export</label>
                                        <select class="form-select" id="export_type" name="export_type" required>
                                            <option value="">Pilih Tipe Export</option>
                                            <option value="all">Semua Tagihan</option>
                                            <option value="lunas">Tagihan Lunas</option>
                                            <option value="belum_lunas">Tagihan Belum Lunas</option>
                                            <option value="period">Periode Tertentu</option>
                                        </select>
                                    </div>

                                    <div class="row" id="period_options" style="display: none;">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="bulan" class="form-label">Bulan</label>
                                                <select class="form-select" id="bulan" name="bulan">
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
                                                <label for="tahun" class="form-label">Tahun</label>
                                                <select class="form-select" id="tahun" name="tahun">
                                                    <option value="">Pilih Tahun</option>
                                                    <?php for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++): ?>
                                                        <option value="<?= $i ?>"><?= $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="include_details" class="form-label">Include Details</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="include_details" name="include_details" value="1" checked>
                                            <label class="form-check-label" for="include_details">
                                                Include detail perhitungan (meter awal, meter akhir, tarif)
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="filename" class="form-label">Nama File</label>
                                        <input type="text" class="form-control" id="filename" name="filename" 
                                               value="tagihan_listrik_<?= date('Y-m-d_H-i-s') ?>" required>
                                        <small class="text-muted">File akan disimpan dengan ekstensi .xlsx</small>
                                    </div>

                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-download me-2"></i>Export Excel
                                    </button>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 shadow mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Export
                                </h5>
                            </div>
                            <div class="card-body">
                                <h6>Kolom yang akan di-export:</h6>
                                <ul class="mb-3">
                                    <li>ID Tagihan</li>
                                    <li>Nama Pelanggan</li>
                                    <li>Alamat</li>
                                    <li>Periode (Bulan/Tahun)</li>
                                    <li>Status</li>
                                    <li>Total KWH</li>
                                    <li>Total Tagihan</li>
                                    <li>Tanggal Dibuat</li>
                                    <li>Meter Awal (opsional)</li>
                                    <li>Meter Akhir (opsional)</li>
                                    <li>Tarif per KWH (opsional)</li>
                                </ul>

                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Catatan:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li>File Excel akan otomatis terdownload</li>
                                        <li>Format tanggal menggunakan YYYY-MM-DD</li>
                                        <li>Angka menggunakan format Indonesia (dengan titik sebagai pemisah ribuan)</li>
                                        <li>Maksimal 10.000 baris data per export</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Export History -->
                <div class="card border-0 shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-history me-2"></i>Riwayat Export
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal Export</th>
                                        <th>Nama File</th>
                                        <th>Tipe Export</th>
                                        <th>Jumlah Data</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= date('d/m/Y H:i') ?></td>
                                        <td>tagihan_listrik_<?= date('Y-m-d_H-i-s') ?>.xlsx</td>
                                        <td>Semua Tagihan</td>
                                        <td><?= count($tagihan ?? []) ?></td>
                                        <td><span class="badge bg-success">Siap</span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Add more rows for export history -->
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
    
    <!-- Export Type Script -->
    <script>
        // Show/hide period options based on export type
        document.getElementById('export_type').addEventListener('change', function() {
            const periodOptions = document.getElementById('period_options');
            if (this.value === 'period') {
                periodOptions.style.display = 'block';
            } else {
                periodOptions.style.display = 'none';
            }
        });

        // Auto-generate filename based on export type
        document.getElementById('export_type').addEventListener('change', function() {
            const filename = document.getElementById('filename');
            const currentDate = new Date().toISOString().slice(0, 19).replace(/:/g, '-');
            
            switch(this.value) {
                case 'all':
                    filename.value = `tagihan_semua_${currentDate}`;
                    break;
                case 'lunas':
                    filename.value = `tagihan_lunas_${currentDate}`;
                    break;
                case 'belum_lunas':
                    filename.value = `tagihan_belum_lunas_${currentDate}`;
                    break;
                case 'period':
                    filename.value = `tagihan_periode_${currentDate}`;
                    break;
                default:
                    filename.value = `tagihan_listrik_${currentDate}`;
            }
        });
    </script>
</body>
</html> 