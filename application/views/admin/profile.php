<?php $this->load->view('admin/template/header'); ?>

<?php $this->load->view('admin/template/sidebar'); ?>

<!-- Main content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Profil Admin</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
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

    <!-- Profile Header -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body text-center" style="background: linear-gradient(135deg, #22304a 0%, #22304a 100%); color: white; border-radius: 10px;">
            <div style="width: 100px; height: 100px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 1rem;">
                <i class="fas fa-user"></i>
            </div>
            <h3><?= $user->nama_admin ?? $user->username ?></h3>
            <p class="mb-0">
                <span class="badge bg-light text-dark">
                    <i class="fas fa-shield-alt me-1"></i>
                    <?= ucfirst($user->role) ?>
                </span>
            </p>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Informasi Profil</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>ID User:</strong></td>
                                    <td><?= $user->id_user ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Username:</strong></td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <?= $user->username ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Nama:</strong></td>
                                    <td><?= $user->nama_admin ?? $user->username ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td><strong>Role:</strong></td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?= ucfirst($user->role) ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge bg-success">Aktif</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Login Terakhir:</strong></td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat:</strong></td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td><strong>Diupdate:</strong></td>
                                    <td>-</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="card border-0 shadow mt-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="m-0 font-weight-bold">Ubah Password</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/dashboard/change_password') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-warning w-100">
                                        <i class="fas fa-key me-2"></i>Ubah Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Stats -->
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">Statistik Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border-end">
                                <h4 class="text-primary"><?= $total_pelanggan ?? 0 ?></h4>
                                <small class="text-muted">Pelanggan</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div>
                                <h4 class="text-success"><?= $total_tagihan ?? 0 ?></h4>
                                <small class="text-muted">Tagihan</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-warning"><?= $tagihan_lunas ?? 0 ?></h4>
                                <small class="text-muted">Lunas</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <h4 class="text-danger"><?= $tagihan_belum_lunas ?? 0 ?></h4>
                                <small class="text-muted">Belum Lunas</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
        </div>
    </div>
</main>

<?php $this->load->view('admin/template/footer'); ?> 