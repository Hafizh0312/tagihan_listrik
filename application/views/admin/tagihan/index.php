<?php $this->load->view('admin/template/header'); ?>

<?php $this->load->view('admin/template/sidebar'); ?>

<!-- Main content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Kelola Tagihan Listrik</h1>
       
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
        <div class="col-md-3">
            <div class="card border-0 shadow">
                <div class="card-body text-center">
                    <i class="fas fa-file-invoice-dollar fa-2x text-primary mb-2"></i>
                    <h5 class="card-title">Total Tagihan</h5>
                    <h3 class="text-primary"><?= count($tagihan) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h5 class="card-title">Lunas</h5>
                    <h3 class="text-success">
                        <?php 
                        $lunas = 0;
                        foreach ($tagihan as $t) {
                            if ($t->status == 'sudah_bayar') $lunas++;
                        }
                        echo $lunas;
                        ?>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h5 class="card-title">Belum Lunas</h5>
                    <h3 class="text-warning">
                        <?php 
                        $belum_lunas = 0;
                        foreach ($tagihan as $t) {
                            if ($t->status == 'belum_bayar') $belum_lunas++;
                        }
                        echo $belum_lunas;
                        ?>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow">
                <div class="card-body text-center">
                    <i class="fas fa-money-bill-wave fa-2x text-info mb-2"></i>
                    <h5 class="card-title">Total Pendapatan</h5>
                    <h3 class="text-info">
                        <?php 
                        $total_pendapatan = 0;
                        foreach ($tagihan as $t) {
                            if ($t->status == 'sudah_bayar') {
                                $total_pendapatan += $t->jumlah_meter * ($t->tarifperkwh ?? 0);
                            }
                        }
                        echo 'Rp ' . number_format($total_pendapatan, 0, ',', '.');
                        ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('admin/tagihan/search') ?>" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="keyword" placeholder="Cari nama pelanggan..." value="<?= $this->input->get('keyword') ?>">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="sudah_bayar" <?= $this->input->get('status') == 'sudah_bayar' ? 'selected' : '' ?>>Sudah Bayar</option>
                        <option value="belum_bayar" <?= $this->input->get('status') == 'belum_bayar' ? 'selected' : '' ?>>Belum Bayar</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?= $i ?>" <?= $this->input->get('bulan') == $i ? 'selected' : '' ?>>
                                <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tagihan Table -->
    <div class="card border-0 shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2"></i>Daftar Tagihan
            </h5>
            <div>
                <a href="<?= base_url('admin/tagihan/export_excel') ?>" class="btn btn-light btn-sm">
                    <i class="fas fa-download me-2"></i>Export Excel
                </a>
                <a href="<?= base_url('admin/tagihan/print_bulk') ?>" class="btn btn-light btn-sm">
                    <i class="fas fa-print me-2"></i>Print Bulk
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered datatable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Bulan/Tahun</th>
                            <th>Jumlah Meter</th>
                            <th>Tarif/KWH</th>
                            <th>Total Tagihan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tagihan)): ?>
                            <?php $no = 1; foreach ($tagihan as $t): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <strong><?= $t->nama_pelanggan ?></strong><br>
                                    <small class="text-muted"><?= $t->nomor_kwh ?></small>
                                </td>
                                <td>
                                    <?= $t->bulan . ' ' . $t->tahun ?>
                                </td>
                                <td><?= number_format($t->jumlah_meter) ?> KWH</td>
                                <td>Rp <?= number_format($t->tarifperkwh ?? 0) ?></td>
                                <td>
                                    <strong>Rp <?= number_format($t->jumlah_meter * ($t->tarifperkwh ?? 0), 0, ',', '.') ?></strong>
                                </td>
                                <td>
                                    <?php if ($t->status == 'sudah_bayar'): ?>
                                        <span class="badge bg-success">Sudah Bayar</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Belum Bayar</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('admin/tagihan/view/' . $t->id_tagihan) ?>" 
                                           class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/tagihan/edit/' . $t->id_tagihan) ?>" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/tagihan/print_bill/' . $t->id_tagihan) ?>" 
                                           class="btn btn-sm btn-secondary" title="Print">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <a href="<?= base_url('admin/tagihan/delete/' . $t->id_tagihan) ?>" 
                                           class="btn btn-sm btn-danger" title="Hapus"
                                           onclick="return confirm('Yakin ingin menghapus tagihan ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">
                                    <i class="fas fa-file-invoice-dollar fa-3x mb-3"></i>
                                    <p>Belum ada data tagihan</p>
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