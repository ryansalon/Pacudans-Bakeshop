<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <?= $this->include('admin/_nav') ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-4">
                <div>
                    <h1 class="display-5 mb-1 fw-bold">Add New Product</h1>
                    <p class="text-muted mb-0">Publish a new drink, cake, or pastry to the Pacudan's storefront.</p>
                </div>
                <a href="<?= base_url('admin/products') ?>" class="btn btn-outline-primary rounded-pill px-4 align-self-start align-self-sm-end">
                    <i class="bi bi-arrow-left me-2"></i>Back to Inventory
                </a>
            </div>

            <div class="surface-panel p-4 p-md-5">
                <?php if (session()->getFlashdata('validation')): ?>
                    <div class="alert alert-danger rounded-4 mb-4 small border-0">
                        <?= session()->getFlashdata('validation')->listErrors() ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('admin/products/store') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label for="prod-name" class="form-label small fw-bold text-uppercase">Product Name</label>
                            <input type="text" id="prod-name" name="name" class="form-control bg-soft border-0 rounded-pill py-3 px-4" placeholder="e.g. Hazelnut Latte" value="<?= esc(old('name')) ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label for="prod-price" class="form-label small fw-bold text-uppercase">Price (₱)</label>
                            <input type="number" id="prod-price" name="price" class="form-control bg-soft border-0 rounded-pill py-3 px-4 tabular-nums" placeholder="0.00" step="0.01" min="0" value="<?= esc(old('price')) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="prod-category" class="form-label small fw-bold text-uppercase">Category</label>
                            <select id="prod-category" name="category_id" class="form-select bg-soft border-0 rounded-pill py-3 px-4" required>
                                <option value="" disabled <?= old('category_id') ? '' : 'selected' ?>>Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['category_id'] ?>" <?= (string) old('category_id') === (string) $cat['category_id'] ? 'selected' : '' ?>>
                                        <?= esc($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="prod-stock" class="form-label small fw-bold text-uppercase">Initial Stock Quantity</label>
                            <input type="number" id="prod-stock" name="stock_quantity" class="form-control bg-soft border-0 rounded-pill py-3 px-4 tabular-nums" min="0" value="<?= esc(old('stock_quantity') !== null ? old('stock_quantity') : '100') ?>" required>
                        </div>

                        <div class="col-12">
                            <label for="prod-desc" class="form-label small fw-bold text-uppercase">Description</label>
                            <textarea id="prod-desc" name="description" class="form-control bg-soft border-0 rounded-4 py-3 px-4" rows="3" placeholder="Describe ingredients, flavor notes, or serving style..."><?= esc(old('description')) ?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="prod-image-file" class="form-label small fw-bold text-uppercase">Upload Product Image</label>
                            <input type="file" id="prod-image-file" name="image_file" class="form-control bg-soft border-0 rounded-pill py-3 px-4" accept="image/*">
                        </div>

                        <div class="col-md-6">
                            <label for="prod-image-url" class="form-label small fw-bold text-uppercase">Or Asset Path (Optional)</label>
                            <input type="text" id="prod-image-url" name="image_url" class="form-control bg-soft border-0 rounded-pill py-3 px-4" placeholder="assets/images/cakes/ube_cake.jpg" value="<?= esc(old('image_url')) ?>">
                        </div>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3">
                            <i class="bi bi-cloud-upload me-2"></i>Save Product to Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
