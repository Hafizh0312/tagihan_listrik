<?php $this->load->view('admin/header'); ?>
<?php $this->load->view('admin/sidebar'); ?>
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-1">Profil Saya</h2>
            <p class="text-muted mb-0">Lihat dan kelola data profil Anda sebagai pelanggan listrik.</p>
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
    <div class="card mb-4">
        <!-- <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <h4 class="mb-0"><?= isset($pelanggan->nama_pelanggan) ? $pelanggan->nama_pelanggan : 'Pelanggan' ?></h4>
            <small>
                <?php
                if (isset($pelanggan->username)) {
                    echo $pelanggan->username;
                } elseif ($this->session->userdata('username')) {
                    echo $this->session->userdata('username');
                } else {
                    echo '-';
                }
                ?>
            </small>
        </div> -->
        <div class="card-body">
            <?php if (isset($pelanggan)): ?>
            <table class="table table-borderless profile-info-table mb-0">
                <tr>
                    <td width="35%"><strong>Nama</strong></td>
                    <td><?= $pelanggan->nama_pelanggan ?></td>
                </tr>
                <tr>
                    <td><strong>Username</strong></td>
                    <td>
                        <?php
                        if (isset($pelanggan->username)) {
                            echo $pelanggan->username;
                        } elseif ($this->session->userdata('username')) {
                            echo $this->session->userdata('username');
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Alamat</strong></td>
                    <td><?= $pelanggan->alamat ?></td>
                </tr>
                <tr>
                    <td><strong>Level Daya</strong></td>
                    <td><?= isset($pelanggan->daya) ? number_format($pelanggan->daya, 0, ',', '.') . ' VA' : '-' ?></td>
                </tr>
                <tr>
                    <td><strong>Tarif/KWH</strong></td>
                    <td><?= isset($pelanggan->tarifperkwh) ? 'Rp ' . number_format($pelanggan->tarifperkwh, 0, ',', '.') : '-' ?></td>
                </tr>
            </table>
            <div class="mt-4 text-end">
                <a href="<?= base_url('pelanggan/profil/change_password') ?>" class="btn btn-warning">
                    <i class="fas fa-key me-1"></i> Ganti Password
                </a>
            </div>
            <?php else: ?>
                <div class="alert alert-danger text-center mb-0">
                    Data profil tidak ditemukan.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $this->load->view('admin/footer'); ?> 