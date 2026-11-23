<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<?php
    $sigName  = !empty($signature_product) ? rtrim((string) $signature_product['name'], '*') : 'Choco Moist Cake';
    $sigPrice = !empty($signature_product) ? (float) $signature_product['price'] : 450.00;
    $sigImg   = !empty($signature_product['image_url']) ? $signature_product['image_url'] : 'assets/images/cakes/choco_moist_cake.jpg';
    $sigUrl   = !empty($signature_product) ? base_url('menu/' . $signature_product['product_id']) : base_url('menu');

    $catImages = [
        'hot drinks'        => 'assets/images/hot_drinks/cafe_latte.jpg',
        'iced coffee'       => 'assets/images/ice_coffee/iced_caramel_machiato.jpg',
        'frappes'           => 'assets/images/frappe/matcha_frappe.jpg',
        'smoothies'         => 'assets/images/smoothies/mango_milk_shake.jpg',
        'cakes'             => 'assets/images/cakes/ube_custard.png',
        'breads & pastries' => 'assets/images/breads_and_pastries/ensaymada.jpg',
        'sandwich & savory' => 'assets/images/sandwich_and_savory/egg_benedict.jpg',
    ];

    $drinksCatUrl = base_url('menu');
    $cakesCatUrl  = base_url('menu');
    foreach (($categories ?? []) as $c) {
        $cname = strtolower((string) $c['name']);
        if (strpos($cname, 'iced') !== false) {
            $drinksCatUrl = base_url('category/' . $c['category_id']);
        }
        if (strpos($cname, 'cake') !== false) {
            $cakesCatUrl = base_url('category/' . $c['category_id']);
        }
    }
?>

<!-- Full-Viewport Split Editorial Hero (occupies 100% of opening screen; next section reveals on scroll) -->
<section class="editorial-hero">
    <div class="container py-4 py-lg-5">
        <div class="row g-4 g-lg-5 align-items-center">
            <!-- Left: Warm Coffeehouse Typography & Conversion Actions -->
            <div class="col-lg-5 hero-stagger">
                <h1 class="hero-display mb-4">
                    Freshly baked cakes &amp; handcrafted coffee, <span class="coffee-italic text-ember-pop">made in Mambajao.</span>
                </h1>

                <p class="hero-lead mb-4">
                    Warm morning ensaymada, celebration ube custard cakes, and iced espresso pulled to order—delivered free across Mambajao with Cash on Delivery.
                </p>

                <div class="d-flex flex-wrap align-items-center gap-3 mb-5">
                    <a href="<?= base_url('menu') ?>" class="btn btn-amber btn-lg px-4 py-3">
                        Order from Menu (<?= (int) ($total_products ?? 38) ?>)
                    </a>
                    <a href="#explore-craving" class="btn btn-outline-primary btn-lg px-4 py-3">
                        Explore Menu <i class="bi bi-arrow-down ms-1"></i>
                    </a>
                </div>

                <!-- Grounded Counter Facts Strip -->
                <div class="hero-facts pt-4 border-top" style="border-color: var(--border-tile-strong) !important;">
                    <div class="row g-3 small">
                        <div class="col-4">
                            <span class="d-block text-muted">Open Daily</span>
                            <strong class="text-dark tabular-nums">8AM – 9PM</strong>
                        </div>
                        <div class="col-4">
                            <span class="d-block text-muted">Local Delivery</span>
                            <strong class="text-dark">Free COD</strong>
                        </div>
                        <div class="col-4">
                            <span class="d-block text-muted">Price Range</span>
                            <strong class="text-dark tabular-nums">₱<?= number_format($min_price ?? 25, 0) ?> – ₱<?= number_format($max_price ?? 500, 0) ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Big Appetizing 3-Frame Editorial Photo Collage -->
            <div class="col-lg-7">
                <div class="hero-collage">
                    <a href="<?= $sigUrl ?>" class="collage-frame collage-main text-decoration-none">
                        <img src="<?= base_url($sigImg) ?>" alt="<?= esc($sigName) ?> at Pacudan's Bakeshop" class="collage-img" fetchpriority="high" decoding="async">
                        <div class="collage-caption">
                            <span class="display-font fs-5 text-dark d-block"><?= esc($sigName) ?></span>
                            <span class="small fw-bold tabular-nums" style="color: var(--ember-bold);">₱<?= number_format($sigPrice, 2) ?> · Order Direct →</span>
                        </div>
                    </a>

                    <a href="<?= $drinksCatUrl ?>" class="collage-frame collage-side text-decoration-none">
                        <img src="<?= base_url('assets/images/ice_coffee/iced_caramel_machiato.jpg') ?>" alt="Iced Caramel Macchiato" class="collage-img" decoding="async">
                        <div class="collage-tag">Iced &amp; Hot Espresso</div>
                    </a>

                    <a href="<?= $cakesCatUrl ?>" class="collage-frame collage-side text-decoration-none">
                        <img src="<?= base_url('assets/images/cakes/ube_custard.png') ?>" alt="Ube Custard Cake" class="collage-img" decoding="async">
                        <div class="collage-tag collage-tag-ember">Celebration Cakes</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Subtle scroll cue anchored at bottom of opening screen -->
    <a href="#explore-craving" class="hero-scroll-cue d-none d-lg-inline-flex align-items-center gap-2 text-decoration-none" aria-label="Scroll to explore categories">
        <span>Scroll to explore</span>
        <i class="bi bi-chevron-down"></i>
    </a>
