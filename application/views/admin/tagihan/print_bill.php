<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagihan Listrik - <?= $tagihan->nama_pelanggan ?></title>
    
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
                padding: 20px;
            }
            .container {
                max-width: 100% !important;
            }
        }
        
        .bill-header {
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .company-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }
        
        .bill-number {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        
        .customer-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .calculation-table {
            border: 2px solid #dee2e6;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .total-amount {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
        }
        
        .status-badge {
            font-size: 1.2rem;
            padding: 10px 20px;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            color: #6c757d;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 4rem;
            color: rgba(0, 123, 255, 0.1);
            z-index: -1;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="watermark">PLN</div>
    
    <div class="container">
        <!-- Print Button -->
        <div class="text-end mb-3 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>Print Tagihan
            </button>
            <a href="<?= base_url('admin/tagihan') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Bill Header -->
        <div class="bill-header">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <div class="company-logo">
                        <i class="fas fa-bolt"></i>
                    </div>
                </div>
                <div class="col-md-8">
                    <h2 class="mb-1">PT. PLN (PERSERO)</h2>
                    <h4 class="text-muted mb-0">Sistem Pembayaran Listrik</h4>
                    <p class="mb-0">Jl. Gatot Subroto Kav. 18, Jakarta 12190</p>
                    <p class="mb-0">Telp: (021) 7251234 | Email: info@pln.co.id</p>
                </div>
                <div class="col-md-2 text-end">
                    <div class="bill-number">
                        <strong>No: <?= $tagihan->tagihan_id ?></strong><br>
                        <small class="text-muted"><?= date('d/m/Y', strtotime($tagihan->created_at)) ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="customer-info">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-user me-2"></i>Informasi Pelanggan</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%"><strong>Nama:</strong></td>
                            <td><?= $tagihan->nama_pelanggan ?></td>
                        </tr>
                        <tr>
                            <td><strong>Alamat:</strong></td>
                            <td><?= $tagihan->alamat ?></td>
                        </tr>
                        <tr>
                            <td><strong>ID Pelanggan:</strong></td>
                            <td><?= $tagihan->pelanggan_id ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5><i class="fas fa-cog me-2"></i>Informasi Tagihan</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%"><strong>Periode:</strong></td>
                            <td><?= date('F Y', mktime(0, 0, 0, $tagihan->bulan, 1, $tagihan->tahun)) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge <?= $tagihan->status == 'Lunas' ? 'bg-success' : 'bg-warning' ?> status-badge">
                                    <?= $tagihan->status ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Daya:</strong></td>
                            <td><?= $tagihan->daya ?> Watt</td>
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
                        <td class="text-center"><?= number_format($tagihan->meter_awal, 0) ?></td>
                        <td class="text-center"><?= number_format($tagihan->meter_akhir, 0) ?></td>
                        <td class="text-center">
                            <strong><?= number_format($tagihan->total_kwh, 0) ?> KWH</strong>
                        </td>
                        <td class="text-center">Rp <?= number_format($tagihan->tarif_per_kwh, 0, ',', '.') ?></td>
                        <td class="text-center">
                            <strong>Rp <?= number_format($tagihan->total_tagihan, 0, ',', '.') ?></strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Total Amount -->
        <div class="total-amount">
            <h3 class="mb-2">TOTAL TAGIHAN</h3>
            <h1 class="mb-0">Rp <?= number_format($tagihan->total_tagihan, 0, ',', '.') ?></h1>
            <small>Terbilang: <?= ucwords(number_to_words($tagihan->total_tagihan)) ?> Rupiah</small>
        </div>

        <!-- Payment Information -->
        <div class="row">
            <div class="col-md-6">
                <div class="card border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Pembayaran</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Batas Waktu:</strong> <?= date('d F Y', strtotime('+1 month', strtotime($tagihan->created_at))) ?></p>
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
                    <?= date('d/m/Y H:i', strtotime($tagihan->created_at)) ?></p>
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