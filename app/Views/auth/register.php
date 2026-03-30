<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="section-padding py-5 mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="text-center mb-5">
                    <i class="bi bi-person-plus-fill fs-1 text-primary"></i>
                    <h2 class="mt-3">Create Account</h2>
                    <p class="text-muted">Join Pacudan's family and start ordering.</p>
                </div>

                <div class="card p-5 border-0 shadow-lg rounded-5 bg-white">
                    <?php if (isset($validation)): ?>
                        <div class="alert alert-danger rounded-4 px-4 small border-0 shadow-sm mb-4">
                            <?= $validation->listErrors() ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('register') ?>" method="post">
                        <div class="mb-4">
                            <label for="name" class="form-label small fw-bold text-uppercase" style="letter-spacing: 1px;">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-pill px-3"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control bg-light border-0 rounded-end-pill py-3" id="name" placeholder="John Doe" value="<?= set_value('name') ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label small fw-bold text-uppercase" style="letter-spacing: 1px;">Email address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-pill px-3"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-0 rounded-end-pill py-3" id="email" placeholder="name@example.com" value="<?= set_value('email') ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label small fw-bold text-uppercase" style="letter-spacing: 1px;">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-pill px-3"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-0 rounded-end-pill py-3" id="password" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="confirmpassword" class="form-label small fw-bold text-uppercase" style="letter-spacing: 1px;">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-pill px-3"><i class="bi bi-shield-lock"></i></span>
                                <input type="password" name="confirmpassword" class="form-control bg-light border-0 rounded-end-pill py-3" id="confirmpassword" placeholder="••••••••" required>
                            </div>
                        </div>
                        
                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3 shadow-sm">
                                Create My Account
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="text-center mt-4">
                    <p class="text-muted">Already have an account? <a href="<?= base_url('login') ?>" class="text-primary fw-bold text-decoration-none">Sign in here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
