<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<?php
    $activeCatId = (int) ($activeCategoryId ?? (isset($category) ? $category['category_id'] : 0));
    $initialVisibleCount = 0;
    foreach ($products as $p) {
        if ($activeCatId === 0 || (int) $p['category_id'] === $activeCatId) {
            $initialVisibleCount++;
        }
    }
?>

<div id="menu-grid" class="container pt-4 pb-2">
    <!-- Menu Header & Live Search -->
    <div class="row align-items-end g-3 mb-2">
        <div class="col-lg-7">
            <h1 class="display-5 mb-2 fw-bold" id="menuPageTitle"><?= esc($title) ?></h1>
            <p class="text-muted mb-0" id="menuPageDesc">
                <?= isset($category) && !empty($category['description']) ? esc($category['description']) : 'Handcrafted espresso, blended drinks, and freshly baked Camiguin pastries.' ?>
            </p>
        </div>
        <div class="col-lg-5">
            <div class="input-group surface-panel p-1 rounded-pill">
                <span class="input-group-text bg-transparent border-0 ps-3 text-muted"><i class="bi bi-search"></i></span>
                <input type="search" id="menuSearchInput" class="form-control border-0 bg-transparent shadow-none" placeholder="Search coffee, cakes, pastries..." aria-label="Search menu items">
                <span class="badge bg-soft text-dark rounded-pill px-3 py-2 align-self-center me-2 tabular-nums" id="menuItemCount">
                    <?= $initialVisibleCount ?> <?= $initialVisibleCount === 1 ? 'item' : 'items' ?>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Sticky Horizontal Category Bar (0ms instant switching while scrolling) -->
<div class="sticky-category-bar mb-4" id="stickyCategoryBar">
    <div class="container">
        <div class="cat-strip-wrap">
            <nav class="d-flex align-items-center gap-2 overflow-auto py-3 pe-4" aria-label="Menu categories">
                <a href="<?= base_url('menu') ?>"
                   data-cat-id="0"
                   data-cat-title="Our Menu"
                   data-cat-desc="Handcrafted espresso, blended drinks, and freshly baked Camiguin pastries."
                   class="btn <?= $activeCatId === 0 ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill px-4 py-2 flex-shrink-0 menu-cat-pill">
                    All Delights
                </a>
                <?php foreach ($categories as $cat): ?>
                    <?php $isActiveCat = $activeCatId === (int) $cat['category_id']; ?>
                    <a href="<?= base_url('category/' . $cat['category_id']) ?>"
                       data-cat-id="<?= (int) $cat['category_id'] ?>"
                       data-cat-title="<?= esc($cat['name'], 'attr') ?>"
                       data-cat-desc="<?= esc($cat['description'] ?: 'Handcrafted espresso, blended drinks, and freshly baked Camiguin pastries.', 'attr') ?>"
                       class="btn <?= $isActiveCat ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill px-4 py-2 flex-shrink-0 menu-cat-pill">
                        <?= esc($cat['name']) ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>
    </div>
</div>

