<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <?= $this->include('admin/_nav') ?>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4">
        <div>
            <h1 class="display-5 mb-1 fw-bold">Admin Dashboard</h1>
            <p class="text-muted mb-0">Welcome back, <?= esc(session()->get('name')) ?>. Live store metrics and pending fulfillment.</p>
        </div>
        <a href="<?= base_url('admin/products/add') ?>" class="btn btn-amber rounded-pill px-4 align-self-start align-self-md-end">
            <i class="bi bi-plus-circle me-2"></i>Add Product
        </a>
    </div>

    <!-- Store Summary Strip -->
    <div class="surface-panel p-4 mb-4">
        <div class="row g-4 text-center text-md-start">
            <div class="col-md-4 border-end-md" style="border-color: var(--border-warm) !important;">
                <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
                    <div class="bg-soft rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bi bi-cart-check fs-4 text-primary"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Orders</div>
                        <div class="h3 fw-bold mb-0 tabular-nums"><?= (int) $total_orders ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 border-end-md" style="border-color: var(--border-warm) !important;">
                <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
                    <div class="bg-soft rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bi bi-hourglass-split fs-4 text-warning"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Pending Approval</div>
                        <div class="h3 fw-bold mb-0 tabular-nums"><?= (int) $pending_orders ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
                    <div class="bg-soft rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bi bi-cup-hot fs-4 text-success"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Active Menu Items</div>
                        <div class="h3 fw-bold mb-0 tabular-nums"><?= (int) $total_products ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="surface-panel p-4 h-100">
                <h2 class="h5 fw-bold mb-3">Revenue Board (Excluding Cancelled)</h2>
                <div class="row g-2 mb-4">
                    <div class="col-4">
                        <div class="text-center p-3 surface-subtle">
                            <div class="small text-muted mb-1">7 Days</div>
                            <div class="fw-bold text-primary tabular-nums">₱<?= number_format($revenue['weekly'], 2) ?></div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center p-3 surface-subtle">
                            <div class="small text-muted mb-1">30 Days</div>
                            <div class="fw-bold text-primary tabular-nums">₱<?= number_format($revenue['monthly'], 2) ?></div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center p-3 surface-subtle">
                            <div class="small text-muted mb-1">365 Days</div>
                            <div class="fw-bold text-primary tabular-nums">₱<?= number_format($revenue['yearly'], 2) ?></div>
                        </div>
                    </div>
                </div>
                <canvas id="revenueChart" height="190"></canvas>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="surface-panel p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 fw-bold mb-0">Product Popularity</h2>
                    <ul class="nav nav-pills bg-soft p-1 rounded-pill" id="popularityTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active rounded-pill px-3 py-1 small" id="top-tab" data-bs-toggle="pill" data-bs-target="#top-5" type="button">Top 5</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link rounded-pill px-3 py-1 small" id="bottom-tab" data-bs-toggle="pill" data-bs-target="#bottom-5" type="button">Bottom 5</button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="popularityTabContent">
                    <div class="tab-pane fade show active" id="top-5">
                        <canvas id="topProductsChart" height="205"></canvas>
                    </div>
                    <div class="tab-pane fade" id="bottom-5">
                        <canvas id="bottomProductsChart" height="205"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="surface-panel p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 fw-bold mb-0">Recent Orders</h2>
            <a href="<?= base_url('admin/orders') ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">View All Orders</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="text-muted small text-uppercase">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recent_orders)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No orders have been placed yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recent_orders as $order): ?>
                            <?php
                                $st = strtolower($order['status']);
                                $badgeClass = $st === 'pending' ? 'bg-warning text-dark' : ($st === 'completed' ? 'bg-success' : 'bg-danger');
                            ?>
                            <tr>
                                <td class="fw-bold text-primary tabular-nums">#<?= $order['order_id'] ?></td>
                                <td class="fw-semibold"><?= esc($order['customer_name']) ?></td>
                                <td>
                                    <span class="badge rounded-pill <?= $badgeClass ?> px-3 py-2">
                                        <?= esc(ucfirst($order['status'])) ?>
                                    </span>
                                </td>
                                <td class="fw-bold tabular-nums">₱<?= number_format($order['total_amount'], 2) ?></td>
                                <td class="small text-muted tabular-nums"><?= date('M d, Y · h:i A', strtotime($order['created_at'])) ?></td>
                                <td class="text-end">
                                    <a href="<?= base_url('admin/orders/' . $order['order_id']) ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">View Order</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const revCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revCtx, {
        type: 'line',
        data: {
            labels: ['7 Days', '30 Days', '365 Days'],
            datasets: [{
                label: 'Revenue (₱)',
                data: [<?= (float) $revenue['weekly'] ?>, <?= (float) $revenue['monthly'] ?>, <?= (float) $revenue['yearly'] ?>],
                borderColor: '#D97706',
                backgroundColor: 'rgba(217, 119, 6, 0.14)',
                fill: true,
                tension: 0.35
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    const topLabels = <?= json_encode(array_column($top_products, 'name')) ?>;
    const topData = <?= json_encode(array_map('intval', array_column($top_products, 'total_sold'))) ?>;
    new Chart(document.getElementById('topProductsChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: topLabels,
            datasets: [{
                label: 'Quantity Sold',
                data: topData,
                backgroundColor: '#143B31',
                borderRadius: 8
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    const bottomLabels = <?= json_encode(array_column($bottom_products, 'name')) ?>;
    const bottomData = <?= json_encode(array_map('intval', array_column($bottom_products, 'total_sold'))) ?>;
    new Chart(document.getElementById('bottomProductsChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: bottomLabels,
            datasets: [{
                label: 'Quantity Sold',
                data: bottomData,
                backgroundColor: '#D97706',
                borderRadius: 8
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    let lastAdminCheck = '<?= date('Y-m-d H:i:s') ?>';
    setInterval(() => {
        fetch('<?= base_url('admin/notifications') ?>?last_check=' + encodeURIComponent(lastAdminCheck))
            .then(response => response.json())
            .then(data => {
                if (data.new_orders > 0) {
                    Swal.fire({
                        title: 'New Order Received',
                        text: `You have ${data.new_orders} new order(s) waiting for review.`,
                        icon: 'info',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: true,
                        confirmButtonText: 'Refresh',
                        timer: 10000,
                        timerProgressBar: true
                    }).then((result) => {
                        if (result.isConfirmed) window.location.reload();
                    });
                    lastAdminCheck = new Date(Date.now() - (new Date().getTimezoneOffset() * 60000)).toISOString().slice(0, 19).replace('T', ' ');
                }
            })
            .catch(err => console.error('Admin notification check failed', err));
    }, 15000);
</script>
<?= $this->endSection() ?>
