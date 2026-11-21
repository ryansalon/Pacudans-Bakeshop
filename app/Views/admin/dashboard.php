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
                    <div class="tab-content" id="popularityTabContent">
                        <div class="tab-pane fade show active" id="top-5">
                            <canvas id="topProductsChart" height="200"></canvas>
                        </div>
                        <div class="tab-pane fade" id="bottom-5">
                            <canvas id="bottomProductsChart" height="200"></canvas>
                        </div>
                    </div>
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
                                    <th>Customer Name</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th class="text-end">Action</th>
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
                                        <td class="small text-muted"><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></td>
                                        <td class="text-end">
                                            <a href="<?= base_url('admin/orders/' . $order['order_id']) ?>" class="btn btn-light btn-sm rounded-pill px-3 shadow-sm border">Details</a>
                                        </td>
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

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const revCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revCtx, {
        type: 'line',
        data: {
            labels: ['Weekly', 'Monthly', 'Yearly'],
            datasets: [{
                label: 'Revenue (₱)',
                data: [<?= $revenue['weekly'] ?>, <?= $revenue['monthly'] ?>, <?= $revenue['yearly'] ?>],
                borderColor: '#b08d57',
                backgroundColor: 'rgba(176, 141, 87, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Top Products Chart
    const topCtx = document.getElementById('topProductsChart').getContext('2d');
    new Chart(topCtx, {
        type: 'bar',
        data: {
            labels: [<?= implode(',', array_map(fn($p) => "'".esc($p['name'])."'", $top_products)) ?>],
            datasets: [{
                label: 'Quantity Sold',
                data: [<?= implode(',', array_column($top_products, 'total_sold')) ?>],
                backgroundColor: '#3d2b1f',
                borderRadius: 10
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    // Bottom Products Chart
    const bottomCtx = document.getElementById('bottomProductsChart').getContext('2d');
    new Chart(bottomCtx, {
        type: 'bar',
        data: {
            labels: [<?= implode(',', array_map(fn($p) => "'".esc($p['name'])."'", $bottom_products)) ?>],
            datasets: [{
                label: 'Quantity Sold',
                data: [<?= implode(',', array_column($bottom_products, 'total_sold')) ?>],
                backgroundColor: '#b08d57',
                borderRadius: 10
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    // Admin Notification (Task 2)
    let lastAdminCheck = '<?= date('Y-m-d H:i:s') ?>';
    setInterval(() => {
        fetch('<?= base_url('admin/notifications') ?>?last_check=' + encodeURIComponent(lastAdminCheck))
            .then(response => response.json())
            .then(data => {
                if (data.new_orders > 0) {
                    Swal.fire({
                        title: 'New Order Alert!',
                        text: `You have ${data.new_orders} new order(s).`,
                        icon: 'info',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: true,
                        confirmButtonText: 'Refresh Dashboard',
                        timer: 10000,
                        timerProgressBar: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                    lastAdminCheck = new Date(Date.now() - (new Date().getTimezoneOffset() * 60000)).toISOString().slice(0, 19).replace('T', ' ');
                }
            })
            .catch(err => console.error('Admin notification check failed', err));
    }, 15000); // Check every 15 seconds
</script>
<?= $this->endSection() ?>
