<?php $errors = ($errors ?? []) + ['name' => '', 'email' => '', 'message' => '']; ?>
<div class="row g-4">
    <div class="col-lg-5">
        <h1 class="section-title">Contact Us</h1>
        <p class="text-secondary">We usually reply within one business day.</p>
        <ul class="list-unstyled">
            <li class="mb-3">
                <i class="bi bi-geo-alt-fill text-primary fs-4 me-2"></i>
                <div class="d-inline-block">
                    <strong>Avenue Hassan II</strong><br>
                    <span class="text-secondary">Laâyoune, Morocco</span>
                </div>
            </li>
            <li class="mb-3">
                <i class="bi bi-telephone-fill text-primary fs-4 me-2"></i>
                <div class="d-inline-block">
                    <strong>+212 6 60 00 00 00</strong>
                </div>
            </li>
            <li class="mb-3">
                <i class="bi bi-envelope-fill text-primary fs-4 me-2"></i>
                <div class="d-inline-block">
                    <strong><?= e(APP_EMAIL) ?></strong>
                </div>
            </li>
            <li class="mb-3">
                <i class="bi bi-clock-fill text-primary fs-4 me-2"></i>
                <div class="d-inline-block">
                    <strong>Opening hours</strong><br>
                    <span class="text-secondary">Mon - Sat: 9:00 - 19:00</span>
                </div>
            </li>
        </ul>
    </div>
    <div class="col-lg-7">
        <div class="card auth-card p-4">
            <h4 class="fw-bold mb-3">Send us a message</h4>
            <form method="post" action="<?= url('contact/store') ?>">
                <?= csrf_field() ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" class="form-control <?= $errors['name'] ? 'is-invalid' : '' ?>" value="<?= e(old('name')) ?>">
                        <div class="invalid-feedback"><?= e($errors['name']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control <?= $errors['email'] ? 'is-invalid' : '' ?>" value="<?= e(old('email')) ?>">
                        <div class="invalid-feedback"><?= e($errors['email']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= e(old('phone')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control" value="<?= e(old('subject')) ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Message *</label>
                        <textarea name="message" rows="5" class="form-control <?= $errors['message'] ? 'is-invalid' : '' ?>"><?= e(old('message')) ?></textarea>
                        <div class="invalid-feedback"><?= e($errors['message']) ?></div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary w-100"><i class="bi bi-send"></i> Send Message</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