<div class="container pb-4">
    <?php if (empty($products)): ?>
        <div class="text-center py-5 surface-panel">
            <i class="bi bi-cup-hot fs-1 text-muted"></i>
            <h2 class="h4 mt-3">No items in the menu yet</h2>
            <p class="text-muted mx-auto mb-0">We are preparing fresh batches—check back shortly.</p>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="productGridContainer">
            <?php foreach ($products as $idx => $product): ?>
                <?php
                    $hasVariants = !empty($product['variant_count']) && (int) $product['variant_count'] > 0;
                    $displayPrice = ($hasVariants && $product['min_price'] !== null)
                        ? (float) $product['min_price']
                        : (float) $product['price'];
                    $inStock = (int) $product['stock_quantity'] > 0;
                    $matchesInitialCat = ($activeCatId === 0 || (int) $product['category_id'] === $activeCatId);
                ?>
                <div class="col menu-item-col <?= $matchesInitialCat ? '' : 'd-none' ?>"
                     style="--card-delay: <?= min($idx, 11) * 30 ?>ms;"
                     data-cat-id="<?= (int) $product['category_id'] ?>"
                     data-name="<?= esc(strtolower($product['name'] . ' ' . ($product['category_name'] ?? '') . ' ' . ($product['description'] ?? ''))) ?>">
                    <article class="card h-100 p-3 d-flex flex-column product-card">
                        <a href="<?= base_url('menu/' . $product['product_id']) ?>" class="position-relative d-block overflow-hidden rounded-3 mb-3 text-decoration-none">
                            <?php if ($product['image_url']): ?>
                                <img src="<?= base_url($product['image_url']) ?>" width="400" height="400" loading="<?= $idx < 4 ? 'eager' : 'lazy' ?>" decoding="async" class="w-100 object-fit-cover product-img" alt="<?= esc(rtrim((string) $product['name'], '*')) ?>" style="aspect-ratio: 1/1;">
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
                                <span class="h5 fw-bold text-primary mb-0 tabular-nums" style="font-family: 'Hanken Grotesk', sans-serif;">
                                    <?= $hasVariants ? 'From ' : '' ?>₱<?= number_format($displayPrice, 2) ?>
                                </span>
                                <a href="<?= base_url('menu/' . $product['product_id']) ?>" class="small fw-bold text-primary text-decoration-none customize-link">
                                    Customize <i class="bi bi-chevron-right customize-arrow"></i>
                                </a>
                            </div>

                            <?php if ($inStock): ?>
                                <form action="<?= base_url('cart/add') ?>" method="post" class="direct-add-form" data-product-name="<?= esc(rtrim((string) $product['name'], '*'), 'attr') ?>">
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

        <div id="noSearchMatches" class="text-center py-5 surface-panel <?= $initialVisibleCount > 0 ? 'd-none' : '' ?> mt-4">
            <i class="bi bi-search fs-2 text-muted"></i>
            <h3 class="h5 mt-3">No matching items found</h3>
            <p class="text-muted mx-auto mb-0">Try another category or clear your search term.</p>
        </div>
    <?php endif; ?>
</div>

<script>
    const stickyBar = document.getElementById('stickyCategoryBar');
    const siteNavbar = document.getElementById('mainNav');
    function syncStickyOffset() {
        if (!stickyBar || !siteNavbar) return;
        stickyBar.style.top = siteNavbar.offsetHeight + 'px';
    }
    syncStickyOffset();
    window.addEventListener('resize', syncStickyOffset, { passive: true });

    const activeCatPill = document.querySelector('#stickyCategoryBar a.btn-primary');
    if (activeCatPill) {
        activeCatPill.scrollIntoView({ inline: 'center', block: 'nearest', behavior: 'instant' });
    }

    // 0ms Instant Category + Search Filtering (zero reload latency)
    let currentCatId = <?= $activeCatId ?>;
    const searchInput = document.getElementById('menuSearchInput');
    const itemCols = document.querySelectorAll('.menu-item-col');
    const countBadge = document.getElementById('menuItemCount');
    const noMatchesEl = document.getElementById('noSearchMatches');
    const pageTitleEl = document.getElementById('menuPageTitle');
    const pageDescEl = document.getElementById('menuPageDesc');

    function applyMenuFilters(animateIn) {
        const q = searchInput ? searchInput.value.trim().toLowerCase() : '';
        let visible = 0;
        itemCols.forEach(col => {
            const catMatch = (currentCatId === 0 || Number(col.getAttribute('data-cat-id')) === currentCatId);
            const searchMatch = (!q || (col.getAttribute('data-name') || '').includes(q));
            const shouldShow = catMatch && searchMatch;
            col.classList.toggle('d-none', !shouldShow);
            if (shouldShow) {
                if (animateIn) {
                    col.style.setProperty('--card-delay', Math.min(visible, 8) * 24 + 'ms');
                    col.classList.remove('is-pop-in');
                    void col.offsetWidth;
                    col.classList.add('is-pop-in');
                }
                visible++;
            }
        });
        if (countBadge) countBadge.textContent = visible + (visible === 1 ? ' item' : ' items');
        if (noMatchesEl) noMatchesEl.classList.toggle('d-none', visible > 0);
    }

    document.querySelectorAll('.menu-cat-pill').forEach(pill => {
        pill.addEventListener('click', function(e) {
            if (e.metaKey || e.ctrlKey || e.shiftKey) return;
            e.preventDefault();
            const nextCatId = Number(this.getAttribute('data-cat-id') || 0);
            if (nextCatId === currentCatId) return;

            currentCatId = nextCatId;
            document.querySelectorAll('.menu-cat-pill').forEach(p => {
                p.classList.remove('btn-primary', 'is-tapped');
                p.classList.add('btn-outline-primary');
            });
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-primary', 'is-tapped');
            this.scrollIntoView({ inline: 'center', block: 'nearest', behavior: 'smooth' });

            if (pageTitleEl) pageTitleEl.textContent = this.getAttribute('data-cat-title') || 'Our Menu';
            if (pageDescEl) pageDescEl.textContent = this.getAttribute('data-cat-desc') || '';
            if (window.history && window.history.replaceState) {
                window.history.replaceState({ catId: currentCatId }, '', this.href);
            }

            applyMenuFilters(true);
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', () => applyMenuFilters(true));
    }

    // 0ms Optimistic Add-to-Bag with verified HTTP 200 OK sync
    document.querySelectorAll('.direct-add-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('.action-btn');
            if (!btn || btn.dataset.busy === '1') return;

            const originalHtml = btn.innerHTML;
            const productName = this.getAttribute('data-product-name') || 'Item';
            const desktopCounter = document.getElementById('cart-counter');
            const prevCount = desktopCounter ? (parseInt(desktopCounter.textContent, 10) || 0) : 0;

            // Instant 0ms UI feedback
            btn.dataset.busy = '1';
            updateBagCounters(prevCount + 1);
            btn.classList.add('is-added');
            btn.innerHTML = '<i class="bi bi-check2-circle me-1"></i>Added to Bag';

            const resetTimer = setTimeout(() => {
                btn.classList.remove('is-added');
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
                    Toast.fire({ icon: 'success', title: data.message || ('Added ' + productName + ' to bag.') });
                } else {
                    throw new Error(data.message || 'Could not add item.');
                }
            })
            .catch(err => {
                clearTimeout(resetTimer);
                updateBagCounters(prevCount);
                btn.classList.remove('is-added');
                btn.innerHTML = originalHtml;
                btn.dataset.busy = '0';
                Toast.fire({ icon: 'error', title: err.message || 'Could not add item.' });
            });
        });
    });
