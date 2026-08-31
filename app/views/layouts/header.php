<?php $activeNav = $activeNav ?? ''; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? APP_NAME) ?> | <?= e(APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= url('') ?>">
            <i class="bi bi-cpu-fill me-1"></i><?= e(APP_NAME) ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link <?= $activeNav === 'home' ? 'active' : '' ?>" href="<?= url('') ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= $activeNav === 'products' ? 'active' : '' ?>" href="<?= url('products') ?>">Products</a></li>
                <li class="nav-item"><a class="nav-link <?= $activeNav === 'services' ? 'active' : '' ?>" href="<?= url('services') ?>">Services</a></li>
                <li class="nav-item"><a class="nav-link <?= $activeNav === 'repair' ? 'active' : '' ?>" href="<?= url('repair/create') ?>">Repair</a></li>
                <li class="nav-item"><a class="nav-link <?= $activeNav === 'about' ? 'active' : '' ?>" href="<?= url('about') ?>">About</a></li>
                <li class="nav-item"><a class="nav-link <?= $activeNav === 'contact' ? 'active' : '' ?>" href="<?= url('contact') ?>">Contact</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= url('cart') ?>">
                        <i class="bi bi-cart3"></i> Cart
                        <span class="badge bg-primary rounded-pill"><?= cartCount() ?></span>
                    </a>
                </li>
                <?php if (isLoggedIn()): ?>
                    <?php if (isAdmin()): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= url('admin') ?>"><i class="bi bi-speedometer2"></i> Admin</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?= url('customer') ?>"><i class="bi bi-person-circle"></i> My Account</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('auth/logout') ?>"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('auth/showLogin') ?>">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('auth/showRegister') ?>">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="flex-grow-1 py-4">
    <div class="container">
        <?php foreach (getFlashAlerts() as $alert): ?>
            <div class="alert alert-<?= e($alert['type']) ?> alert-dismissible fade show" role="alert">
                <?= e($alert['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endforeach; ?>
