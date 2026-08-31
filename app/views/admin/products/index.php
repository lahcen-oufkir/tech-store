<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Products</h1>
    <a href="<?= url('admin/products/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Product</a>
</div>

<form method="get" action="<?= url('admin/products') ?>" class="mb-3">
    <div class="input-group" style="max-width:400px">
        <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?= e($search) ?>">
        <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
    </div>
</form>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Featured</th>
                <th>Active</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= (int) $product['id'] ?></td>
                    <td><?= e($product['name']) ?></td>
                    <td class="small"><?= e($product['category_name'] ?? '-') ?></td>
                    <td><?= money($product['price']) ?></td>
                    <td>
                        <?php if ($product['stock'] <= 0): ?>
                            <span class="text-danger fw-bold"><?= (int) $product['stock'] ?></span>
                        <?php else: ?>
                            <?= (int) $product['stock'] ?>
                        <?php endif; ?>
                    </td>
                    <td><?= $product['is_featured'] ? '<i class="bi bi-star-fill text-warning"></i>' : '' ?></td>
                    <td><?= $product['is_active'] ? '<span class="text-success"><i class="bi bi-check-circle"></i></span>' : '<span class="text-secondary"><i class="bi bi-x-circle"></i></span>' ?></td>
                    <td class="text-end">
                        <a href="<?= url('admin/products/edit/' . $product['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form method="post" action="<?= url('admin/products/destroy/' . $product['id']) ?>" class="d-inline" data-confirm="Delete this product?">
                            <?= csrf_field() ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($products)): ?><tr><td colspan="8" class="text-secondary">No products found.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
