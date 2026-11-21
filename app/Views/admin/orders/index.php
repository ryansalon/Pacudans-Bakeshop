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
                            <?php
                                $st = strtolower($order['status']);
                                $badgeClass = $st === 'pending' ? 'bg-warning text-dark' : ($st === 'completed' ? 'bg-success' : 'bg-danger');
                            ?>
                            <tr class="date-group" data-date="<?= $orderDate ?>">
                                <td class="fw-bold text-primary tabular-nums">#<?= $order['order_id'] ?></td>
                                <td class="fw-semibold"><?= esc($order['customer_name']) ?></td>
                                <td class="text-muted small tabular-nums"><?= date('h:i A', strtotime($order['created_at'])) ?></td>
                                <td class="fw-bold tabular-nums">₱<?= number_format($order['total_amount'], 2) ?></td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 <?= $badgeClass ?>">
                                        <?= esc(ucfirst($order['status'])) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="<?= base_url('admin/orders/' . $order['order_id']) ?>" class="btn btn-primary btn-sm rounded-pill px-3">
                                        View Order
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div id="noSalesMsg" class="text-center py-5 d-none">
                <i class="bi bi-calendar-x fs-1 text-muted"></i>
                <h2 class="h5 mt-3">No orders on this date</h2>
                <p class="text-muted mx-auto mb-0">Try selecting another day or clear the date filter.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    const dateFilter = document.getElementById('dateFilter');
    const clearBtn = document.getElementById('clearDateFilter');
    const noSalesMsg = document.getElementById('noSalesMsg');

    function applyDateFilter() {
        const selectedDate = dateFilter ? dateFilter.value : '';
        const headers = document.querySelectorAll('.date-group-header');
        const rows = document.querySelectorAll('.date-group');
        let hasMatches = false;

        if (clearBtn) clearBtn.classList.toggle('d-none', !selectedDate);

        headers.forEach(h => {
            h.style.display = (!selectedDate || h.getAttribute('data-date') === selectedDate) ? '' : 'none';
        });

        rows.forEach(r => {
            const match = !selectedDate || r.getAttribute('data-date') === selectedDate;
            r.style.display = match ? '' : 'none';
            if (match) hasMatches = true;
        });

        if (noSalesMsg) {
            noSalesMsg.classList.toggle('d-none', !(selectedDate && !hasMatches));
        }
    }

    if (dateFilter) dateFilter.addEventListener('change', applyDateFilter);
    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            dateFilter.value = '';
            applyDateFilter();
        });
    }
</script>

<?= $this->endSection() ?>
