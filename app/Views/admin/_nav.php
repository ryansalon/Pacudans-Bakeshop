<?php $adminPath = preg_replace('#^index\.php/?#', '', trim(uri_string(), '/')); ?>
<nav class="admin-subnav" aria-label="Admin sections">
    <a href="<?= base_url('admin') ?>" class="<?= $adminPath === 'admin' ? 'active' : '' ?>">
        <i class="bi bi-speedometer2"></i>Dashboard
    </a>
    <a href="<?= base_url('admin/orders') ?>" class="<?= strpos($adminPath, 'admin/orders') === 0 ? 'active' : '' ?>">
        <i class="bi bi-receipt"></i>Orders
    </a>
    <a href="<?= base_url('admin/products') ?>" class="<?= $adminPath === 'admin/products' ? 'active' : '' ?>">
        <i class="bi bi-box-seam"></i>Inventory
    </a>
    <a href="<?= base_url('admin/products/add') ?>" class="<?= $adminPath === 'admin/products/add' ? 'active' : '' ?>">
        <i class="bi bi-plus-circle"></i>Add Product
    </a>
</nav>
