<h1 class="h3 mb-4">Customers</h1>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Joined</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?= (int) $customer['id'] ?></td>
                    <td><?= e($customer['name']) ?></td>
                    <td class="small"><?= e($customer['email']) ?></td>
                    <td class="small"><?= e($customer['phone'] ?: '-') ?></td>
                    <td class="small"><?= date('d M Y', strtotime($customer['created_at'])) ?></td>
                    <td class="text-end">
                        <a href="<?= url('admin/customers/show/' . $customer['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($customers)): ?><tr><td colspan="6" class="text-secondary">No customers yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
