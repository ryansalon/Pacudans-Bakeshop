<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="section-padding py-5 mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="text-center mb-5">
                    <i class="bi bi-cup-hot-fill fs-1 text-primary"></i>
                    <h2 class="mt-3">Welcome Back</h2>
                    <p class="text-muted">Treat yourself to something sweet today.</p>
                </div>

                <div class="card p-5 border-0 shadow-lg rounded-5 bg-white">
                    <form action="<?= base_url('login') ?>" method="post">
                        <div class="mb-4">
                            <label for="email" class="form-label small fw-bold text-uppercase" style="letter-spacing: 1px;">Email address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-pill px-3"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-0 rounded-end-pill py-3" id="email" placeholder="name@example.com" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label small fw-bold text-uppercase" style="letter-spacing: 1px;">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-pill px-3"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-0 rounded-end-pill py-3" id="password" placeholder="••••••••" required>
                            </div>
                        </div>
                        
                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3">
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="text-center mt-4">
                    <p class="text-muted">Don't have an account? <a href="<?= base_url('register') ?>" class="text-primary fw-bold text-decoration-none">Create account</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
