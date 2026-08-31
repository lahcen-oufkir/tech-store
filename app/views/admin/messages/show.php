<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Message</h1>
    <a href="<?= url('admin/messages') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card p-4" style="max-width:700px">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-0"><?= e($message['subject'] ?: 'No subject') ?></h5>
            <span class="text-secondary small">
                <?= e($message['name']) ?> &lt;<?= e($message['email']) ?>&gt;
                <?= $message['phone'] ? ' - ' . e($message['phone']) : '' ?>
            </span>
        </div>
        <span class="text-secondary small"><?= date('d M Y H:i', strtotime($message['created_at'])) ?></span>
    </div>
    <hr>
    <p style="white-space:pre-wrap"><?= e($message['message']) ?></p>
    <hr>
    <div class="d-flex gap-2">
        <a href="mailto:<?= e($message['email']) ?>" class="btn btn-primary"><i class="bi bi-reply"></i> Reply</a>
        <form method="post" action="<?= url('admin/messages/destroy/' . $message['id']) ?>" class="d-inline" data-confirm="Delete this message?">
            <?= csrf_field() ?>
            <button class="btn btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
        </form>
    </div>
</div>
