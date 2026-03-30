<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-end mb-5 reveal">
                    <div>
                        <h6 class="text-primary fw-bold text-uppercase mb-2 tracking-widest" style="letter-spacing: 2px;">Inventory</h6>
                        <h2 class="display-5 mb-0 fw-bold">Add New Product</h2>
                    </div>
                    <a href="<?= base_url('admin/products') ?>" class="text-decoration-none fw-bold small"><i class="bi bi-arrow-left me-2"></i>Back to Inventory</a>
                </div>

                <div class="card p-5 border-0 shadow-lg rounded-5 bg-white reveal">
                    <?php if (session()->getFlashdata('validation')): ?>
                        <div class="alert alert-danger rounded-4 mb-4">
                            <?= session()->getFlashdata('validation')->listErrors() ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/products/store') ?>" method="post">
                        <div class="row g-4">
                            <div class="col-md-8">
                                <label class="form-label small fw-bold text-uppercase">Product Name</label>
                                <input type="text" name="name" class="form-control bg-light border-0 rounded-pill py-3 px-4" placeholder="e.g. Hazelnut Latte" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-uppercase">Price (₱)</label>
                                <input type="number" name="price" class="form-control bg-light border-0 rounded-pill py-3 px-4" placeholder="0.00" step="0.01" required>
                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold text-uppercase">Category</label>
                                <select name="category_id" class="form-select bg-light border-0 rounded-pill py-3 px-4" required>
                                    <option value="" disabled selected>Select Category</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['category_id'] ?>"><?= esc($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase">Description</label>
                                <textarea name="description" class="form-control bg-light border-0 rounded-4 py-3 px-4" rows="3" placeholder="Describe this delicious item..."></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase">Image URL (Optional)</label>
                                <input type="text" name="image_url" class="form-control bg-light border-0 rounded-pill py-3 px-4" placeholder="https://example.com/image.jpg">
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3 shadow-lg">
                                <i class="bi bi-cloud-upload me-2"></i> Save Product to Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
