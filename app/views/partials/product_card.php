<div class="col">
    <div class="card product-card h-100">
        <?php if (!empty($product['image'])): ?>
            <img src="<?= e(UPLOAD_URL . $product['image']) ?>" class="card-img-top product-image" alt="<?= e($product['name']) ?>">
        <?php else: ?>
            <div class="product-placeholder"><i class="bi bi-box-seam"></i></div>
        <?php endif; ?>
        <div class="card-body d-flex flex-column">
            <?php if (!empty($product['category_name'])): ?>
                <span class="badge text-bg-light mb-2 align-self-start"><?= e($product['category_name']) ?></span>
            <?php endif; ?>
            <h5 class="card-title h6">
                <a class="text-decoration-none text-dark" href="<?= url('products/show/' . $product['slug']) ?>"><?= e($product['name']) ?></a>
            </h5>
            <div class="mt-auto">
                <?php if (!empty($product['old_price'])): ?>
                    <span class="old-price me-2"><?= money($product['old_price']) ?></span>
                <?php endif; ?>
                <span class="price"><?= money($product['price']) ?></span>
                <form method="post" action="<?= url('cart/add') ?>" class="mt-2">
                    <?= csrf_field() ?>
                    <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button class="btn btn-primary btn-sm w-100" <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>
                        <i class="bi bi-cart-plus"></i>
                        <?= $product['stock'] <= 0 ? 'Out of Stock' : 'Add to Cart' ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
