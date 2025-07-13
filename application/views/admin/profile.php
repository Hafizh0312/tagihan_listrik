<?php $this->load->view('admin/template/header'); ?>

<?php $this->load->view('admin/template/sidebar'); ?>

<?php $this->load->view('admin/template/content'); ?>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil Admin</h1>
        <a href="<?= base_url('admin/dashboard') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Dashboard
        </a>
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

        <!-- Profile Information -->
        <div class="col-lg-8">

            <!-- Profile Header -->
            <div class="card shadow mb-4">
                <div class="card-body text-center" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; border-radius: 10px;">
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

            <!-- Profile Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Profil</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                
                                <tr>
                                    <td><strong>Username:</strong></td>
                                    <td>
                                        <span class="badge badge-primary">
                                            <?= $user->username ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Nama:</strong></td>
                                    <td><?= $user->nama_admin ?? $user->username ?></td>
                                </tr>
                                
                                <tr>
                                    <td><strong>Role:</strong></td>
                                    <td>
                                        <span class="badge badge-info">
                                            <?= ucfirst($user->role) ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge badge-success">Aktif</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
        
                            
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Ubah Password</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/dashboard/profile') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="current_password">Password Saat Ini</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="new_password">Password Baru</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirm_password">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-warning btn-block">
                                        <i class="fas fa-key fa-sm"></i> Ubah Password
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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Statistik Cepat</h6>
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

</div>
<!-- /.container-fluid -->

<?php $this->load->view('admin/template/footer'); ?> 