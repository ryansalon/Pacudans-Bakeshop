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

    <!-- Full-Width Product Grid -->
    <?php if (empty($products)): ?>
        <div class="text-center py-5 bg-white rounded-5 shadow-sm" data-aos="zoom-in">
            <i class="bi bi-search fs-1 opacity-25"></i>
            <h4 class="mt-4">No products found</h4>
            <p class="text-muted">Check back later for fresh batches!</p>
        </div>
    <?php else: ?>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($products as $index => $product): ?>
                <div class="col" data-aos="fade-up" data-aos-delay="<?= ($index % 4) * 100 ?>">
                    <div class="card h-100 p-0 border-0 shadow-sm overflow-hidden product-card-interactive" style="border-radius: 20px;">
                        <div class="position-relative overflow-hidden">
                            <?php if ($product['image_url']): ?>
                                <img src="<?= base_url($product['image_url']) ?>" class="card-img-top w-100 object-fit-cover" alt="<?= esc($product['name']) ?>" style="aspect-ratio: 1/1;">
                            <?php else: ?>
                                <div class="bg-light text-muted text-center d-flex align-items-center justify-content-center" style="aspect-ratio: 1/1;">
                                    <i class="bi bi-image fs-1 opacity-10"></i>
                                </div>
                            <?php endif; ?>
                            <div class="position-absolute top-0 end-0 m-3 px-3 py-1 fw-bold rounded-pill price-badge-glass">
                                ₱<?= number_format($product['price'], 2) ?>
                            </div>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h6 class="fw-bold mb-1 text-truncate" style="font-family: 'Playfair Display', serif; color: var(--text-main);"><?= esc($product['name']) ?></h6>
                            <p class="text-muted small mb-0">Local Camiguin Specialty</p>
                            
                            <!-- Interaction View Footer -->
                            <div class="interaction-overlay p-4">
                                <div class="d-grid gap-2">
                                    <?php if ($product['stock_quantity'] > 0): ?>
                                        <form action="<?= base_url('cart/add') ?>" method="post" class="direct-add-form">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                            <button type="submit" class="btn btn-primary rounded-pill btn-sm fw-bold action-btn w-100">ADD TO CART</button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-secondary rounded-pill btn-sm fw-bold action-btn" disabled>OUT OF STOCK</button>
                                    <?php endif; ?>
                                    <a href="<?= base_url('menu/' . $product['product_id']) ?>" class="text-decoration-none small fw-bold mt-2" style="color: var(--accent-color);">LEARN MORE</a>
                                </div>
                            </div>
                        </div>
                    </div>
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
