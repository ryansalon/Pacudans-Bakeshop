<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="section-padding">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5 reveal">
            <div>
                <h6 class="text-primary fw-bold text-uppercase mb-2 tracking-widest" style="letter-spacing: 2px;">Management</h6>
                <h2 class="display-5 mb-0 fw-bold">Admin Dashboard</h2>
            </div>
            <div class="text-muted">Welcome back, <?= session()->get('name') ?></div>
        </div>

        <!-- Stats Grid -->
        <div class="row g-4 mb-5 reveal">
            <div class="col-md-4">
                <div class="card p-4 border-0 shadow-sm text-center bg-white h-100">
                    <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-cart-check fs-3 text-primary"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= $total_orders ?></h3>
                    <p class="text-muted small mb-0">Total Orders</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 border-0 shadow-sm text-center bg-white h-100">
                    <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-hourglass-split fs-3 text-warning"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= $pending_orders ?></h3>
                    <p class="text-muted small mb-0">Pending Orders</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 border-0 shadow-sm text-center bg-white h-100">
                    <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-cup-hot fs-3 text-success"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= $total_products ?></h3>
                    <p class="text-muted small mb-0">Active Menu Items</p>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <!-- Quick Actions -->
            <div class="col-lg-4 reveal" style="transition-delay: 0.2s;">
                <div class="card p-4 border-0 shadow-sm bg-white rounded-4 mb-4">
                    <h5 class="fw-bold mb-4">Quick Actions</h5>
                    <div class="d-grid gap-3">
                        <a href="<?= base_url('admin/products/add') ?>" class="btn btn-primary rounded-pill py-3">
                            <i class="bi bi-plus-circle me-2"></i> Add New Product
                        </a>
                        <a href="<?= base_url('admin/products') ?>" class="btn btn-outline-dark rounded-pill py-3">
                            <i class="bi bi-list-ul me-2"></i> Manage Inventory
                        </a>
                        <a href="<?= base_url('admin/orders') ?>" class="btn btn-outline-dark rounded-pill py-3">
                            <i class="bi bi-receipt me-2"></i> View All Orders
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="col-lg-8 reveal" style="transition-delay: 0.4s;">
                <div class="card p-4 border-0 shadow-sm bg-white rounded-4">
                    <h5 class="fw-bold mb-4">Recent Orders</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="text-muted small text-uppercase">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_orders as $order): ?>
                                    <tr>
                                        <td class="fw-bold text-primary">#<?= $order['order_id'] ?></td>
                                        <td>
                                            <div class="small fw-bold"><?= esc($order['customer_name']) ?></div>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill bg-<?= $order['status'] == 'pending' ? 'warning text-dark' : ($order['status'] == 'completed' ? 'success' : 'danger') ?> px-3 py-2">
                                                <?= ucfirst($order['status']) ?>
                                            </span>
                                        </td>
                                        <td class="fw-bold">₱<?= number_format($order['total_amount'], 2) ?></td>
                                        <td><a href="<?= base_url('admin/orders/' . $order['order_id']) ?>" class="btn btn-light btn-sm rounded-pill px-3 shadow-sm border">Details</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
