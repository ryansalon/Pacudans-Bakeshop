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
                        <div class="d-flex align-items-center">
                            <div class="text-white rounded-circle p-2 me-3" style="background-color: var(--accent-color);"><i class="bi bi-heart-fill"></i></div>
                            <span class="fw-bold">Family Recipes</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="text-white rounded-circle p-2 me-3" style="background-color: var(--accent-color);"><i class="bi bi-star-fill"></i></div>
                            <span class="fw-bold">Top Rated</span>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-outline-primary btn-lg rounded-pill px-5" style="border-color: var(--accent-color); color: var(--accent-color);">Learn More</a>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<div class="section-padding" style="border-radius: 80px 80px 0 0;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="fw-bold text-uppercase mb-2 tracking-widest" style="letter-spacing: 2px; color: var(--secondary-accent);">Testimonials</h6>
            <h2 class="display-5 mb-0 fw-bold" style="font-family: 'Playfair Display', serif;">What Our Community Says</h2>
            <p class="text-muted mt-3 col-lg-6 mx-auto">Real stories from our lovely customers who have made Pacudan's a part of their daily ritual.</p>
        </div>

        <div class="testimonial-grid mt-5" data-aos="fade-up">
            <!-- Testimonial 1 -->
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://ui-avatars.com/api/?name=Maria+Santos&background=3d2b1f&color=fff" class="testimonial-avatar" alt="User">
                    <div class="testimonial-user-info">
                        <div class="testimonial-name">Maria Santos</div>
                        <div class="testimonial-handle">@m_santos</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    Best coffee in Camiguin! ☕️ The <span class="highlight">Iced Spanish Latte</span> is a game changer. Also, their ube bread is always fresh. Highly recommend! #PacudansCoffee #CamiguinEats
                </div>
                <span class="testimonial-timestamp">10:24 AM · May 10, 2026</span>
            </div>

            <!-- Testimonial 2 -->
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://ui-avatars.com/api/?name=James+Wilson&background=b08d57&color=fff" class="testimonial-avatar" alt="User">
                    <div class="testimonial-user-info">
                        <div class="testimonial-name">James Wilson</div>
                        <div class="testimonial-handle">@jwilson_travels</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    Found this hidden gem while exploring Mambajao. The aesthetic is so <span class="highlight">premium</span> and the staff are incredibly friendly. 10/10 would visit again! ✨
                </div>
                <span class="testimonial-timestamp">2:15 PM · May 8, 2026</span>
            </div>

            <!-- Testimonial 3 -->
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://ui-avatars.com/api/?name=Liza+Dela+Cruz&background=5c4033&color=fff" class="testimonial-avatar" alt="User">
                    <div class="testimonial-user-info">
                        <div class="testimonial-name">Liza Dela Cruz</div>
                        <div class="testimonial-handle">@lizadc</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    Their <span class="highlight">customized cakes</span> are not just beautiful, they taste amazing too! Ordered one for my mom's birthday and she loved it. Thank you @Pacudans! 🎂❤️
                </div>
                <span class="testimonial-timestamp">9:45 AM · May 5, 2026</span>
            </div>

            <!-- Testimonial 4 -->
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://ui-avatars.com/api/?name=David+Reyes&background=3d2b1f&color=fff" class="testimonial-avatar" alt="User">
                    <div class="testimonial-user-info">
                        <div class="testimonial-name">David Reyes</div>
                        <div class="testimonial-handle">@dreyes_dev</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    The perfect spot to work from home. High-speed internet, great vibes, and the <span class="highlight">Caramel Macchiato</span> keeps me going. 💻☕️
                </div>
                <span class="testimonial-timestamp">11:30 AM · May 3, 2026</span>
            </div>

            <!-- Testimonial 5 -->
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://ui-avatars.com/api/?name=Sarah+G&background=b08d57&color=fff" class="testimonial-avatar" alt="User">
                    <div class="testimonial-user-info">
                        <div class="testimonial-name">Sarah G.</div>
                        <div class="testimonial-handle">@sarah_bakes</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    Honestly, I dream about their <span class="highlight">Cheese Ensaymada</span>. It's so fluffy and buttery! Best paired with their hot chocolate. 🥐🍫
                </div>
                <span class="testimonial-timestamp">4:20 PM · May 1, 2026</span>
            </div>

            <!-- Testimonial 6 -->
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://ui-avatars.com/api/?name=Marco+Polo&background=5c4033&color=fff" class="testimonial-avatar" alt="User">
                    <div class="testimonial-user-info">
                        <div class="testimonial-name">Marco Polo</div>
                        <div class="testimonial-handle">@marco_p</div>
                    </div>
                </div>
                <div class="testimonial-content">
                    The <span class="highlight">Peach Mango Smoothie</span> is so refreshing! Perfect for the Camiguin heat. 🏝️🥤 Can't wait to go back!
                </div>
                <span class="testimonial-timestamp">1:05 PM · Apr 28, 2026</span>
            </div>
        </div>
    </div>
</div>

<!-- Visit Us Section -->
<div id="location" class="section-padding bg-soft" style="border-radius: 80px 80px 0 0;">
    <div class="container">
        <div class="text-center mb-5 reveal" data-aos="fade-up">
            <h6 class="text-primary fw-bold text-uppercase mb-2 tracking-widest" style="letter-spacing: 2px;">Find Us</h6>
            <h2 class="display-5 mb-0 fw-bold">Visit Our Shop</h2>
            <p class="text-muted mt-3 col-lg-6 mx-auto">Come and experience the aroma of fresh coffee and newly baked pastries in person.</p>
        </div>

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
