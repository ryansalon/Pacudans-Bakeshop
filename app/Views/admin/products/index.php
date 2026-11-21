<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<?php
    $groupedProducts = [];
    foreach ($products as $product) {
        $groupedProducts[$product['category_name']][] = $product;
    }
?>

<div class="container py-4">
    <?= $this->include('admin/_nav') ?>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
        <div>
            <h1 class="display-5 mb-1 fw-bold">Manage Inventory</h1>
            <p class="text-muted mb-0">Filter by category, monitor stock levels, and edit or remove products directly.</p>
        </div>
        <a href="<?= base_url('admin/products/add') ?>" class="btn btn-primary rounded-pill px-4 align-self-start align-self-md-end">
            <i class="bi bi-plus-circle me-2"></i>Add New Product
        </a>
    </div>

    <!-- Category Filter Pills (All visible by default so screen is never empty) -->
    <div class="d-flex flex-wrap gap-2 mb-4" id="inventoryFilterBar">
        <button type="button" class="btn btn-primary rounded-pill px-4 py-2 inv-cat-btn" data-cat="all">
            All Categories <span class="badge bg-white text-dark rounded-pill ms-1 tabular-nums"><?= count($products) ?></span>
        </button>
        <?php foreach ($groupedProducts as $catName => $items): ?>
            <button type="button" class="btn btn-outline-primary rounded-pill px-4 py-2 inv-cat-btn" data-cat="<?= esc(url_title($catName)) ?>">
                <?= esc($catName) ?> <span class="badge bg-soft text-dark rounded-pill ms-1 tabular-nums"><?= count($items) ?></span>
            </button>
        <?php endforeach; ?>
    </div>

    <!-- Inventory Table -->
    <div class="surface-panel p-3 p-md-4">
        <?php if (empty($products)): ?>
            <div class="text-center py-5">
                <i class="bi bi-box-seam fs-1 text-muted"></i>
                <h2 class="h5 mt-3">No products in inventory</h2>
                <p class="text-muted mx-auto mb-4">Add your first coffee or pastry to populate the store menu.</p>
                <a href="<?= base_url('admin/products/add') ?>" class="btn btn-primary rounded-pill px-4">Add New Product</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <?php
                                $stock = (int) $product['stock_quantity'];
                                $stockClass = $stock <= 0 ? 'bg-danger' : ($stock <= 10 ? 'bg-warning text-dark' : 'bg-success-subtle text-success');
                            ?>
                            <tr class="inv-row" data-cat="<?= esc(url_title($product['category_name'])) ?>">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-soft rounded-3 me-3 d-flex align-items-center justify-content-center border" style="width: 46px; height: 46px; overflow: hidden; flex-shrink: 0;">
                                            <?php if ($product['image_url']): ?>
                                                <img src="<?= base_url($product['image_url']) ?>" class="h-100 w-100 object-fit-cover" alt="<?= esc($product['name']) ?>">
                                            <?php else: ?>
                                                <i class="bi bi-image text-muted"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold"><?= esc($product['name']) ?></div>
                                            <small class="text-muted d-block text-truncate" style="max-width: 280px;"><?= esc($product['description']) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-soft text-primary border rounded-pill px-3 py-2"><?= esc($product['category_name']) ?></span></td>
                                <td class="fw-bold tabular-nums">₱<?= number_format($product['price'], 2) ?></td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 tabular-nums <?= $stockClass ?>">
                                        <?= $stock > 0 ? $stock . ' in stock' : 'Out of Stock' ?>
                                    </span>
                                </td>
                                <td class="text-end text-nowrap">
                                    <button type="button"
                                            class="btn btn-outline-primary btn-sm rounded-pill px-3 me-1 edit-product-btn"
                                            data-id="<?= $product['product_id'] ?>"
                                            data-name="<?= esc($product['name'], 'attr') ?>"
                                            data-category="<?= $product['category_id'] ?>"
                                            data-price="<?= $product['price'] ?>"
                                            data-stock="<?= $stock ?>"
                                            data-description="<?= esc($product['description'] ?? '', 'attr') ?>"
                                            data-image="<?= esc($product['image_url'] ?? '', 'attr') ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editProductModal">
                                        <i class="bi bi-pencil-square me-1"></i>Edit
                                    </button>
                                    <form action="<?= base_url('admin/products/delete/' . $product['product_id']) ?>" method="post" class="d-inline delete-product-form" data-name="<?= esc($product['name'], 'attr') ?>">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            <i class="bi bi-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h2 class="h5 modal-title fw-bold" id="editProductModalLabel">Edit Product</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/products/update') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" id="edit-product-id">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="edit-name" class="form-label small fw-bold text-uppercase">Product Name</label>
                            <input type="text" id="edit-name" name="name" class="form-control bg-soft border-0 rounded-pill py-2 px-3" required>
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
