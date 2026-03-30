<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="section-padding">
    <div class="container">
        <div class="mb-5">
            <a href="<?= base_url('menu') ?>" class="btn btn-outline-primary rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-arrow-left me-2"></i> Back to Menu
            </a>
        </div>
        <h2 class="display-6 mb-5"><i class="bi bi-cart3 me-3 text-primary"></i>Your Shopping Cart</h2>

        <?php if (empty($cart)): ?>
            <div class="text-center py-5 bg-white rounded-5 shadow-sm">
                <i class="bi bi-cart-x display-1 opacity-25"></i>
                <h3 class="mt-4">Your cart is feeling light...</h3>
                <p class="text-muted mb-4">You haven't added any treats to your cart yet.</p>
                <a href="<?= base_url('menu') ?>" class="btn btn-primary btn-lg rounded-pill px-5">Go to Menu</a>
            </div>
        <?php else: ?>
            <div class="row g-5">
                <div class="col-lg-8">
                    <form action="<?= base_url('cart/update') ?>" method="post" id="updateCartForm">
                        <div class="card p-4 border-0 shadow-sm rounded-4">
                            <div class="table-responsive" style="overflow: visible;">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr class="text-muted small text-uppercase">
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                            <th class="text-end">Action</th>
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
                                                            <img src="<?= base_url($item['image']) ?>" width="60" height="60" class="me-3 rounded-4" style="object-fit: cover;">
                                                        <?php else: ?>
                                                            <div class="bg-light text-muted text-center rounded-4 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                                <i class="bi bi-image fs-5 opacity-25"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div>
                                                            <span class="fw-semibold text-dark d-block"><?= esc($item['name']) ?></span>
                                                            <?php if (!empty($item['size'])): ?>
                                                                <span class="badge bg-soft text-primary border small rounded-pill px-2"><?= esc($item['size']) ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>₱<?= number_format($item['price'], 2) ?></td>
                                                <td style="width: 120px;">
                                                    <input type="number" name="quantity[<?= $key ?>]" value="<?= $item['quantity'] ?>" class="form-control rounded-pill text-center border-light bg-light" min="1">
                                                </td>
                                                <td class="fw-bold">₱<?= number_format($subtotal, 2) ?></td>
                                                <td class="text-end">
                                                    <a href="<?= base_url('cart/remove/' . $key) ?>" class="btn btn-light btn-sm rounded-circle text-danger p-2 shadow-sm border remove-item" title="Remove Item" data-name="<?= esc($item['name']) ?>">
                                                        <i class="bi bi-x-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-between align-items-center">
                            <a href="<?= base_url('menu') ?>" class="btn btn-outline-primary rounded-pill px-4 shadow-sm fw-bold">
                                <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                            </a>
                            <button type="submit" class="btn btn-outline-primary rounded-pill px-4 shadow-sm fw-bold">
                                <i class="bi bi-arrow-repeat me-2"></i>Update Quantities
                            </button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4">
                    <div class="card p-5 border-0 shadow-lg rounded-5 bg-white sticky-top" style="top: 100px;">
                        <h5 class="fw-bold mb-4">Order Summary</h5>
                        <div class="d-flex justify-content-between mb-3 text-muted">
                            <span>Subtotal</span>
                            <span>₱<?= number_format($total, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 text-muted">
                            <span>Delivery</span>
                            <span class="text-success fw-bold">FREE</span>
                        </div>
                        <hr class="opacity-10 my-4">
                        <div class="d-flex justify-content-between align-items-end mb-5">
                            <span class="h5 mb-0 fw-bold">Grand Total</span>
                            <span class="h3 mb-0 text-primary fw-bold">₱<?= number_format($total, 2) ?></span>
                        </div>
                        <div class="d-grid">
                            <a href="<?= base_url('checkout') ?>" class="btn btn-primary btn-lg rounded-pill py-3 shadow-lg">
                                Checkout Now <i class="bi bi-chevron-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const removeButtons = document.querySelectorAll('.remove-item');
        removeButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                const name = this.getAttribute('data-name');

                Swal.fire({
                    title: 'Remove Item?',
                    text: `Are you sure you want to remove ${name} from your cart?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it!',
                    cancelButtonText: 'No, keep it',
                    customClass: {
                        popup: 'premium-swal',
                        confirmButton: 'premium-confirm',
                        cancelButton: 'premium-cancel'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    });
</script>

<?= $this->endSection() ?>
