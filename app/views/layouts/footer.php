    </div>
</main>

<footer class="bg-dark text-light pt-5 pb-3 mt-auto">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="fw-bold"><i class="bi bi-cpu-fill me-1"></i><?= e(APP_NAME) ?></h5>
                <p class="text-secondary small">
                    Your local computer and smartphone shop in Laâyoune. Quality products,
                    professional repair services and friendly support.
                </p>
            </div>
            <div class="col-lg-2 col-md-4">
                <h6 class="fw-bold text-uppercase small">Quick Links</h6>
                <ul class="list-unstyled small">
                    <li><a class="footer-link" href="<?= url('') ?>">Home</a></li>
                    <li><a class="footer-link" href="<?= url('products') ?>">Products</a></li>
                    <li><a class="footer-link" href="<?= url('services') ?>">Services</a></li>
                    <li><a class="footer-link" href="<?= url('about') ?>">About</a></li>
                    <li><a class="footer-link" href="<?= url('contact') ?>">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4">
                <h6 class="fw-bold text-uppercase small">Our Services</h6>
                <ul class="list-unstyled small">
                    <li><a class="footer-link" href="<?= url('services') ?>">Computer Repair</a></li>
                    <li><a class="footer-link" href="<?= url('services') ?>">Smartphone Repair</a></li>
                    <li><a class="footer-link" href="<?= url('services') ?>">OS Installation</a></li>
                    <li><a class="footer-link" href="<?= url('services') ?>">Virus Removal</a></li>
                    <li><a class="footer-link" href="<?= url('services') ?>">Wi-Fi & Network Setup</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4">
                <h6 class="fw-bold text-uppercase small">Contact</h6>
                <ul class="list-unstyled small">
                    <li class="mb-1"><i class="bi bi-geo-alt me-1"></i> Avenue Hassan II, Laâyoune, Morocco</li>
                    <li class="mb-1"><i class="bi bi-telephone me-1"></i> +212 6 60 00 00 00</li>
                    <li class="mb-1"><i class="bi bi-envelope me-1"></i> <?= e(APP_EMAIL) ?></li>
                    <li><i class="bi bi-clock me-1"></i> Mon - Sat: 9:00 - 19:00</li>
                </ul>
            </div>
        </div>
        <div class="text-center small text-secondary border-top border-secondary pt-3 mt-4">
            &copy; <?= date('Y') ?> <?= e(APP_NAME) ?>. All rights reserved.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= url('assets/js/main.js') ?>"></script>
</body>
</html>
