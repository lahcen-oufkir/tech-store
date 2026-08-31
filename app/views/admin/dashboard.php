<h1 class="h3 mb-4">Dashboard</h1>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card">
            <div class="card-body">
                <i class="bi bi-box-seam stat-icon text-primary"></i>
                <div class="h4 mb-0"><?= (int) $stats['products'] ?></div>
                <span class="text-secondary small">Products</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card">
            <div class="card-body">
                <i class="bi bi-tools stat-icon text-info"></i>
                <div class="h4 mb-0"><?= (int) $stats['services'] ?></div>
                <span class="text-secondary small">Services</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card">
            <div class="card-body">
                <i class="bi bi-cart-check stat-icon text-success"></i>
                <div class="h4 mb-0"><?= (int) $stats['orders'] ?></div>
                <span class="text-secondary small">Orders</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card">
            <div class="card-body">
                <i class="bi bi-cash-coin stat-icon text-warning"></i>
                <div class="h4 mb-0"><?= money($stats['revenue']) ?></div>
                <span class="text-secondary small">Revenue</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card">
            <div class="card-body">
                <i class="bi bi-people stat-icon text-secondary"></i>
                <div class="h4 mb-0"><?= (int) $stats['customers'] ?></div>
                <span class="text-secondary small">Customers</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card">
            <div class="card-body">
                <i class="bi bi-envelope stat-icon text-danger"></i>
                <div class="h4 mb-0"><?= (int) $stats['unread'] ?></div>
                <span class="text-secondary small">Unread messages</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold">Recent Orders</h5>
                <a href="<?= url('admin/orders') ?>" class="small">View all</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentOrders as $order): ?>
                            <tr>
                                <td><a href="<?= url('admin/orders/show/' . $order['id']) ?>"><?= e($order['order_number']) ?></a></td>
                                <td class="small"><?= e($order['customer_name']) ?></td>
                                <td class="small"><?= money($order['total']) ?></td>
                                <td><?= statusBadge($order['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($recentOrders)): ?><tr><td colspan="4" class="text-secondary">No orders yet.</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card p-3 h-100">
            <h5 class="fw-bold mb-3">Revenue - last 6 months</h5>
            <?php
                $rows = array_reverse($revenueByMonth);
                $max  = max(array_map(fn($r) => (float) $r['revenue'], $rows) ?: [1]);
            ?>
            <?php foreach ($rows as $row): ?>
                <div class="mb-2">
                    <div class="d-flex justify-content-between small">
                        <span><?= e($row['month']) ?></span>
                        <span class="text-secondary"><?= money($row['revenue']) ?></span>
                    </div>
                    <div class="progress" style="height:8px">
                        <div class="progress-bar" style="width: <?= max(2, (float) $row['revenue'] / $max * 100) ?>%"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-lg-6">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold">Recent Repairs</h5>
                <a href="<?= url('admin/repairs') ?>" class="small">View all</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <tbody>
                        <?php foreach ($recentRepairs as $request): ?>
                            <tr>
                                <td class="small">#<?= (int) $request['id'] ?> - <?= e($request['customer_name']) ?></td>
                                <td class="small text-secondary"><?= e(ucfirst($request['device_type'])) ?></td>
                                <td><?= statusBadge($request['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($recentRepairs)): ?><tr><td colspan="3" class="text-secondary">No repair requests yet.</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold">Latest Messages</h5>
                <a href="<?= url('admin/messages') ?>" class="small">View all</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <tbody>
                        <?php foreach ($recentMessages as $message): ?>
                            <tr>
                                <td class="small"><?= e($message['name']) ?></td>
                                <td class="small text-secondary"><?= e(mb_strimwidth($message['message'], 0, 50, '...')) ?></td>
                                <td>
                                    <?php if (!$message['is_read']): ?><span class="badge text-bg-danger">New</span><?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($recentMessages)): ?><tr><td colspan="3" class="text-secondary">No messages yet.</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
