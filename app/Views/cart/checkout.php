<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-5">
        <div>
            <h1 class="display-5 mb-1 fw-bold">Checkout</h1>
            <p class="text-muted mb-0">Confirm your Mambajao delivery address and place your Cash on Delivery order.</p>
        </div>
        <a href="<?= $isDirect ? base_url('menu') : base_url('cart') ?>" class="btn btn-outline-primary rounded-pill px-4 align-self-start align-self-sm-end">
            <i class="bi bi-arrow-left me-2"></i>Back to <?= $isDirect ? 'Menu' : 'Bag' ?>
        </a>
    </div>

    <div class="row g-5 align-items-start">
        <div class="col-lg-7">
            <div class="surface-panel p-4 p-md-5">
                <h2 class="h4 fw-bold mb-4"><i class="bi bi-truck me-2 text-primary"></i>Delivery Information</h2>

                <form action="<?= base_url('checkout/process') ?>" method="post" id="checkout-form">
                    <?= csrf_field() ?>
                    <input type="hidden" name="is_direct" value="<?= $isDirect ? '1' : '0' ?>">

                    <div class="mb-4">
                        <label for="recipient-name" class="form-label small fw-bold text-uppercase">Recipient Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-soft border-0 rounded-start-pill px-3"><i class="bi bi-person"></i></span>
                            <input type="text" id="recipient-name" class="form-control bg-soft border-0 rounded-end-pill py-3" value="<?= esc(session()->get('name')) ?>" readonly>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="checkout-phone" class="form-label small fw-bold text-uppercase">Contact Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-soft border-0 rounded-start-pill px-3"><i class="bi bi-telephone"></i></span>
                            <input type="tel" id="checkout-phone" name="phone" class="form-control bg-soft border-0 rounded-end-pill py-3 tabular-nums" required placeholder="e.g. 0963 921 6585" value="<?= esc($user['phone'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="checkout-address" class="form-label small fw-bold text-uppercase">Delivery Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-soft border-0 rounded-start-4 px-3 align-items-start pt-3"><i class="bi bi-geo-alt"></i></span>
                            <textarea id="checkout-address" class="form-control bg-soft border-0 rounded-end-4 py-3" name="address" rows="3" required placeholder="House/Building, Street, Barangay, Mambajao, Camiguin..."><?= esc($user['address'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <h2 class="h4 fw-bold mb-3"><i class="bi bi-wallet2 me-2 text-primary"></i>Payment Method</h2>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <input class="btn-check" type="radio" name="payment_method" id="cod" value="cod" checked>
                            <label class="btn btn-outline-primary w-100 py-3 rounded-4 d-flex align-items-center justify-content-center gap-2" for="cod">
                                <i class="bi bi-cash-stack fs-5"></i>Cash on Delivery
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input class="btn-check" type="radio" name="payment_method" id="gcash" value="gcash" disabled>
                            <label class="btn btn-outline-secondary w-100 py-3 rounded-4 d-flex align-items-center justify-content-center gap-2" for="gcash">
                                <i class="bi bi-phone fs-5"></i>GCash (Coming Soon)
                            </label>
                        </div>
                    </div>

                    <div class="mt-4 d-none d-lg-block">
                        <button type="submit" class="btn btn-amber btn-lg rounded-pill w-100 py-3">
                            Place Order Now <i class="bi bi-check2-circle ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="surface-panel p-4 p-md-5 sticky-top" style="top: 96px;">
                <h2 class="h4 fw-bold mb-4">Order Summary</h2>

                <div class="mb-4 overflow-auto pe-1" style="max-height: 300px;">
                    <?php $total = 0; ?>
                    <?php foreach ($cart as $item): ?>
                        <?php
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom" style="border-color: var(--border-tile) !important;">
                            <div class="d-flex align-items-center">
                                <div class="bg-soft rounded-3 me-3 d-flex align-items-center justify-content-center tabular-nums" style="width: 44px; height: 44px;">
                                    <span class="fw-bold text-primary small"><?= (int) $item['quantity'] ?>x</span>
                                </div>
                                <div>
                                    <h3 class="h6 mb-0 fw-bold">
                                        <?= esc($item['name']) ?>
                                        <?php if (!empty($item['size'])): ?>
                                            <span class="badge bg-soft text-primary border small rounded-pill ms-1"><?= esc($item['size']) ?></span>
                                        <?php endif; ?>
                                    </h3>
                                    <small class="text-muted tabular-nums">₱<?= number_format($item['price'], 2) ?> each</small>
                                </div>
                            </div>
                            <span class="fw-bold tabular-nums">₱<?= number_format($subtotal, 2) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="surface-subtle p-4 mb-4">
                    <div class="d-flex justify-content-between mb-2 text-muted small">
                        <span>Subtotal</span>
                        <span class="tabular-nums">₱<?= number_format($total, 2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-muted small">
                        <span>Delivery Fee</span>
                        <span class="text-success fw-bold">FREE</span>
                    </div>
                    <hr style="border-color: var(--border-tile);">
                    <div class="d-flex justify-content-between align-items-baseline mt-3">
                        <span class="h6 mb-0 fw-bold">Total Due</span>
                        <span class="h3 mb-0 text-primary fw-bold tabular-nums">₱<?= number_format($total, 2) ?></span>
                    </div>
                </div>

                <div class="d-lg-none mb-3">
                    <button type="submit" form="checkout-form" class="btn btn-amber btn-lg rounded-pill w-100 py-3">
                        Place Order Now <i class="bi bi-check2-circle ms-2"></i>
                    </button>
                </div>

                <p class="small text-muted text-center mb-0">
                    <i class="bi bi-shield-check me-1 text-success"></i>Pay in cash upon delivery at your doorstep.
                </p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
