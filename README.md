# TechnoMeits Store Management System (TSMS)

A modern, responsive web application for a local computer and smartphone shop in
Laâyoune, Morocco. Customers can browse products, request repairs, contact the
shop and manage orders. Administrators get a secure dashboard to manage
products, categories, services, orders, repairs, customers and messages.

Built as a learning / portfolio project using **vanilla PHP** (no frameworks),
**MySQL**, **Bootstrap 5** and a small amount of **vanilla JavaScript**.

---

## 1. Requirements

- PHP 8.0+ (with PDO MySQL extension)
- MySQL 5.7+ / MariaDB 10.3+
- Apache (XAMPP or WAMP) — or PHP's built-in server for quick testing

## 2. Installation (XAMPP)

1. Copy the whole `Tech-Store` folder into `C:\xampp\htdocs\`.
2. Start **Apache** and **MySQL** from the XAMPP control panel.
3. Open http://localhost/phpmyadmin and import
   `database/technomeits.sql` (creates the `technomeits` database, all tables
   and sample data).
4. If your MySQL credentials differ from `root` / (empty password), edit
   `config/config.php`.
5. Open http://localhost/Tech-Store/public/ in your browser.

> If you access the project root directly (http://localhost/Tech-Store/), the
> `.htaccess` at the root redirects you to `public/`.

### Quick test without Apache

```
php -S localhost:8080 -t public
```

Then open http://localhost:8080/ (mod_rewrite is not available here, so use
URLs like `/index.php?url=products`).

## 3. Demo accounts

| Role     | Email                | Password    |
|----------|----------------------|-------------|
| Admin    | admin@technomeits.ma | `admin123`  |
| Customer | customer@example.com | `customer123` |

## 4. Folder structure

```
Tech-Store/
├── app/
│   ├── core/              # Bootstrap: router, base classes, helpers
│   │   ├── App.php        # Front controller / simple router
│   │   ├── Controller.php # Base controller (view + json rendering)
│   │   ├── Model.php      # Base model (reusable CRUD)
│   │   ├── Database.php   # PDO singleton (prepared statements only)
│   │   ├── Session.php    # Session wrapper
│   │   ├── Validation.php # Lightweight validation engine
│   │   └── helpers.php    # e(), url(), flash(), auth & cart helpers
│   ├── controllers/       # Public page controllers
│   ├── controllers/admin/ # Admin panel controllers
│   ├── models/            # Database models (User, Product, Order, ...)
│   └── views/             # Templates (layouts + per-page views)
├── config/
│   └── config.php         # App + database configuration
├── database/
│   └── technomeits.sql    # Schema + sample data
└── public/                # Document root (Apache points here)
    ├── index.php          # Entry point for the website
    ├── .htaccess          # Pretty URLs -> front controller
    ├── api/               # Simple REST API
    └── assets/            # CSS, JS, images
```

## 5. Architecture decisions

- **No framework.** A small MVC-inspired structure keeps every concept
  (routing, controllers, models, views) visible and easy to learn.
- **Front controller.** Every request goes through `public/index.php`, which
  registers a PSR-4-style autoloader and boots the router
  (`App\Core\App`). URLs map to controllers and actions:
  `/products/show/12` → `ProductsController::show(12)`.
- **Single entry point** means security rules live in one place and the
  document root only exposes `public/`.
- **Reusable base classes.** `Model` provides `all/find/create/update/delete`
  so domain models stay small. `Controller` centralizes view + JSON rendering.
- **Security built in from the start:**
  - All SQL goes through **PDO prepared statements** (`Database::run`).
  - All output is escaped with `e()` (htmlspecialchars) to prevent XSS.
  - Passwords are hashed with `password_hash()` / verified with
    `password_verify()`.
  - Every POST form uses a **CSRF token** (`csrf_field()` + `verifyCsrf()`).
  - Server-side validation on every form via `Validation`.
  - Session-based role checks (`requireAdmin()`, `requireLogin()`).
- **Cart is session-based** (`tsms_cart`), so no extra database table is needed
  while staying fast and simple.
- **Orders** record the customer's details at checkout time (order history is
  kept even if the account or product is later removed). Product names are
  copied into `order_items` for the same reason.
- **Public vs admin layouts**: two layouts (`header/footer` and
  `admin_header/admin_footer`) keep every page consistent with minimal markup.

## 6. Routes

| URL                     | Controller / Action                 |
|-------------------------|-------------------------------------|
| `/`                     | Home                                 |
| `/products`             | Product list + search + category    |
| `/products/show/{slug}` | Product details                     |
| `/services`             | Services list                       |
| `/about`                | About page                          |
| `/contact`              | Contact form                        |
| `/auth/login`           | Login                               |
| `/auth/register`        | Register                            |
| `/auth/logout`          | Logout                              |
| `/cart`                 | Shopping cart                       |
| `/orders/checkout`      | Checkout (requires login)           |
| `/repair/create`        | Submit a repair request             |
| `/repair/track`         | Track a repair by email             |
| `/customer`             | Customer dashboard (requires login) |
| `/admin`                | Admin dashboard (admin only)        |
| `/admin/products`       | Product CRUD (admin only)           |
| `/admin/categories`     | Category CRUD (admin only)          |
| `/admin/services`       | Service CRUD (admin only)           |
| `/admin/orders`         | Order management (admin only)       |
| `/admin/repairs`        | Repair management (admin only)      |
| `/admin/customers`      | Customer list (admin only)          |
| `/admin/messages`       | Contact messages (admin only)       |

## 7. REST API

Base URL: `http://localhost/Tech-Store/public/api/`

| Method | Endpoint           | Description                        | Auth   |
|--------|--------------------|------------------------------------|--------|
| GET    | `/api/products`    | List active products               | Public |
| GET    | `/api/products/{id}` | Single product                   | Public |
| GET    | `/api/categories`  | Categories with product counts     | Public |
| GET    | `/api/services`    | List active services               | Public |
| GET    | `/api/orders`      | List orders                        | Admin  |
| GET    | `/api/orders/{id}` | Single order with items            | Admin  |
| GET    | `/api/repairs`     | List repair requests               | Admin  |
| GET    | `/api/repairs/{id}` | Single repair request             | Admin  |

Responses are JSON with proper HTTP status codes (200, 404, 405, 401/403).
Admin endpoints rely on the current session (log in as the admin first), so
they are easy to test in the browser or with Postman.

## 8. Customization

- Colors, shop name and currency: `config/config.php` and
  `public/assets/css/style.css`.
- Seed data (products, services, demo users): `database/technomeits.sql`.

## 9. Image credits

Product photos in `public/uploads/` are real photographs from Wikimedia
Commons, used under Creative Commons licenses. See [IMAGE_CREDITS.md](IMAGE_CREDITS.md)
for per-file attribution.

## 10. Future ideas (out of scope for v1)

Online payment integration, appointment scheduling, inventory low-stock alerts
and multilingual support.