</section>

<!-- Section 2: Visual Photo-Backed Category Shelf -->
<?php if (!empty($categories)): ?>
<section id="explore-craving" class="landing-band border-top border-bottom" style="border-color: var(--border-tile) !important; background-color: var(--cream-soft);">
    <div class="container">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-2 mb-4 scroll-reveal">
            <div>
                <h2 class="section-heading mb-1">Explore by <span class="coffee-italic text-ember-pop">Craving</span></h2>
                <p class="text-muted mb-0">Jump straight into any counter section to browse and customize.</p>
            </div>
            <a href="<?= base_url('menu') ?>" class="fw-bold text-decoration-none" style="color: var(--ember-bold);">
                View full menu <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="cat-strip-wrap">
            <div class="d-flex gap-3 overflow-auto pb-2 pe-4">
                <?php foreach ($categories as $idx => $cat): ?>
                    <?php
                        $catKey = strtolower((string) $cat['name']);
                        $catImg = $catImages[$catKey] ?? 'assets/images/hot_drinks/cafe_latte.jpg';
                    ?>
                    <a href="<?= base_url('category/' . $cat['category_id']) ?>"
                       class="cat-visual-card text-decoration-none flex-shrink-0 scroll-reveal"
                       style="--reveal-delay: <?= $idx * 55 ?>ms;">
                        <div class="cat-visual-thumb-wrap">
                            <img src="<?= base_url($catImg) ?>" alt="<?= esc($cat['name']) ?>" class="cat-visual-thumb" width="166" height="112" loading="lazy" decoding="async">
                        </div>
                        <div class="p-3 text-center">
                            <span class="fw-bold text-dark d-block small"><?= esc($cat['name']) ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Section 3: Today's Counter Picks -->
