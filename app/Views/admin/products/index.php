<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="mb-5 reveal" style="margin-top: 100px;">
                <h6 class="text-primary fw-bold text-uppercase mb-2 tracking-widest" style="letter-spacing: 2px;">Inventory Hub</h6>
                <h2 class="display-5 mb-0 fw-bold">Manage by Category</h2>
            </div>

            <?php if (session()->getFlashdata('msg')): ?>
                <div class="alert alert-success rounded-pill border-0 shadow-sm mb-4 px-4"><?= session()->getFlashdata('msg') ?></div>
            <?php endif; ?>

            <!-- Category "Floating Boxes" Grid -->
            <div class="row g-4 mb-5 reveal">
                <?php 
                $groupedProducts = [];
                foreach ($products as $product) {
                    $groupedProducts[$product['category_name']][] = $product;
                }

                foreach ($groupedProducts as $catName => $items): 
                    $icon = 'bi-cup-hot';
                    $name_lower = strtolower($catName);
                    if(strpos($name_lower, 'ice') !== false) $icon = 'bi-snow';
                    elseif(strpos($name_lower, 'frappe') !== false) $icon = 'bi-cup-straw';
                    elseif(strpos($name_lower, 'smoothie') !== false) $icon = 'bi-water';
                    elseif(strpos($name_lower, 'cake') !== false) $icon = 'bi-cake2';
                    elseif(strpos($name_lower, 'bread') !== false || strpos($name_lower, 'pastri') !== false) $icon = 'bi-egg-fried';
                    elseif(strpos($name_lower, 'sandwich') !== false || strpos($name_lower, 'savory') !== false) $icon = 'bi-egg-fill';
                ?>                <div class="col-md-3">
                    <div class="card p-4 border-0 shadow-sm text-center h-100 category-card" 
                         onclick="showCategory('<?= url_title($catName) ?>')" 
                         style="cursor: pointer;">
                        <div class="bg-soft rounded-4 mx-auto mb-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 70px; height: 70px; background: var(--bg-soft);">
                            <i class="bi <?= $icon ?> fs-2 text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-1"><?= esc($catName) ?></h5>
                        <p class="text-muted small mb-0"><?= count($items) ?> Products</p>
                        <div class="mt-3 text-primary small fw-bold">Click to Manage <i class="bi bi-chevron-down"></i></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Product Lists -->
        <div id="category-details">
            <?php foreach ($groupedProducts as $catName => $items): ?>
                <div class="category-section d-none" id="cat-<?= url_title($catName) ?>">
                    <div class="card p-5 border-0 shadow-lg rounded-5 bg-white reveal">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold mb-0 text-primary"><?= esc($catName) ?></h3>
                            <div class="d-flex align-items-center gap-3">
                                <a href="<?= base_url('admin/products/add') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                    <i class="bi bi-plus-circle me-2"></i> Add New Item
                                </a>
                                <button class="btn btn-light btn-sm rounded-pill px-3" onclick="hideAll()">Close <i class="bi bi-x"></i></button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="text-muted small text-uppercase">
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $product): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-light rounded-3 me-3 d-flex align-items-center justify-content-center border" style="width: 45px; height: 45px; overflow: hidden;">
                                                        <?php if ($product['image_url']): ?>
                                                            <img src="<?= base_url($product['image_url']) ?>" class="h-100 w-100 object-fit-cover">
                                                        <?php else: ?>
                                                            <i class="bi bi-image opacity-10"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                    <span class="fw-bold"><?= esc($product['name']) ?></span>
                                                </div>
                                            </td>
                                            <td class="fw-bold">₱<?= number_format($product['price'], 2) ?></td>
                                            <td class="text-end">
                                                <button class="btn btn-light btn-sm rounded-circle p-2 mx-1 text-primary shadow-sm border"><i class="bi bi-pencil-square"></i></button>
                                                <button class="btn btn-light btn-sm rounded-circle p-2 mx-1 text-danger shadow-sm border"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    function showCategory(id) {
        const sections = document.querySelectorAll('.category-section');
        sections.forEach(s => s.classList.add('d-none'));
        const selected = document.getElementById('cat-' + id);
        if (selected) {
            selected.classList.remove('d-none');
            selected.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function hideAll() {
        const sections = document.querySelectorAll('.category-section');
        sections.forEach(s => s.classList.add('d-none'));
    }
</script>

<style>
    .category-card { 
        background: #FDF9F3; 
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1); 
    }
    .category-card:hover { 
        background: transparent; 
        transform: scale(1.05); 
        box-shadow: 0 15px 30px rgba(74, 49, 33, 0.15) !important;
    }
    .category-card:hover h5, .category-card:hover p, .category-card:hover .text-primary { 
        color: var(--accent-color) !important; 
    }
</style>

<?= $this->endSection() ?>
