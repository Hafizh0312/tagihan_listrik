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
            background: #2c3e50;
        }
        .sidebar .nav-link {
            color: #ecf0f1;
        }
        .sidebar .nav-link:hover {
            background: #34495e;
            color: #fff;
        }
        .sidebar .nav-link.active {
            background: #3498db;
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
        .password-strength {
            height: 5px;
            border-radius: 3px;
            margin-top: 5px;
        }
        .strength-weak { background-color: #dc3545; }
        .strength-medium { background-color: #ffc107; }
        .strength-strong { background-color: #28a745; }
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
                    <h1 class="h2">Ganti Password</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="<?= base_url('admin/dashboard/profile') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Profil
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

                <!-- Change Password Form -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Form Ganti Password</h6>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('admin/dashboard/change_password') ?>" method="POST" id="changePasswordForm">
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control <?= form_error('current_password') ? 'is-invalid' : '' ?>" 
                                                   id="current_password" name="current_password" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                                <i class="fas fa-eye" id="current_password_icon"></i>
                                            </button>
                                        </div>
                                        <?php if (form_error('current_password')): ?>
                                            <div class="invalid-feedback">
                                                <?= form_error('current_password') ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="form-text">Masukkan password yang sedang digunakan</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control <?= form_error('new_password') ? 'is-invalid' : '' ?>" 
                                                   id="new_password" name="new_password" required minlength="6">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                                <i class="fas fa-eye" id="new_password_icon"></i>
                                            </button>
                                        </div>
                                        <?php if (form_error('new_password')): ?>
                                            <div class="invalid-feedback">
                                                <?= form_error('new_password') ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="form-text">Minimal 6 karakter</div>
                                        <div class="password-strength" id="passwordStrength"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control <?= form_error('confirm_password') ? 'is-invalid' : '' ?>" 
                                                   id="confirm_password" name="confirm_password" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                                <i class="fas fa-eye" id="confirm_password_icon"></i>
                                            </button>
                                        </div>
                                        <?php if (form_error('confirm_password')): ?>
                                            <div class="invalid-feedback">
                                                <?= form_error('confirm_password') ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="form-text">Masukkan ulang password baru</div>
                                        <div id="passwordMatch" class="mt-2"></div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="<?= base_url('admin/dashboard/profile') ?>" class="btn btn-secondary">
                                            <i class="fas fa-times me-1"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="submitBtn">
                                            <i class="fas fa-save me-1"></i> Ganti Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Tips Password</h6>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-lightbulb me-2"></i>Password yang Kuat</h6>
                                    <ul class="mb-0">
                                        <li>Minimal 8 karakter</li>
                                        <li>Kombinasi huruf besar dan kecil</li>
                                        <li>Angka dan simbol</li>
                                        <li>Hindari informasi pribadi</li>
                                        <li>Jangan gunakan password yang sama</li>
                                    </ul>
                                </div>

                                <div class="alert alert-warning">
                                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Keamanan</h6>
                                    <ul class="mb-0">
                                        <li>Jangan bagikan password</li>
                                        <li>Logout setelah selesai</li>
                                        <li>Ganti password secara berkala</li>
                                        <li>Waspada terhadap phishing</li>
                                    </ul>
                                </div>

                                <div class="alert alert-success">
                                    <h6><i class="fas fa-check-circle me-2"></i>Setelah Ganti Password</h6>
                                    <p class="mb-0">Anda akan tetap login dengan password baru. Pastikan untuk mengingat password baru Anda.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '_icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password strength checker
        document.getElementById('new_password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrength');
            
            let strength = 0;
            let strengthClass = '';
            let strengthText = '';
            
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            if (strength < 2) {
                strengthClass = 'strength-weak';
                strengthText = 'Lemah';
            } else if (strength < 4) {
                strengthClass = 'strength-medium';
                strengthText = 'Sedang';
            } else {
                strengthClass = 'strength-strong';
                strengthText = 'Kuat';
            }
            
            strengthBar.className = 'password-strength ' + strengthClass;
            strengthBar.style.width = (strength * 20) + '%';
            strengthBar.title = strengthText;
        });

        // Password confirmation checker
        document.getElementById('confirm_password').addEventListener('input', function() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = this.value;
            const matchDiv = document.getElementById('passwordMatch');
            
            if (confirmPassword === '') {
                matchDiv.innerHTML = '';
            } else if (newPassword === confirmPassword) {
                matchDiv.innerHTML = '<span class="text-success"><i class="fas fa-check-circle me-1"></i>Password cocok</span>';
            } else {
                matchDiv.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle me-1"></i>Password tidak cocok</span>';
            }
        });

        // Form validation
        document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Password baru dan konfirmasi password tidak cocok!');
                return false;
            }
            
            if (newPassword.length < 6) {
                e.preventDefault();
                alert('Password baru minimal 6 karakter!');
                return false;
            }
        });
    </script>
</body>
</html> 