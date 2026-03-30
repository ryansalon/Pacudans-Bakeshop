<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="section-padding">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5 reveal">
            <div>
                <h6 class="text-primary fw-bold text-uppercase mb-2 tracking-widest" style="letter-spacing: 2px;">Management</h6>
                <h2 class="display-5 mb-0 fw-bold">Order #<?= $order['order_id'] ?></h2>
            </div>
            <a href="<?= base_url('admin/orders') ?>" class="text-decoration-none fw-bold small"><i class="bi bi-arrow-left me-2"></i>Back to Orders</a>
        </div>

        <?php if (session()->getFlashdata('msg')): ?>
            <div class="alert alert-success rounded-pill border-0 shadow-sm mb-4 px-4"><?= session()->getFlashdata('msg') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger rounded-pill border-0 shadow-sm mb-4 px-4"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="row g-5">
            <div class="col-lg-8 reveal">
                <!-- Order Items -->
                <div class="card p-5 border-0 shadow-lg rounded-5 bg-white mb-4">
                    <h4 class="fw-bold mb-4">Purchased Items</h4>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="text-muted small text-uppercase">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
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
                                        <td>₱<?= number_format($item['price'], 2) ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td class="text-end fw-bold">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="border-top-0">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold pt-4">Total Amount:</td>
                                    <td class="text-end fw-bold pt-4 h4 text-primary">₱<?= number_format($order['total_amount'], 2) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 reveal" style="transition-delay: 0.2s;">
                <!-- Customer & Status Info -->
                <div class="card p-4 border-0 shadow-sm bg-white rounded-4 mb-4">
                    <h5 class="fw-bold mb-4">Customer Info</h5>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-soft rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold text-primary" style="width: 45px; height: 45px; background: var(--bg-soft);">
                            <?= strtoupper(substr($order['customer_name'], 0, 1)) ?>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold"><?= esc($order['customer_name']) ?></h6>
                            <small class="text-muted"><?= esc($order['customer_email']) ?></small>
                        </div>
                    </div>
                    <p class="small text-muted mb-0"><i class="bi bi-calendar-event me-2"></i>Placed on <?= date('M d, Y | h:i A', strtotime($order['created_at'])) ?></p>
                </div>

                <div class="card p-4 border-0 shadow-sm bg-white rounded-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Manage Status</h5>
                        <span class="badge rounded-pill px-3 py-2 bg-<?= strtolower($order['status']) == 'pending' ? 'warning text-dark' : (strtolower($order['status']) == 'completed' ? 'success' : 'danger') ?>">
                            <?= ucfirst($order['status']) ?>
                        </span>
                    </div>

                    <?php if ($order['status'] == 'pending'): ?>
                        <form action="<?= base_url('admin/orders/update-status') ?>" method="post">
                            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                            <div class="mb-4">
                                <label class="form-label small text-muted text-uppercase">Update To</label>
                                <select name="status" class="form-select bg-light border-0 rounded-pill py-2 px-3">
                                    <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                                    <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">Update Status</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-light border rounded-4 small mb-0">
                            <i class="bi bi-info-circle me-2"></i> This order is <strong><?= $order['status'] ?></strong> and can no longer be modified.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
