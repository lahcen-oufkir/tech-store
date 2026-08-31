<h1 class="section-title">Track a Repair</h1>
<p class="text-secondary">Enter the email you used when submitting your repair request.</p>

<div class="row">
    <div class="col-lg-8">
        <div class="card p-4 mb-4">
            <form method="post" action="<?= url('repair/track') ?>" class="d-flex gap-2">
                <?= csrf_field() ?>
                <input type="email" name="email" class="form-control" placeholder="Your email address" value="<?= e(old('email')) ?>" required>
                <button class="btn btn-primary"><i class="bi bi-search"></i> Track</button>
            </form>
        </div>

        <?php if (!empty($results)): ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Device</th>
                            <th>Issue</th>
                            <th>Submitted</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $request): ?>
                            <tr>
                                <td>#<?= (int) $request['id'] ?></td>
                                <td><?= e(ucfirst($request['device_type'])) ?><?= $request['brand_model'] ? ' - ' . e($request['brand_model']) : '' ?></td>
                                <td class="small text-secondary" style="max-width:260px"><?= e(mb_strimwidth($request['issue_description'], 0, 60, '...')) ?></td>
                                <td class="small"><?= date('d M Y', strtotime($request['created_at'])) ?></td>
                                <td><?= statusBadge($request['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <div class="alert alert-info">No repair requests found for this email.</div>
        <?php endif; ?>
    </div>
</div>
