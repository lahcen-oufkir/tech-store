<?php $errors = ($errors ?? []) + ['email' => '', 'password' => '']; ?>
<div class="card auth-card">
    <div class="card-body p-4">
        <h4 class="fw-bold text-center mb-1">Welcome back</h4>
        <p class="text-secondary text-center mb-4">Log in to your account</p>
        <form method="post" action="<?= url('auth/login') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control <?= $errors['email'] ? 'is-invalid' : '' ?>" value="<?= e(old('email')) ?>">
                <div class="invalid-feedback"><?= e($errors['email']) ?></div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control <?= $errors['password'] ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback"><?= e($errors['password']) ?></div>
            </div>
            <button class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right"></i> Login</button>
        </form>
        <p class="text-center mt-3 mb-0 text-secondary">
            No account? <a href="<?= url('auth/showRegister') ?>">Register here</a>
        </p>
    </div>
</div>
