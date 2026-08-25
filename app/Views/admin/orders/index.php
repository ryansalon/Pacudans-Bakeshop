<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <!-- Dashboard Header & Filters -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 reveal" style="margin-top: 100px;">
        <div>
            <h6 class="text-primary fw-bold text-uppercase mb-2 tracking-widest" style="letter-spacing: 2px;">Transactions</h6>
            <h2 class="display-5 mb-0 fw-bold">Customer Orders</h2>
        </div>
            
            <!-- Date Filter & Badge -->
            <div class="d-flex align-items-center gap-3 mt-4 mt-md-0">
                <input type="date" class="form-control rounded-pill border-0 shadow-sm px-4" id="dateFilter" placeholder="Filter by Date">
                <span class="badge bg-white text-dark shadow-sm border rounded-pill px-4 py-3">Total Orders: <?= count($orders) ?></span>
            </div>
        </div>

        <div class="card p-4 border-0 shadow-lg rounded-5 bg-white reveal mb-5" style="min-height: 450px; padding-bottom: 100px !important;">
            <div class="table-responsive" style="overflow: visible;">
                <table class="table table-hover align-middle mb-0">
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
                        <?php 
                            $currentDate = null;
                            foreach ($orders as $order): 
                                $orderDate = date('Y-m-d', strtotime($order['created_at']));
                                if ($orderDate !== $currentDate): 
                                    $currentDate = $orderDate;
                                    $dailyTotal = 0;
                                    foreach ($orders as $o) {
                                        if (date('Y-m-d', strtotime($o['created_at'])) === $orderDate) $dailyTotal += $o['total_amount'];
                                    }
                        ?>
                            <tr class="date-group-header" data-date="<?= $orderDate ?>">
                                <td colspan="6" class="bg-light fw-bold text-primary py-3">
                                    <div class="d-flex justify-content-between">
                                        <span><?= date('F d, Y', strtotime($orderDate)) ?></span>
                                        <span class="badge bg-secondary">Daily Revenue: ₱<?= number_format($dailyTotal, 2) ?></span>
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
