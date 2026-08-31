<h1 class="section-title">My Repair Requests</h1>

<?php if (empty($repairs)): ?>
    <div class="alert alert-info">You have no repair requests. <a href="<?= url('repair/create') ?>" class="alert-link">Request a repair</a></div>
<?php else: ?>
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
                <?php foreach ($repairs as $request): ?>
                    <tr>
                        <td>#<?= (int) $request['id'] ?></td>
                        <td><?= e(ucfirst($request['device_type'])) ?><?= $request['brand_model'] ? ' - ' . e($request['brand_model']) : '' ?></td>
                        <td class="small text-secondary" style="max-width:320px"><?= e(mb_strimwidth($request['issue_description'], 0, 80, '...')) ?></td>
                        <td class="small"><?= date('d M Y', strtotime($request['created_at'])) ?></td>
                        <td><?= statusBadge($request['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
