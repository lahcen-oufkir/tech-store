<div class="row g-4">
    <div class="col-lg-7">
        <div class="card product-card">
            <?php if (!empty($product['image'])): ?>
                <img src="<?= e(UPLOAD_URL . $product['image']) ?>" class="card-img-top product-image" style="height:320px" alt="<?= e($product['name']) ?>">
            <?php else: ?>
                <div class="product-placeholder" style="height:320px"><i class="bi bi-box-seam"></i></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-5">
        <?php if (!empty($product['category_name'])): ?>
            <span class="badge text-bg-light mb-2"><?= e($product['category_name']) ?></span>
        <?php endif; ?>
        <h1 class="h3"><?= e($product['name']) ?></h1>
        <p class="mb-2">
            <?php if (!empty($product['old_price'])): ?>
                <span class="old-price me-2"><?= money($product['old_price']) ?></span>
            <?php endif; ?>
            <span class="price fs-3"><?= money($product['price']) ?></span>
        </p>
        <p class="text-secondary small mb-3">
            <i class="bi bi-box-seam me-1"></i>
            <?= $product['stock'] > 0 ? 'In stock (' . (int) $product['stock'] . ' available)' : 'Out of stock' ?>
        </p>

        <form method="post" action="<?= url('cart/add') ?>" class="mb-4">
            <?= csrf_field() ?>
            <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
            <div class="d-flex align-items-center gap-2">
                <input type="number" name="quantity" class="form-control" style="max-width:90px" value="1" min="1" max="<?= max(1, (int) $product['stock']) ?>">
                <button class="btn btn-primary" <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>
                    <i class="bi bi-cart-plus"></i> Add to Cart
                </button>
            </div>
        </form>

        <div class="border-top pt-3">
            <h5>Description</h5>
            <p class="text-secondary"><?= e($product['description']) ?></p>
        </div>
    </div>
</div>

<?php if (!empty($related)): ?>
    <hr class="my-5">
    <h2 class="section-title">Related Products</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php foreach ($related as $product): ?>
            <?php include VIEW_PATH . '/partials/product_card.php'; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
