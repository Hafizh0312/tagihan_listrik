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
                    <h1 class="h2">Mark All as Paid</h1>
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

                <!-- Confirmation Card -->
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card border-0 shadow">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-check-circle me-2"></i>Mark All as Paid
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Peringatan:</strong> Tindakan ini akan mengubah status semua tagihan yang belum lunas menjadi lunas.
                                </div>

                                <!-- Summary Information -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6><i class="fas fa-info-circle me-2"></i>Informasi Aksi</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%"><strong>Total Tagihan:</strong></td>
                                                <td><?= count($tagihan) ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status Saat Ini:</strong></td>
                                                <td><span class="badge bg-warning">Belum Lunas</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status Setelah Update:</strong></td>
                                                <td><span class="badge bg-success">Lunas</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Nilai:</strong></td>
                                                <td>
                                                    <?php 
                                                    $total_nilai = 0;
                                                    foreach ($tagihan as $t) {
                                                        $total_nilai += $t->total_tagihan;
                                                    }
                                                    echo '<strong class="text-primary">Rp ' . number_format($total_nilai, 0, ',', '.') . '</strong>';
                                                    ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h6><i class="fas fa-calendar me-2"></i>Detail Pembayaran</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%"><strong>Tanggal Pembayaran:</strong></td>
                                                <td><?= date('d/m/Y') ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Metode Pembayaran:</strong></td>
                                                <td>Bulk Payment</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Diupdate Oleh:</strong></td>
                                                <td>Admin</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Waktu Update:</strong></td>
                                                <td><?= date('d/m/Y H:i') ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- Bills to be Updated -->
                                <div class="mb-4">
                                    <h6><i class="fas fa-list me-2"></i>Daftar Tagihan yang Akan Diupdate</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Pelanggan</th>
                                                    <th>Periode</th>
                                                    <th>Total Tagihan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                                        <strong class="text-primary">
                                                            Rp <?= number_format($t->total_tagihan, 0, ',', '.') ?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Bulk Update Form -->
                                <?= form_open('admin/tagihan/confirm_mark_all_paid') ?>
                                    <input type="hidden" name="status_filter" value="<?= $status_filter ?? '' ?>">
                                    
                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                                        <select class="form-select" id="payment_method" name="payment_method" required>
                                            <option value="">Pilih Metode Pembayaran</option>
                                            <option value="Bulk Transfer">Bulk Transfer</option>
                                            <option value="Tunai">Tunai</option>
                                            <option value="E-Wallet">E-Wallet</option>
                                            <option value="Kantor PLN">Kantor PLN</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                                  placeholder="Tambahkan catatan tentang pembayaran massal ini..."></textarea>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="row mt-4">
                                        <div class="col-12 text-center">
                                            <div class="alert alert-info">
                                                <i class="fas fa-question-circle me-2"></i>
                                                <strong>Konfirmasi:</strong> Apakah Anda yakin ingin mengubah status semua tagihan ini menjadi lunas?
                                            </div>
                                            
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                <button type="submit" class="btn btn-success btn-lg">
                                                    <i class="fas fa-check me-2"></i>Ya, Update Semua Status
                                                </button>
                                                <a href="<?= base_url('admin/tagihan') ?>" class="btn btn-secondary btn-lg">
                                                    <i class="fas fa-times me-2"></i>Batal
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?= form_close() ?>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="card border-0 shadow mt-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                                </h5>
                            </div>
                            <div class="card-body">
                                <ul class="mb-0">
                                    <li>Tindakan ini akan mengupdate <?= count($tagihan) ?> tagihan sekaligus</li>
                                    <li>Total nilai yang akan diupdate: Rp <?= number_format($total_nilai, 0, ',', '.') ?></li>
                                    <li>Semua tagihan akan memiliki tanggal pembayaran yang sama</li>
                                    <li>Riwayat pembayaran akan dicatat untuk setiap tagihan</li>
                                    <li>Tindakan ini tidak dapat dibatalkan secara massal</li>
                                </ul>
                            </div>
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