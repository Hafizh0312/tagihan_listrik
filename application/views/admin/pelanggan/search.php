<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Sistem Pembayaran Listrik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #22304a;
        }
        .sidebar .nav-link {
            color: #ecf0f1;
            font-weight: 500;
            border-radius: 6px;
            margin-bottom: 6px;
            padding: 0.75rem 1rem;
            transition: background 0.2s, color 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .sidebar .nav-link:hover {
            background: #2d4063;
            color: #fff;
        }
        .sidebar .nav-link.active {
            background: #2196f3;
            color: #fff;
        }
        .sidebar .nav-link i {
            color: #fff;
            min-width: 22px;
            text-align: center;
        }
        .sidebar .nav-item {
            margin-bottom: 2px;
        }
        .sidebar h4, .sidebar small {
            color: #fff;
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .btn-primary {
            background: linear-gradient(135deg, #22304a 0%, #22304a 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #22304a 0%, #22304a 100%);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Admin Panel</h4>
                        <small class="text-muted">Sistem Pembayaran Listrik</small>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url('admin/pelanggan') ?>">
                                <i class="fas fa-users me-2"></i>
                                Kelola Pelanggan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/penggunaan') ?>">
                                <i class="fas fa-bolt me-2"></i>
                                Kelola Penggunaan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/tagihan') ?>">
                                <i class="fas fa-file-invoice-dollar me-2"></i>
                                Kelola Tagihan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/tarif') ?>">
                                <i class="fas fa-cog me-2"></i>
                                Kelola Tarif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/level') ?>">
                                <i class="fas fa-user-shield me-2"></i>
                                Kelola Level
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a class="nav-link" href="<?= base_url('admin/dashboard/profile') ?>">
                                <i class="fas fa-user me-2"></i>
                                Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('auth/logout') ?>">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Hasil Pencarian Pelanggan</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <!-- Search Info -->
                <div class="alert alert-info">
                    <i class="fas fa-search me-2"></i>
                    <strong>Kata kunci pencarian:</strong> "<?= $keyword ?>"
                    <br>
                    <strong>Hasil ditemukan:</strong> <?= count($pelanggan) ?> pelanggan
                </div>

                <!-- Search Form -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/pelanggan/search') ?>" method="get" class="row g-3">
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="keyword" placeholder="Cari pelanggan berdasarkan nama, username, nomor KWH, atau alamat..." value="<?= $keyword ?>">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-search me-2"></i>Cari
                                </button>
                                <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary">
                                    <i class="fas fa-refresh me-2"></i>Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Search Results -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Hasil Pencarian</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($pelanggan)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Username</th>
                                            <th>Nomor KWH</th>
                                            <th>Alamat</th>
                                            <th>Daya</th>
                                            <th>Tarif/KWH</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($pelanggan as $p): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><?= $p->nama_pelanggan ?></strong>
                                            </td>
                                            <td><?= $p->username ?></td>
                                            <td>
                                                <span class="badge bg-info"><?= $p->nomor_kwh ?></span>
                                            </td>
                                            <td><?= $p->alamat ?></td>
                                            <td>
                                                <span class="badge bg-primary"><?= $p->daya ?> VA</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">Rp <?= number_format($p->tarifperkwh, 0, ',', '.') ?></span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('admin/pelanggan/view/' . $p->id_pelanggan) ?>" 
                                                       class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/pelanggan/edit/' . $p->id_pelanggan) ?>" 
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/pelanggan/delete/' . $p->id_pelanggan) ?>" 
                                                       class="btn btn-sm btn-danger" title="Hapus"
                                                       onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada hasil pencarian</h5>
                                <p class="text-muted">Tidak ada pelanggan yang sesuai dengan kata kunci "<?= $keyword ?>"</p>
                                <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pelanggan
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 
</html> 