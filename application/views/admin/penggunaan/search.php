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

    <!-- Search Form -->
    <div class="card border-0 shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-search me-2"></i> Form Pencarian
            </h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/penggunaan/search') ?>" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="keyword" class="form-label">Kata Kunci</label>
                    <input type="text" class="form-control" id="keyword" name="keyword" 
                           placeholder="Cari nama pelanggan atau nomor meter..." 
                           value="<?= $keyword ?>">
                </div>
                <div class="col-md-2">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select name="bulan" id="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?= $i ?>" <?= $bulan == $i ? 'selected' : '' ?>>
                                <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select name="tahun" id="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        <?php for ($year = date('Y'); $year >= date('Y') - 5; $year--): ?>
                            <option value="<?= $year ?>" <?= $tahun == $year ? 'selected' : '' ?>>
                                <?= $year ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <a href="<?= base_url('admin/penggunaan/search') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Results -->
    <div class="card border-0 shadow">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2"></i> Hasil Pencarian
                <?php if ($keyword || $bulan || $tahun): ?>
                    <span class="badge bg-light text-dark ms-2"><?= count($penggunaan) ?> hasil</span>
                <?php endif; ?>
            </h5>
        </div>
        <div class="card-body">
            <?php if ($keyword || $bulan || $tahun): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    Menampilkan hasil pencarian untuk:
                    <?php if ($keyword): ?>
                        <strong>"<?= $keyword ?>"</strong>
                    <?php endif; ?>
                    <?php if ($bulan): ?>
                        Bulan: <strong><?= date('F', mktime(0, 0, 0, $bulan, 1)) ?></strong>
                    <?php endif; ?>
                    <?php if ($tahun): ?>
                        Tahun: <strong><?= $tahun ?></strong>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Nomor Meter</th>
                            <th>Bulan/Tahun</th>
                            <th>Meter Awal</th>
                            <th>Meter Akhir</th>
                            <th>Total KWH</th>
                            <th>Tarif</th>
                            <th>Total Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($penggunaan)): ?>
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="py-4">
                                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Tidak ada data yang ditemukan</p>
                                        <?php if ($keyword || $bulan || $tahun): ?>
                                            <p class="text-muted">Coba ubah kriteria pencarian Anda</p>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($penggunaan as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $p->nama_pelanggan ?></td>
                                    <td><?= $p->nomor_kwh ?></td>
                                                                    <td><?= $p->bulan . ' ' . $p->tahun ?></td>
                                <td><?= number_format($p->meter_awal) ?></td>
                                <td><?= number_format($p->meter_ahir) ?></td>
                                <td><?= number_format($p->meter_ahir - $p->meter_awal) ?> KWH</td>
                                <td>Rp <?= number_format($p->tarifperkwh ?? 0) ?></td>
                                <td>Rp <?= number_format(($p->meter_ahir - $p->meter_awal) * ($p->tarifperkwh ?? 0)) ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/penggunaan/view/' . $p->id_penggunaan) ?>" class="btn btn-sm btn-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/penggunaan/edit/' . $p->id_penggunaan) ?>" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('admin/penggunaan/delete/' . $p->id_penggunaan) ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php $this->load->view('admin/template/footer'); ?> 