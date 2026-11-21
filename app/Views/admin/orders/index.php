<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<?php
    // Precompute daily totals in a single O(N) pass, excluding cancelled orders
    $dailyTotals = [];
    foreach ($orders as $o) {
        $d = date('Y-m-d', strtotime($o['created_at']));
        if (!isset($dailyTotals[$d])) {
            $dailyTotals[$d] = 0.0;
        }
        if (strtolower($o['status']) !== 'cancelled') {
            $dailyTotals[$d] += (float) $o['total_amount'];
        }
    }
?>

<div class="container py-4">
    <?= $this->include('admin/_nav') ?>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
        <div>
            <h1 class="display-5 mb-1 fw-bold">Customer Orders</h1>
            <p class="text-muted mb-0">Filter orders by date and open any transaction to approve or update status.</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <input type="date" class="form-control rounded-pill px-3" id="dateFilter" aria-label="Filter orders by date" style="width: auto;">
            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 d-none" id="clearDateFilter">Clear Date</button>
            <span class="badge bg-soft text-dark border rounded-pill px-3 py-2 tabular-nums">
                Total: <?= count($orders) ?>
            </span>
        </div>
    </div>

    <div class="surface-panel p-3 p-md-4">
        <?php if (empty($orders)): ?>
            <div class="text-center py-5">
                <i class="bi bi-receipt fs-1 text-muted"></i>
                <h2 class="h5 mt-3">No customer orders yet</h2>
                <p class="text-muted mx-auto mb-0">Orders placed by customers will appear here grouped by date.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Time</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $currentDate = null;
                            foreach ($orders as $order):
                                $orderDate = date('Y-m-d', strtotime($order['created_at']));
                                if ($orderDate !== $currentDate):
                                    $currentDate = $orderDate;
                        ?>
                            <tr class="date-group-header" data-date="<?= $orderDate ?>">
                                <td colspan="6" class="bg-soft fw-bold text-primary py-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                        <span><?= date('F d, Y', strtotime($orderDate)) ?></span>
                                        <span class="badge bg-white text-dark border rounded-pill px-3 py-2 tabular-nums">
                                            Daily Revenue: ₱<?= number_format($dailyTotals[$orderDate] ?? 0, 2) ?>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                            <tr class="date-group" data-date="<?= $orderDate ?>">
                                <td class="fw-bold text-primary">#<?= $order['order_id'] ?></td>
                                <td><?= esc($order['customer_name']) ?></td>
                                <td class="text-muted small"><?= date('h:i A', strtotime($order['created_at'])) ?></td>
                                <td class="fw-bold">₱<?= number_format($order['total_amount'], 2) ?></td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 bg-<?= strtolower($order['status']) == 'pending' ? 'warning text-dark' : 'success' ?>">
                                        <?= ucfirst($order['status']) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm rounded-pill px-4 dropdown-toggle" type="button" data-bs-toggle="dropdown">Manage</button>
                                        <ul class="dropdown-menu dropdown-menu-end p-2">
                                            <li><a class="dropdown-item" href="<?= base_url('admin/orders/' . $order['order_id']) ?>">View Details</a></li>
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
<script>
    document.getElementById('dateFilter').addEventListener('change', function() {
        const selectedDate = this.value;
        const headers = document.querySelectorAll('.date-group-header');
        const rows = document.querySelectorAll('.date-group');
        let hasMatches = false;

        // Reset visibility
        document.querySelectorAll('tr').forEach(el => el.style.display = "");

        if (selectedDate !== "") {
            headers.forEach(h => {
                if (h.getAttribute('data-date') !== selectedDate) {
                    h.style.display = "none";
                }
            });
            rows.forEach(r => {
                if (r.getAttribute('data-date') !== selectedDate) {
                    r.style.display = "none";
                } else {
                    hasMatches = true;
                }
            });
        }

        let emptyMsg = document.getElementById('noSalesMsg');
        if (!emptyMsg) {
            emptyMsg = document.createElement('div');
            emptyMsg.id = 'noSalesMsg';
            emptyMsg.className = 'text-center py-5';
            emptyMsg.innerHTML = '<i class="bi bi-cart-x fs-1 text-muted"></i><h4 class="mt-3">No sales for this date.</h4>';
            document.querySelector('.card').appendChild(emptyMsg);
        }
        emptyMsg.style.display = (selectedDate !== "" && !hasMatches) ? '' : 'none';
    });
</script>
<style>
    .table-responsive { overflow: visible !important; }
    .dropdown-item:active { background-color: var(--primary-mocha) !important; }
</style>

<?= $this->endSection() ?>
