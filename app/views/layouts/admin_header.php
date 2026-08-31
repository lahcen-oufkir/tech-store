<?php requireAdmin(); ?>
<?php $adminActive = $adminActive ?? ''; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Admin') ?> | Admin - <?= e(APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body class="admin-body">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="<?= url('admin') ?>">
            <i class="bi bi-speedometer2 me-1"></i><?= e(APP_NAME) ?> Admin
        </a>
        <div class="d-flex align-items-center">
            <span class="text-light me-3 small d-none d-md-inline">
                <i class="bi bi-person-circle me-1"></i><?= e(currentUser()['name'] ?? 'Admin') ?>
            </span>
            <a href="<?= url('') ?>" class="btn btn-outline-light btn-sm me-2"><i class="bi bi-house-door"></i> View Site</a>
            <a href="<?= url('auth/logout') ?>" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 admin-sidebar d-md-block p-0">
            <ul class="nav flex-column p-3">
                <li class="nav-item">
                    <a class="nav-link <?= $adminActive === 'dashboard' ? 'active' : '' ?>" href="<?= url('admin') ?>">
                        <i class="bi bi-grid-1x2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $adminActive === 'products' ? 'active' : '' ?>" href="<?= url('admin/products') ?>">
                        <i class="bi bi-box-seam"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $adminActive === 'categories' ? 'active' : '' ?>" href="<?= url('admin/categories') ?>">
                        <i class="bi bi-tags"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $adminActive === 'services' ? 'active' : '' ?>" href="<?= url('admin/services') ?>">
                        <i class="bi bi-tools"></i> Services
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $adminActive === 'orders' ? 'active' : '' ?>" href="<?= url('admin/orders') ?>">
                        <i class="bi bi-cart-check"></i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $adminActive === 'repairs' ? 'active' : '' ?>" href="<?= url('admin/repairs') ?>">
                        <i class="bi bi-wrench-adjustable"></i> Repairs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $adminActive === 'customers' ? 'active' : '' ?>" href="<?= url('admin/customers') ?>">
                        <i class="bi bi-people"></i> Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $adminActive === 'messages' ? 'active' : '' ?>" href="<?= url('admin/messages') ?>">
                        <i class="bi bi-envelope"></i> Messages
                        <?php $unread = (new App\Models\ContactMessage())->unreadCount(); ?>
                        <?php if ($unread > 0): ?>
                            <span class="badge bg-danger rounded-pill"><?= $unread ?></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
        </nav>
        <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4 py-4">
            <?php foreach (getFlashAlerts() as $alert): ?>
                <div class="alert alert-<?= e($alert['type']) ?> alert-dismissible fade show" role="alert">
                    <?= e($alert['message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endforeach; ?>
