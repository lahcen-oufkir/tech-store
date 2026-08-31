<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Order <?= e($order['order_number']) ?></h1>
    <a href="<?= url('admin/orders') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card p-3 mb-4">
            <h5 class="fw-bold mb-3">Items</h5>
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td><?= e($item['product_name']) ?></td>
                            <td class="text-center"><?= (int) $item['quantity'] ?></td>
                            <td class="text-end"><?= money($item['price']) ?></td>
                            <td class="text-end"><?= money($item['price'] * $item['quantity']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-end mt-3">
                <strong>Total: <span class="price"><?= money($order['total']) ?></span></strong>
            </div>
        </div>

        <?php if ($order['notes']): ?>
            <div class="card p-3 mb-4">
                <h6 class="fw-bold">Customer notes</h6>
                <p class="text-secondary mb-0"><?= e($order['notes']) ?></p>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-lg-4">
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-3">Customer</h5>
            <p class="mb-1"><strong><?= e($order['customer_name']) ?></strong></p>
            <p class="mb-1 small"><i class="bi bi-envelope me-1"></i><?= e($order['customer_email']) ?></p>
            <p class="mb-1 small"><i class="bi bi-telephone me-1"></i><?= e($order['customer_phone']) ?></p>
            <p class="mb-0 small"><i class="bi bi-geo-alt me-1"></i><?= e($order['shipping_address']) ?></p>
        </div>

        <div class="card p-4">
            <h5 class="fw-bold mb-3">Update status</h5>
            <form method="post" action="<?= url('admin/orders/updateStatus/' . $order['id']) ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <select name="status" class="form-select">
                        <?php foreach (['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'] as $status): ?>
                            <option value="<?= $status ?>" <?= $order['status'] === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button class="btn btn-primary w-100"><i class="bi bi-arrow-repeat"></i> Update Status</button>
            </form>
            <hr>
            <p class="small text-secondary mb-0">
                Payment: <?= ucwords(str_replace('_', ' ', $order['payment_method'])) ?><br>
                Placed: <?= date('d M Y H:i', strtotime($order['created_at'])) ?>
            </p>
        </div>
    </div>
</div>
