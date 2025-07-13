<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penggunaan Listrik Saya - Sistem Pembayaran Listrik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8fafc;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(34,48,74,0.06);
        }
        .table thead {
            background: #22304a;
            color: #fff;
        }
        .table tbody tr:hover {
            background: #e3f0ff;
        }
        .page-title {
            font-weight: 700;
            color: #22304a;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="page-title mb-1">Penggunaan Listrik Saya</h2>
            <p class="text-muted mb-0">Lihat riwayat penggunaan listrik Anda setiap bulan.</p>
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

    <div class="card">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0">Daftar Penggunaan Listrik</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($penggunaan)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Meter Awal</th>
                            <th>Meter Akhir</th>
                            <th>Total KWH</th>
                            <th>Total Tagihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($penggunaan as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('F', mktime(0,0,0,(int)$row->bulan,1)) ?></td>
                            <td><?= $row->tahun ?></td>
                            <td><?= number_format($row->meter_awal, 2, ',', '.') ?></td>
                            <td><?= number_format($row->meter_ahir, 2, ',', '.') ?></td>
                            <td><?= number_format($row->meter_ahir - $row->meter_awal, 2, ',', '.') ?></td>
                            <td>Rp <?= isset($row->total_tagihan) ? number_format($row->total_tagihan, 0, ',', '.') : '-' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data penggunaan listrik</h5>
                    <p class="text-muted">Data penggunaan listrik Anda akan muncul di sini setelah ada pencatatan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 