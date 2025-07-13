<?php $this->load->view('admin/template/header'); ?>

<?php $this->load->view('admin/template/sidebar'); ?>

<?php $this->load->view('admin/template/content'); ?>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Level Daya</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a href="<?= base_url('admin/level/add') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus fa-sm"></i> Tambah Level
                </a>
                <a href="<?= base_url('admin/level/import') ?>" class="btn btn-success btn-sm">
                    <i class="fas fa-upload fa-sm"></i> Import CSV
                </a>
                <a href="<?= base_url('admin/level/statistics') ?>" class="btn btn-info btn-sm">
                    <i class="fas fa-chart-bar fa-sm"></i> Statistik
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Statistics Cards -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Level</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($levels) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cog fa-2x text-gray-300"></i>
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
                                Level Terendah</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= !empty($levels) ? min(array_column($levels, 'daya')) . ' VA' : '0 VA' ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
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
                                Level Tertinggi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= !empty($levels) ? max(array_column($levels, 'daya')) . ' VA' : '0 VA' ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Rata-rata Daya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= !empty($levels) ? round(array_sum(array_column($levels, 'daya')) / count($levels)) . ' VA' : '0 VA' ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Level Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list fa-sm"></i> Daftar Level Daya
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
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
                                    <span class="badge badge-info"><?= $level->daya ?> VA</span>
                                </td>
                                <td>
                                    <strong>Rp <?= number_format($level->tarifperkwh, 0, ',', '.') ?></strong>
                                </td>
                                <td>
                                    <span class="badge badge-success">Aktif</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('admin/level/view/' . $level->id_tarif) ?>" 
                                           class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/level/edit/' . $level->id_tarif) ?>" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/level/delete/' . $level->id_tarif) ?>" 
                                           class="btn btn-danger btn-sm" title="Hapus"
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

</div>
<!-- /.container-fluid -->

<?php $this->load->view('admin/template/footer'); ?> 