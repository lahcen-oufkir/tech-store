<?php $errors = ($errors ?? []) + ['customer_name' => '', 'customer_email' => '', 'customer_phone' => '', 'shipping_address' => '', 'payment_method' => '']; ?>
<h1 class="section-title">Checkout</h1>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card auth-card p-4">
            <h5 class="fw-bold mb-3">Delivery & Payment details</h5>
            <form method="post" action="<?= url('orders/store') ?>">
                <?= csrf_field() ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full name *</label>
                        <input type="text" name="customer_name" class="form-control <?= $errors['customer_name'] ? 'is-invalid' : '' ?>" value="<?= e(old('customer_name', $user['name'] ?? '')) ?>">
                        <div class="invalid-feedback"><?= e($errors['customer_name']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email *</label>
                        <input type="email" name="customer_email" class="form-control <?= $errors['customer_email'] ? 'is-invalid' : '' ?>" value="<?= e(old('customer_email', $user['email'] ?? '')) ?>">
                        <div class="invalid-feedback"><?= e($errors['customer_email']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="customer_phone" class="form-control <?= $errors['customer_phone'] ? 'is-invalid' : '' ?>" value="<?= e(old('customer_phone', $user['phone'] ?? '')) ?>">
                        <div class="invalid-feedback"><?= e($errors['customer_phone']) ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Shipping address *</label>
                        <input type="text" name="shipping_address" class="form-control <?= $errors['shipping_address'] ? 'is-invalid' : '' ?>" value="<?= e(old('shipping_address', $user['address'] ?? '')) ?>">
                        <div class="invalid-feedback"><?= e($errors['shipping_address']) ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Payment method</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="pm_store" value="pay_in_store" <?= old('payment_method') === 'pay_in_store' || old('payment_method') === '' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="pm_store">Pay in store</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="pm_cod" value="cash_on_delivery" <?= old('payment_method') === 'cash_on_delivery' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="pm_cod">Cash on delivery</label>
                        </div>
                        <div class="invalid-feedback d-block"><?= e($errors['payment_method']) ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes (optional)</label>
                        <textarea name="notes" rows="3" class="form-control"><?= e(old('notes')) ?></textarea>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary btn-lg w-100"><i class="bi bi-bag-check"></i> Place Order</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">Order Summary</h5>
            <?php foreach ($items as $row): ?>
                <div class="d-flex justify-content-between mb-2 small">
                    <span><?= e($row['product']['name']) ?> × <?= (int) $row['quantity'] ?></span>
                    <span><?= money($row['product']['price'] * $row['quantity']) ?></span>
                </div>
            <?php endforeach; ?>
            <hr>
            <div class="d-flex justify-content-between fw-bold fs-5">
                <span>Total</span>
                <span class="price"><?= money($total) ?></span>
            </div>
        </div>
    </div>
</div>
