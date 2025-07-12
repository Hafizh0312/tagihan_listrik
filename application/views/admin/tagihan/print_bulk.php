<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Bulk Tagihan - Sistem Pembayaran Listrik</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
                padding: 10px;
            }
            .container {
                max-width: 100% !important;
            }
            .bill-page {
                page-break-after: always;
                margin-bottom: 20px;
            }
            .bill-page:last-child {
                page-break-after: avoid;
            }
        }
        
        .bill-page {
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            background: white;
        }
        
        .bill-header {
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        
        .company-logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
        
        .bill-number {
            background: #f8f9fa;
            padding: 8px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        
        .customer-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        
        .calculation-table {
            border: 2px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .total-amount {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin: 15px 0;
        }
        
        .status-badge {
            font-size: 1rem;
            padding: 8px 16px;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            color: #6c757d;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 3rem;
            color: rgba(0, 123, 255, 0.1);
            z-index: -1;
            pointer-events: none;
        }
        
        .summary-info {
            background: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="watermark">PLN</div>
    
    <div class="container">
        <!-- Print Button -->
        <div class="text-end mb-3 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>Print Semua Tagihan
            </button>
            <a href="<?= base_url('admin/tagihan') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Summary Information -->
        <div class="summary-info no-print">
            <div class="row">
                <div class="col-md-3">
                    <strong>Total Tagihan:</strong> <?= count($tagihan) ?>
                </div>
                <div class="col-md-3">
                    <strong>Total Nilai:</strong> 
                    <?php 
                    $total_nilai = 0;
                    foreach ($tagihan as $t) {
                        $total_nilai += $t->total_tagihan;
                    }
                    echo 'Rp ' . number_format($total_nilai, 0, ',', '.');
                    ?>
                </div>
                <div class="col-md-3">
                    <strong>Status Filter:</strong> <?= $status_filter ?? 'Semua' ?>
                </div>
                <div class="col-md-3">
                    <strong>Tanggal Print:</strong> <?= date('d/m/Y H:i') ?>
                </div>
            </div>
        </div>

        <!-- Bills -->
        <?php foreach ($tagihan as $index => $t): ?>
        <div class="bill-page">
            <!-- Bill Header -->
            <div class="bill-header">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <div class="company-logo">
                            <i class="fas fa-bolt"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h3 class="mb-1">PT. PLN (PERSERO)</h3>
                        <h5 class="text-muted mb-0">Sistem Pembayaran Listrik</h5>
                        <p class="mb-0">Jl. Gatot Subroto Kav. 18, Jakarta 12190</p>
                        <p class="mb-0">Telp: (021) 7251234 | Email: info@pln.co.id</p>
                    </div>
                    <div class="col-md-2 text-end">
                        <div class="bill-number">
                            <strong>No: <?= $t->tagihan_id ?></strong><br>
                            <small class="text-muted"><?= date('d/m/Y', strtotime($t->created_at)) ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="customer-info">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-user me-2"></i>Informasi Pelanggan</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>Nama:</strong></td>
                                <td><?= $t->nama_pelanggan ?></td>
                            </tr>
                            <tr>
                                <td><strong>Alamat:</strong></td>
                                <td><?= $t->alamat ?></td>
                            </tr>
                            <tr>
                                <td><strong>ID Pelanggan:</strong></td>
                                <td><?= $t->pelanggan_id ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-cog me-2"></i>Informasi Tagihan</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Periode:</strong></td>
                                <td><?= date('F Y', mktime(0, 0, 0, $t->bulan, 1, $t->tahun)) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge <?= $t->status == 'Lunas' ? 'bg-success' : 'bg-warning' ?> status-badge">
                                        <?= $t->status ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Daya:</strong></td>
                                <td><?= $t->daya ?> Watt</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Calculation Details -->
            <div class="calculation-table">
                <table class="table table-bordered mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center" width="20%">Meter Awal</th>
                            <th class="text-center" width="20%">Meter Akhir</th>
                            <th class="text-center" width="20%">Total KWH</th>
                            <th class="text-center" width="20%">Tarif/KWH</th>
                            <th class="text-center" width="20%">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><?= number_format($t->meter_awal, 0) ?></td>
                            <td class="text-center"><?= number_format($t->meter_akhir, 0) ?></td>
                            <td class="text-center">
                                <strong><?= number_format($t->total_kwh, 0) ?> KWH</strong>
                            </td>
                            <td class="text-center">Rp <?= number_format($t->tarif_per_kwh, 0, ',', '.') ?></td>
                            <td class="text-center">
                                <strong>Rp <?= number_format($t->total_tagihan, 0, ',', '.') ?></strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Total Amount -->
            <div class="total-amount">
                <h4 class="mb-2">TOTAL TAGIHAN</h4>
                <h2 class="mb-0">Rp <?= number_format($t->total_tagihan, 0, ',', '.') ?></h2>
                <small>Terbilang: <?= ucwords(number_to_words($t->total_tagihan)) ?> Rupiah</small>
            </div>

            <!-- Payment Information -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Pembayaran</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Batas Waktu:</strong> <?= date('d F Y', strtotime('+1 month', strtotime($t->created_at))) ?></p>
                            <p><strong>Metode Pembayaran:</strong></p>
                            <ul class="mb-0">
                                <li>Transfer Bank: BCA 123-456-789</li>
                                <li>E-Wallet: OVO, DANA, GoPay</li>
                                <li>Kantor PLN Terdekat</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-info">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Peringatan</h6>
                        </div>
                        <div class="card-body">
                            <ul class="mb-0">
                                <li>Pembayaran setelah batas waktu akan dikenakan denda 2%</li>
                                <li>Pemutusan aliran listrik akan dilakukan jika tidak membayar dalam 3 bulan</li>
                                <li>Simpan bukti pembayaran sebagai arsip</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <p><strong>Dibuat oleh:</strong><br>
                        Admin Sistem<br>
                        <?= date('d/m/Y H:i', strtotime($t->created_at)) ?></p>
                    </div>
                    <div class="col-md-4 text-center">
                        <p><strong>Diverifikasi oleh:</strong><br>
                        ________________<br>
                        Tanda Tangan</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <p><strong>Diterima oleh:</strong><br>
                        ________________<br>
                        Tanda Tangan</p>
                    </div>
                </div>
                <hr>
                <p class="mb-0">
                    <small>
                        Dokumen ini dicetak secara otomatis oleh sistem. 
                        Untuk informasi lebih lanjut, hubungi customer service kami.
                    </small>
                </p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Number to Words Function -->
    <script>
        function number_to_words(number) {
            const ones = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
            const teens = ['sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'];
            const tens = ['', '', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'];
            
            if (number === 0) return 'nol';
            if (number < 10) return ones[number];
            if (number < 20) return teens[number - 10];
            if (number < 100) {
                const ten = Math.floor(number / 10);
                const one = number % 10;
                return tens[ten] + (one > 0 ? ' ' + ones[one] : '');
            }
            if (number < 1000) {
                const hundred = Math.floor(number / 100);
                const remainder = number % 100;
                return (hundred === 1 ? 'seratus' : ones[hundred] + ' ratus') + 
                       (remainder > 0 ? ' ' + number_to_words(remainder) : '');
            }
            if (number < 1000000) {
                const thousand = Math.floor(number / 1000);
                const remainder = number % 1000;
                return (thousand === 1 ? 'seribu' : number_to_words(thousand) + ' ribu') + 
                       (remainder > 0 ? ' ' + number_to_words(remainder) : '');
            }
            if (number < 1000000000) {
                const million = Math.floor(number / 1000000);
                const remainder = number % 1000000;
                return number_to_words(million) + ' juta' + 
                       (remainder > 0 ? ' ' + number_to_words(remainder) : '');
            }
            return 'nomor terlalu besar';
        }
    </script>
</body>
</html> 