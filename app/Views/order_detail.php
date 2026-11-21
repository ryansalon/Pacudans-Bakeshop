<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<?php
    $st = strtolower($order['status']);
    $badgeClass = $st === 'pending' ? 'bg-warning text-dark' : ($st === 'completed' ? 'bg-success' : 'bg-danger');
    $statusIcon = $st === 'pending' ? 'bi-clock' : ($st === 'completed' ? 'bi-check-circle' : 'bi-x-circle');
?>

<div class="container py-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-5">
        <div>
            <h1 class="display-5 mb-1 fw-bold tabular-nums">Order #<?= $order['order_id'] ?></h1>
            <p class="text-muted mb-0 tabular-nums">Placed on <?= date('M d, Y · h:i A', strtotime($order['created_at'])) ?></p>
        </div>
        <a href="<?= base_url('profile') ?>" class="btn btn-outline-primary rounded-pill px-4 align-self-start align-self-sm-end">
            <i class="bi bi-arrow-left me-2"></i>Back to Order History
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
                                        <div class="fw-bold text-dark"><?= esc($item['product_name']) ?></div>
                                        <?php if (!empty($item['size'])): ?>
                                            <span class="badge bg-soft text-primary border small rounded-pill px-2"><?= esc($item['size']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted tabular-nums">₱<?= number_format($item['price'], 2) ?></td>
                                    <td class="text-muted tabular-nums"><?= (int) $item['quantity'] ?></td>
                                    <td class="text-end fw-bold text-dark tabular-nums">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
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
                <h2 class="h5 fw-bold mb-3">Order Status</h2>
                <div class="text-center py-4 surface-subtle mb-3">
                    <span class="badge rounded-pill px-4 py-3 fs-6 <?= $badgeClass ?>">
                        <i class="bi <?= $statusIcon ?> me-2"></i><?= esc(ucfirst($order['status'])) ?>
                    </span>
                </div>
                <p class="small text-muted mb-0 text-center">
                    <?= $st === 'pending' ? 'Our kitchen is reviewing and preparing your order.' : ($st === 'completed' ? 'Completed and dispatched for delivery.' : 'This order was cancelled.') ?>
                </p>
            </div>

            <div class="surface-panel p-4">
                <h2 class="h5 fw-bold mb-2">Need Help?</h2>
                <p class="small text-muted mb-4">Have a question about delivery timing or an item in Order #<?= $order['order_id'] ?>? Reach our counter directly.</p>
                <div class="d-grid gap-2">
                    <a href="tel:09639216585" class="btn btn-primary rounded-pill">
                        <i class="bi bi-telephone me-2"></i>Call 0963 921 6585
                    </a>
                    <a href="mailto:pacudanscoffee@gmail.com?subject=Order%20%23<?= $order['order_id'] ?>%20Inquiry" class="btn btn-outline-primary rounded-pill">
                        <i class="bi bi-envelope me-2"></i>Email Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
