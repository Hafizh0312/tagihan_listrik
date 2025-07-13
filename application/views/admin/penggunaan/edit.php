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
        <div class="card-header bg-warning text-dark">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-edit me-2"></i>Edit Data Penggunaan
            </h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/penggunaan/edit/' . $penggunaan->id_penggunaan) ?>" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_pelanggan" class="form-label">Pelanggan <span class="text-danger">*</span></label>
                            <select name="id_pelanggan" id="id_pelanggan" class="form-select" required>
                                <option value="">Pilih Pelanggan</option>
                                <?php foreach ($pelanggan as $p): ?>
                                    <option value="<?= $p->id_pelanggan ?>" <?= $penggunaan->id_pelanggan == $p->id_pelanggan ? 'selected' : '' ?>>
                                        <?= $p->nama_pelanggan ?> - <?= $p->nomor_kwh ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bulan" class="form-label">Bulan <span class="text-danger">*</span></label>
                                    <select name="bulan" id="bulan" class="form-select" required>
                                        <option value="">Pilih Bulan</option>
                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                            <option value="<?= $i ?>" <?= $penggunaan->bulan == $i ? 'selected' : '' ?>>
                                                <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                                    <select name="tahun" id="tahun" class="form-select" required>
                                        <option value="">Pilih Tahun</option>
                                        <?php for ($year = date('Y'); $year >= date('Y') - 5; $year--): ?>
                                            <option value="<?= $year ?>" <?= $penggunaan->tahun == $year ? 'selected' : '' ?>>
                                                <?= $year ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="meter_awal" class="form-label">Meter Awal (KWH) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="meter_awal" name="meter_awal" 
                                   value="<?= $penggunaan->meter_awal ?>" min="0" step="0.01" required>
                            <div class="form-text">Masukkan angka meteran awal dalam KWH</div>
                        </div>

                        <div class="mb-3">
                            <label for="meter_ahir" class="form-label">Meter Akhir (KWH) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="meter_ahir" name="meter_ahir" 
                                   value="<?= $penggunaan->meter_ahir ?>" min="0" step="0.01" required>
                            <div class="form-text">Masukkan angka meteran akhir dalam KWH</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total KWH</label>
                            <input type="text" class="form-control" id="total_kwh" readonly>
                            <div class="form-text">Total penggunaan akan dihitung otomatis</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle"></i> Peringatan</h6>
                            <ul class="mb-0">
                                <li>Perubahan data penggunaan akan mempengaruhi tagihan terkait</li>
                                <li>Pastikan meter akhir lebih besar dari meter awal</li>
                                <li>Data yang sudah dibuat tagihan sebaiknya tidak diubah</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Update Data
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const meterAwal = document.getElementById('meter_awal');
    const meterAkhir = document.getElementById('meter_ahir');
    const totalKwh = document.getElementById('total_kwh');

    function calculateTotal() {
        const awal = parseFloat(meterAwal.value) || 0;
        const akhir = parseFloat(meterAkhir.value) || 0;
        const total = akhir - awal;
        
        if (total >= 0) {
            totalKwh.value = total.toFixed(2);
        } else {
            totalKwh.value = '0.00';
        }
    }

    meterAwal.addEventListener('input', calculateTotal);
    meterAkhir.addEventListener('input', calculateTotal);
    
    // Calculate initial total
    calculateTotal();
});
</script>

<?php $this->load->view('admin/template/footer'); ?> 