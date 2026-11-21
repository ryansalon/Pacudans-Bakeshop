<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<?php
    $st = strtolower($order['status']);
    $badgeClass = $st === 'pending' ? 'bg-warning text-dark' : ($st === 'completed' ? 'bg-success' : 'bg-danger');
?>

<div class="container py-4">
    <?= $this->include('admin/_nav') ?>

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-4">
        <div>
            <h1 class="display-5 mb-1 fw-bold tabular-nums">Order #<?= $order['order_id'] ?></h1>
            <p class="text-muted mb-0 tabular-nums">Placed on <?= date('M d, Y · h:i A', strtotime($order['created_at'])) ?></p>
        </div>
        <a href="<?= base_url('admin/orders') ?>" class="btn btn-outline-primary rounded-pill px-4 align-self-start align-self-sm-end">
            <i class="bi bi-arrow-left me-2"></i>Back to Orders
        </a>
    </div>

    <div class="row g-5 align-items-start">
        <div class="col-lg-8">
            <div class="surface-panel p-4 p-md-5">
                <h2 class="h4 fw-bold mb-4">Purchased Items</h2>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-muted small text-uppercase">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?= esc($item['product_name']) ?></div>
                                        <?php if (!empty($item['size'])): ?>
                                            <span class="badge bg-soft text-primary border small rounded-pill px-2"><?= esc($item['size']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="tabular-nums">₱<?= number_format($item['price'], 2) ?></td>
                                    <td class="tabular-nums"><?= (int) $item['quantity'] ?></td>
                                    <td class="text-end fw-bold tabular-nums">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold pt-4 text-muted">Total Amount</td>
                                <td class="text-end fw-bold pt-4 h4 text-primary tabular-nums">₱<?= number_format($order['total_amount'], 2) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4 d-grid gap-4">
            <div class="surface-panel p-4">
                <h2 class="h5 fw-bold mb-3">Customer &amp; Delivery</h2>
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-soft rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold text-primary" style="width: 46px; height: 46px;">
                        <?= esc(strtoupper(substr((string) $order['customer_name'], 0, 1))) ?>
                    </div>
                    <div>
                        <h3 class="h6 mb-0 fw-bold"><?= esc($order['customer_name']) ?></h3>
                        <small class="text-muted"><?= esc($order['customer_email']) ?></small>
                    </div>
                </div>
                <div class="surface-subtle p-3 small d-grid gap-2">
                    <div>
                        <span class="text-muted d-block">Phone</span>
                        <strong class="tabular-nums"><?= esc(!empty($order['customer_phone']) ? $order['customer_phone'] : 'No phone provided') ?></strong>
                    </div>
                    <div>
                        <span class="text-muted d-block">Delivery Address</span>
                        <strong><?= esc(!empty($order['customer_address']) ? $order['customer_address'] : 'No address provided') ?></strong>
                    </div>
                </div>
            </div>

            <div class="surface-panel p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 fw-bold mb-0">Order Status</h2>
                    <span class="badge rounded-pill px-3 py-2 <?= $badgeClass ?>">
                        <?= esc(ucfirst($order['status'])) ?>
                    </span>
                </div>

                <?php if ($st === 'pending'): ?>
                    <form action="<?= base_url('admin/orders/update-status') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                        <div class="mb-3">
                            <label for="orderStatusSelect" class="form-label small text-muted text-uppercase fw-bold">Update Status</label>
                            <select id="orderStatusSelect" name="status" class="form-select bg-soft border-0 rounded-pill py-2 px-3">
                                <option value="pending" selected>Pending</option>
                                <option value="completed">Completed (Ready for Delivery)</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">Save Status</button>
                    </form>
                <?php else: ?>
                    <div class="surface-subtle p-3 small mb-0 text-muted">
                        <i class="bi bi-info-circle me-2"></i>This order is marked <strong><?= esc($order['status']) ?></strong> and is locked from further changes.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
