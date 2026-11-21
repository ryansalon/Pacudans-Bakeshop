<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Deep Volcanic-Jade Architectural Masthead -->
<section class="jade-masthead">
    <div class="container">
        <div class="row g-4 align-items-end">
            <div class="col-lg-7">
                <h1 class="masthead-title mb-3">
                    Mambajao's warm coffee bar &amp; bakeshop.
                </h1>
                <p class="masthead-sub mb-3">
                    Fresh morning breads, custom Camiguin celebration cakes, and dialed-in hot &amp; iced espresso—delivered free across Mambajao with Cash on Delivery.
                </p>
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <a href="<?= base_url('menu') ?>" class="btn btn-amber px-4 py-2">
                        Browse <?= (int) ($total_products ?? 38) ?> Menu Items
                    </a>
                    <a href="#location" class="btn btn-ghost-jade px-4 py-2">
                        <i class="bi bi-clock me-2"></i>Open 8AM – 9PM Daily
                    </a>
                </div>
            </div>

            <div class="col-lg-5">
                <?php if (!empty($signature_product)): ?>
                    <article class="signature-tile">
                        <a href="<?= base_url('menu/' . $signature_product['product_id']) ?>" class="signature-thumb-wrap flex-shrink-0">
                            <?php if (!empty($signature_product['image_url'])): ?>
                                <img src="<?= base_url($signature_product['image_url']) ?>" alt="<?= esc(rtrim((string) $signature_product['name'], '*')) ?>" class="signature-thumb">
                            <?php else: ?>
                                <div class="signature-thumb d-flex align-items-center justify-content-center bg-dark text-white">
                                    <i class="bi bi-cake2 fs-1"></i>
                                </div>
                            <?php endif; ?>
                        </a>
                        <div class="flex-grow-1 min-w-0">
                            <h2 class="h4 fw-bold text-white mb-1"><?= esc(rtrim((string) $signature_product['name'], '*')) ?></h2>
                            <p class="small mb-3" style="color: var(--jade-tint);">
                                <?= esc($signature_product['description'] ?: 'House-baked specialty prepared fresh daily in Mambajao.') ?>
                            </p>
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                <span class="h5 fw-bold mb-0 tabular-nums" style="color: var(--amber-light);">
                                    ₱<?= number_format($signature_product['price'], 2) ?>
                                </span>
                                <a href="<?= base_url('menu/' . $signature_product['product_id']) ?>" class="btn btn-amber btn-sm px-3 py-1">
                                    Order Direct <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Sun-Washed Plaster Counter Shelf: Live Categories & Today's Picks inside the first viewport -->
