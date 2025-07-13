<?php $this->load->view('admin/template/header'); ?>
<?php $this->load->view('admin/template/sidebar'); ?>
<?php $this->load->view('admin/template/content'); ?>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Level Daya</h1>
        <a href="<?= base_url('admin/level') ?>" class="btn btn-secondary btn-sm">
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
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Level Daya</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/level/add') ?>" method="POST">
                        <div class="form-group">
                            <label for="daya">Daya (VA) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?= form_error('daya') ? 'is-invalid' : '' ?>" id="daya" name="daya" value="<?= set_value('daya') ?>" min="1" required>
                            <?php if (form_error('daya')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('daya') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="tarif_per_kwh">Tarif per KWH (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?= form_error('tarif_per_kwh') ? 'is-invalid' : '' ?>" id="tarif_per_kwh" name="tarif_per_kwh" value="<?= set_value('tarif_per_kwh') ?>" min="1" step="0.01" required>
                            <?php if (form_error('tarif_per_kwh')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('tarif_per_kwh') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('admin/level') ?>" class="btn btn-secondary">
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