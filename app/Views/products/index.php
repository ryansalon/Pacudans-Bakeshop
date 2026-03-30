<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="section-padding">
    <div class="container">
        <div class="row g-5">
            <!-- Professional Sidebar Navigation -->
            <div class="col-lg-3">
                <div class="sidebar-card sticky-top" style="top: 100px;" data-aos="fade-right">
                    <h6 class="text-uppercase tracking-widest fw-800 text-primary mb-4" style="font-size: 0.7rem; letter-spacing: 2px;">Menu Categories</h6>
                    <div class="nav flex-column">
                        <a href="<?= base_url('menu') ?>" class="sidebar-link <?= !isset($category) ? 'active' : '' ?>">
                            <i class="bi bi-grid-fill"></i>
                            <span>All Delights</span>
                        </a>
                        <?php foreach ($categories as $cat): ?>
                            <?php 
                                $icon = 'bi-cup-hot';
                                if(strpos(strtolower($cat['name']), 'ice') !== false) $icon = 'bi-snow';
                                elseif(strpos(strtolower($cat['name']), 'frappe') !== false) $icon = 'bi-cup-straw';
                                elseif(strpos(strtolower($cat['name']), 'smoothie') !== false) $icon = 'bi-water';
                                elseif(strpos(strtolower($cat['name']), 'cake') !== false) $icon = 'bi-cake2';
                                elseif(strpos(strtolower($cat['name']), 'bread') !== false) $icon = 'bi-egg-fried';
                            ?>
                            <a href="<?= base_url('category/' . $cat['category_id']) ?>" 
                               class="sidebar-link <?= (isset($category) && $category['category_id'] == $cat['category_id']) ? 'active' : '' ?>">
                                <i class="bi <?= $icon ?>"></i>
                                <span><?= esc($cat['name']) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-5 p-4 rounded-4 text-center" style="background: var(--bg-soft); border: 1px dashed var(--accent-gold);">
                        <i class="bi bi-clock text-primary mb-2 d-block fs-4"></i>
                        <span class="d-block fw-bold small">Open Daily</span>
                        <span class="text-muted" style="font-size: 0.75rem;">8:00 AM - 9:00 PM</span>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <div class="mb-5">
                    <a href="<?= base_url() ?>" class="btn btn-outline-primary rounded-pill px-4 fw-bold shadow-sm">
                        <i class="bi bi-arrow-left me-2"></i> Back to Home
                    </a>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-5" data-aos="fade-down">
                    <div>
                        <h2 class="display-6 mb-1 fw-bold"><?= esc($title) ?></h2>
                        <p class="text-muted mb-0 small text-uppercase tracking-widest">Handcrafted with love</p>
                    </div>
                    <span class="badge bg-white text-dark shadow-sm border rounded-pill px-3 py-2 small fw-bold">
                        <?= count($products) ?> items
                    </span>
                </div>
                
                <?php if (empty($products)): ?>
                    <div class="text-center py-5 bg-white rounded-5 shadow-sm" data-aos="zoom-in">
                        <i class="bi bi-search fs-1 opacity-25"></i>
                        <h4 class="mt-4">No products found</h4>
                        <p class="text-muted">Check back later for fresh batches!</p>
                    </div>
                <?php else: ?>
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <?php foreach ($products as $index => $product): ?>
                            <div class="col" data-aos="fade-up" data-aos-delay="<?= ($index % 3) * 100 ?>">
                                <div class="card h-100 p-2 border-0 shadow-sm hover-up">
                                    <div class="position-relative overflow-hidden rounded-4">
                                        <?php if ($product['image_url']): ?>
                                            <img src="<?= base_url($product['image_url']) ?>" class="card-img-top w-100 object-fit-cover transition-transform" alt="<?= esc($product['name']) ?>" style="height: 240px;">
                                        <?php else: ?>
                                            <div class="bg-light text-muted text-center py-5 h-100 d-flex flex-column justify-content-center" style="min-height: 240px;">
                                                <i class="bi bi-image fs-1 opacity-25"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="position-absolute top-0 end-0 m-3">
                                            <span class="badge bg-white text-dark shadow-sm rounded-pill px-3 py-2 fw-800">
                                                ₱<?= number_format($product['min_price'] ?? $product['price'], 2) ?>
                                                <?php if($product['min_price'] > 0): ?><small class="opacity-50">+</small><?php endif; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body px-2 pt-3">
                                        <h6 class="fw-800 mb-2 text-truncate"><?= esc($product['name']) ?></h6>
                                        <p class="text-muted small mb-4 line-clamp-2" style="font-size: 0.75rem; height: 35px;"><?= esc($product['description']) ?></p>
                                        <a href="<?= base_url('menu/' . $product['product_id']) ?>" class="btn btn-primary w-100 rounded-pill py-2 shadow-sm text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">
                                            Customize & Order
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-up { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .hover-up:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important; }
    .transition-transform { transition: transform 0.6s ease; }
    .card:hover .transition-transform { transform: scale(1.1); }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .fw-800 { font-weight: 800; }
</style>

<?= $this->endSection() ?>
