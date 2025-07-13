<?php $this->load->view('admin/template/header'); ?>

<?php $this->load->view('admin/template/sidebar'); ?>

<!-- Main content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= $title ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= base_url('admin/penggunaan') ?>" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="<?= base_url('admin/penggunaan/edit/' . $penggunaan->id_penggunaan) ?>" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="<?= base_url('admin/penggunaan/delete/' . $penggunaan->id_penggunaan) ?>" class="btn btn-danger" 
               onclick="return confirm('Yakin ingin menghapus data ini?')">
                <i class="fas fa-trash"></i> Hapus
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Detail Penggunaan -->
        <div class="col-md-8">
            <div class="card border-0 shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i> Detail Penggunaan Listrik
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>ID Penggunaan</strong></td>
                                    <td width="60%">: <?= $penggunaan->id_penggunaan ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Periode</strong></td>
                                    <td>: <?= date('F Y', mktime(0, 0, 0, $penggunaan->bulan, 1, $penggunaan->tahun)) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Meter Awal</strong></td>
                                    <td>: <?= number_format($penggunaan->meter_awal) ?> KWH</td>
                                </tr>
                                <tr>
                                    <td><strong>Meter Akhir</strong></td>
                                    <td>: <?= number_format($penggunaan->meter_ahir) ?> KWH</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Total KWH</strong></td>
                                    <td width="60%">: <span class="badge bg-success"><?= number_format($penggunaan->meter_ahir - $penggunaan->meter_awal) ?> KWH</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Tarif per KWH</strong></td>
                                    <td>: Rp <?= number_format($penggunaan->tarifperkwh ?? 0) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Bayar</strong></td>
                                    <td>: <strong class="text-primary">Rp <?= number_format(($penggunaan->meter_ahir - $penggunaan->meter_awal) * ($penggunaan->tarifperkwh ?? 0)) ?></strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Status Tagihan</strong></td>
                                    <td>: 
                                        <?php if (isset($penggunaan->status_tagihan)): ?>
                                            <?php if ($penggunaan->status_tagihan == 'Belum Bayar'): ?>
                                                <span class="badge bg-danger"><?= $penggunaan->status_tagihan ?></span>
                                            <?php elseif ($penggunaan->status_tagihan == 'Lunas'): ?>
                                                <span class="badge bg-success"><?= $penggunaan->status_tagihan ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-warning"><?= $penggunaan->status_tagihan ?></span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Belum Ada Tagihan</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Pelanggan -->
            <div class="card border-0 shadow mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i> Informasi Pelanggan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Nama</strong></td>
                                    <td width="60%">: <?= $penggunaan->nama_pelanggan ?></td>
                                </tr>
                                <tr>
                                    <td><strong>No. KWH</strong></td>
                                    <td>: <?= $penggunaan->nomor_kwh ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat</strong></td>
                                    <td>: <?= $penggunaan->alamat ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Daya</strong></td>
                                    <td width="60%">: <?= $penggunaan->daya ?> VA</td>
                                </tr>
                                <tr>
                                    <td><strong>Username</strong></td>
                                    <td>: <?= $penggunaan->username ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>: <span class="badge bg-success">Aktif</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-tools me-2"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('admin/penggunaan/edit/' . $penggunaan->id_penggunaan) ?>" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Data
                        </a>
                        <a href="<?= base_url('admin/tagihan/generate/' . $penggunaan->id_penggunaan) ?>" class="btn btn-success">
                            <i class="fas fa-file-invoice me-2"></i>Buat Tagihan
                        </a>
                        <a href="<?= base_url('admin/penggunaan/delete/' . $penggunaan->id_penggunaan) ?>" 
                           class="btn btn-danger"
                           onclick="return confirm('Yakin ingin menghapus data ini?')">
                            <i class="fas fa-trash me-2"></i>Hapus Data
                        </a>
                    </div>
                </div>
            </div>

            <!-- Usage Statistics -->
            <div class="card border-0 shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Penggunaan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border-end">
                                <h4 class="text-primary"><?= number_format($penggunaan->meter_ahir - $penggunaan->meter_awal) ?></h4>
                                <small class="text-muted">KWH</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div>
                                <h4 class="text-success">Rp <?= number_format(($penggunaan->meter_ahir - $penggunaan->meter_awal) * ($penggunaan->tarifperkwh ?? 0)) ?></h4>
                                <small class="text-muted">Total Bayar</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-info"><?= date('F', mktime(0, 0, 0, $penggunaan->bulan, 1)) ?></h4>
                                <small class="text-muted">Bulan</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <h4 class="text-warning"><?= $penggunaan->tahun ?></h4>
                                <small class="text-muted">Tahun</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->load->view('admin/template/footer'); ?> 