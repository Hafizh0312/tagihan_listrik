<?php $this->load->view('admin/template/header'); ?>

<?php $this->load->view('admin/template/sidebar'); ?>

<!-- Main content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Penggunaan Listrik</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= base_url('admin/penggunaan/add') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Penggunaan
            </a>
            <!-- <a href="<?= base_url('admin/penggunaan/statistics') ?>" class="btn btn-info ms-2">
                <i class="fas fa-chart-bar me-2"></i>Statistik
            </a> -->
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

    <!-- Search Form -->
    <!-- Dihapus: form search di atas tabel -->

    <!-- Penggunaan Table -->
    <div class="card border-0 shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2"></i>Daftar Penggunaan Listrik
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="penggunaanTable" class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>No. KWH</th>
                            <th>Periode</th>
                            <th>Meter Awal</th>
                            <th>Meter Akhir</th>
                            <th>Total KWH</th>
                            <th>Tarif/KWH</th>
                            <th>Total Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <!-- Dihapus: tfoot search per kolom -->
                    <tbody>
                        <?php if (!empty($penggunaan)): ?>
                            <?php $no = 1; foreach ($penggunaan as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $p->nama_pelanggan ?></td>
                                <td><?= $p->nomor_kwh ?></td>
                                <td><?= bulan_indo($p->bulan) . ' ' . $p->tahun ?></td>
                                <td><?= number_format($p->meter_awal) ?></td>
                                <td><?= number_format($p->meter_ahir) ?></td>
                                <td><?= number_format($p->meter_ahir - $p->meter_awal) ?> KWH</td>
                                <td>Rp <?= number_format($p->tarifperkwh ?? 0) ?></td>
                                <td>Rp <?= number_format(($p->meter_ahir - $p->meter_awal) * ($p->tarifperkwh ?? 0)) ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('admin/penggunaan/view/' . $p->id_penggunaan) ?>" 
                                           class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/penggunaan/edit/' . $p->id_penggunaan) ?>" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/penggunaan/delete/' . $p->id_penggunaan) ?>" 
                                           class="btn btn-sm btn-danger" title="Hapus"
                                           onclick="return confirm('Yakin ingin menghapus data penggunaan ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted">
                                    <i class="fas fa-bolt fa-3x mb-3"></i>
                                    <p>Belum ada data penggunaan</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php $this->load->view('admin/template/footer'); ?> 