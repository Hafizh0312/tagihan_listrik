<!-- Sidebar -->
<nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="text-center mb-4">
            <h4 class="text-white">Admin Panel</h4>
            <small class="text-muted">Sistem Pembayaran Listrik</small>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == 'dashboard' ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == 'pelanggan' ? 'active' : '' ?>" href="<?= base_url('admin/pelanggan') ?>">
                    <i class="fas fa-users me-2"></i>
                    Kelola Pelanggan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == 'penggunaan' ? 'active' : '' ?>" href="<?= base_url('admin/penggunaan') ?>">
                    <i class="fas fa-bolt me-2"></i>
                    Penggunaan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == 'tagihan' ? 'active' : '' ?>" href="<?= base_url('admin/tagihan') ?>">
                    <i class="fas fa-file-invoice-dollar me-2"></i>
                    Tagihan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == 'level' ? 'active' : '' ?>" href="<?= base_url('admin/level') ?>">
                    <i class="fas fa-user-shield me-2"></i>
                    Level
                </a>
            </li>

            <li class="nav-item mt-3">
                <a class="nav-link <?= $this->uri->segment(3) == 'profile' ? 'active' : '' ?>" href="<?= base_url('admin/dashboard/profile') ?>">
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