<section id="todays-picks" class="landing-band">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4 scroll-reveal">
            <div>
                <h2 class="section-heading mb-1">Fresh Counter Picks for <span class="coffee-italic text-ember-pop"><?= esc($current_day) ?></span></h2>
                <p class="text-muted mb-0">Add straight to your bag or tap any treat to pick your size.</p>
            </div>
            <a href="<?= base_url('menu') ?>" class="btn btn-outline-primary btn-sm rounded-pill px-4 align-self-start align-self-md-end">
                See all <?= (int) ($total_products ?? 38) ?> items <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <?php if (empty($featured_products)): ?>
            <div class="surface-panel p-5 text-center scroll-reveal">
                <i class="bi bi-cup-straw fs-1 text-muted"></i>
                <p class="mt-3 text-muted mx-auto mb-0">Our ovens and espresso machine are warming up—check back shortly.</p>
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                <?php foreach ($featured_products as $idx => $product): ?>
                    <?php
                        $cleanName = rtrim((string) $product['name'], '*');
                        $hasVariants = !empty($product['variant_count']) && (int) $product['variant_count'] > 0;
                        $displayPrice = ($hasVariants && $product['min_price'] !== null)
                            ? (float) $product['min_price']
                            : (float) $product['price'];
                        $inStock = (int) ($product['stock_quantity'] ?? 1) > 0;
                    ?>
                    <div class="col scroll-reveal" style="--reveal-delay: <?= $idx * 80 ?>ms;">
                        <article class="card h-100 p-3 d-flex flex-column counter-card">
                            <a href="<?= base_url('menu/' . $product['product_id']) ?>" class="d-block overflow-hidden rounded-3 mb-3 position-relative">
                                <?php if ($product['image_url']): ?>
                                    <img src="<?= base_url($product['image_url']) ?>" alt="<?= esc($cleanName) ?>" class="w-100 object-fit-cover counter-thumb" width="320" height="320" style="aspect-ratio: 1/1;" loading="lazy" decoding="async">
                                <?php else: ?>
                                    <div class="bg-soft d-flex align-items-center justify-content-center text-muted" style="aspect-ratio: 1/1;">
                                        <i class="bi bi-image fs-2"></i>
                                    </div>
                                <?php endif; ?>
                            </a>

                            <div class="d-flex flex-column flex-grow-1">
                                <h3 class="h5 mb-1">
                                    <a href="<?= base_url('menu/' . $product['product_id']) ?>" class="text-decoration-none text-dark"><?= esc($cleanName) ?></a>
                                </h3>
                                <p class="small text-muted mb-3 flex-grow-1">
                                    <?= esc($product['description'] ?: 'Made fresh daily at Pacudan\'s Bakeshop.') ?>
                                    <?php if (!empty($product['category_name'])): ?>
                                        <span class="d-block fw-semibold text-amber mt-1"><?= esc($product['category_name']) ?></span>
                                    <?php endif; ?>
                                </p>

                                <div class="d-flex align-items-center justify-content-between gap-2 pt-3 border-top" style="border-color: var(--border-tile) !important;">
                                    <span class="h5 fw-bold text-primary mb-0 tabular-nums" style="font-family: 'Hanken Grotesk', sans-serif;">
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

<!-- Section 4: Deep Espresso Roast Story Band -->
<section id="about" class="landing-band pt-3">
    <div class="container">
        <div class="story-espresso-band p-4 p-lg-5 scroll-reveal">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-6">
                    <img src="<?= base_url('assets/images/logo_and_bg/cafe-bg.jpg') ?>" class="img-fluid w-100 object-fit-cover rounded-4 shadow-lg" alt="Warm wooden table inside Pacudan's Bakeshop & Coffee Bar" style="height: 380px;" loading="lazy" decoding="async">
                </div>
                <div class="col-lg-6">
                    <h2 class="section-heading text-white mb-3">A family kitchen turned <span class="coffee-italic" style="color: var(--ember-light);">Mambajao's coffee bar.</span></h2>
                    <p class="mb-4" style="color: var(--cream-tint);">
                        Pacudan's Bakeshop &amp; Coffee Bar began as a small family dream right here in Camiguin. Every morning starts with warm trays of brioche ensaymada, layered custard cakes, and freshly pulled espresso for island neighbors and travelers.
                    </p>
                    <ul class="list-unstyled small border-top mb-4" style="border-color: rgba(235, 220, 207, 0.2) !important; color: var(--cream-tint);">
                        <li class="py-2 border-bottom d-flex align-items-center gap-2" style="border-color: rgba(235, 220, 207, 0.14) !important;">
                            <i class="bi bi-check2 fw-bold" style="color: var(--ember-light);"></i>
                            <span>Small-batch breads, cupcakes, and custard cakes baked every morning</span>
                        </li>
                        <li class="py-2 border-bottom d-flex align-items-center gap-2" style="border-color: rgba(235, 220, 207, 0.14) !important;">
                            <i class="bi bi-check2 fw-bold" style="color: var(--ember-light);"></i>
                            <span>Custom celebration cakes available for birthdays and family gatherings</span>
                        </li>
                        <li class="py-2 border-bottom d-flex align-items-center gap-2" style="border-color: rgba(235, 220, 207, 0.14) !important;">
                            <i class="bi bi-check2 fw-bold" style="color: var(--ember-light);"></i>
                            <span>Free Cash on Delivery across Mambajao with live order status updates</span>
                        </li>
                    </ul>
                    <a href="<?= base_url('menu') ?>" class="btn btn-amber px-4 py-2">Start Your Order</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section 5: Visit Our Shop -->
