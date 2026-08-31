<h1 class="h3 mb-4">Orders</h1>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Order</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Date</th>
                <th>Status</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= e($order['order_number']) ?></td>
                    <td><?= e($order['customer_name']) ?></td>
                    <td class="small"><?= e($order['customer_phone']) ?></td>
                    <td><?= money($order['total']) ?></td>
                    <td class="small"><?= ucwords(str_replace('_', ' ', $order['payment_method'])) ?></td>
                    <td class="small"><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                    <td><?= statusBadge($order['status']) ?></td>
                    <td class="text-end">
                        <a href="<?= url('admin/orders/show/' . $order['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($orders)): ?><tr><td colspan="8" class="text-secondary">No orders yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
