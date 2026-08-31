<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Customer: <?= e($customer['name']) ?></h1>
    <a href="<?= url('admin/customers') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">Profile</h5>
            <p class="mb-1"><i class="bi bi-person me-1"></i><?= e($customer['name']) ?></p>
            <p class="mb-1 small"><i class="bi bi-envelope me-1"></i><?= e($customer['email']) ?></p>
            <p class="mb-1 small"><i class="bi bi-telephone me-1"></i><?= e($customer['phone'] ?: '-') ?></p>
            <p class="mb-0 small"><i class="bi bi-geo-alt me-1"></i><?= e($customer['address'] ?: '-') ?></p>
            <hr>
            <p class="small text-secondary mb-0">Member since <?= date('F Y', strtotime($customer['created_at'])) ?></p>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card p-3">
            <h5 class="fw-bold mb-3">Order history</h5>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><a href="<?= url('admin/orders/show/' . $order['id']) ?>"><?= e($order['order_number']) ?></a></td>
                                <td><?= money($order['total']) ?></td>
                                <td class="small"><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                                <td><?= statusBadge($order['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($orders)): ?><tr><td colspan="4" class="text-secondary">No orders.</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
