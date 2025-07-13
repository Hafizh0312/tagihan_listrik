<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penggunaan Listrik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    <style>
        body { background: #f8f9fc; }
        .dt-center { text-align: center; }
        .table thead th, .table tfoot th { vertical-align: middle; }
        .dataTables_wrapper .dataTables_filter input { margin-left: 0.5em; }
        .dataTables_wrapper .dataTables_length select { margin-right: 0.5em; }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="mb-4">
        <h4 class="fw-bold">Column Search</h4>
        <p class="mb-2 text-muted" style="max-width:600px;">DataTables with Column Search by Text Inputs. Fitur pencarian per kolom sangat berguna untuk mencari data secara spesifik di tabel. Semua fitur DataTables (search, sort, pagination, export) aktif dan tampilan Bootstrap 5.</p>
    </div>
    <div class="table-responsive bg-white p-3 rounded shadow-sm">
        <table id="penggunaanTable" class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th class="dt-center">No</th>
                    <th>Pelanggan</th>
                    <th>No. KWH</th>
                    <th>Periode</th>
                    <th class="dt-center">Meter Awal</th>
                    <th class="dt-center">Meter Akhir</th>
                    <th class="dt-center">Total KWH</th>
                    <th class="dt-center">Tarif/KWH</th>
                    <th class="dt-center">Total Bayar</th>
                    <th class="dt-center">Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari No" /></th>
                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari Nama" /></th>
                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari KWH" /></th>
                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari Periode" /></th>
                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari Meter Awal" /></th>
                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari Meter Akhir" /></th>
                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari KWH" /></th>
                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari Tarif" /></th>
                    <th><input type="text" class="form-control form-control-sm" placeholder="Cari Bayar" /></th>
                    <th></th>
                </tr>
            </tfoot>
            <tbody>
                <?php if (empty($penggunaan)): ?>
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data yang ditemukan</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($penggunaan as $p): ?>
                        <tr>
                            <td class="dt-center"><?= $no++ ?></td>
                            <td><?= $p->nama_pelanggan ?></td>
                            <td><?= $p->nomor_kwh ?></td>
                            <td><?= $p->bulan . ' ' . $p->tahun ?></td>
                            <td class="dt-center"><?= number_format($p->meter_awal) ?></td>
                            <td class="dt-center"><?= number_format($p->meter_ahir) ?></td>
                            <td class="dt-center"><?= number_format($p->meter_ahir - $p->meter_awal) ?> KWH</td>
                            <td class="dt-center">Rp <?= number_format($p->tarifperkwh ?? 0) ?></td>
                            <td class="dt-center">Rp <?= number_format(($p->meter_ahir - $p->meter_awal) * ($p->tarifperkwh ?? 0)) ?></td>
                            <td class="dt-center">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
<script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#penggunaanTable tfoot th').each(function () {
        var title = $(this).text();
        if (title !== '') {
            $(this).find('input').on('click', function(e) {
                e.stopPropagation();
            });
        }
    });
    var table = $('#penggunaanTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        },
        dom: 'Bfrtip',
        buttons: [
            'colvis', 'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        responsive: true,
        orderCellsTop: true,
        fixedHeader: true
    });
    // Apply the search for each column
    table.columns().every(function () {
        var that = this;
        $('input', this.footer()).on('keyup change clear', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });
});
</script>
</body>
</html> 