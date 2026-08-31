<section class="hero mb-5">
    <div class="container">
    <div class="row align-items-center g-4">
        <div class="col-lg-7">
            <p class="text-uppercase small text-info mb-2"><?= e(APP_TAGLINE) ?></p>
            <h1>Your Trusted Computer & Smartphone Shop in Laâyoune</h1>
            <p class="lead text-light opacity-75">
                Quality new and used devices, accessories, and professional repair
                services — all in one place.
            </p>
            <a href="<?= url('products') ?>" class="btn btn-primary btn-lg me-2">
                <i class="bi bi-bag"></i> Shop Products
            </a>
            <a href="<?= url('repair/create') ?>" class="btn btn-outline-light btn-lg">
                <i class="bi bi-wrench-adjustable"></i> Request a Repair
            </a>
        </div>
        <div class="col-lg-5">
            <div class="hero-img-wrap">
                <img src="<?= url('assets/images/hero.jpg') ?>" alt="Technician repairing a laptop at TechnoMeits Store" class="hero-img" loading="eager">
            </div>
        </div>
    </div>
    <div class="row g-3 mt-4">
        <div class="col-6 col-lg-3"><div class="feature-card bg-white text-dark"><i class="bi bi-laptop feature-icon"></i><h6 class="mt-2">New & Used PCs</h6></div></div>
        <div class="col-6 col-lg-3"><div class="feature-card bg-white text-dark"><i class="bi bi-phone feature-icon"></i><h6 class="mt-2">Smartphones</h6></div></div>
        <div class="col-6 col-lg-3"><div class="feature-card bg-white text-dark"><i class="bi bi-tools feature-icon"></i><h6 class="mt-2">Expert Repairs</h6></div></div>
        <div class="col-6 col-lg-3"><div class="feature-card bg-white text-dark"><i class="bi bi-shield-check feature-icon"></i><h6 class="mt-2">1-Year Warranty</h6></div></div>
    </div>
    </div>
</section>

<section class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="section-title mb-0">Featured Products</h2>
        <a href="<?= url('products') ?>" class="btn btn-outline-primary btn-sm">View All <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php foreach ($featured as $product): ?>
            <?php include VIEW_PATH . '/partials/product_card.php'; ?>
        <?php endforeach; ?>
        <?php if (empty($featured)): ?>
            <div class="col"><p class="text-secondary">No featured products yet.</p></div>
        <?php endif; ?>
    </div>
</section>

<section class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="section-title mb-0">Our Services</h2>
        <a href="<?= url('services') ?>" class="btn btn-outline-primary btn-sm">All Services <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($services as $service): ?>
            <div class="col">
                <div class="feature-card bg-light">
                    <i class="bi bi-<?= e($service['icon'] ?: 'wrench') ?> feature-icon"></i>
                    <h6 class="mt-2"><?= e($service['name']) ?></h6>
                    <p class="text-secondary small mb-1"><?= e($service['description']) ?></p>
                    <?php if ($service['price']): ?>
                        <span class="badge text-bg-primary">from <?= money($service['price']) ?></span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
