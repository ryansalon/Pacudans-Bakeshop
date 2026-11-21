<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="surface-panel overflow-hidden">
                <div class="bg-jade p-4 text-center" style="border-bottom: 4px solid var(--amber-cta);">
                    <i class="bi bi-person-plus-fill fs-2" style="color: var(--amber-light);"></i>
                    <h1 class="h3 mt-2 mb-1 fw-bold text-white">Create Your Account</h1>
                    <p class="small mb-0 mx-auto" style="color: var(--jade-tint);">Join Pacudan's to save favorites and order in seconds.</p>
                </div>
                <div class="p-4 p-md-5">
                <?php if (isset($validation)): ?>
                    <div class="alert alert-danger rounded-4 px-4 small border-0 mb-4">
                        <?= $validation->listErrors() ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('register') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="name" class="form-label small fw-bold text-uppercase">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-soft border-0 rounded-start-pill px-3"><i class="bi bi-person"></i></span>
                            <input type="text" name="name" class="form-control bg-soft border-0 rounded-end-pill py-3" id="name" placeholder="Maria Santos" value="<?= esc(set_value('name')) ?>" autocomplete="name" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label small fw-bold text-uppercase">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-soft border-0 rounded-start-pill px-3"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control bg-soft border-0 rounded-end-pill py-3" id="email" placeholder="name@example.com" value="<?= esc(set_value('email')) ?>" autocomplete="email" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label small fw-bold text-uppercase">Password (min. 8 characters)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-soft border-0 rounded-start-pill px-3"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control bg-soft border-0 rounded-end-pill py-3" id="password" placeholder="At least 8 characters" autocomplete="new-password" minlength="8" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="confirmpassword" class="form-label small fw-bold text-uppercase">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-soft border-0 rounded-start-pill px-3"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" name="confirmpassword" class="form-control bg-soft border-0 rounded-end-pill py-3" id="confirmpassword" placeholder="Re-enter password" autocomplete="new-password" minlength="8" required>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-amber btn-lg rounded-pill py-3">
                            Create Account
                        </button>
                    </div>
                </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted mx-auto mb-0">Already have an account? <a href="<?= base_url('login') ?>" class="text-primary fw-bold text-decoration-none">Sign in</a></p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
