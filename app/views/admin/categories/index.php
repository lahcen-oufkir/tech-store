<h1 class="h3 mb-4">Categories</h1>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">Add Category</h5>
            <form method="post" action="<?= url('admin/categories/store') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" class="form-control" value="<?= e(old('name')) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug *</label>
                    <input type="text" name="slug" class="form-control" value="<?= e(old('slug')) ?>" placeholder="e.g. computers" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control"><?= e(old('description')) ?></textarea>
                </div>
                <button class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Category</button>
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
                        <th>Slug</th>
                        <th class="text-center">Products</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= (int) $category['id'] ?></td>
                            <td><?= e($category['name']) ?></td>
                            <td class="text-secondary"><?= e($category['slug']) ?></td>
                            <td class="text-center"><?= (int) $category['product_count'] ?></td>
                            <td class="text-end">
                                <a href="<?= url('admin/categories/edit/' . $category['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form method="post" action="<?= url('admin/categories/destroy/' . $category['id']) ?>" class="d-inline" data-confirm="Delete this category? Products in it will lose their category.">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($categories)): ?><tr><td colspan="5" class="text-secondary">No categories yet.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
