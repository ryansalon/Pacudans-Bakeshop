<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div id="menu-grid" class="container py-5">
    <!-- Header & Menu Toggle -->
    <div class="d-flex align-items-center mb-5" style="position: relative; z-index: 500; margin-top: 100px;">
        <button class="btn p-0 border-0 me-4 d-flex align-items-center justify-content-center hamburger-trigger" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuSidebar" aria-controls="menuSidebar" style="width: 48px; height: 48px; z-index: 1100;">
            <i class="bi bi-list fs-1" style="color: var(--accent-color);"></i>
        </button>
        <div class="d-flex flex-column justify-content-center">
            <h2 class="display-5 mb-0 fw-bold" style="font-family: 'Playfair Display', serif; line-height: 1.2;"><?= esc($title) ?></h2>
            <p class="text-muted mb-0 small text-uppercase tracking-widest">Explore our handcrafted delights</p>
        </div>
        <div class="ms-auto d-none d-md-block">
            <span class="badge bg-white text-dark shadow-sm border rounded-pill px-4 py-2 small fw-bold" style="color: var(--accent-color) !important;">
                <?= count($products) ?> items
            </span>
        </div>
    </div>

    <!-- Off-canvas Sidebar -->
    <div class="offcanvas offcanvas-start border-0 shadow-lg" tabindex="-1" id="menuSidebar" aria-labelledby="menuSidebarLabel" style="background-color: var(--accent-color); width: 320px;">
        <div class="offcanvas-header p-4 border-bottom border-white border-opacity-10">
            <h5 class="offcanvas-title text-white fw-bold" id="menuSidebarLabel" style="font-family: 'Playfair Display', serif; letter-spacing: 1px;">MENU CATEGORIES</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="nav flex-column py-3">
                <a href="<?= base_url('menu') ?>" class="nav-link px-4 py-3 text-white border-bottom border-white border-opacity-5 d-flex align-items-center justify-content-between <?= !isset($category) ? 'active-drawer-link' : '' ?>">
                    <span>All Delights</span>
                    <i class="bi bi-chevron-right small opacity-50"></i>
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="<?= base_url('category/' . $cat['category_id']) ?>" 
                       class="nav-link px-4 py-3 text-white border-bottom border-white border-opacity-5 d-flex align-items-center justify-content-between <?= (isset($category) && $category['category_id'] == $cat['category_id']) ? 'active-drawer-link' : '' ?>">
                        <span><?= esc($cat['name']) ?></span>
                        <i class="bi bi-chevron-right small opacity-50"></i>
                    </a>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-auto p-4 opacity-50 text-white small">
                <p class="mb-1"><i class="bi bi-geo-alt me-2"></i> Mambajao, Camiguin</p>
                <p class="mb-0"><i class="bi bi-clock me-2"></i> 8:00 AM - 9:00 PM</p>
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
