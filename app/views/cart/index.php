<h1 class="section-title">Shopping Cart</h1>

<?php if (empty($cart)): ?>
    <div class="alert alert-info">
        Your cart is empty. <a href="<?= url('products') ?>" class="alert-link">Browse products</a> to get started.
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-end">Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $row): ?>
                    <tr>
                        <td>
                            <a class="text-decoration-none text-dark" href="<?= url('products/show/' . $row['product']['slug']) ?>">
                                <strong><?= e($row['product']['name']) ?></strong>
                            </a>
                        </td>
                        <td><?= money($row['product']['price']) ?></td>
                        <td class="text-center">
                            <form method="post" action="<?= url('cart/update') ?>" class="d-inline-flex align-items-center gap-1">
                                <?= csrf_field() ?>
                                <input type="hidden" name="product_id" value="<?= (int) $row['product']['id'] ?>">
                                <input type="number" name="quantity" value="<?= (int) $row['quantity'] ?>" min="0" class="form-control form-control-sm qty-input">
                                <button class="btn btn-sm btn-outline-secondary" title="Update"><i class="bi bi-arrow-repeat"></i></button>
                            </form>
                        </td>
                        <td class="text-end"><strong><?= money($row['product']['price'] * $row['quantity']) ?></strong></td>
                        <td class="text-end">
                            <form method="post" action="<?= url('cart/remove') ?>" data-confirm="Remove this item?">
                                <?= csrf_field() ?>
                                <input type="hidden" name="product_id" value="<?= (int) $row['product']['id'] ?>">
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
        <div>
            <form method="post" action="<?= url('cart/clear') ?>" class="d-inline" data-confirm="Clear your whole cart?">
                <?= csrf_field() ?>
                <button class="btn btn-outline-danger"><i class="bi bi-trash"></i> Clear Cart</button>
            </form>
            <a href="<?= url('products') ?>" class="btn btn-outline-secondary ms-1"><i class="bi bi-arrow-left"></i> Continue Shopping</a>
        </div>
        <div class="text-end">
            <div class="fs-4">Total: <strong class="price"><?= money($total) ?></strong></div>
            <?php if (isLoggedIn()): ?>
                <a href="<?= url('orders/checkout') ?>" class="btn btn-primary btn-lg mt-2"><i class="bi bi-bag-check"></i> Proceed to Checkout</a>
            <?php else: ?>
                <p class="text-secondary small mt-2 mb-0">Log in to complete your order.</p>
                <a href="<?= url('auth/showLogin') ?>" class="btn btn-primary mt-2">Login to Checkout</a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
