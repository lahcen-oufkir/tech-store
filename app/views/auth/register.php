<?php $errors = ($errors ?? []) + ['name' => '', 'email' => '', 'password' => '']; ?>
<div class="card auth-card">
    <div class="card-body p-4">
        <h4 class="fw-bold text-center mb-1">Create an account</h4>
        <p class="text-secondary text-center mb-4">Join <?= e(APP_NAME) ?> today</p>
        <form method="post" action="<?= url('auth/register') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Full name</label>
                <input type="text" name="name" class="form-control <?= $errors['name'] ? 'is-invalid' : '' ?>" value="<?= e(old('name')) ?>">
                <div class="invalid-feedback"><?= e($errors['name']) ?></div>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control <?= $errors['email'] ? 'is-invalid' : '' ?>" value="<?= e(old('email')) ?>">
                <div class="invalid-feedback"><?= e($errors['email']) ?></div>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="<?= e(old('phone')) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="<?= e(old('address')) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control <?= $errors['password'] ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback"><?= e($errors['password']) ?></div>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <button class="btn btn-primary w-100"><i class="bi bi-person-plus"></i> Register</button>
        </form>
        <p class="text-center mt-3 mb-0 text-secondary">
            Already have an account? <a href="<?= url('auth/showLogin') ?>">Log in</a>
        </p>
    </div>
</div>
