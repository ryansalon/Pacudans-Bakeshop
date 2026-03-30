<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="section-padding">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5 reveal">
            <div>
                <h6 class="text-primary fw-bold text-uppercase mb-2 tracking-widest" style="letter-spacing: 2px;">Transactions</h6>
                <h2 class="display-5 mb-0 fw-bold">Customer Orders</h2>
            </div>
            <span class="badge bg-white text-dark shadow-sm border rounded-pill px-4 py-3">Total Orders: <?= count($orders) ?></span>
        </div>

        <!-- Added pb-5 to ensure dropdowns on the last row have space to show fully -->
        <div class="card p-4 border-0 shadow-lg rounded-5 bg-white reveal mb-5" style="min-height: 450px; padding-bottom: 100px !important;">
            <div class="table-responsive" style="overflow: visible;">
                <table class="table table-hover align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Date & Time</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td class="fw-bold text-primary">#<?= $order['order_id'] ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-soft rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold text-primary shadow-sm" style="width: 40px; height: 40px; background: var(--bg-soft);">
                                            <?= strtoupper(substr($order['customer_name'], 0, 1)) ?>
                                        </div>
                                        <span class="fw-semibold"><?= esc($order['customer_name']) ?></span>
                                    </div>
                                </td>
                                <td class="text-muted small"><?= date('M d, Y | h:i A', strtotime($order['created_at'])) ?></td>
                                <td class="fw-bold">₱<?= number_format($order['total_amount'], 2) ?></td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 bg-<?= strtolower($order['status']) == 'pending' ? 'warning text-dark' : (strtolower($order['status']) == 'completed' ? 'success' : 'danger') ?>">
                                        <?= ucfirst($order['status']) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm rounded-pill px-4 border shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Manage
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 rounded-4 p-2" style="z-index: 1050; min-width: 200px;">
                                            <li>
                                                <a class="dropdown-item rounded-3 mb-1 py-2" href="<?= base_url('admin/orders/' . $order['order_id']) ?>">
                                                    <i class="bi bi-eye me-2 text-primary"></i> View Details
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider opacity-10"></li>
                                            <li>
                                                <form action="<?= base_url('admin/orders/update-status') ?>" method="post">
                                                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="dropdown-item rounded-3 mb-1 py-2 text-success fw-bold">
                                                        <i class="bi bi-check-circle me-2"></i> Mark Completed
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="<?= base_url('admin/orders/update-status') ?>" method="post">
                                                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="dropdown-item rounded-3 py-2 text-danger">
                                                        <i class="bi bi-x-circle me-2"></i> Cancel Order
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Ensure the table container doesn't clip the dropdown menu */
    .table-responsive {
        overflow: visible !important;
    }
    
    .dropdown-item:active {
        background-color: var(--primary-mocha) !important;
    }
</style>

<?= $this->endSection() ?>
