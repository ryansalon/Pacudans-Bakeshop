<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="section-padding">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5 reveal">
            <div>
                <h6 class="text-primary fw-bold text-uppercase mb-2 tracking-widest" style="letter-spacing: 2px;">Management</h6>
                <h2 class="display-5 mb-0 fw-bold">Admin Dashboard</h2>
            </div>
            <div class="text-muted">Welcome back, <?= session()->get('name') ?></div>
        </div>

        <!-- Stats Grid -->
        <div class="row g-4 mb-5 reveal">
            <div class="col-md-4">
                <div class="card p-4 border-0 shadow-sm text-center bg-white h-100">
                    <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-cart-check fs-3 text-primary"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= $total_orders ?></h3>
                    <p class="text-muted small mb-0">Total Orders</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 border-0 shadow-sm text-center bg-white h-100">
                    <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-hourglass-split fs-3 text-warning"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= $pending_orders ?></h3>
                    <p class="text-muted small mb-0">Pending Orders</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 border-0 shadow-sm text-center bg-white h-100">
                    <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-cup-hot fs-3 text-success"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= $total_products ?></h3>
                    <p class="text-muted small mb-0">Active Menu Items</p>
                </div>
            </div>
        </div>

        <!-- Analytics Section -->
        <div class="row g-4 mb-5 reveal">
            <!-- Revenue Board -->
            <div class="col-lg-6">
                <div class="card p-4 border-0 shadow-sm bg-white h-100">
                    <h5 class="fw-bold mb-4">Revenue Board</h5>
                    <div class="d-flex justify-content-between mb-4">
                        <div class="text-center p-3 border rounded-4 flex-fill me-2">
                            <div class="small text-muted mb-1">Weekly</div>
                            <div class="fw-bold text-primary">₱<?= number_format($revenue['weekly'], 2) ?></div>
                        </div>
                        <div class="text-center p-3 border rounded-4 flex-fill mx-2 bg-light">
                            <div class="small text-muted mb-1">Monthly</div>
                            <div class="fw-bold text-primary">₱<?= number_format($revenue['monthly'], 2) ?></div>
                        </div>
                        <div class="text-center p-3 border rounded-4 flex-fill ms-2">
                            <div class="small text-muted mb-1">Yearly</div>
                            <div class="fw-bold text-primary">₱<?= number_format($revenue['yearly'], 2) ?></div>
                        </div>
                    </div>
                    <canvas id="revenueChart" height="200"></canvas>
                </div>
            </div>

            <!-- Product Popularity -->
            <div class="col-lg-6">
                <div class="card p-4 border-0 shadow-sm bg-white h-100">
                    <h5 class="fw-bold mb-4">Product Popularity</h5>
                    <ul class="nav nav-pills nav-fill mb-4 bg-light p-1 rounded-pill" id="popularityTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active rounded-pill px-4" id="top-tab" data-bs-toggle="pill" data-bs-target="#top-5" type="button">Top 5</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link rounded-pill px-4" id="bottom-tab" data-bs-toggle="pill" data-bs-target="#bottom-5" type="button">Bottom 5</button>
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
