# Pacudan's Bakeshop — Online Ordering & Management System

A full-featured web application built for **Pacudan's Bakeshop & Coffee Bar**. It provides a customer-facing online storefront for browsing products, managing a cart, and placing orders, along with a complete **admin panel** for managing products, inventory, orders, categories, users, and notifications.

## 📋 What It Is

Pacudan's Bakeshop is an e-commerce / point-of-order system tailored for a local bakeshop and coffee bar. Customers can:

- Browse the product catalog (breads, pastries, coffee, etc.)
- View product details, variants, and availability
- Add items to a cart and place orders
- Save favorite products
- Receive notifications about their orders

Staff/Administrators can:

- Manage products, product variants, and categories
- Track stock levels with an inventory log system
- Process and update customer orders
- Manage user accounts
- Send/receive in-app notifications

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Language | PHP 8.2+ |
| Framework | CodeIgniter 4 |
| Database | MySQL / MariaDB (via XAMPP) |
| Frontend | HTML5, CSS3, Vanilla JavaScript |
| CSS Framework | Bootstrap 5.3 + Bootstrap Icons |
| Fonts | Google Fonts (Playfair Display, Inter) |
| UI Enhancements | AOS (Animate On Scroll), SweetAlert2 |
| Dev Tooling | PHPUnit, PHP CS Fixer, Kint Debug Bar, Faker |
| Server | Apache (XAMPP) |

## 🏗️ Architecture

The project follows the classic **MVC (Model–View–Controller)** architecture enforced by CodeIgniter 4:

```
TEST/
├── app/
│   ├── Config/          # Application configuration (App, Routes, Database, etc.)
│   ├── Controllers/     # Request handling & business logic
│   │   ├── Auth.php     # Authentication (login/register)
│   │   ├── Home.php     # Landing page
│   │   ├── Product.php  # Product catalog (public)
│   │   ├── Cart.php     # Shopping cart
│   │   ├── Favorites.php# Customer favorites
│   │   ├── Admin.php    # Admin dashboard (products, orders, users)
│   │   └── NotificationController.php
│   ├── Models/          # Data access layer
│   │   ├── UserModel, ProductModel, CategoryModel
│   │   ├── OrderModel, OrderItemModel
│   │   ├── ProductVariantModel, InventoryLogModel
│   │   └── FavoritesModel, NotificationModel
│   ├── Views/           # Presentation layer
│   │   ├── layout.php   # Global layout/template
│   │   ├── auth/, cart/, home.php, products/
│   │   └── admin/       # Admin views (orders/, products/)
│   ├── Database/
│   │   ├── Migrations/  # Schema definitions
│   │   └── Seeds/       # Test/sample data
│   └── Filters/         # Request filters (auth guards)
├── public/              # Web root (index.php, assets/css, js, images)
├── writable/            # Runtime storage (logs, sessions, cache, uploads)
├── tests/               # PHPUnit test suite
└── spark                # CodeIgniter CLI tool
```

**Request flow:** Browser → `public/index.php` → Routing (`Config/Routes`) → Filters (auth/session checks) → Controller → Model (MySQL) → View → Response.

### Database Schema (via migrations)

- `users` — accounts & authentication
- `categories` — product groupings
- `products` — catalog items
- `product_variants` — size/price variants per product
- `orders` — customer orders
- `order_items` — line items per order
- `inventory_logs` — stock movement history
- `notifications` — in-app notifications (with links)

## ✨ Features

### Customer Side
- 🏠 Landing/home page with animated sections (AOS)
- 🧁 Product catalog with category browsing
- 🔍 Product detail view with variants
- 🛒 Shopping cart management
- ❤️ Favorites / wishlist
- 📦 Order placement & order tracking
- 🔔 In-app notifications
- 🔐 User registration & login (session-based)

### Admin Panel
- 📊 Admin dashboard
- 🧾 Product CRUD with image uploads
- 🏷️ Category & variant management
- 📥 Order management & status updates
- 📦 Inventory tracking with logs
- 👤 User management
- 🔔 Notification system

## 🚀 Getting Started

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL + PHP 8.2+)
- Composer

### Installation

1. Clone the repository into your XAMPP `htdocs` folder:
   ```bash
   cd C:\xampp\htdocs
   git clone https://github.com/Novicedev123/Pacudans-Bakeshop.git
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Create a database in MySQL (e.g., via phpMyAdmin) and configure `.env`:
   ```env
   database.default.hostname = localhost
   database.default.database = your_db_name
   database.default.username = root
   database.default.password =
   ```

4. Run migrations:
   ```bash
   php spark migrate
   ```

5. Serve the app:
   ```
   http://localhost/cdi4/TEST/public/
   ```
   or use the built-in server:
   ```bash
   php spark serve
   ```

## 📄 License

This project is released under the [MIT License](LICENSE).
