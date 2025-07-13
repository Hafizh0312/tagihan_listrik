<?php $this->load->view('admin/header'); ?>

<!-- Sidebar -->
<?php $this->load->view('admin/sidebar'); ?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
           
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard Pelanggan</h1>
                <div class="text-muted">Selamat datang, <?= $user['nama'] ?></div>
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

            <?php if (isset($pelanggan)): ?>
            <!-- Customer Information -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Pelanggan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="150"><strong>Nama:</strong></td>
                                            <td><?= isset($pelanggan->nama_pelanggan) ? $pelanggan->nama_pelanggan : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Alamat:</strong></td>
                                            <td><?= $pelanggan->alamat ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Level Daya:</strong></td>
                                            <td><?= $pelanggan->daya ?> Watt</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tarif per KWH:</strong></td>
                                            <td>Rp <?= isset($pelanggan->tarifperkwh) ? number_format($pelanggan->tarifperkwh, 0, ',', '.') : '-' ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <i class="fas fa-user-circle fa-5x text-primary mb-3"></i>
                                        <h5><?= isset($pelanggan->nama_pelanggan) ? $pelanggan->nama_pelanggan : '-' ?></h5>
                                        <p class="text-muted">Pelanggan Listrik</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Penggunaan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= isset($usage_stats->total_usage) ? number_format($usage_stats->total_usage, 2) : '0' ?> KWH
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-bolt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Tagihan Lunas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= isset($bill_stats->paid_bills) ? $bill_stats->paid_bills : '0' ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Tagihan Belum Lunas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= isset($bill_stats->unpaid_bills) ? $bill_stats->unpaid_bills : '0' ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Total Tagihan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp <?= isset($bill_stats->total_amount) ? number_format($bill_stats->total_amount, 0, ',', '.') : '0' ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Data -->
            <div class="row">
                <!-- Recent Usage -->
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Penggunaan Terbaru</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_usage)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Periode</th>
                                                <th>Meter Awal</th>
                                                <th>Meter Akhir</th>
                                                <th>Total KWH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (array_slice($recent_usage, 0, 5) as $penggunaan): ?>
                                            <tr>
                                                <td><?= $penggunaan->bulan ?>/<?= $penggunaan->tahun ?></td>
                                                <td><?= number_format($penggunaan->meter_awal, 2) ?></td>
                                                <td><?= number_format($penggunaan->meter_ahir, 2) ?></td>
                                                <td><?= number_format($penggunaan->meter_ahir - $penggunaan->meter_awal, 2) ?> KWH</td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">Belum ada data penggunaan</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Bills -->
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tagihan Terbaru</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_bills)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Periode</th>
                                                <th>Total KWH</th>
                                                <th>Total Tagihan</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (array_slice($recent_bills, 0, 5) as $tagihan): ?>
                                            <tr>
                                                <td><?= $tagihan->bulan ?>/<?= $tagihan->tahun ?></td>
                                                <td><?= number_format($tagihan->jumlah_meter, 2) ?> KWH</td>
                                                <td>Rp <?= number_format($tagihan->total_tagihan, 0, ',', '.') ?></td>
                                                <td>
                                                    <span class="badge bg-<?= $tagihan->status == 'Lunas' ? 'success' : 'warning' ?>">
                                                        <?= $tagihan->status ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">Belum ada data tagihan</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Latest Usage -->
            <?php if (isset($latest_usage)): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Penggunaan Terakhir</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h4 class="text-primary"><?= $latest_usage->bulan ?>/<?= $latest_usage->tahun ?></h4>
                                        <small class="text-muted">Periode</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h4 class="text-info"><?= number_format($latest_usage->meter_awal, 2) ?></h4>
                                        <small class="text-muted">Meter Awal</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h4 class="text-success"><?= number_format($latest_usage->meter_ahir, 2) ?></h4>
                                        <small class="text-muted">Meter Akhir</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h4 class="text-warning"><?= number_format($latest_usage->meter_ahir - $latest_usage->meter_awal, 2) ?> KWH</h4>
                                        <small class="text-muted">Total Penggunaan</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php else: ?>
            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">Data Pelanggan Tidak Ditemukan!</h4>
                <p>Mohon hubungi administrator untuk mengaktifkan akun pelanggan Anda.</p>
            </div>
            <?php endif; ?>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
</div>

<?php $this->load->view('admin/footer'); ?> 