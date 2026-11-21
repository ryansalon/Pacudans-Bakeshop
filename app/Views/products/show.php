<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<?php $inStock = (int) ($product['stock_quantity'] ?? 0) > 0; ?>

<div class="container py-4">
    <div class="mb-4">
        <a href="<?= base_url('menu') ?>" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Back to Menu
        </a>
    </div>

    <div class="row g-5 align-items-start">
        <div class="col-lg-6">
            <div class="surface-panel p-3 overflow-hidden">
                <?php if ($product['image_url']): ?>
                    <img src="<?= base_url($product['image_url']) ?>" class="img-fluid rounded-3 w-100 object-fit-cover" alt="<?= esc($product['name']) ?>" style="max-height: 480px; aspect-ratio: 1/1;">
                <?php else: ?>
                    <div class="bg-soft text-muted text-center py-5 rounded-3 d-flex flex-column justify-content-center" style="min-height: 400px;">
                        <i class="bi bi-image fs-1"></i>
                        <p class="mt-3 mb-0 mx-auto">No Image Available</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-6 ps-lg-3">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                <?php if (!empty($product['category_name'])): ?>
                    <span class="badge bg-soft text-primary border rounded-pill px-3 py-2"><?= esc($product['category_name']) ?></span>
                <?php endif; ?>
                <span class="badge <?= $inStock ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?> rounded-pill px-3 py-2 tabular-nums">
                    <?= $inStock ? esc($product['stock_quantity']) . ' available' : 'Out of Stock' ?>
                </span>
            </div>

            <h1 class="display-5 mb-2 fw-bold"><?= esc($product['name']) ?></h1>

            <p class="display-6 text-primary mb-3 fw-bold price-tag" id="main-price">
                ₱<?= number_format(!empty($variants) ? $variants[0]['price'] : $product['price'], 2) ?>
            </p>

            <p class="lead text-muted mb-4"><?= esc($product['description'] ?: 'Freshly prepared to order at Pacudan\'s Bakeshop & Coffee Bar.') ?></p>

            <div class="surface-panel p-4 mb-4">
                <form id="addToCartForm" action="<?= base_url('cart/add') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                    <input type="hidden" name="buy_now" id="buy_now_flag" value="0">

                    <?php if (!empty($variants)): ?>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase">Select Size</label>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($variants as $index => $v): ?>
                                    <input type="radio" class="btn-check" name="variant_id" id="v-<?= $v['variant_id'] ?>"
                                           value="<?= $v['variant_id'] ?>"
                                           data-price="<?= $v['price'] ?>"
                                           <?= $index === 0 ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-primary rounded-pill px-4" for="v-<?= $v['variant_id'] ?>">
                                        <?= esc($v['size_name']) ?> · ₱<?= number_format($v['price'], 0) ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row align-items-center mb-4">
                        <div class="col-auto">
                            <label for="product-qty" class="form-label mb-0 fw-bold">Quantity</label>
                        </div>
                        <div class="col-auto">
                            <div class="input-group" style="width: 148px;">
                                <button class="btn btn-outline-secondary rounded-start-pill" type="button" onclick="this.nextElementSibling.stepDown()" aria-label="Decrease quantity"><i class="bi bi-dash"></i></button>
                                <input type="number" name="quantity" id="product-qty" class="form-control text-center border-secondary tabular-nums" value="1" min="1" max="<?= max(1, (int) $product['stock_quantity']) ?>">
                                <button class="btn btn-outline-secondary rounded-end-pill" type="button" onclick="this.previousElementSibling.stepUp()" aria-label="Increase quantity"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-amber btn-lg rounded-pill py-3" id="orderBtn" onclick="document.getElementById('buy_now_flag').value='1'" <?= $inStock ? '' : 'disabled' ?>>
                            <i class="bi bi-bag-check me-2"></i><?= $inStock ? 'Order Now (Direct Checkout)' : 'Currently Out of Stock' ?>
                        </button>

                        <div class="row g-2">
                            <div class="col-sm-7">
                                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2" id="addBtn" onclick="document.getElementById('buy_now_flag').value='0'" <?= $inStock ? '' : 'disabled' ?>>
                                    <i class="bi bi-bag-plus me-2"></i>Add to Bag
                                </button>
                            </div>
                            <div class="col-sm-5">
                                <button type="button" class="btn btn-outline-primary w-100 rounded-pill py-2" id="favBtn" onclick="toggleFavorite(<?= $product['product_id'] ?>)" aria-label="Save to Favorites">
                                    <i class="bi bi-heart me-1"></i><span>Favorite</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex flex-wrap gap-4 text-muted small pt-2 border-top" style="border-color: var(--border-tile) !important;">
                <span><i class="bi bi-check-circle-fill text-primary me-2"></i>Prepared fresh to order</span>
                <span><i class="bi bi-truck text-primary me-2"></i>Free Mambajao delivery</span>
                <span><i class="bi bi-cash-stack text-primary me-2"></i>Cash on Delivery</span>
            </div>
        </div>
    </div>
