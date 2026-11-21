<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div id="menu-grid" class="container pt-4 pb-2">
    <!-- Menu Header & Live Search -->
    <div class="row align-items-end g-3 mb-2">
        <div class="col-lg-7">
            <h1 class="display-5 mb-2 fw-bold"><?= esc($title) ?></h1>
            <p class="text-muted mb-0">
                <?= isset($category) && !empty($category['description']) ? esc($category['description']) : 'Handcrafted espresso, blended drinks, and freshly baked Camiguin pastries.' ?>
            </p>
        </div>
        <div class="col-lg-5">
            <div class="input-group surface-panel p-1 rounded-pill">
                <span class="input-group-text bg-transparent border-0 ps-3 text-muted"><i class="bi bi-search"></i></span>
                <input type="search" id="menuSearchInput" class="form-control border-0 bg-transparent shadow-none" placeholder="Search coffee, cakes, pastries..." aria-label="Search menu items">
                <span class="badge bg-soft text-dark rounded-pill px-3 py-2 align-self-center me-2 tabular-nums" id="menuItemCount">
                    <?= count($products) ?> items
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Sticky Horizontal Category Bar (stays visible while scrolling products) -->
<div class="sticky-category-bar mb-4" id="stickyCategoryBar">
    <div class="container">
        <div class="cat-strip-wrap">
            <nav class="d-flex align-items-center gap-2 overflow-auto py-3 pe-4" aria-label="Menu categories">
                <a href="<?= base_url('menu') ?>" class="btn <?= !isset($category) ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill px-4 py-2 flex-shrink-0">
                    All Delights
                </a>
                <?php foreach ($categories as $cat): ?>
                    <?php $isActiveCat = isset($category) && (int) $category['category_id'] === (int) $cat['category_id']; ?>
                    <a href="<?= base_url('category/' . $cat['category_id']) ?>"
                       class="btn <?= $isActiveCat ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill px-4 py-2 flex-shrink-0">
                        <?= esc($cat['name']) ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>
    </div>
</div>

<div class="container pb-4">
    <!-- Product Grid -->
    <?php if (empty($products)): ?>
        <div class="text-center py-5 surface-panel">
            <i class="bi bi-cup-hot fs-1 text-muted"></i>
            <h2 class="h4 mt-3">No items in this category yet</h2>
            <p class="text-muted mx-auto mb-4">We are preparing fresh batches. Browse all available items below.</p>
            <a href="<?= base_url('menu') ?>" class="btn btn-primary rounded-pill px-4">View Full Menu</a>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="productGridContainer">
            <?php foreach ($products as $product): ?>
                <?php
                    $hasVariants = !empty($product['variant_count']) && (int) $product['variant_count'] > 0;
                    $displayPrice = ($hasVariants && $product['min_price'] !== null)
                        ? (float) $product['min_price']
                        : (float) $product['price'];
                    $inStock = (int) $product['stock_quantity'] > 0;
                ?>
                <div class="col menu-item-col" data-name="<?= esc(strtolower($product['name'] . ' ' . ($product['category_name'] ?? '') . ' ' . ($product['description'] ?? ''))) ?>">
                    <article class="card h-100 p-3 d-flex flex-column product-card">
                        <a href="<?= base_url('menu/' . $product['product_id']) ?>" class="position-relative d-block overflow-hidden rounded-3 mb-3 text-decoration-none">
                            <?php if ($product['image_url']): ?>
                                <img src="<?= base_url($product['image_url']) ?>" class="w-100 object-fit-cover product-img" alt="<?= esc($product['name']) ?>" style="aspect-ratio: 1/1;">
                            <?php else: ?>
                                <div class="bg-soft text-muted d-flex align-items-center justify-content-center" style="aspect-ratio: 1/1;">
                                    <i class="bi bi-image fs-1"></i>
                                </div>
                            <?php endif; ?>
                            <?php if (!$inStock): ?>
                                <span class="position-absolute bottom-0 start-0 m-2 badge bg-danger rounded-pill px-3 py-1">Out of Stock</span>
                            <?php endif; ?>
                        </a>

                        <div class="d-flex flex-column flex-grow-1">
                            <h2 class="h5 fw-bold mb-1">
                                <a href="<?= base_url('menu/' . $product['product_id']) ?>" class="text-decoration-none text-dark"><?= esc(rtrim((string) $product['name'], '*')) ?></a>
                            </h2>
                            <p class="text-muted small mb-3 flex-grow-1">
                                <?= esc($product['description'] ?: 'Handcrafted fresh daily at Pacudan\'s.') ?>
                                <?php if (!empty($product['category_name'])): ?>
                                    <span class="d-block text-amber fw-semibold mt-1"><?= esc($product['category_name']) ?></span>
                                <?php endif; ?>
                            </p>

                            <div class="d-flex align-items-center justify-content-between pt-3 mb-3 border-top" style="border-color: var(--border-tile) !important;">
                                <span class="h5 fw-bold text-primary mb-0 tabular-nums">
                                    <?= $hasVariants ? 'From ' : '' ?>₱<?= number_format($displayPrice, 2) ?>
                                </span>
                                <a href="<?= base_url('menu/' . $product['product_id']) ?>" class="small fw-bold text-primary text-decoration-none">
                                    Customize <i class="bi bi-chevron-right"></i>
                                </a>
                            </div>

                            <?php if ($inStock): ?>
                                <form action="<?= base_url('cart/add') ?>" method="post" class="direct-add-form">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                    <button type="submit" class="btn btn-primary rounded-pill btn-sm fw-bold w-100 py-2 action-btn">
                                        <i class="bi bi-bag-plus me-1"></i>Add to Bag
                                    </button>
                                </form>
                            <?php else: ?>
                                <button type="button" class="btn btn-secondary rounded-pill btn-sm fw-bold w-100 py-2" disabled>Out of Stock</button>
                            <?php endif; ?>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    document.querySelectorAll('.direct-add-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const btn = this.querySelector('.action-btn');
            if (btn) {
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>PROCEEDING...';
                btn.disabled = true;
            }
        });
    });
</script>

<style>
    .active-drawer-link {
        background: rgba(255, 255, 255, 0.1);
        font-weight: bold;
    }

    .price-badge-glass {
        background: rgba(253, 249, 243, 0.85);
        backdrop-filter: blur(10px);
        color: var(--accent-color);
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid rgba(255,255,255,0.2);
    }

    .product-card-interactive {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .product-card-interactive:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(74, 49, 33, 0.12) !important;
    }

    .interaction-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(253, 249, 243, 0.98);
        backdrop-filter: blur(10px);
        transform: translateY(100%);
        transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border-top: 1px solid rgba(74, 49, 33, 0.05);
    }

    .product-card-interactive:hover .interaction-overlay {
        transform: translateY(0);
    }

    .action-btn {
        letter-spacing: 1px;
    }

    @media (max-width: 767.98px) {
        .display-5 { font-size: 2rem !important; }
    }
</style>

<?= $this->endSection() ?>
