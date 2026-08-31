<?php $errors = ($errors ?? []) + ['customer_name' => '', 'customer_phone' => '', 'customer_email' => '', 'device_type' => '', 'issue_description' => '']; ?>
<h1 class="section-title">Request a Repair</h1>
<p class="text-secondary mb-4">
    Tell us about your device and the problem. Our technicians will contact you with
    a free estimate.
</p>

<div class="row">
    <div class="col-lg-8">
        <div class="card auth-card p-4">
            <form method="post" action="<?= url('repair/store') ?>">
                <?= csrf_field() ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Your name *</label>
                        <input type="text" name="customer_name" class="form-control <?= $errors['customer_name'] ? 'is-invalid' : '' ?>" value="<?= e(old('customer_name', $user['name'] ?? '')) ?>">
                        <div class="invalid-feedback"><?= e($errors['customer_name']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="customer_phone" class="form-control <?= $errors['customer_phone'] ? 'is-invalid' : '' ?>" value="<?= e(old('customer_phone', $user['phone'] ?? '')) ?>">
                        <div class="invalid-feedback"><?= e($errors['customer_phone']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email *</label>
                        <input type="email" name="customer_email" class="form-control <?= $errors['customer_email'] ? 'is-invalid' : '' ?>" value="<?= e(old('customer_email', $user['email'] ?? '')) ?>">
                        <div class="invalid-feedback"><?= e($errors['customer_email']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Device type *</label>
                        <select name="device_type" class="form-select <?= $errors['device_type'] ? 'is-invalid' : '' ?>">
                            <?php $deviceTypes = ['computer', 'smartphone', 'tablet', 'printer', 'other']; ?>
                            <?php foreach ($deviceTypes as $type): ?>
                                <option value="<?= $type ?>" <?= old('device_type') === $type ? 'selected' : '' ?>><?= ucfirst($type) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= e($errors['device_type']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Brand / model</label>
                        <input type="text" name="brand_model" class="form-control" value="<?= e(old('brand_model')) ?>" placeholder="e.g. HP Pavilion 15">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Describe the problem *</label>
                        <textarea name="issue_description" rows="5" class="form-control <?= $errors['issue_description'] ? 'is-invalid' : '' ?>"><?= e(old('issue_description')) ?></textarea>
                        <div class="invalid-feedback"><?= e($errors['issue_description']) ?></div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary btn-lg"><i class="bi bi-wrench-adjustable"></i> Submit Request</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card bg-light p-4">
            <h6 class="fw-bold"><i class="bi bi-lightbulb"></i> How it works</h6>
            <ol class="small text-secondary mb-0">
                <li class="mb-2">Submit the request online.</li>
                <li class="mb-2">We call you to confirm and give an estimate.</li>
                <li class="mb-2">Drop off your device at the shop.</li>
                <li class="mb-2">Track the status online or in your account.</li>
                <li>Collect your repaired device.</li>
            </ol>
        </div>
    </div>
</div>
