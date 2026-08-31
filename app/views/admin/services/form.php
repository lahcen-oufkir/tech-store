<?php $errors = ($errors ?? []) + ['name' => '']; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Service</h1>
    <a href="<?= url('admin/services') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card p-4" style="max-width:600px">
    <form method="post" action="<?= url('admin/services/update/' . $service['id']) ?>">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Name *</label>
            <input type="text" name="name" class="form-control <?= $errors['name'] ? 'is-invalid' : '' ?>" value="<?= e(old('name', $service['name'])) ?>">
            <div class="invalid-feedback"><?= e($errors['name']) ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="3" class="form-control"><?= e(old('description', $service['description'])) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Price (<?= CURRENCY ?>)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?= e(old('price', $service['price'])) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Bootstrap icon name</label>
            <input type="text" name="icon" class="form-control" value="<?= e(old('icon', $service['icon'])) ?>">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" <?= $service['is_active'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
        <button class="btn btn-primary"><i class="bi bi-save"></i> Update Service</button>
    </form>
</div>
