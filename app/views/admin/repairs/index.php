<h1 class="h3 mb-4">Repair Requests</h1>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Device</th>
                <th>Brand / Model</th>
                <th>Date</th>
                <th>Status</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($repairs as $request): ?>
                <tr>
                    <td>#<?= (int) $request['id'] ?></td>
                    <td><?= e($request['customer_name']) ?><br><small class="text-secondary"><?= e($request['customer_phone']) ?></small></td>
                    <td class="small"><?= e(ucfirst($request['device_type'])) ?></td>
                    <td class="small"><?= e($request['brand_model'] ?: '-') ?></td>
                    <td class="small"><?= date('d M Y', strtotime($request['created_at'])) ?></td>
                    <td><?= statusBadge($request['status']) ?></td>
                    <td class="text-end">
                        <a href="<?= url('admin/repairs/show/' . $request['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($repairs)): ?><tr><td colspan="7" class="text-secondary">No repair requests yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
