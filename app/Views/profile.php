<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row g-5 align-items-start">
        <div class="col-lg-4">
            <div class="surface-panel p-4 p-md-5 text-center">
                <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white fw-bold" style="width: 84px; height: 84px; font-size: 2.1rem; background-color: var(--jade-deep);">
                    <?= esc(strtoupper(substr((string) $user['name'], 0, 1))) ?>
                </div>
                <h1 class="h3 fw-bold mb-1"><?= esc($user['name']) ?></h1>
                <p class="text-muted small mb-3"><?= esc($user['email']) ?></p>
                <span class="badge rounded-pill bg-soft text-primary border px-3 py-2 mb-4 text-uppercase fw-bold"><?= esc($user['role']) ?> Account</span>

                <div class="text-start surface-subtle p-3 mb-4 small">
                    <div class="mb-2">
                        <span class="text-muted d-block">Phone</span>
                        <strong class="tabular-nums"><?= esc(!empty($user['phone']) ? $user['phone'] : 'Not set yet') ?></strong>
                    </div>
                    <div>
                        <span class="text-muted d-block">Default Delivery Address</span>
                        <strong><?= esc(!empty($user['address']) ? $user['address'] : 'Not set yet') ?></strong>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary rounded-pill" type="button" data-bs-toggle="collapse" data-bs-target="#editProfileCollapse" aria-expanded="false" aria-controls="editProfileCollapse">
                        <i class="bi bi-pencil-square me-2"></i>Edit Profile &amp; Address
                    </button>
                    <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger rounded-pill">
                        <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                    </a>
                </div>

                <div class="collapse mt-4 text-start" id="editProfileCollapse">
                    <form action="<?= base_url('profile/update') ?>" method="post" class="pt-3 border-top" style="border-color: var(--border-tile) !important;">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="profile-name" class="form-label small fw-bold">Full Name</label>
                            <input type="text" id="profile-name" name="name" class="form-control bg-soft border-0 rounded-pill px-3 py-2" value="<?= esc($user['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="profile-phone" class="form-label small fw-bold">Phone Number</label>
                            <input type="tel" id="profile-phone" name="phone" class="form-control bg-soft border-0 rounded-pill px-3 py-2 tabular-nums" value="<?= esc($user['phone'] ?? '') ?>" placeholder="0963 921 6585">
                        </div>
                        <div class="mb-3">
                            <label for="profile-address" class="form-label small fw-bold">Delivery Address</label>
                            <textarea id="profile-address" name="address" class="form-control bg-soft border-0 rounded-4 px-3 py-2" rows="2" placeholder="Street, Barangay, Mambajao"><?= esc($user['address'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill w-100 py-2">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="h3 fw-bold mb-1">Order History</h2>
                    <p class="text-muted small mb-0">Track active deliveries and review past purchases.</p>
                </div>
                <a href="<?= base_url('menu') ?>" class="btn btn-amber btn-sm rounded-pill px-3">New Order</a>
            </div>

            <?php if (empty($orders)): ?>
                <div class="surface-panel p-5 text-center">
                    <i class="bi bi-bag-x display-4 text-muted"></i>
                    <h3 class="h4 mt-3">No orders yet</h3>
                    <p class="text-muted mx-auto mb-4">Treat yourself to freshly brewed coffee or warm pastries from our menu.</p>
                    <a href="<?= base_url('menu') ?>" class="btn btn-primary rounded-pill px-5">Browse Menu</a>
                </div>
            <?php else: ?>
                <div class="surface-panel p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="text-muted small text-uppercase">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="text-end">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <?php
                                        $st = strtolower($order['status']);
                                        $badgeClass = $st === 'pending' ? 'bg-warning text-dark' : ($st === 'completed' ? 'bg-success' : 'bg-danger');
                                    ?>
                                    <tr>
                                        <td class="fw-bold text-primary tabular-nums">#<?= $order['order_id'] ?></td>
                                        <td class="small text-muted tabular-nums"><?= date('M d, Y · h:i A', strtotime($order['created_at'])) ?></td>
                                        <td class="fw-bold tabular-nums">₱<?= number_format($order['total_amount'], 2) ?></td>
                                        <td>
                                            <span class="badge rounded-pill px-3 py-2 <?= $badgeClass ?>">
                                                <?= esc(ucfirst($order['status'])) ?>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="<?= base_url('profile/order/' . $order['order_id']) ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">View Order</a>
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

<?= $this->endSection() ?>
