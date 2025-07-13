<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url() ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-bolt"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PLN</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <?php if ($this->session->userdata('level') == 'admin'): ?>
    <!-- Admin Navigation -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Master Data
    </div>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/level') ?>">
            <i class="fas fa-fw fa-layer-group"></i>
            <span>Level</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/pelanggan') ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Pelanggan</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Transaksi
    </div>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/penggunaan') ?>">
            <i class="fas fa-fw fa-bolt"></i>
            <span>Penggunaan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/tagihan') ?>">
            <i class="fas fa-fw fa-file-invoice-dollar"></i>
            <span>Tagihan</span>
        </a>
    </li>

    <?php else: ?>
    <!-- Pelanggan Navigation -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('pelanggan/dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu Pelanggan
    </div>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('pelanggan/penggunaan') ?>">
            <i class="fas fa-fw fa-bolt"></i>
            <span>Penggunaan Listrik</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('pelanggan/tagihan') ?>">
            <i class="fas fa-fw fa-file-invoice-dollar"></i>
            <span>Tagihan Listrik</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('pelanggan/profil') ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>Profil Saya</span>
        </a>
    </li>

    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Akun
    </div>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('auth/logout') ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar --> 