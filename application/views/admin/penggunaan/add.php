<?php $this->load->view('admin/template/header'); ?>

<?php $this->load->view('admin/template/sidebar'); ?>

<!-- Main content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= $title ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= base_url('admin/penggunaan') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow">
        <div class="card-header bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                Data Penggunaan
            </h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/penggunaan/add') ?>" method="POST">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="id_pelanggan" class="form-label">Pelanggan <span class="text-danger">*</span></label>
                        <select name="id_pelanggan" id="id_pelanggan" class="form-select select2" required>
                            <option value="">Pilih Pelanggan</option>
                            <?php foreach ($pelanggan as $p): ?>
                                <option value="<?= $p->id_pelanggan ?>" <?= set_select('id_pelanggan', $p->id_pelanggan) ?>>
                                    <?= $p->nama_pelanggan ?> - <?= $p->nomor_kwh ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="bulan" class="form-label">Bulan <span class="text-danger">*</span></label>
                        <select name="bulan" id="bulan" class="form-select select2" required>
                            <option value="">Pilih Bulan</option>
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= $i ?>" <?= set_select('bulan', $i) ?>>
                                    <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <select name="tahun" id="tahun" class="form-select select2" required>
                            <option value="">Pilih Tahun</option>
                            <?php for ($year = date('Y'); $year >= date('Y') - 5; $year--): ?>
                                <option value="<?= $year ?>" <?= set_select('tahun', $year) ?>>
                                    <?= $year ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="meter_awal" class="form-label">Meter Awal (KWH) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="meter_awal" name="meter_awal" value="<?= set_value('meter_awal') ?>" min="0" step="0.01" required>
                        <div class="form-text">Meteran awal</div>
                    </div>
                    <div class="col-md-2">
                        <label for="meter_ahir" class="form-label">Meter Akhir (KWH) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="meter_ahir" name="meter_ahir" value="<?= set_value('meter_ahir') ?>" min="0" step="0.01" required>
                        <div class="form-text">Meteran akhir</div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4 offset-md-8">
                        <label class="form-label">Total KWH</label>
                        <input type="text" class="form-control" id="total_kwh" readonly>
                        <div class="form-text">Total penggunaan akan dihitung otomatis</div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Informasi</h6>
                            <ul class="mb-0">
                                <li>Pastikan meter akhir lebih besar dari meter awal</li>
                                <li>Data penggunaan akan digunakan untuk menghitung tagihan</li>
                                <li>Setelah disimpan, data tidak dapat diubah</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Data
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php $this->load->view('admin/template/footer'); ?> 