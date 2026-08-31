<?php $errors = ($errors ?? []) + ['name' => '', 'email' => '']; ?>
<h1 class="section-title">My Profile</h1>

<div class="row">
    <div class="col-lg-7">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">Personal information</h5>
            <form method="post" action="<?= url('customer/updateProfile') ?>">
                <?= csrf_field() ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full name</label>
                        <input type="text" name="name" class="form-control <?= $errors['name'] ? 'is-invalid' : '' ?>" value="<?= e(old('name', $user['name'])) ?>">
                        <div class="invalid-feedback"><?= e($errors['name']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control <?= $errors['email'] ? 'is-invalid' : '' ?>" value="<?= e(old('email', $user['email'])) ?>">
                        <div class="invalid-feedback"><?= e($errors['email']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= e(old('phone', $user['phone'] ?? '')) ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" value="<?= e(old('address', $user['address'] ?? '')) ?>">
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary"><i class="bi bi-check2-circle"></i> Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card bg-light p-4">
            <h6 class="fw-bold">Account</h6>
            <p class="small text-secondary mb-2">
                Member since <?= date('F Y', strtotime($user['created_at'] ?? 'now')) ?><br>
                Role: <strong><?= ucfirst($user['role']) ?></strong>
            </p>
            <hr>
            <a href="<?= url('customer/orders') ?>" class="btn btn-outline-primary btn-sm w-100 mb-2"><i class="bi bi-bag-check"></i> My Orders</a>
            <a href="<?= url('customer/repairs') ?>" class="btn btn-outline-primary btn-sm w-100"><i class="bi bi-wrench-adjustable"></i> My Repairs</a>
        </div>
    </div>
</div>
