<h1 class="h3 mb-4">Messages</h1>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>From</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Status</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $message): ?>
                <tr <?= !$message['is_read'] ? 'class="table-light fw-bold"' : '' ?>>
                    <td><?= e($message['name']) ?><br><small class="text-secondary fw-normal"><?= e($message['email']) ?></small></td>
                    <td class="small"><?= e($message['subject'] ?: 'No subject') ?></td>
                    <td class="small"><?= date('d M Y H:i', strtotime($message['created_at'])) ?></td>
                    <td><?= $message['is_read'] ? '<span class="badge text-bg-secondary">Read</span>' : '<span class="badge text-bg-danger">New</span>' ?></td>
                    <td class="text-end">
                        <a href="<?= url('admin/messages/show/' . $message['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                        <form method="post" action="<?= url('admin/messages/destroy/' . $message['id']) ?>" class="d-inline" data-confirm="Delete this message?">
                            <?= csrf_field() ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($messages)): ?><tr><td colspan="5" class="text-secondary">No messages yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
