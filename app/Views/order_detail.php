<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="section-padding">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5 reveal">
            <div>
                <h6 class="text-primary fw-bold text-uppercase mb-2 tracking-widest" style="letter-spacing: 2px;">My Account</h6>
                <h2 class="display-5 mb-0 fw-bold">Order Details #<?= $order['order_id'] ?></h2>
            </div>
            <a href="<?= base_url('profile') ?>" class="btn btn-outline-primary rounded-pill px-4 fw-bold shadow-sm"><i class="bi bi-arrow-left me-2"></i>Back to History</a>
        </div>

        <div class="row g-5">
            <div class="col-lg-8 reveal">
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
                                            <div class="fw-bold text-dark"><?= esc($item['product_name']) ?></div>
                                            <?php if (!empty($item['size'])): ?>
                                                <span class="badge bg-soft text-primary border small rounded-pill px-2"><?= esc($item['size']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-muted">₱<?= number_format($item['price'], 2) ?></td>
                                        <td class="text-muted"><?= $item['quantity'] ?></td>
                                        <td class="text-end fw-bold text-dark">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="border-top-0">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold pt-4 text-muted">Total Paid:</td>
                                    <td class="text-end fw-bold pt-4 h4 text-primary">₱<?= number_format($order['total_amount'], 2) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 reveal" style="transition-delay: 0.2s;">
                <div class="card p-4 border-0 shadow-sm bg-white rounded-4 mb-4">
                    <h5 class="fw-bold mb-4">Order Status</h5>
                    <div class="text-center py-4 bg-light rounded-5 mb-3">
                        <span class="badge rounded-pill px-4 py-3 fs-6 bg-<?= strtolower($order['status']) == 'pending' ? 'warning text-dark' : (strtolower($order['status']) == 'completed' ? 'success' : 'danger') ?>">
                            <i class="bi bi-<?= strtolower($order['status']) == 'pending' ? 'clock' : (strtolower($order['status']) == 'completed' ? 'check-circle' : 'x-circle') ?> me-2"></i>
                            <?= ucfirst($order['status']) ?>
                        </span>
                    </div>
                    <p class="small text-muted mb-0 text-center"><i class="bi bi-calendar-event me-2"></i>Placed on <?= date('M d, Y | h:i A', strtotime($order['created_at'])) ?></p>
                </div>

                <div class="card p-4 border-0 shadow-sm bg-white rounded-4">
                    <h5 class="fw-bold mb-3">Need Help?</h5>
                    <p class="small text-muted mb-4">If you have any questions regarding your order, please contact our support.</p>
                    <button class="btn btn-outline-primary w-100 rounded-pill"><i class="bi bi-chat-dots me-2"></i>Contact Us</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
