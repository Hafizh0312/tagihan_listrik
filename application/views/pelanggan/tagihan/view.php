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
                        <h4 class="text-white">Pelanggan Panel</h4>
                        <small class="text-muted">Sistem Pembayaran Listrik</small>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('pelanggan/dashboard') ?>">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('pelanggan/penggunaan') ?>">
                                <i class="fas fa-bolt me-2"></i>
                                Penggunaan Listrik
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url('pelanggan/tagihan') ?>">
                                <i class="fas fa-file-invoice-dollar me-2"></i>
                                Tagihan Listrik
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a class="nav-link" href="<?= base_url('pelanggan/profil') ?>">
                                <i class="fas fa-user me-2"></i>
                                Profil Saya
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
                    <h1 class="h2">Detail Tagihan Listrik</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="<?= base_url('pelanggan/tagihan') ?>" class="btn btn-secondary">
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

                <!-- Bill Information -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 shadow mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-file-invoice-dollar me-2"></i>Informasi Tagihan
                                </h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%"><strong>ID Tagihan:</strong></td>
                                        <td><?= $tagihan->tagihan_id ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Periode:</strong></td>
                                        <td><?= date('F Y', mktime(0, 0, 0, $tagihan->bulan, 1, $tagihan->tahun)) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            <span class="badge <?= $tagihan->status == 'Lunas' ? 'bg-success' : 'bg-warning' ?> fs-6">
                                                <?= $tagihan->status ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Dibuat:</strong></td>
                                        <td><?= date('d/m/Y H:i', strtotime($tagihan->created_at)) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card border-0 shadow mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-calculator me-2"></i>Detail Perhitungan
                                </h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%"><strong>Level Daya:</strong></td>
                                        <td><?= $tagihan->daya ?> Watt</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tarif/KWH:</strong></td>
                                        <td>Rp <?= number_format($tagihan->tarif_per_kwh, 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total KWH:</strong></td>
                                        <td>
                                            <span class="badge bg-success fs-6">
                                                <?= number_format($tagihan->total_kwh, 0) ?> KWH
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Tagihan:</strong></td>
                                        <td>
                                            <strong class="text-primary fs-4">
                                                Rp <?= number_format($tagihan->total_tagihan, 0, ',', '.') ?>
                                            </strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usage Details -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt me-2"></i>Detail Penggunaan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Meter Awal</th>
                                        <th>Meter Akhir</th>
                                        <th>Total KWH</th>
                                        <th>Tarif/KWH</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= number_format($tagihan->meter_awal, 0) ?></td>
                                        <td><?= number_format($tagihan->meter_akhir, 0) ?></td>
                                        <td>
                                            <span class="badge bg-success">
                                                <?= number_format($tagihan->total_kwh, 0) ?> KWH
                                            </span>
                                        </td>
                                        <td>Rp <?= number_format($tagihan->tarif_per_kwh, 0, ',', '.') ?></td>
                                        <td>
                                            <strong class="text-primary">
                                                Rp <?= number_format($tagihan->total_tagihan, 0, ',', '.') ?>
                                            </strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('pelanggan/tagihan/print_bill/' . $tagihan->tagihan_id) ?>" 
                               class="btn btn-primary" target="_blank">
                                <i class="fas fa-print me-2"></i>Print Tagihan
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-grid gap-2">
                            <?php if ($tagihan->status == 'Belum Lunas'): ?>
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Tagihan ini belum lunas. Silakan lakukan pembayaran.
                            </div>
                            <?php else: ?>
                            <div class="alert alert-success mb-0">
                                <i class="fas fa-check-circle me-2"></i>
                                Tagihan ini sudah lunas.
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <?php if ($tagihan->status == 'Belum Lunas'): ?>
                <div class="card border-0 shadow mt-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-credit-card me-2"></i>Informasi Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Metode Pembayaran:</h6>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-money-bill-wave me-2"></i>Transfer Bank</li>
                                    <li><i class="fas fa-credit-card me-2"></i>Kartu Kredit/Debit</li>
                                    <li><i class="fas fa-mobile-alt me-2"></i>E-Wallet</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Rekening Pembayaran:</h6>
                                <p><strong>Bank PLN</strong><br>
                                No. Rek: 1234-5678-9012-3456<br>
                                Atas Nama: PT PLN (Persero)</p>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Catatan:</strong> Mohon transfer sesuai dengan nominal tagihan dan sertakan ID Tagihan (<?= $tagihan->tagihan_id ?>) pada keterangan transfer.
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 