<section class="plaster-shelf py-4">
    <div class="container">
        <?php if (!empty($categories)): ?>
            <div class="cat-strip-wrap mb-3">
                <nav class="d-flex align-items-center gap-2 overflow-auto pb-2 pe-4" aria-label="Browse menu categories">
                    <a href="<?= base_url('menu') ?>" class="btn btn-primary btn-sm rounded-pill px-3 py-2 flex-shrink-0">All Delights</a>
                    <?php foreach ($categories as $cat): ?>
                        <a href="<?= base_url('category/' . $cat['category_id']) ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-2 flex-shrink-0">
                            <?= esc($cat['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </div>
        <?php endif; ?>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-3">
            <div>
                <h2 class="h3 fw-bold mb-0">Fresh Counter Picks for <?= esc($current_day) ?></h2>
                <p class="text-muted small mb-0">Add straight to your bag or tap any treat to pick your cup size.</p>
            </div>
            <a href="<?= base_url('menu') ?>" class="fw-bold text-primary text-decoration-none small">
                See full menu <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <?php if (empty($featured_products)): ?>
            <div class="surface-panel p-5 text-center">
                <i class="bi bi-cup-straw fs-1 text-muted"></i>
                <p class="mt-3 text-muted mx-auto mb-0">Our ovens and espresso machine are warming up—check back shortly.</p>
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
                <?php foreach ($featured_products as $product): ?>
                    <?php
                        $cleanName = rtrim((string) $product['name'], '*');
                        $hasVariants = !empty($product['variant_count']) && (int) $product['variant_count'] > 0;
                        $displayPrice = ($hasVariants && $product['min_price'] !== null)
                            ? (float) $product['min_price']
                            : (float) $product['price'];
                        $inStock = (int) ($product['stock_quantity'] ?? 1) > 0;
                    ?>
                    <div class="col">
                        <article class="card h-100 p-3 d-flex flex-column counter-card">
                            <a href="<?= base_url('menu/' . $product['product_id']) ?>" class="d-block overflow-hidden rounded-3 mb-2 position-relative">
                                <?php if ($product['image_url']): ?>
                                    <img src="<?= base_url($product['image_url']) ?>" alt="<?= esc($cleanName) ?>" class="w-100 object-fit-cover counter-thumb">
                                <?php else: ?>
                                    <div class="bg-soft d-flex align-items-center justify-content-center text-muted counter-thumb">
                                        <i class="bi bi-image fs-2"></i>
                                    </div>
                                <?php endif; ?>
                            </a>

                            <div class="d-flex flex-column flex-grow-1">
                                <h3 class="h5 fw-bold mb-1">
                                    <a href="<?= base_url('menu/' . $product['product_id']) ?>" class="text-decoration-none text-dark"><?= esc($cleanName) ?></a>
                                </h3>
                                <p class="small text-muted mb-2 flex-grow-1">
                                    <?= esc($product['description'] ?: 'Made fresh daily at Pacudan\'s Bakeshop.') ?>
                                    <?php if (!empty($product['category_name'])): ?>
                                        <span class="d-block fw-semibold text-amber mt-1"><?= esc($product['category_name']) ?></span>
                                    <?php endif; ?>
                                </p>

                                <div class="d-flex align-items-center justify-content-between gap-2 pt-2 border-top" style="border-color: var(--border-tile) !important;">
                                    <span class="h6 fw-bold text-primary mb-0 tabular-nums">
                                        <?= $hasVariants ? 'From ' : '' ?>₱<?= number_format($displayPrice, 2) ?>
                                    </span>
                                    <?php if ($inStock): ?>
                                        <form action="<?= base_url('cart/add') ?>" method="post" class="home-quick-add">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                            <button type="submit" class="btn btn-primary btn-sm px-3 py-1 quick-add-btn">
                                                <i class="bi bi-plus-lg me-1"></i>Add
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="badge bg-danger rounded-pill">Sold Out</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Authentic Café Specialties (Grounded Counter Facts — Zero Fabricated Quotes or Stat Templates) -->
<section class="py-5">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5">
                <div class="bg-jade rounded-4 p-4 p-lg-5 h-100 d-flex flex-column justify-content-between jade-tile-surface">
                    <div>
                        <h2 class="h2 fw-bold text-white mb-3">Built for Camiguin mornings &amp; celebrations.</h2>
                        <p class="mb-4" style="color: var(--jade-tint);">
                            Everything on our online menu comes straight from our Mambajao kitchen and espresso bar—transparent Peso pricing from ₱<?= number_format($min_price ?? 25, 0) ?> to ₱<?= number_format($max_price ?? 500, 0) ?>, free town delivery, and live counter status updates.
                        </p>
                    </div>

                    <dl class="mb-0 small border-top pt-3" style="border-color: rgba(203, 224, 216, 0.22) !important;">
                        <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: rgba(203, 224, 216, 0.14) !important;">
                            <dt class="fw-normal" style="color: var(--jade-tint);">Counter Hours</dt>
                            <dd class="mb-0 fw-bold tabular-nums" style="color: var(--amber-light);">Daily, 8:00 AM – 9:00 PM</dd>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: rgba(203, 224, 216, 0.14) !important;">
                            <dt class="fw-normal" style="color: var(--jade-tint);">Delivery Terms</dt>
                            <dd class="mb-0 fw-bold text-white">Free Mambajao COD</dd>
                        </div>
                        <div class="d-flex justify-content-between pt-2">
                            <dt class="fw-normal" style="color: var(--jade-tint);">Direct Line</dt>
                            <dd class="mb-0 fw-bold tabular-nums"><a href="tel:09639216585" class="text-decoration-none text-white">0963 921 6585</a></dd>
                        </div>
                    </dl>
                </div>
            </div>

            <?php
                $drinksCatUrl = base_url('menu');
                $cakesCatUrl  = base_url('menu');
                foreach (($categories ?? []) as $c) {
                    $cname = strtolower((string) $c['name']);
                    if (strpos($cname, 'iced') !== false || strpos($cname, 'hot') !== false) {
                        if ($drinksCatUrl === base_url('menu')) {
                            $drinksCatUrl = base_url('category/' . $c['category_id']);
                        }
                    }
                    if (strpos($cname, 'cake') !== false) {
                        $cakesCatUrl = base_url('category/' . $c['category_id']);
                    }
                }
            ?>
            <div class="col-lg-7">
                <div class="row g-4 h-100">
                    <div class="col-sm-6">
                        <div class="surface-panel p-4 h-100 d-flex flex-column">
                            <img src="<?= base_url('assets/images/ice_coffee/iced_caramel_machiato.jpg') ?>" alt="Iced Caramel Macchiato at Pacudan's" class="w-100 object-fit-cover rounded-3 mb-3" style="height: 170px;">
                            <h3 class="h5 fw-bold mb-2">Hot, Iced &amp; Blended Bar</h3>
                            <p class="small text-muted mb-3 flex-grow-1">Single &amp; double espresso shots, matcha lattes, iced white mochas, oreo frappes, and fresh mango shakes made to order.</p>
                            <a href="<?= $drinksCatUrl ?>" class="fw-bold text-primary text-decoration-none small">Order drinks <i class="bi bi-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="surface-panel p-4 h-100 d-flex flex-column">
                            <img src="<?= base_url('assets/images/cakes/ube_custard.png') ?>" alt="Ube Custard Cake at Pacudan's" class="w-100 object-fit-cover rounded-3 mb-3" style="height: 170px;">
                            <h3 class="h5 fw-bold mb-2">Celebration Cakes &amp; Breads</h3>
                            <p class="small text-muted mb-3 flex-grow-1">Ube Custard, Choco Moist, Red Velvet, Brazo Cupcakes, fluffy Cheese Ensaymada, and toasted sandwiches baked fresh daily.</p>
                            <a href="<?= $cakesCatUrl ?>" class="fw-bold text-primary text-decoration-none small">Order cakes &amp; bakes <i class="bi bi-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Story -->
<section id="about" class="py-5">
    <div class="container">
        <div class="surface-subtle p-4 p-lg-5">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-6">
                    <img src="<?= base_url('assets/images/logo_and_bg/cafe-bg.jpg') ?>" class="img-fluid w-100 object-fit-cover rounded-4 shadow-sm" alt="Warm wooden counter at Pacudan's Bakeshop & Coffee Bar in Mambajao" style="height: 360px;">
                </div>
                <div class="col-lg-6">
                    <h2 class="display-6 fw-bold mb-3">A family kitchen turned neighborhood coffee bar.</h2>
                    <p class="lead text-muted mb-4">
                        Pacudan's Bakeshop &amp; Coffee Bar began as a small family dream right here in Mambajao. Every morning starts with warm trays of brioche ensaymada, layered custard cakes, and freshly pulled espresso for island neighbors and travelers.
                    </p>
                    <ul class="list-unstyled small border-top mb-4" style="border-color: var(--border-tile) !important;">
                        <li class="py-2 border-bottom d-flex align-items-center gap-2" style="border-color: var(--border-tile) !important;">
                            <i class="bi bi-check2 text-primary fw-bold"></i>
                            <span>Small-batch breads, cupcakes, and custard cakes baked every morning</span>
                        </li>
                        <li class="py-2 border-bottom d-flex align-items-center gap-2" style="border-color: var(--border-tile) !important;">
                            <i class="bi bi-check2 text-primary fw-bold"></i>
                            <span>Custom celebration cakes available for birthdays and family gatherings</span>
                        </li>
                        <li class="py-2 border-bottom d-flex align-items-center gap-2" style="border-color: var(--border-tile) !important;">
                            <i class="bi bi-check2 text-primary fw-bold"></i>
                            <span>Direct Cash on Delivery across Mambajao with counter status alerts</span>
                        </li>
                    </ul>
                    <a href="<?= base_url('menu') ?>" class="btn btn-primary px-4">Start Your Order</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visit Our Shop -->
<section id="location" class="py-5">
    <div class="container">
        <div class="surface-panel p-4 p-lg-5">
            <div class="row g-4 g-lg-5 align-items-center">
                <div class="col-lg-5">
                    <h2 class="display-6 fw-bold mb-3">Visit Our Shop in Mambajao</h2>
                    <p class="text-muted mb-4">Dine in for fresh espresso and warm pastries, pick up a celebration cake, or call the counter directly.</p>

        <div class="row g-5 align-items-center mt-4">
            <div class="col-lg-5 reveal" data-aos="fade-right">
                <div class="card p-5 border-0 shadow-lg rounded-5 bg-white h-100">
                    <div class="mb-5">
                        <div class="d-flex align-items-start mb-4">
                            <div class="bg-primary text-white rounded-circle p-3 me-4 shadow-sm">
                                <i class="bi bi-geo-alt fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Our Location</h5>
                                <p class="text-muted mb-0">Mambajao, Camiguin Island, Philippines</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <div class="bg-primary text-white rounded-circle p-3 me-4 shadow-sm">
                                <i class="bi bi-clock fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Operating Hours</h5>
                                <p class="text-muted mb-0">Monday - Sunday<br>8:00 AM - 9:00 PM</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start">
                            <div class="bg-primary text-white rounded-circle p-3 me-4 shadow-sm">
                                <i class="bi bi-envelope fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Contact Us</h5>
                                <p class="text-muted mb-0">pacudanscoffee@gmail.com<br>0963 921 6585</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 reveal" data-aos="fade-left">
                <div class="card p-2 border-0 shadow-lg rounded-5 bg-white overflow-hidden position-relative" style="height: 500px;">
                    <!-- Embedded Google Map - With Pinpoint and Scroll Disabled -->
                    <iframe 
                        src="https://maps.google.com/maps?q=Pacudan's%20Bakeshop,%20Mambajao,%20Camiguin&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                        width="100%" 
                        height="100%" 
                        style="border:0; border-radius: 40px; pointer-events: none;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                    <!-- Overlay to prevent accidental interactions but allow clicking 'View Larger Map' if the iframe had it (pointer-events: none on iframe is safer for scroll) -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-transform { transition: transform 0.5s ease; }
    .card:hover .transition-transform { transform: scale(1.05); }
</style>

<?= $this->endSection() ?>
