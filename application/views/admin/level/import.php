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
        .drop-zone {
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .drop-zone.dragover {
            border-color: #007bff;
            background-color: #f8f9fa;
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
                    <h1 class="h2">Import Level Daya</h1>
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

                <!-- Import Form -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Upload File CSV</h6>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('admin/level/import') ?>" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="csv_file" class="form-label">Pilih File CSV <span class="text-danger">*</span></label>
                                        <div class="drop-zone" id="dropZone">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Drag & Drop file CSV di sini</h5>
                                            <p class="text-muted">atau</p>
                                            <input type="file" class="form-control" id="csv_file" name="csv_file" 
                                                   accept=".csv" required style="display: none;">
                                            <button type="button" class="btn btn-primary" onclick="document.getElementById('csv_file').click()">
                                                <i class="fas fa-folder-open me-1"></i> Pilih File
                                            </button>
                                            <div id="fileInfo" class="mt-3" style="display: none;">
                                                <div class="alert alert-info">
                                                    <i class="fas fa-file-csv me-2"></i>
                                                    <span id="fileName"></span>
                                                    <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="clearFile()">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="<?= base_url('admin/level') ?>" class="btn btn-secondary">
                                            <i class="fas fa-times me-1"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-success" id="submitBtn" disabled>
                                            <i class="fas fa-upload me-1"></i> Import Level Daya
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Format CSV</h6>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle me-2"></i>Format File</h6>
                                    <p class="mb-2">File CSV harus memiliki format:</p>
                                    <ul class="mb-0">
                                        <li>Baris pertama: header (daya,tarif_per_kwh)</li>
                                        <li>Kolom 1: Level Daya (VA)</li>
                                        <li>Kolom 2: Tarif per KWH (Rp)</li>
                                    </ul>
                                </div>

                                <div class="alert alert-warning">
                                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Contoh Format</h6>
                                    <pre class="mb-0"><code>daya,tarif_per_kwh
900,1352
1300,1444
2200,1444
3500,1699
5500,1699</code></pre>
                                </div>

                                <div class="alert alert-success">
                                    <h6><i class="fas fa-check-circle me-2"></i>Ketentuan</h6>
                                    <ul class="mb-0">
                                        <li>File maksimal 2MB</li>
                                        <li>Format file: .csv</li>
                                        <li>Level daya harus unik</li>
                                        <li>Data numerik tanpa koma</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Download Template -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Download Template</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-3">Download template CSV untuk memudahkan import data:</p>
                                <a href="#" class="btn btn-outline-primary" onclick="downloadTemplate()">
                                    <i class="fas fa-download me-1"></i> Download Template CSV
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // File handling
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('csv_file');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const submitBtn = document.getElementById('submitBtn');

        // Drag and drop functionality
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelect();
            }
        });

        fileInput.addEventListener('change', handleFileSelect);

        function handleFileSelect() {
            const file = fileInput.files[0];
            if (file) {
                fileName.textContent = file.name;
                fileInfo.style.display = 'block';
                submitBtn.disabled = false;
            }
        }

        function clearFile() {
            fileInput.value = '';
            fileInfo.style.display = 'none';
            submitBtn.disabled = true;
        }

        function downloadTemplate() {
            const csvContent = "daya,tarif_per_kwh\n900,1352\n1300,1444\n2200,1444\n3500,1699\n5500,1699";
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'template_level_daya.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
    </script>
</body>
</html> 