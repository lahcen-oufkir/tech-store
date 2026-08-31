<h1 class="section-title">My Dashboard</h1>
<p class="text-secondary">Welcome back, <strong><?= e($user['name']) ?></strong>.</p>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-bag-check stat-icon text-primary"></i>
                <div>
                    <div class="h4 mb-0"><?= count($orders) ?></div>
                    <span class="text-secondary small">Orders</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-wrench-adjustable stat-icon text-success"></i>
                <div>
                    <div class="h4 mb-0"><?= count($repairs) ?></div>
                    <span class="text-secondary small">Repair requests</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-person stat-icon text-info"></i>
                <div>
                    <div class="h4 mb-0"><?= e($user['email']) ?></div>
                    <span class="text-secondary small">Account email</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0 fw-bold">Recent Orders</h5>
                <a href="<?= url('customer/orders') ?>" class="small">View all</a>
            </div>
            <?php if (empty($orders)): ?>
                <p class="text-secondary small mb-0">No orders yet. <a href="<?= url('products') ?>">Start shopping</a></p>
            <?php else: ?>
                <table class="table table-sm align-middle mb-0">
                    <tbody>
                        <?php foreach (array_slice($orders, 0, 5) as $order): ?>
                            <tr>
                                <td class="small"><?= e($order['order_number']) ?></td>
                                <td class="small"><?= money($order['total']) ?></td>
                                <td><?= statusBadge($order['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0 fw-bold">Repair Requests</h5>
                <a href="<?= url('customer/repairs') ?>" class="small">View all</a>
            </div>
            <?php if (empty($repairs)): ?>
                <p class="text-secondary small mb-0">No repair requests. <a href="<?= url('repair/create') ?>">Request a repair</a></p>
            <?php else: ?>
                <table class="table table-sm align-middle mb-0">
                    <tbody>
                        <?php foreach (array_slice($repairs, 0, 5) as $request): ?>
                            <tr>
                                <td class="small">#<?= (int) $request['id'] ?> - <?= e(ucfirst($request['device_type'])) ?></td>
                                <td><?= statusBadge($request['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
