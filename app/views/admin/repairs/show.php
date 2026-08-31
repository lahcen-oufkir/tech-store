<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Repair #<?= (int) $request['id'] ?></h1>
    <a href="<?= url('admin/repairs') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">Issue description</h5>
            <p><?= nl2br(e($request['issue_description'])) ?></p>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <span class="text-secondary small">Device</span>
                    <div><?= e(ucfirst($request['device_type'])) ?></div>
                </div>
                <div class="col-md-4">
                    <span class="text-secondary small">Brand / Model</span>
                    <div><?= e($request['brand_model'] ?: '-') ?></div>
                </div>
                <div class="col-md-4">
                    <span class="text-secondary small">Submitted</span>
                    <div><?= date('d M Y H:i', strtotime($request['created_at'])) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-3">Customer</h5>
            <p class="mb-1"><strong><?= e($request['customer_name']) ?></strong></p>
            <p class="mb-1 small"><i class="bi bi-envelope me-1"></i><?= e($request['customer_email']) ?></p>
            <p class="mb-0 small"><i class="bi bi-telephone me-1"></i><?= e($request['customer_phone']) ?></p>
        </div>
        <div class="card p-4">
            <h5 class="fw-bold mb-3">Update status</h5>
            <form method="post" action="<?= url('admin/repairs/updateStatus/' . $request['id']) ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <select name="status" class="form-select">
                        <?php foreach (['pending', 'in_progress', 'repaired', 'collected', 'cancelled'] as $status): ?>
                            <option value="<?= $status ?>" <?= $request['status'] === $status ? 'selected' : '' ?>><?= ucwords(str_replace('_', ' ', $status)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button class="btn btn-primary w-100"><i class="bi bi-arrow-repeat"></i> Update Status</button>
            </form>
        </div>
    </div>
</div>
