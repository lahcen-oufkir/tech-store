<?php $errors = ($errors ?? []) + ['name' => '', 'slug' => '']; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Category</h1>
    <a href="<?= url('admin/categories') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card p-4" style="max-width:600px">
    <form method="post" action="<?= url('admin/categories/update/' . $category['id']) ?>">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Name *</label>
            <input type="text" name="name" class="form-control <?= $errors['name'] ? 'is-invalid' : '' ?>" value="<?= e(old('name', $category['name'])) ?>">
            <div class="invalid-feedback"><?= e($errors['name']) ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Slug *</label>
            <input type="text" name="slug" class="form-control <?= $errors['slug'] ? 'is-invalid' : '' ?>" value="<?= e(old('slug', $category['slug'])) ?>">
            <div class="invalid-feedback"><?= e($errors['slug']) ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="3" class="form-control"><?= e(old('description', $category['description'])) ?></textarea>
        </div>
        <button class="btn btn-primary"><i class="bi bi-save"></i> Update Category</button>
    </form>
</div>
