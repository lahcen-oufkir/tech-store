<h1 class="section-title">My Orders</h1>

<?php if (empty($orders)): ?>
    <div class="alert alert-info">You have not placed any orders yet. <a href="<?= url('products') ?>" class="alert-link">Browse products</a></div>
<?php else: ?>
    <?php foreach ($orders as $order): ?>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <strong><?= e($order['order_number']) ?></strong>
                    <span class="text-secondary small ms-2"><?= date('d M Y H:i', strtotime($order['created_at'])) ?></span>
                </div>
                <div>
                    <?= statusBadge($order['status']) ?>
                    <span class="ms-2 small text-secondary"><?= ucwords(str_replace('_', ' ', $order['payment_method'])) ?></span>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm align-middle mb-3">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                            <tr>
                                <td><?= e($item['product_name']) ?></td>
                                <td class="text-center"><?= (int) $item['quantity'] ?></td>
                                <td class="text-end"><?= money($item['price']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="text-end">
                    <strong>Total: <span class="price"><?= money($order['total']) ?></span></strong>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
