<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-5">
        <div>
            <h1 class="display-5 mb-1 fw-bold">Saved Favorites</h1>
            <p class="text-muted mb-0">Your regular Pacudan's coffees, cakes, and pastries ready for quick reorder.</p>
        </div>
        <a href="<?= base_url('menu') ?>" class="btn btn-outline-primary rounded-pill px-4 align-self-start align-self-sm-end">
            <i class="bi bi-arrow-left me-2"></i>Back to Menu
        </a>
    </div>

    <?php if (empty($favorites)): ?>
        <div class="text-center py-5 surface-panel">
            <i class="bi bi-heart display-4 text-muted"></i>
            <h2 class="h4 mt-3">No saved favorites yet</h2>
            <p class="text-muted mb-4 mx-auto">Tap "Favorite" on any drink or cake to keep your go-to items one tap away.</p>
            <a href="<?= base_url('menu') ?>" class="btn btn-primary rounded-pill px-5">Explore Menu</a>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($favorites as $product): ?>
                <div class="col">
                    <article class="card h-100 p-3 d-flex flex-column">
                        <div class="position-relative overflow-hidden rounded-3 mb-3">
                            <a href="<?= base_url('menu/' . $product['product_id']) ?>" class="d-block">
                                <?php if ($product['image_url']): ?>
                                    <img src="<?= base_url($product['image_url']) ?>" class="w-100 object-fit-cover rounded-3" alt="<?= esc($product['name']) ?>" style="height: 225px;">
                                <?php else: ?>
                                    <div class="bg-soft text-muted text-center py-5 d-flex flex-column justify-content-center" style="height: 225px;">
                                        <i class="bi bi-image fs-1"></i>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <a href="<?= base_url('favorites/remove/' . $product['product_id']) ?>" class="btn btn-light position-absolute top-0 end-0 m-2 shadow-sm rounded-circle p-2 text-danger" title="Remove from favorites" aria-label="Remove <?= esc($product['name']) ?> from favorites">
                                <i class="bi bi-heart-fill"></i>
                            </a>
                        </div>
                        <div class="d-flex flex-column flex-grow-1">
                            <div class="d-flex justify-content-between align-items-baseline gap-2 mb-1">
                                <h2 class="h5 fw-bold mb-0"><?= esc(rtrim((string) $product['name'], '*')) ?></h2>
                                <span class="fw-bold text-primary price-tag">₱<?= number_format($product['price'], 2) ?></span>
                            </div>
                            <p class="text-muted small mb-4 flex-grow-1">
                                <?= esc($product['description']) ?>
                                <span class="d-block fw-semibold text-amber mt-1"><?= esc($product['category_name']) ?></span>
                            </p>
                            <a href="<?= base_url('menu/' . $product['product_id']) ?>" class="btn btn-primary rounded-pill py-2 w-100">
                                View &amp; Order <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>

        <?php
            $cart = session()->get('cart') ?? [];
            if (!empty($cart)):
        ?>
            <div class="mt-5 pt-4 text-center border-top" style="border-color: var(--border-tile) !important;">
                <h3 class="h4 fw-bold mb-2">Ready to check out?</h3>
                <p class="text-muted mb-3 mx-auto">You have items waiting in your bag.</p>
                <a href="<?= base_url('checkout') ?>" class="btn btn-amber btn-lg rounded-pill px-5">
                    Proceed to Checkout <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
