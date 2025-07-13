<?php $this->load->view('admin/template/header'); ?>
<?php $this->load->view('admin/template/sidebar'); ?>
<?php $this->load->view('admin/template/content'); ?>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Pelanggan</h1>
        <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
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

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Pelanggan</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/pelanggan/add') ?>" method="POST">
                        <div class="form-group">
                            <label for="nama_pelanggan">Nama Pelanggan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= form_error('nama_pelanggan') ? 'is-invalid' : '' ?>" id="nama_pelanggan" name="nama_pelanggan" value="<?= set_value('nama_pelanggan') ?>" required>
                            <?php if (form_error('nama_pelanggan')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('nama_pelanggan') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= form_error('username') ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= set_value('username') ?>" required>
                            <?php if (form_error('username')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('username') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" id="password" name="password" required>
                            <?php if (form_error('password')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('password') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="nomor_kwh">Nomor KWH <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= form_error('nomor_kwh') ? 'is-invalid' : '' ?>" id="nomor_kwh" name="nomor_kwh" value="<?= set_value('nomor_kwh') ?>" required>
                            <?php if (form_error('nomor_kwh')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('nomor_kwh') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2"><?= set_value('alamat') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="id_tarif">Tarif Listrik <span class="text-danger">*</span></label>
                            <select class="form-control <?= form_error('id_tarif') ? 'is-invalid' : '' ?>" id="id_tarif" name="id_tarif" required>
                                <option value="">-- Pilih Tarif --</option>
                                <?php foreach ($tarifs as $tarif): ?>
                                    <option value="<?= $tarif->id_tarif ?>" <?= set_select('id_tarif', $tarif->id_tarif) ?>><?= $tarif->daya ?> VA - Rp <?= number_format($tarif->tarifperkwh, 0, ',', '.') ?>/KWH</option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (form_error('id_tarif')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('id_tarif') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php $this->load->view('admin/template/footer'); ?> 