</script>

<style>
    .sticky-category-bar {
        position: sticky;
        top: 68px;
        z-index: 1020;
        background: var(--cream-bg);
        border-bottom: 1px solid var(--border-tile);
        box-shadow: 0 4px 14px rgba(51, 30, 20, 0.06);
    }

    .menu-cat-pill {
        transition: transform 0.16s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.18s ease, color 0.18s ease !important;
    }

    .menu-cat-pill:active {
        transform: scale(0.93) !important;
    }

    @keyframes pillTapPop {
        0% { transform: scale(0.93); }
        60% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .menu-cat-pill.is-tapped {
        animation: pillTapPop 0.24s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes menuCardIn {
        0% { opacity: 0; transform: translateY(14px) scale(0.985); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .menu-item-col {
        content-visibility: auto;
        contain-intrinsic-size: 360px;
    }

    .menu-item-col.is-pop-in {
        animation: menuCardIn 0.24s cubic-bezier(0.16, 1, 0.3, 1) var(--card-delay, 0ms) both;
    }

    .action-btn {
        transition: transform 0.14s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.2s ease, border-color 0.2s ease !important;
    }

    .action-btn:active {
        transform: scale(0.95) !important;
    }

    @keyframes btnSuccessPop {
        0% { transform: scale(0.95); }
        50% { transform: scale(1.04); }
        100% { transform: scale(1); }
    }

    .action-btn.is-added {
        background-color: var(--ember-bold) !important;
        border-color: var(--ember-bold) !important;
        color: #FFFDF9 !important;
        animation: btnSuccessPop 0.32s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .customize-arrow {
        display: inline-block;
        transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .customize-link:hover .customize-arrow,
    .customize-link:active .customize-arrow {
        transform: translateX(4px);
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 32px rgba(51, 30, 20, 0.1);
    }

    .product-img {
        transition: transform 0.35s ease;
    }

    .product-card:hover .product-img {
        transform: scale(1.04);
    }
</style>

<?= $this->endSection() ?>
