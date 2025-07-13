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

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow">
                <div class="card-body text-center">
                    <i class="fas fa-bolt fa-2x text-primary mb-2"></i>
                    <h5 class="card-title">Total Penggunaan</h5>
                    <h3 class="text-primary"><?= number_format($total_penggunaan) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow">
                <div class="card-body text-center">
                    <i class="fas fa-calendar fa-2x text-success mb-2"></i>
                    <h5 class="card-title">Bulan Ini</h5>
                    <h3 class="text-success"><?= number_format($penggunaan_bulan_ini) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow">
                <div class="card-body text-center">
                    <i class="fas fa-tachometer-alt fa-2x text-warning mb-2"></i>
                    <h5 class="card-title">Total KWH</h5>
                    <h3 class="text-warning"><?= number_format($total_kwh) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x text-info mb-2"></i>
                    <h5 class="card-title">Rata-rata KWH</h5>
                    <h3 class="text-info"><?= number_format($rata_rata_kwh, 1) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i> Grafik Penggunaan per Bulan
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="usageChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i> Distribusi Penggunaan
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="distributionChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Usage by Month Table -->
    <div class="card border-0 shadow mt-4">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-table me-2"></i> Detail Penggunaan per Bulan
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Bulan</th>
                            <th>Jumlah Data</th>
                            <th>Total KWH</th>
                            <th>Rata-rata KWH</th>
                            <th>Total Bayar</th>
                            <th>Rata-rata Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($penggunaan_per_bulan)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data penggunaan</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($penggunaan_per_bulan as $data): ?>
                                <tr>
                                    <td>
                                        <strong><?= date('F Y', mktime(0, 0, 0, $data->bulan, 1, $data->tahun)) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary"><?= $data->jumlah_data ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><?= number_format($data->total_kwh) ?> KWH</span>
                                    </td>
                                    <td>
                                        <?= number_format($data->rata_rata_kwh, 1) ?> KWH
                                    </td>
                                    <td>
                                        <strong class="text-primary">Rp <?= number_format($data->total_bayar) ?></strong>
                                    </td>
                                    <td>
                                        Rp <?= number_format($data->rata_rata_bayar) ?>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Usage Chart
const usageCtx = document.getElementById('usageChart').getContext('2d');
const usageChart = new Chart(usageCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode($chart_labels) ?>,
        datasets: [{
            label: 'Total KWH',
            data: <?= json_encode($chart_data) ?>,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Penggunaan Listrik per Bulan'
            }
        }
    }
});

// Distribution Chart
const distributionCtx = document.getElementById('distributionChart').getContext('2d');
const distributionChart = new Chart(distributionCtx, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($pie_labels) ?>,
        datasets: [{
            data: <?= json_encode($pie_data) ?>,
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF',
                '#FF9F40'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            },
            title: {
                display: true,
                text: 'Distribusi Penggunaan'
            }
        }
    }
});
</script>

<?php $this->load->view('admin/template/footer'); ?> 