<h1 class="h3 mb-4">Services</h1>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">Add Service</h5>
            <form method="post" action="<?= url('admin/services/store') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" class="form-control" value="<?= e(old('name')) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control"><?= e(old('description')) ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Price (<?= CURRENCY ?>)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="<?= e(old('price')) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Bootstrap icon name</label>
                    <input type="text" name="icon" class="form-control" value="<?= e(old('icon')) ?>" placeholder="e.g. laptop, phone, wrench">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
                <button class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Service</button>
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Active</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?= (int) $service['id'] ?></td>
                            <td><i class="bi bi-<?= e($service['icon'] ?: 'wrench') ?> me-1"></i><?= e($service['name']) ?></td>
                            <td><?= $service['price'] ? money($service['price']) : '--' ?></td>
                            <td><?= $service['is_active'] ? '<span class="text-success"><i class="bi bi-check-circle"></i></span>' : '<span class="text-secondary"><i class="bi bi-x-circle"></i></span>' ?></td>
                            <td class="text-end">
                                <a href="<?= url('admin/services/edit/' . $service['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form method="post" action="<?= url('admin/services/destroy/' . $service['id']) ?>" class="d-inline" data-confirm="Delete this service?">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($services)): ?><tr><td colspan="5" class="text-secondary">No services yet.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