<section id="location" class="landing-band pt-3">
    <div class="container">
        <div class="surface-panel p-4 p-lg-5 scroll-reveal">
            <div class="row g-4 g-lg-5 align-items-center">
                <div class="col-lg-5">
                    <h2 class="section-heading mb-3">Visit Our Shop in <span class="coffee-italic text-ember-pop">Mambajao</span></h2>
                    <p class="text-muted mb-4">Dine in for fresh espresso and warm pastries, pick up a celebration cake, or call the counter directly.</p>

                    <div class="d-grid gap-3 mb-4">
                        <div class="d-flex align-items-start gap-3">
                            <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 42px; height: 42px; background: var(--espresso-deep);">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                            <div>
                                <h3 class="h6 mb-0">Address</h3>
                                <p class="text-muted small mb-0">Mambajao, Camiguin Island, Philippines</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 42px; height: 42px; background: var(--espresso-deep);">
                                <i class="bi bi-clock"></i>
                            </span>
                            <div>
                                <h3 class="h6 mb-0">Hours</h3>
                                <p class="text-muted small mb-0 tabular-nums">Monday – Sunday · 8:00 AM – 9:00 PM</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 42px; height: 42px; background: var(--espresso-deep);">
                                <i class="bi bi-telephone"></i>
                            </span>
                            <div>
                                <h3 class="h6 mb-0">Direct Counter Line</h3>
                                <p class="text-muted small mb-0">
                                    <a href="tel:09639216585" class="text-decoration-none text-dark fw-bold tabular-nums">0963 921 6585</a><br>
                                    <a href="mailto:pacudanscoffee@gmail.com" class="text-decoration-none text-muted">pacudanscoffee@gmail.com</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <a href="https://maps.google.com/?q=Pacudan's+Bakeshop,+Mambajao,+Camiguin" target="_blank" rel="noopener" class="btn btn-outline-primary">
                        <i class="bi bi-map me-2"></i>Open in Google Maps
                    </a>
                </div>

                <div class="col-lg-7">
                    <div id="mapFacadeContainer" class="position-relative overflow-hidden rounded-4 border" style="height: 400px; border-color: var(--border-tile) !important; background: #EFE5D8;">
                        <!-- Zero-network inline SVG map preview; mounts live Google Maps only when clicked -->
                        <svg viewBox="0 0 720 400" preserveAspectRatio="xMidYMid slice" class="w-100 h-100 d-block" aria-hidden="true">
                            <rect width="720" height="400" fill="#EFE5D8"/>
                            <path d="M0 0 H720 V118 C590 142 465 92 315 112 C180 130 92 98 0 120 Z" fill="#DDE7E5"/>
                            <path d="M0 245 Q180 218 360 228 T720 198" stroke="#FAF4EB" stroke-width="18" fill="none"/>
                            <path d="M0 245 Q180 218 360 228 T720 198" stroke="#D5C4B2" stroke-width="2" stroke-dasharray="8 8" fill="none"/>
                            <path d="M235 95 L268 400 M485 105 L445 400 M120 330 L620 292" stroke="#FAF4EB" stroke-width="10" fill="none"/>
                            <rect x="292" y="160" width="62" height="36" rx="6" fill="#E3D4C3"/>
                            <rect x="385" y="254" width="76" height="44" rx="6" fill="#E3D4C3"/>
                            <rect x="165" y="264" width="54" height="34" rx="6" fill="#E3D4C3"/>
                            <circle cx="360" cy="212" r="46" fill="#C84122" fill-opacity="0.14"/>
                            <circle cx="360" cy="212" r="24" fill="#C84122" fill-opacity="0.22"/>
                            <path d="M360 162 C341 162 326 177 326 196 C326 220 360 250 360 250 C360 250 394 220 394 196 C394 177 379 162 360 162 Z" fill="#C84122"/>
                            <circle cx="360" cy="195" r="12" fill="#FAF4EB"/>
                            <text x="360" y="92" text-anchor="middle" fill="#6F8A86" font-family="Hanken Grotesk, sans-serif" font-size="13" font-weight="700" letter-spacing="3">CAMIGUIN COAST</text>
                            <text x="360" y="274" text-anchor="middle" fill="#331E14" font-family="Young Serif, Georgia, serif" font-size="17">Pacudan's Bakeshop &amp; Coffee Bar</text>
                            <text x="360" y="294" text-anchor="middle" fill="#5C463A" font-family="Hanken Grotesk, sans-serif" font-size="13" font-weight="600">Mambajao, Camiguin Island</text>
                        </svg>
                        <div class="position-absolute bottom-0 start-0 end-0 p-3 d-flex justify-content-center">
                            <button type="button" id="loadLiveMapBtn" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                                <i class="bi bi-geo-alt-fill me-2"></i>Load Interactive Map
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Scroll-triggered reveal transitions (IntersectionObserver, zero dependencies)
    (function() {
        const els = document.querySelectorAll('.scroll-reveal');
        if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            els.forEach(el => el.classList.add('is-visible'));
            return;
        }
        document.documentElement.classList.add('has-scroll-reveal');
        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.14, rootMargin: '0px 0px -40px 0px' });

        els.forEach(el => io.observe(el));
    })();

    // Mount live Google Maps iframe only when user clicks the SVG map facade
    const loadMapBtn = document.getElementById('loadLiveMapBtn');
    if (loadMapBtn) {
        loadMapBtn.addEventListener('click', function() {
            const box = document.getElementById('mapFacadeContainer');
            if (!box) return;
            box.innerHTML = '<iframe title="Pacudan\'s Bakeshop &amp; Coffee Bar Map" src="https://maps.google.com/maps?q=Pacudan\'s%20Bakeshop,%20Mambajao,%20Camiguin&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="100%" style="border: 0;" allowfullscreen=""></iframe>';
        });
    }

    // 0ms Optimistic Quick-Add on Today's Counter Picks with verified 200 OK sync
    document.querySelectorAll('.home-quick-add').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('.quick-add-btn');
            if (!btn || btn.dataset.busy === '1') return;

            const originalHtml = btn.innerHTML;
            const desktopCounter = document.getElementById('cart-counter');
            const prevCount = desktopCounter ? (parseInt(desktopCounter.textContent, 10) || 0) : 0;

            btn.dataset.busy = '1';
            updateBagCounters(prevCount + 1);
            btn.style.backgroundColor = 'var(--ember-bold)';
            btn.style.borderColor = 'var(--ember-bold)';
            btn.innerHTML = '<i class="bi bi-check2 me-1"></i>Added';

            const resetTimer = setTimeout(() => {
                btn.style.backgroundColor = '';
                btn.style.borderColor = '';
                btn.innerHTML = originalHtml;
                btn.dataset.busy = '0';
            }, 900);

            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    const d = document.getElementById('cart-counter');
                    const m = document.getElementById('cart-counter-mobile');
                    if (d) d.textContent = data.cart_count;
                    if (m) m.textContent = data.cart_count;
                    Toast.fire({ icon: 'success', title: data.message || 'Added to bag!' });
                } else {
                    throw new Error(data.message || 'Could not add item.');
                }
            })
            .catch(err => {
                clearTimeout(resetTimer);
                updateBagCounters(prevCount);
                btn.style.backgroundColor = '';
                btn.style.borderColor = '';
                btn.innerHTML = originalHtml;
                btn.dataset.busy = '0';
                Toast.fire({ icon: 'error', title: err.message || 'Could not add item.' });
            });
        });
    });
