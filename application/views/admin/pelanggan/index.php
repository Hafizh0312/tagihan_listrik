<?php $this->load->view('admin/template/header'); ?>

<?php $this->load->view('admin/template/sidebar'); ?>

<!-- Main content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Kelola Pelanggan</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= base_url('admin/pelanggan/add') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Pelanggan
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

    <!-- Search Form -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('admin/pelanggan/search') ?>" method="GET" class="row g-3">
                <div class="col-md-8">
                    <input type="text" class="form-control" name="keyword" placeholder="Cari nama, alamat, atau nomor KWH..." value="<?= $this->input->get('keyword') ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                    <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary">
                        <i class="fas fa-refresh me-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Pelanggan Table -->
    <div class="card border-0 shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2"></i>Daftar Pelanggan
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Username</th>
                            <th>No. KWH</th>
                            <th>Alamat</th>
                            <th>Daya</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pelanggan)): ?>
                            <?php $no = 1; foreach ($pelanggan as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <strong><?= $p->nama_pelanggan ?></strong>
                                </td>
                                <td><?= $p->username ?></td>
                                <td><?= $p->nomor_kwh ?></td>
                                <td><?= $p->alamat ?></td>
                                <td><?= $p->daya ?> VA</td>
                                <td>
                                    <span class="badge bg-success">Aktif</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('admin/pelanggan/view/' . $p->id_pelanggan) ?>" 
                                           class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/pelanggan/edit/' . $p->id_pelanggan) ?>" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/pelanggan/delete/' . $p->id_pelanggan) ?>" 
                                           class="btn btn-sm btn-danger" title="Hapus"
                                           onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <p>Belum ada data pelanggan</p>
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