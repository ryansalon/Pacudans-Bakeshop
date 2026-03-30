<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="section-padding">
    <div class="container">
        <div class="row g-5">
            <!-- Profile Info Card -->
            <div class="col-lg-4 reveal">
                <div class="card p-5 border-0 shadow-lg rounded-5 bg-white text-center">
                    <div class="bg-primary rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center text-white fw-bold shadow-lg" style="width: 100px; height: 100px; font-size: 2.5rem;">
                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                    </div>
                    <h3 class="fw-bold mb-1"><?= esc($user['name']) ?></h3>
                    <p class="text-muted small mb-4"><?= esc($user['email']) ?></p>
                    <span class="badge rounded-pill bg-light text-primary border px-4 py-2 mb-4 text-uppercase fw-bold" style="letter-spacing: 1px;"><?= $user['role'] ?> Account</span>
                    
                    <hr class="opacity-10 my-4">
                    
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary rounded-pill">Edit Profile</button>
                        <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger rounded-pill">Logout</a>
                    </div>
                </div>
            </div>

            <!-- Order History Section -->
            <div class="col-lg-8 reveal" style="transition-delay: 0.2s;">
                <h4 class="fw-bold mb-4"><i class="bi bi-clock-history me-2 text-primary"></i>My Order History</h4>
                
                <?php if (empty($orders)): ?>
                    <div class="card p-5 border-0 shadow-sm rounded-5 bg-white text-center">
                        <i class="bi bi-bag-x display-1 opacity-10"></i>
                        <h4 class="mt-4">No orders yet</h4>
                        <p class="text-muted">Treat yourself to something sweet from our menu today!</p>
                        <a href="<?= base_url('menu') ?>" class="btn btn-primary rounded-pill px-5 mt-3">Browse Menu</a>
                    </div>
                <?php else: ?>
                    <div class="card p-4 border-0 shadow-lg rounded-5 bg-white">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="text-muted small text-uppercase">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td class="fw-bold text-primary">#<?= $order['order_id'] ?></td>
                                            <td class="small text-muted"><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                            <td class="fw-bold">₱<?= number_format($order['total_amount'], 2) ?></td>
                                            <td>
                                                <span class="badge rounded-pill px-3 py-2 bg-<?= strtolower($order['status']) == 'pending' ? 'warning text-dark' : (strtolower($order['status']) == 'completed' ? 'success' : 'danger') ?>">
                                                    <?= ucfirst($order['status']) ?>
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="<?= base_url('profile/order/' . $order['order_id']) ?>" class="btn btn-light btn-sm rounded-pill px-3 shadow-sm border">Details</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