</script>

<style>
    /* Full-Viewport Opening Screen */
    .editorial-hero {
        background-color: var(--cream-bg);
        min-height: calc(100svh - 76px);
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        padding-bottom: 36px;
    }

    .landing-band {
        padding: 84px 0;
        scroll-margin-top: 76px;
    }

    .hero-display {
        font-family: 'Young Serif', Georgia, serif;
        font-size: clamp(2.4rem, 4.3vw, 3.95rem);
        line-height: 1.08;
        letter-spacing: -0.02em;
        color: var(--ink-main);
    }

    .hero-display .coffee-italic {
        font-size: 1.14em;
        line-height: 1;
    }

    .section-heading {
        font-family: 'Young Serif', Georgia, serif;
        font-size: clamp(1.85rem, 3vw, 2.55rem);
        line-height: 1.14;
    }

    .section-heading .coffee-italic {
        font-size: 1.12em;
    }

    .text-ember-pop {
        color: var(--ember-bold);
    }

    .hero-lead {
        font-size: 1.1rem;
        line-height: 1.65;
        color: var(--ink-muted);
        max-width: 46ch;
    }

    /* Instant first-frame hero paint (no opacity:0 delay that feels like lag) */
    .hero-collage {
        display: grid;
        grid-template-columns: 1.35fr 0.95fr;
        grid-template-rows: 268px 268px;
        gap: 14px;
    }

    .hero-scroll-cue {
        position: absolute;
        bottom: 18px;
        left: 50%;
        transform: translateX(-50%);
        color: var(--ink-muted);
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.02em;
        transition: color 0.2s ease, transform 0.25s ease;
    }

    .hero-scroll-cue:hover {
        color: var(--ember-bold);
        transform: translate(-50%, 3px);
    }

    /* Scroll-Triggered Section & Card Transitions */
    .has-scroll-reveal .scroll-reveal {
        opacity: 0;
        transform: translateY(24px);
        transition:
            opacity 0.55s cubic-bezier(0.16, 1, 0.3, 1) var(--reveal-delay, 0ms),
            transform 0.6s cubic-bezier(0.16, 1, 0.3, 1) var(--reveal-delay, 0ms);
    }

    .has-scroll-reveal .scroll-reveal.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .collage-frame {
        position: relative;
        overflow: hidden;
        border-radius: 22px;
        border: 1px solid var(--border-tile);
        box-shadow: 0 14px 32px rgba(51, 30, 20, 0.1);
        display: block;
        background: var(--cream-soft);
    }

    .collage-main {
        grid-row: 1 / 3;
    }

    .collage-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.55s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .collage-frame:hover .collage-img {
        transform: scale(1.05);
    }

    .collage-caption {
        position: absolute;
        left: 16px;
        right: 16px;
        bottom: 16px;
        background: rgba(250, 244, 235, 0.96);
        box-shadow: 0 8px 22px rgba(36, 20, 13, 0.14);
        padding: 12px 16px;
        border-radius: 14px;
        border: 1px solid var(--border-tile);
    }

    .collage-tag {
        position: absolute;
        left: 14px;
        bottom: 14px;
        background: var(--espresso-deep);
        color: var(--cream-bg);
        font-weight: 700;
        font-size: 0.82rem;
        padding: 7px 14px;
        border-radius: 999px;
        box-shadow: 0 6px 16px rgba(36, 20, 13, 0.24);
    }

    .collage-tag-ember {
        background: var(--ember-bold);
        color: #FFFDF9;
    }

    /* Visual Photo Category Shelf */
    .cat-visual-card {
        width: 166px;
        background: var(--card-bg);
        border: 1px solid var(--border-tile);
        border-radius: 16px;
        overflow: hidden;
        transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.2s ease, box-shadow 0.28s ease;
    }

    .cat-visual-card:hover {
        transform: translateY(-4px);
        border-color: var(--ember-bold);
        box-shadow: 0 12px 24px rgba(51, 30, 20, 0.1);
    }

    .cat-visual-thumb-wrap {
        height: 112px;
        overflow: hidden;
        background: var(--cream-soft);
    }

    .cat-visual-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s ease;
    }

    .cat-visual-card:hover .cat-visual-thumb {
        transform: scale(1.06);
    }

    /* Deep Espresso Story Band */
    .story-espresso-band {
        background-color: var(--espresso-deep);
        border-radius: 26px;
        border-bottom: 6px solid var(--ember-bold);
        box-shadow: 0 18px 42px rgba(36, 20, 13, 0.16);
    }

    .counter-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(51, 30, 20, 0.1);
    }

    .counter-thumb {
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .counter-card:hover .counter-thumb {
        transform: scale(1.04);
    }

    @media (max-width: 991.98px) {
        .editorial-hero {
            min-height: auto;
            padding-bottom: 24px;
        }
        .landing-band {
            padding: 56px 0;
        }
        .hero-collage {
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 260px 180px;
        }
        .collage-main {
            grid-column: 1 / 3;
            grid-row: 1 / 2;
        }
    }
</style>

<?= $this->endSection() ?>
