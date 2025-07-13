<?php $this->load->view('admin/template/header'); ?>

<?php $this->load->view('admin/template/sidebar'); ?>

<!-- Main content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard Admin</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <span class="text-muted">Selamat datang, <?= $user['nama'] ?></span>
            </div>
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

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stats border-0 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pelanggan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_pelanggan ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stats success border-0 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Penggunaan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_penggunaan ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bolt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stats warning border-0 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Tagihan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_tagihan ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stats danger border-0 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Tarif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_tarif ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Pelanggan -->
        <div class="col-xl-6 col-lg-6">
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-users me-2"></i>Pelanggan Terbaru
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>No. KWH</th>
                                    <th>Daya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($recent_pelanggan, 0, 5) as $pelanggan): ?>
                                <tr>
                                    <td><?= $pelanggan->nama_pelanggan ?></td>
                                    <td><?= $pelanggan->nomor_kwh ?></td>
                                    <td><?= $pelanggan->daya ?> VA</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Tagihan -->
        <div class="col-xl-6 col-lg-6">
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-file-invoice-dollar me-2"></i>Tagihan Terbaru
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Pelanggan</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($recent_tagihan, 0, 5) as $tagihan): ?>
                                <tr>
                                    <td><?= $tagihan->nama_pelanggan ?></td>
                                    <td><?= $tagihan->bulan . ' ' . $tagihan->tahun ?></td>
                                    <td>
                                        <?php if ($tagihan->status == 'Lunas'): ?>
                                            <span class="badge bg-success">Lunas</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Belum Bayar</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Row -->
    <div class="row">
        <!-- Bill Statistics -->
        <div class="col-xl-6 col-lg-6">
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Tagihan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <h4 class="text-primary"><?= $bill_stats->total_bills ?? 0 ?></h4>
                            <small class="text-muted">Total Tagihan</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-success"><?= $bill_stats->paid_bills ?? 0 ?></h4>
                            <small class="text-muted">Lunas</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-warning"><?= $bill_stats->unpaid_bills ?? 0 ?></h4>
                            <small class="text-muted">Belum Bayar</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usage Statistics -->
        <div class="col-xl-6 col-lg-6">
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-bolt me-2"></i>Statistik Penggunaan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <h4 class="text-success"><?= $usage_stats['total_usage'] ?? 0 ?></h4>
                            <small class="text-muted">Total Penggunaan</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-info"><?= number_format($usage_stats['total_kwh'] ?? 0) ?></h4>
                            <small class="text-muted">Total KWH</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-warning"><?= number_format($usage_stats['avg_kwh'] ?? 0, 1) ?></h4>
                            <small class="text-muted">Rata-rata KWH</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->load->view('admin/template/footer'); ?> 