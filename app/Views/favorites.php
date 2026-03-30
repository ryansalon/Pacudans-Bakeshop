<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="section-padding">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5 reveal">
            <div>
                <h6 class="text-primary fw-bold text-uppercase mb-2 tracking-widest" style="letter-spacing: 2px;">My Account</h6>
                <h2 class="display-5 mb-0 fw-bold"><i class="bi bi-heart-fill me-3 text-danger"></i>My Favorites</h2>
            </div>
            <a href="<?= base_url('menu') ?>" class="btn btn-outline-primary rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-arrow-left me-2"></i> Back to Menu
            </a>
        </div>

        <?php if (empty($favorites)): ?>
            <div class="text-center py-5 bg-white rounded-5 shadow-sm reveal">
                <i class="bi bi-heart display-1 opacity-10"></i>
                <h3 class="mt-4">No favorites yet</h3>
                <p class="text-muted mb-4">Save the treats you love to find them easily later!</p>
                <a href="<?= base_url('menu') ?>" class="btn btn-primary btn-lg rounded-pill px-5">Explore Menu</a>
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($favorites as $index => $product): ?>
                    <div class="col" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <div class="card h-100 p-3 border-0 shadow-sm hover-up">
                            <div class="position-relative overflow-hidden rounded-4">
                                <?php if ($product['image_url']): ?>
                                    <img src="<?= base_url($product['image_url']) ?>" class="card-img-top w-100 object-fit-cover transition-transform" alt="<?= esc($product['name']) ?>" style="height: 240px;">
                                <?php else: ?>
                                    <div class="bg-soft text-muted text-center py-5 h-100 d-flex flex-column justify-content-center" style="min-height: 240px;">
                                        <i class="bi bi-image fs-1 opacity-10"></i>
                                    </div>
                                <?php endif; ?>
                                <a href="<?= base_url('favorites/remove/' . $product['product_id']) ?>" class="btn btn-white position-absolute top-0 end-0 m-3 shadow-sm rounded-circle p-2 text-danger" title="Remove from favorites">
                                    <i class="bi bi-heart-fill"></i>
                                </a>
                                <span class="badge bg-white text-dark position-absolute bottom-0 start-0 m-3 shadow-sm px-3 py-2 fw-bold rounded-pill">
                                    <?= esc($product['category_name']) ?>
                                </span>
                            </div>
                            <div class="card-body px-2 pt-4">
                                <h5 class="fw-bold mb-2"><?= esc($product['name']) ?></h5>
                                <p class="text-muted small mb-4 line-clamp-2" style="height: 40px;"><?= esc($product['description']) ?></p>
                                <div class="d-grid gap-2">
                                    <a href="<?= base_url('menu/' . $product['product_id']) ?>" class="btn btn-primary rounded-pill py-2 shadow-sm fw-bold">
                                        View & Order <i class="bi bi-cart-plus ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Global Checkout Button -->
            <?php 
                $cart = session()->get('cart') ?? [];
                if (!empty($cart)): 
            ?>
                <div class="mt-5 pt-5 text-center reveal border-top">
                    <h4 class="fw-bold mb-3">Ready to get your treats?</h4>
                    <p class="text-muted mb-4">You have items in your shopping cart ready for checkout.</p>
                    <a href="<?= base_url('checkout') ?>" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-lg">
                        Proceed to Checkout <i class="bi bi-credit-card ms-2"></i>
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<style>
    .hover-up { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .hover-up:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important; }
    .transition-transform { transition: transform 0.6s ease; }
    .card:hover .transition-transform { transform: scale(1.1); }
</style>

<?= $this->endSection() ?>
