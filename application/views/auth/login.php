<?php $this->load->view('admin/template/header'); ?>

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-xl-5 col-lg-6 col-md-8">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="p-5">
                        <div class="text-center mb-4">
                            <h1 class="h4 text-gray-900 mb-2">Login Admin / Petugas</h1>
                            <p class="mb-4">Sistem Pembayaran Listrik</p>
                        </div>
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $this->session->flashdata('error') ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <form class="user" action="<?= base_url('auth/login') ?>" method="POST">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user <?= form_error('username') ? 'is-invalid' : '' ?>" id="username" name="username" placeholder="Username" value="<?= set_value('username') ?>" required autofocus>
                                <?php if (form_error('username')): ?>
                                    <div class="invalid-feedback">
                                        <?= form_error('username') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user <?= form_error('password') ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Password" required>
                                <?php if (form_error('password')): ?>
                                    <div class="invalid-feedback">
                                        <?= form_error('password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                <i class="fas fa-sign-in-alt mr-1"></i> Login
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <small class="text-muted">&copy; <?= date('Y') ?> Sistem Pembayaran Listrik</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/template/footer'); ?> 