<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="surface-panel overflow-hidden">
                <div class="bg-jade p-4 text-center" style="border-bottom: 4px solid var(--amber-cta);">
                    <i class="bi bi-cup-hot-fill fs-2" style="color: var(--amber-light);"></i>
                    <h1 class="h3 mt-2 mb-1 fw-bold text-white">Welcome Back</h1>
                    <p class="small mb-0 mx-auto" style="color: var(--jade-tint);">Sign in to order faster and track your deliveries.</p>
                </div>
                <div class="p-4 p-md-5">
                <form action="<?= base_url('login') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-4">
                        <label for="email" class="form-label small fw-bold text-uppercase">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-soft border-0 rounded-start-pill px-3"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control bg-soft border-0 rounded-end-pill py-3" id="email" placeholder="name@example.com" autocomplete="email" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label small fw-bold text-uppercase">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-soft border-0 rounded-start-pill px-3"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control bg-soft border-0 rounded-end-pill py-3" id="password" placeholder="Enter your password" autocomplete="current-password" required>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-amber btn-lg rounded-pill py-3">
                            Sign In
                        </button>
                    </div>
                </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted mx-auto mb-0">New to Pacudan's? <a href="<?= base_url('register') ?>" class="text-primary fw-bold text-decoration-none">Create an account</a></p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
