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
                    <h1 class="h2">Update Status Tagihan</h1>
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

                <!-- Status Update Form -->
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card border-0 shadow">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-check-circle me-2"></i>Update Status Pembayaran
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Bill Information -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6><i class="fas fa-file-invoice-dollar me-2"></i>Informasi Tagihan</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%"><strong>ID Tagihan:</strong></td>
                                                <td><?= $tagihan->tagihan_id ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Pelanggan:</strong></td>
                                                <td><?= $tagihan->nama_pelanggan ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Alamat:</strong></td>
                                                <td><?= $tagihan->alamat ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Periode:</strong></td>
                                                <td><?= date('F Y', mktime(0, 0, 0, $tagihan->bulan, 1, $tagihan->tahun)) ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status Saat Ini:</strong></td>
                                                <td>
                                                    <span class="badge <?= $tagihan->status == 'Lunas' ? 'bg-success' : 'bg-warning' ?>">
                                                        <?= $tagihan->status ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h6><i class="fas fa-calculator me-2"></i>Detail Tagihan</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%"><strong>Total KWH:</strong></td>
                                                <td><?= number_format($tagihan->total_kwh, 0) ?> KWH</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tarif/KWH:</strong></td>
                                                <td>Rp <?= number_format($tagihan->tarif_per_kwh, 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Tagihan:</strong></td>
                                                <td>
                                                    <strong class="text-primary">
                                                        Rp <?= number_format($tagihan->total_tagihan, 0, ',', '.') ?>
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Dibuat:</strong></td>
                                                <td><?= date('d/m/Y H:i', strtotime($tagihan->created_at)) ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- Status Update Form -->
                                <?= form_open('admin/tagihan/confirm_update_status/' . $tagihan->tagihan_id) ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status Baru</label>
                                                <select class="form-select" id="status" name="status" required>
                                                    <option value="Belum Lunas" <?= $tagihan->status == 'Belum Lunas' ? 'selected' : '' ?>>
                                                        Belum Lunas
                                                    </option>
                                                    <option value="Lunas" <?= $tagihan->status == 'Lunas' ? 'selected' : '' ?>>
                                                        Lunas
                                                    </option>
                                                </select>
                                                <?= form_error('status', '<small class="text-danger">', '</small>') ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="payment_date" class="form-label">Tanggal Pembayaran</label>
                                                <input type="date" class="form-control" id="payment_date" name="payment_date" 
                                                       value="<?= date('Y-m-d') ?>" 
                                                       <?= $tagihan->status == 'Lunas' ? 'readonly' : '' ?>>
                                                <?= form_error('payment_date', '<small class="text-danger">', '</small>') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                                        <select class="form-select" id="payment_method" name="payment_method">
                                            <option value="">Pilih Metode Pembayaran</option>
                                            <option value="Tunai">Tunai</option>
                                            <option value="Transfer Bank">Transfer Bank</option>
                                            <option value="E-Wallet">E-Wallet</option>
                                            <option value="Kantor PLN">Kantor PLN</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                        <?= form_error('payment_method', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                                  placeholder="Tambahkan catatan tentang pembayaran ini..."></textarea>
                                        <?= form_error('notes', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="row mt-4">
                                        <div class="col-12 text-center">
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>Konfirmasi:</strong> Apakah Anda yakin ingin mengubah status tagihan ini?
                                            </div>
                                            
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                <button type="submit" class="btn btn-success btn-lg">
                                                    <i class="fas fa-check me-2"></i>Update Status
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

                        <!-- Payment History -->
                        <div class="card border-0 shadow mt-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-history me-2"></i>Riwayat Status
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Metode Pembayaran</th>
                                                <th>Catatan</th>
                                                <th>Diupdate Oleh</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= date('d/m/Y H:i', strtotime($tagihan->created_at)) ?></td>
                                                <td>
                                                    <span class="badge <?= $tagihan->status == 'Lunas' ? 'bg-success' : 'bg-warning' ?>">
                                                        <?= $tagihan->status ?>
                                                    </span>
                                                </td>
                                                <td>-</td>
                                                <td>Tagihan dibuat</td>
                                                <td>Admin</td>
                                            </tr>
                                            <!-- Add more rows if there's payment history -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Payment Date Script -->
    <script>
        // Enable/disable payment date based on status
        document.getElementById('status').addEventListener('change', function() {
            const paymentDate = document.getElementById('payment_date');
            if (this.value === 'Lunas') {
                paymentDate.removeAttribute('readonly');
                paymentDate.style.backgroundColor = '#fff';
            } else {
                paymentDate.setAttribute('readonly', true);
                paymentDate.style.backgroundColor = '#e9ecef';
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const status = document.getElementById('status').value;
            const paymentDate = document.getElementById('payment_date');
            if (status === 'Lunas') {
                paymentDate.removeAttribute('readonly');
                paymentDate.style.backgroundColor = '#fff';
            } else {
                paymentDate.setAttribute('readonly', true);
                paymentDate.style.backgroundColor = '#e9ecef';
            }
        });
    </script>
</body>
</html> 