</div>

<script>
const variantRadios = document.querySelectorAll('input[name="variant_id"]');
const mainPrice = document.getElementById('main-price');

variantRadios.forEach(radio => {
    radio.addEventListener('change', function() {
        const price = parseFloat(this.getAttribute('data-price')).toFixed(2);
        mainPrice.textContent = '₱' + price;
    });
});

document.getElementById('addToCartForm').addEventListener('submit', function(e) {
    if (document.getElementById('buy_now_flag').value === '1') {
        return;
    }

    e.preventDefault();

    const form = this;
    const submitBtn = document.getElementById('addBtn');
    const originalText = submitBtn.innerHTML;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Adding...';

    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateBagCounters(data.cart_count);
            Toast.fire({ icon: 'success', title: data.message || 'Added to Bag!' });
            submitBtn.innerHTML = '<i class="bi bi-check2 me-2"></i>Added!';
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }, 1500);
        } else {
            Toast.fire({ icon: 'error', title: data.message || 'Unable to add item.' });
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    })
    .catch(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

function syncFavoriteButton(isFav, favCount) {
    const favBtn = document.getElementById('favBtn');
    if (favBtn) {
        if (isFav) {
            favBtn.innerHTML = '<i class="bi bi-heart-fill me-1"></i><span>Saved</span>';
            favBtn.classList.add('active');
        } else {
            favBtn.innerHTML = '<i class="bi bi-heart me-1"></i><span>Favorite</span>';
            favBtn.classList.remove('active');
        }
    }
    const favCounter = document.getElementById('fav-counter');
    if (favCounter && favCount !== undefined) {
        favCounter.textContent = favCount;
        favCounter.classList.toggle('d-none', Number(favCount) <= 0);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    <?php if (session()->get('isLoggedIn')): ?>
    fetch('<?= base_url('favorites/check/' . $product['product_id']) ?>')
        .then(response => response.json())
        .then(data => syncFavoriteButton(Boolean(data.isFavorite), data.fav_count));
    <?php endif; ?>
});

function toggleFavorite(productId) {
    fetch('<?= base_url('favorites/toggle/') ?>' + productId, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Toast.fire({ icon: 'success', title: data.message });
            syncFavoriteButton(data.action === 'added', data.fav_count);
        } else if (data.redirect) {
            Swal.fire({
                title: 'Sign In Required',
                text: 'Please sign in to save your favorite treats.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sign In Now',
                cancelButtonText: 'Not Now',
                customClass: {
                    popup: 'premium-swal',
                    confirmButton: 'premium-confirm',
                    cancelButton: 'premium-cancel'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) window.location.href = data.redirect;
            });
        }
    });
}
</script>

<?= $this->endSection() ?>
