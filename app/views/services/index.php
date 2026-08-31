<div class="text-center mb-4">
    <h1 class="section-title">Our Services</h1>
    <p class="text-secondary">Professional repair and technical services for all your devices.</p>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
    <?php foreach ($services as $service): ?>
        <div class="col">
            <div class="feature-card bg-light h-100">
                <i class="bi bi-<?= e($service['icon'] ?: 'wrench') ?> feature-icon"></i>
                <h5 class="mt-3"><?= e($service['name']) ?></h5>
                <p class="text-secondary small"><?= e($service['description']) ?></p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="price"><?= $service['price'] ? 'from ' . money($service['price']) : 'Contact us' ?></span>
                    <a href="<?= url('repair/create') ?>" class="btn btn-sm btn-outline-primary">Request</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="card text-bg-dark rounded-4 p-4 text-center">
    <h4>Have a device problem?</h4>
    <p class="text-secondary mb-3">Describe the issue and we will get back to you with a free estimate.</p>
    <div>
        <a href="<?= url('repair/create') ?>" class="btn btn-primary">Request a Repair</a>
        <a href="<?= url('contact') ?>" class="btn btn-outline-light ms-2">Contact Us</a>
    </div>
</div>
