<?php $errors = ($errors ?? []) + ['name' => '', 'slug' => '', 'price' => '', 'stock' => '']; ?>
<?php $product = $product ?? []; ?>
<?php $isEdit = !empty($product['id']); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><?= $isEdit ? 'Edit Product' : 'Add Product' ?></h1>
    <a href="<?= url('admin/products') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card p-4" style="max-width:800px">
    <form method="post" action="<?= $isEdit ? url('admin/products/update/' . $product['id']) : url('admin/products/store') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Name *</label>
                <input type="text" name="name" class="form-control <?= $errors['name'] ? 'is-invalid' : '' ?>" value="<?= e(old('name', $product['name'] ?? '')) ?>">
                <div class="invalid-feedback"><?= e($errors['name']) ?></div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Slug *</label>
                <input type="text" name="slug" class="form-control <?= $errors['slug'] ? 'is-invalid' : '' ?>" value="<?= e(old('slug', $product['slug'] ?? '')) ?>">
                <div class="invalid-feedback"><?= e($errors['slug']) ?></div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">-- None --</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= (int) $category['id'] ?>" <?= old('category_id', $product['category_id'] ?? '') == $category['id'] ? 'selected' : '' ?>>
                            <?= e($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Price (<?= CURRENCY ?>) *</label>
                <input type="number" step="0.01" name="price" class="form-control <?= $errors['price'] ? 'is-invalid' : '' ?>" value="<?= e(old('price', $product['price'] ?? '')) ?>">
                <div class="invalid-feedback"><?= e($errors['price']) ?></div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Old price (optional)</label>
                <input type="number" step="0.01" name="old_price" class="form-control" value="<?= e(old('old_price', $product['old_price'] ?? '')) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Stock *</label>
                <input type="number" name="stock" class="form-control <?= $errors['stock'] ? 'is-invalid' : '' ?>" value="<?= e(old('stock', $product['stock'] ?? 0)) ?>">
                <div class="invalid-feedback"><?= e($errors['stock']) ?></div>
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" class="form-control"><?= e(old('description', $product['description'] ?? '')) ?></textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <?php if (!empty($product['image'])): ?>
                    <div class="mt-2">
                        <img src="<?= e(UPLOAD_URL . $product['image']) ?>" class="border rounded" style="height:60px" alt="">
                        <span class="small text-secondary ms-2">Current image: <?= e($product['image']) ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" <?= !empty($product['is_featured']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_featured">Featured product</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" <?= !isset($product['is_active']) || $product['is_active'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">Active (visible in store)</label>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary"><i class="bi bi-save"></i> <?= $isEdit ? 'Update Product' : 'Create Product' ?></button>
            </div>
        </div>
    </form>
</div>
