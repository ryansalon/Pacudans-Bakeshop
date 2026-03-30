<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="section-padding">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5 reveal">
            <div>
                <h6 class="text-primary fw-bold text-uppercase mb-2 tracking-widest" style="letter-spacing: 2px;">Final Step</h6>
                <h2 class="display-5 mb-0 fw-bold">Checkout</h2>
            </div>
            <a href="<?= $isDirect ? base_url('menu') : base_url('cart') ?>" class="btn btn-outline-primary rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-arrow-left me-2"></i>Back to <?= $isDirect ? 'Menu' : 'Cart' ?>
            </a>
        </div>

        <div class="row g-5">
            <!-- Delivery Details Form -->
            <div class="col-lg-7 reveal" style="transition-delay: 0.2s;">
                <div class="card p-5 border-0 shadow-sm bg-white rounded-5">
                    <h4 class="fw-bold mb-4"><i class="bi bi-truck me-2 text-primary"></i>Delivery Details</h4>
                    <hr class="opacity-10 mb-5">

                    <form action="<?= base_url('checkout/process') ?>" method="post" id="checkout-form">
                        <input type="hidden" name="is_direct" value="<?= $isDirect ? '1' : '0' ?>">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 1px;">Recipient Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-pill px-3"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control bg-light border-0 rounded-end-pill py-3" value="<?= session()->get('name') ?>" readonly>
                            </div>
                            <div class="form-text small opacity-50 ms-2">Registered account name</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 1px;">Contact Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-pill px-3"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="phone" class="form-control bg-light border-0 rounded-end-pill py-3" required placeholder="e.g. 09123456789" value="<?= esc($user['phone'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 1px;">Delivery Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-4 px-3 align-items-start pt-3"><i class="bi bi-geo-alt"></i></span>
                                <textarea class="form-control bg-light border-0 rounded-end-4 py-3" name="address" rows="3" required placeholder="Unit/House Number, Street, Barangay, City..."><?= esc($user['address'] ?? '') ?></textarea>
                            </div>
                        </div>
                        
                        <h4 class="fw-bold mb-4 mt-5"><i class="bi bi-credit-card me-2 text-primary"></i>Payment Method</h4>
                        <hr class="opacity-10 mb-4">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check p-0">
                                    <input class="btn-check" type="radio" name="payment_method" id="cod" value="cod" checked>
                                    <label class="btn btn-outline-primary w-100 py-3 rounded-4 border-2 d-flex align-items-center justify-content-center gap-2" for="cod">
                                        <i class="bi bi-cash-stack fs-4"></i> Cash on Delivery
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check p-0">
                                    <input class="btn-check" type="radio" name="payment_method" id="gcash" value="gcash" disabled>
                                    <label class="btn btn-outline-secondary w-100 py-3 rounded-4 border-2 d-flex align-items-center justify-content-center gap-2" for="gcash">
                                        <i class="bi bi-wallet2 fs-4"></i> GCash <small class="opacity-50">(Soon)</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 d-none d-lg-block">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill w-100 py-3 shadow-lg">
                                Place Order Now <i class="bi bi-chevron-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Order Summary Sidebar -->
            <div class="col-lg-5 reveal" style="transition-delay: 0.4s;">
                <div class="card p-5 border-0 shadow-lg rounded-5 bg-white sticky-top" style="top: 100px;">
                    <h4 class="fw-bold mb-4">Order Summary</h4>
                    <hr class="opacity-10 mb-4">
                    
                    <div class="mb-4 overflow-auto" style="max-height: 300px;">
                        <?php $total = 0; ?>
                        <?php foreach ($cart as $item): ?>
                            <?php 
                                $subtotal = $item['price'] * $item['quantity']; 
                                $total += $subtotal;
                            ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <span class="fw-bold text-primary small"><?= $item['quantity'] ?>x</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold"><?= esc($item['name']) ?></h6>
                                        <small class="text-muted">₱<?= number_format($item['price'], 2) ?> each</small>
                                    </div>
                                </div>
                                <span class="fw-bold">₱<?= number_format($subtotal, 2) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="bg-soft p-4 rounded-4 mb-5" style="background-color: var(--bg-soft);">
                        <div class="d-flex justify-content-between mb-3 text-muted small">
                            <span>Subtotal</span>
                            <span>₱<?= number_format($total, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 text-muted small">
                            <span>Delivery Fee</span>
                            <span class="text-success fw-bold">FREE</span>
                        </div>
                        <hr class="opacity-10">
                        <div class="d-flex justify-content-between align-items-end mt-4">
                            <h5 class="mb-0 fw-bold">Total Amount</h5>
                            <h3 class="mb-0 text-primary fw-bold">₱<?= number_format($total, 2) ?></h3>
                        </div>
                    </div>

                    <div class="d-lg-none">
                        <button type="submit" form="checkout-form" class="btn btn-primary btn-lg rounded-pill w-100 py-3 shadow-lg">
                            Place Order Now <i class="bi bi-chevron-right ms-2"></i>
                        </button>
                    </div>

                    <div class="text-center mt-4 p-3 bg-light rounded-4">
                        <p class="small text-muted mb-0"><i class="bi bi-shield-lock-fill me-2 text-success"></i>Secure checkout. Your information is protected.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
