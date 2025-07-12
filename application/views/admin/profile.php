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
        .card-stats {
            border-left: 4px solid #3498db;
        }
        .card-stats.success {
            border-left-color: #27ae60;
        }
        .card-stats.warning {
            border-left-color: #f39c12;
        }
        .card-stats.danger {
            border-left-color: #e74c3c;
        }
        .profile-header {
            background: linear-gradient(135deg, #22304a  0%, #22304a 100%);
            color: white;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 1rem;
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
                            <a class="nav-link" href="<?= base_url('admin/pelanggan') ?>">
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
                            <a class="nav-link" href="<?= base_url('admin/level') ?>">
                                <i class="fas fa-cog me-2"></i>
                                Kelola Tarif
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a class="nav-link active" href="<?= base_url('admin/dashboard/profile') ?>">
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
                    <h1 class="h2">Profil Admin</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </div>

                <!-- Flash Messages -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Profile Header -->
                <div class="profile-header">
                    <div class="text-center">
                        <div class="profile-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3><?= $user->nama ?? $user->username ?></h3>
                        <p class="mb-0">
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-shield-alt me-1"></i>
                                <?= ucfirst($user->role) ?>
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Informasi Profil</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%"><strong>ID User:</strong></td>
                                                <td><?= $user->user_id ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Username:</strong></td>
                                                <td>
                                                    <span class="badge bg-primary">
                                                        <?= $user->username ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nama:</strong></td>
                                                <td><?= $user->nama ?? 'Tidak diisi' ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>Tidak tersedia</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%"><strong>Role:</strong></td>
                                                <td>
                                                    <span class="badge bg-success">
                                                        <?= ucfirst($user->role) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <td>
                                                    <span class="badge bg-success">Aktif</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Terdaftar:</strong></td>
                                                <td><?= isset($user->created_at) ? date('d/m/Y H:i', strtotime($user->created_at)) : 'Tidak tersedia' ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Terakhir Update:</strong></td>
                                                <td><?= isset($user->updated_at) ? date('d/m/Y H:i', strtotime($user->updated_at)) : 'Tidak tersedia' ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Actions -->
                        <div class="card border-0 shadow mt-4">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Aksi Akun</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-grid">
                                            <a href="<?= base_url('admin/dashboard/change_password') ?>" class="btn btn-warning">
                                                <i class="fas fa-key me-2"></i>
                                                Ganti Password
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-grid">
                                            <button class="btn btn-info" onclick="showEditProfile()">
                                                <i class="fas fa-edit me-2"></i>
                                                Edit Profil
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Account Security -->
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Keamanan Akun</h6>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-shield-alt me-2"></i>Tips Keamanan</h6>
                                    <ul class="mb-0">
                                        <li>Gunakan password yang kuat</li>
                                        <li>Jangan bagikan kredensial login</li>
                                        <li>Logout setelah selesai menggunakan sistem</li>
                                        <li>Periksa aktivitas login secara berkala</li>
                                    </ul>
                                </div>

                                <div class="alert alert-warning">
                                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Perhatian</h6>
                                    <p class="mb-0">Pastikan untuk selalu logout dari sistem setelah selesai menggunakan aplikasi untuk menjaga keamanan akun.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="card border-0 shadow mt-4">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Statistik Singkat</h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border rounded p-3">
                                            <i class="fas fa-clock fa-2x text-primary mb-2"></i>
                                            <h4 class="mb-0"><?= date('H:i') ?></h4>
                                            <small class="text-muted">Waktu Sekarang</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border rounded p-3">
                                            <i class="fas fa-calendar fa-2x text-success mb-2"></i>
                                            <h4 class="mb-0"><?= date('d/m') ?></h4>
                                            <small class="text-muted">Tanggal</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= base_url('admin/dashboard/update_profile') ?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" 
                                   value="<?= $user->nama ?? '' ?>" required>
                        </div>
                                                            <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="" disabled>
                                        <div class="form-text">Fitur email belum tersedia</div>
                                    </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?= $user->username ?>" readonly>
                            <div class="form-text">Username tidak dapat diubah</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showEditProfile() {
            const modal = new bootstrap.Modal(document.getElementById('editProfileModal'));
            modal.show();
        }
    </script>
</body>
</html> 