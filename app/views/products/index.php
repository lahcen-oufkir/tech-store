<h1 class="section-title">Products</h1>

<div class="row g-4">
    <div class="col-lg-3">
        <form method="get" action="<?= url('products') ?>" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?= e($search) ?>">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
        <div class="card mb-3">
            <div class="card-header fw-bold">Categories</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item <?= $currentCategory === '' ? 'active' : '' ?>">
                    <a class="text-decoration-none d-block" href="<?= url('products') ?>">All Products</a>
                </li>
                <?php foreach ($categories as $cat): ?>
                    <li class="list-group-item <?= $currentCategory === $cat['slug'] ? 'active' : '' ?>">
                        <a class="text-decoration-none d-block" href="<?= url('products?category=' . $cat['slug']) ?>">
                            <?= e($cat['name']) ?>
                            <span class="badge text-bg-light rounded-pill float-end"><?= (int) $cat['product_count'] ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="col-lg-9">
        <?php if ($search): ?>
            <p class="text-secondary">Results for "<strong><?= e($search) ?></strong>" (<?= count($products) ?>)</p>
        <?php endif; ?>

        <?php if (empty($products)): ?>
            <div class="alert alert-info">No products found. Try a different search or category.</div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                <?php foreach ($products as $product): ?>
                    <?php include VIEW_PATH . '/partials/product_card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
