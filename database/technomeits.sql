-- ============================================================
--  TechnoMeits Store Management System (TSMS) - Database Schema
--  MySQL 8.x / MariaDB 10.x
-- ============================================================

CREATE DATABASE IF NOT EXISTS technomeits
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE technomeits;

-- ------------------------------------------------------------
--  USERS (customers + administrators)
-- ------------------------------------------------------------
CREATE TABLE users (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    phone      VARCHAR(20)  DEFAULT NULL,
    address    VARCHAR(255) DEFAULT NULL,
    password   VARCHAR(255) NOT NULL,
    role       ENUM('customer', 'admin') NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_users_role (role)
) ENGINE = InnoDB;

-- ------------------------------------------------------------
--  CATEGORIES (product categories)
-- ------------------------------------------------------------
CREATE TABLE categories (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    slug        VARCHAR(120) NOT NULL UNIQUE,
    description TEXT,
    created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;

-- ------------------------------------------------------------
--  PRODUCTS
-- ------------------------------------------------------------
CREATE TABLE products (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED DEFAULT NULL,
    name        VARCHAR(150) NOT NULL,
    slug        VARCHAR(160) NOT NULL UNIQUE,
    description TEXT,
    price       DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    old_price   DECIMAL(10, 2) DEFAULT NULL,
    stock       INT UNSIGNED NOT NULL DEFAULT 0,
    image       VARCHAR(255) DEFAULT NULL,
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_products_category (category_id),
    INDEX idx_products_active (is_active),
    CONSTRAINT fk_products_category
        FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE SET NULL
) ENGINE = InnoDB;

-- ------------------------------------------------------------
--  SERVICES (repair and technical services)
-- ------------------------------------------------------------
CREATE TABLE services (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(150) NOT NULL,
    description TEXT,
    price       DECIMAL(10, 2) DEFAULT NULL,
    icon        VARCHAR(100) DEFAULT NULL,
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;

-- ------------------------------------------------------------
--  ORDERS (placed by customers)
-- ------------------------------------------------------------
CREATE TABLE orders (
    id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_number     VARCHAR(20) NOT NULL UNIQUE,
    user_id          INT UNSIGNED DEFAULT NULL,
    customer_name    VARCHAR(100) NOT NULL,
    customer_email   VARCHAR(150) NOT NULL,
    customer_phone   VARCHAR(20)  NOT NULL,
    shipping_address VARCHAR(255) DEFAULT NULL,
    payment_method   ENUM('pay_in_store', 'cash_on_delivery') NOT NULL DEFAULT 'pay_in_store',
    status           ENUM('pending', 'confirmed', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending',
    total            DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    notes            TEXT,
    created_at       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_orders_user (user_id),
    INDEX idx_orders_status (status),
    CONSTRAINT fk_orders_user
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL
) ENGINE = InnoDB;

-- ------------------------------------------------------------
--  ORDER ITEMS (rows inside an order)
-- ------------------------------------------------------------
CREATE TABLE order_items (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id     INT UNSIGNED NOT NULL,
    product_id   INT UNSIGNED DEFAULT NULL,
    product_name VARCHAR(150) NOT NULL,
    quantity     INT UNSIGNED NOT NULL DEFAULT 1,
    price        DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    INDEX idx_order_items_order (order_id),
    CONSTRAINT fk_order_items_order
        FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE,
    CONSTRAINT fk_order_items_product
        FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE SET NULL
) ENGINE = InnoDB;

-- ------------------------------------------------------------
--  REPAIR REQUESTS
-- ------------------------------------------------------------
CREATE TABLE repair_requests (
    id                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id           INT UNSIGNED DEFAULT NULL,
    customer_name     VARCHAR(100) NOT NULL,
    customer_email    VARCHAR(150) NOT NULL,
    customer_phone    VARCHAR(20)  NOT NULL,
    device_type       VARCHAR(50)  NOT NULL,
    brand_model       VARCHAR(100) DEFAULT NULL,
    issue_description TEXT NOT NULL,
    status            ENUM('pending', 'in_progress', 'repaired', 'collected', 'cancelled') NOT NULL DEFAULT 'pending',
    created_at        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_repairs_status (status),
    CONSTRAINT fk_repairs_user
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL
) ENGINE = InnoDB;

-- ------------------------------------------------------------
--  CONTACT MESSAGES
-- ------------------------------------------------------------
CREATE TABLE contact_messages (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL,
    phone      VARCHAR(20)  DEFAULT NULL,
    subject    VARCHAR(150) DEFAULT NULL,
    message    TEXT NOT NULL,
    is_read    TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_messages_read (is_read)
) ENGINE = InnoDB;

-- ============================================================
--  SAMPLE DATA
-- ============================================================

-- Password for both sample users is the same as the login shown.
-- admin123    => the administrator account
-- customer123 => a regular customer account

INSERT INTO users (name, email, phone, address, password, role) VALUES
('Store Admin',   'admin@technomeits.ma',    '0660000000', 'Avenue Hassan II, Laâyoune', '$2y$10$hV3GQOwAVWTJBzvrFaQKH.Cpk/xGd9S5vnm/aE/tq3TLb.te1Wf62', 'admin'),
('Sara Customer', 'customer@example.com',    '0661111111', 'Quartier Massira, Laâyoune', '$2y$10$60OUTvIKBnj6nhHP.3xO3.lqbmMzBIo5G9PwB3kgvZKxbHH1al1p2', 'customer');

INSERT INTO categories (name, slug, description) VALUES
('Computers',    'computers',    'Desktops, laptops and PC components.'),
('Smartphones',  'smartphones',  'New and used smartphones from popular brands.'),
('Accessories',  'accessories',  'Chargers, headphones, cases and more.'),
('Used Devices', 'used-devices', 'Certified used computers and phones at great prices.');

INSERT INTO products (category_id, name, slug, description, price, old_price, stock, image, is_featured, is_active) VALUES
(1, 'HP ProBook 450 G8', 'hp-probook-450-g8', '15.6" laptop, Intel Core i5, 8GB RAM, 512GB SSD. Ideal for work and study.', 7999.00, 8999.00, 8, 'hp-probook-450-g8.jpg', 1, 1),
(1, 'Dell OptiPlex Desktop', 'dell-optiplex-desktop', 'Core i5 desktop, 16GB RAM, 512GB SSD. Complete PC for home and office.', 5999.00, NULL, 5, 'dell-optiplex-desktop.jpg', 0, 1),
(2, 'Samsung Galaxy A54', 'samsung-galaxy-a54', '6.4" AMOLED, 128GB, 50MP camera. Dual SIM.', 3299.00, 3599.00, 12, 'samsung-galaxy-a54.jpg', 1, 1),
(2, 'iPhone 12 128GB', 'iphone-12-128gb', 'Used in excellent condition. 6.1" Super Retina XDR display.', 3899.00, 4299.00, 4, 'iphone-12-128gb.jpg', 1, 1),
(3, 'Anker 65W Charger', 'anker-65w-charger', 'USB-C fast charger compatible with laptops and phones.', 299.00, NULL, 30, 'anker-65w-charger.jpg', 0, 1),
(3, 'JBL Tune 510BT Headphones', 'jbl-tune-510bt', 'Wireless Bluetooth headphones with 40h battery life.', 399.00, 499.00, 20, 'jbl-tune-510bt.jpg', 0, 1),
(4, 'Lenovo ThinkPad T480 (Used)', 'lenovo-thinkpad-t480-used', 'Certified used, Core i5, 16GB RAM, 256GB SSD, 1-year warranty.', 3499.00, 3999.00, 6, 'lenovo-thinkpad-t480-used.jpg', 1, 1),
(4, 'Redmi Note 11 (Used)', 'redmi-note-11-used', 'Certified used smartphone, 128GB, dual SIM, tested battery.', 1299.00, NULL, 10, 'redmi-note-11-used.jpg', 0, 1);

INSERT INTO services (name, description, price, icon) VALUES
('Computer Repair',    'Diagnosis and repair of desktops and laptops, hardware and software.', 150.00, 'laptop'),
('Smartphone Repair',  'Screen, battery and charging port replacement for all major brands.', 200.00, 'phone'),
('OS Installation',    'Windows / Linux installation with drivers and basic setup.', 100.00, 'monitor'),
('Virus Removal',      'Deep cleaning and removal of viruses and unwanted software.', 150.00, 'shield'),
('Wi-Fi & Network Setup', 'Router configuration and home / office Wi-Fi installation.', 250.00, 'wifi'),
('Software Troubleshooting', 'Fixing crashes, slow systems and installing essential software.', 100.00, 'gear');

INSERT INTO orders (order_number, user_id, customer_name, customer_email, customer_phone, shipping_address, payment_method, status, total, notes) VALUES
('TM-20260001', 2, 'Sara Customer', 'customer@example.com', '0661111111', 'Quartier Massira, Laâyoune', 'cash_on_delivery', 'delivered', 3899.00, 'Please call before delivery.');

INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES
(1, 4, 'iPhone 12 128GB', 1, 3899.00);

INSERT INTO repair_requests (user_id, customer_name, customer_email, customer_phone, device_type, brand_model, issue_description, status) VALUES
(2, 'Sara Customer', 'customer@example.com', '0661111111', 'smartphone', 'Samsung Galaxy A54', 'Screen cracked after a fall, need a replacement estimate.', 'in_progress'),
(NULL, 'Youssef Amrani', 'youssef.amrani@example.com', '0662222222', 'computer', 'HP Pavilion', 'Computer does not start, black screen with a beeping sound.', 'pending');

INSERT INTO contact_messages (name, email, phone, subject, message, is_read) VALUES
('Youssef Amrani', 'youssef.amrani@example.com', '0662222222', 'Opening hours', 'Hello, what are your opening hours on Saturday?', 0);
