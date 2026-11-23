<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-4">
        <div>
            <h1 class="display-5 mb-1 fw-bold">Your Order Bag</h1>
            <p class="text-muted mb-0">Adjust quantities anytime—your totals stay automatically in sync.</p>
        </div>
        <a href="<?= base_url('menu') ?>" class="btn btn-outline-primary rounded-pill px-4 align-self-start align-self-sm-end">
            <i class="bi bi-arrow-left me-2"></i>Continue Shopping
        </a>
    </div>

    <?php if (empty($cart)): ?>
        <div class="text-center py-5 surface-panel">
            <i class="bi bi-bag-x display-4 text-muted"></i>
            <h2 class="h4 mt-3">Your bag is empty</h2>
            <p class="text-muted mb-4 mx-auto">Explore our espresso bar, cold drinks, and freshly baked Camiguin cakes.</p>
            <a href="<?= base_url('menu') ?>" class="btn btn-primary rounded-pill px-5">Browse Menu</a>
        </div>
    <?php else: ?>
        <div class="row g-4 align-items-start">
            <div class="col-lg-8">
                <form action="<?= base_url('cart/update') ?>" method="post" id="updateCartForm">
                    <?= csrf_field() ?>
                    <div class="surface-panel p-3 p-md-4">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr class="text-muted small text-uppercase">
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th style="width: 155px;">Quantity</th>
                                        <th>Subtotal</th>
                                        <th class="text-end">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; ?>
                                    <?php foreach ($cart as $key => $item): ?>
                                        <?php
                                            $subtotal = $item['price'] * $item['quantity'];
                                            $total += $subtotal;
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if ($item['image']): ?>
                                                        <img src="<?= base_url($item['image']) ?>" width="58" height="58" loading="lazy" decoding="async" class="me-3 rounded-3 object-fit-cover" alt="<?= esc($item['name']) ?>">
                                                    <?php else: ?>
                                                        <div class="bg-soft text-muted rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 58px; height: 58px;">
                                                            <i class="bi bi-image"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <a href="<?= base_url('menu/' . $item['id']) ?>" class="fw-bold text-dark text-decoration-none d-block"><?= esc($item['name']) ?></a>
                                                        <?php if (!empty($item['size'])): ?>
                                                            <span class="badge bg-soft text-primary border small rounded-pill px-2"><?= esc($item['size']) ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tabular-nums">₱<?= number_format($item['price'], 2) ?></td>
                                            <td>
                                                <div class="input-group input-group-sm" style="width: 132px;">
                                                    <button class="btn btn-outline-secondary rounded-start-pill qty-step" type="button" data-dir="-1" aria-label="Decrease quantity"><i class="bi bi-dash"></i></button>
                                                    <input type="number" name="quantity[<?= esc($key) ?>]" value="<?= (int) $item['quantity'] ?>" class="form-control text-center border-secondary cart-qty-input tabular-nums" min="0" aria-label="Quantity for <?= esc($item['name']) ?>">
                                                    <button class="btn btn-outline-secondary rounded-end-pill qty-step" type="button" data-dir="1" aria-label="Increase quantity"><i class="bi bi-plus"></i></button>
                                                </div>
                                            </td>
                                            <td class="fw-bold tabular-nums">₱<?= number_format($subtotal, 2) ?></td>
                                            <td class="text-end">
                                                <a href="<?= base_url('cart/remove/' . $key) ?>" class="btn btn-light btn-sm rounded-circle text-danger p-2 border remove-item" title="Remove Item" data-name="<?= esc($item['name']) ?>" aria-label="Remove <?= esc($item['name']) ?>">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <noscript>
                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-outline-primary rounded-pill px-4">Update Quantities</button>
                        </div>
                    </noscript>
                </form>
            </div>

            <div class="col-lg-4">
                <div class="surface-panel p-4 p-md-5 sticky-top" style="top: 96px;">
                    <h2 class="h5 fw-bold mb-4">Order Summary</h2>
                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Subtotal</span>
                        <span class="tabular-nums">₱<?= number_format($total, 2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Mambajao Delivery</span>
                        <span class="text-success fw-bold">FREE</span>
                    </div>
                    <hr class="my-4" style="border-color: var(--border-tile);">
                    <div class="d-flex justify-content-between align-items-baseline mb-4">
                        <span class="h6 mb-0 fw-bold">Grand Total</span>
                        <span class="h3 mb-0 text-primary fw-bold tabular-nums">₱<?= number_format($total, 2) ?></span>
                    </div>
                    <div class="d-grid">
                        <a href="<?= base_url('checkout') ?>" class="btn btn-amber btn-lg rounded-pill py-3">
                            Proceed to Checkout <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cartForm = document.getElementById('updateCartForm');
        let submitTimer = null;

        function scheduleCartUpdate() {
            if (!cartForm) return;
            clearTimeout(submitTimer);
            submitTimer = setTimeout(() => cartForm.submit(), 350);
        }

        document.querySelectorAll('.qty-step').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.cart-qty-input');
                const dir = parseInt(this.getAttribute('data-dir'), 10);
                input.value = Math.max(0, (parseInt(input.value, 10) || 1) + dir);
                scheduleCartUpdate();
            });
        });

        document.querySelectorAll('.cart-qty-input').forEach(input => {
            input.addEventListener('change', scheduleCartUpdate);
        });

        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                const name = this.getAttribute('data-name');

                Swal.fire({
                    title: 'Remove Item?',
                    text: `Remove ${name} from your order bag?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Remove',
                    cancelButtonText: 'Keep Item',
                    customClass: {
                        popup: 'premium-swal',
                        confirmButton: 'premium-confirm',
                        cancelButton: 'premium-cancel'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) window.location.href = url;
                });
            });
        });
    });
</script>

<?= $this->endSection() ?>
