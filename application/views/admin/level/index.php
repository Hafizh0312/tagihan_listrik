<?php $this->load->view('admin/template/header'); ?>

<?php $this->load->view('admin/template/sidebar'); ?>

<!-- Main content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Kelola Level Daya</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= base_url('admin/level/add') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Level
                </a>
                <a href="<?= base_url('admin/level/import') ?>" class="btn btn-success">
                    <i class="fas fa-upload me-1"></i> Import CSV
                </a>
                <a href="<?= base_url('admin/level/statistics') ?>" class="btn btn-info">
                    <i class="fas fa-chart-bar me-1"></i> Statistik
                </a>
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
            <div class="card border-0 shadow h-100">
                <div class="card-body text-center">
                    <i class="fas fa-cog fa-2x text-primary mb-2"></i>
                    <h5 class="card-title">Total Level</h5>
                    <h3 class="text-primary"><?= count($levels) ?></h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body text-center">
                    <i class="fas fa-arrow-down fa-2x text-success mb-2"></i>
                    <h5 class="card-title">Level Terendah</h5>
                    <h3 class="text-success">
                        <?= !empty($levels) ? min(array_column($levels, 'daya')) . ' VA' : '0 VA' ?>
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body text-center">
                    <i class="fas fa-arrow-up fa-2x text-warning mb-2"></i>
                    <h5 class="card-title">Level Tertinggi</h5>
                    <h3 class="text-warning">
                        <?= !empty($levels) ? max(array_column($levels, 'daya')) . ' VA' : '0 VA' ?>
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x text-info mb-2"></i>
                    <h5 class="card-title">Rata-rata Daya</h5>
                    <h3 class="text-info">
                        <?= !empty($levels) ? round(array_sum(array_column($levels, 'daya')) / count($levels)) . ' VA' : '0 VA' ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Level Table -->
    <div class="card border-0 shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2"></i>Daftar Level Daya
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Level</th>
                            <th>Daya (VA)</th>
                            <th>Tarif per KWH</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($levels)): ?>
                            <?php $no = 1; foreach ($levels as $level): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <strong>Level <?= $level->daya ?> VA</strong>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= $level->daya ?> VA</span>
                                </td>
                                <td>
                                    <strong>Rp <?= number_format($level->tarifperkwh, 0, ',', '.') ?></strong>
                                </td>
                                <td>
                                    <span class="badge bg-success">Aktif</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('admin/level/view/' . $level->id_tarif) ?>" 
                                           class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/level/edit/' . $level->id_tarif) ?>" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/level/delete/' . $level->id_tarif) ?>" 
                                           class="btn btn-sm btn-danger" title="Hapus"
                                           onclick="return confirm('Yakin ingin menghapus level ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    <i class="fas fa-cog fa-3x mb-3"></i>
                                    <p>Belum ada data level daya</p>
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