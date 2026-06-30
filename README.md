# 🌿 FloraFetch — Plant E-Commerce Platform

A Laravel-based e-commerce web application for buying and selling plants online. Built as a Final Year Project (FYP).

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 10 (PHP) |
| Database | MySQL |
| Frontend | Blade Templates + CSS |
| Auth | Laravel Session Auth |
| Payment | Cash on Delivery (COD) |

---

## ✅ Features

- 🌱 Plant catalog with search & filter (category, sunlight, watering)
- 🛒 Session-based shopping cart
- 📦 Order placement with COD
- 👤 Customer registration & login
- 🔑 Admin dashboard with plant CRUD & order management
- 📉 Auto stock decrement on order
- 🔒 Role-based access (admin/customer)

---

## 🚀 Local Setup

### Requirements
- PHP 8.1+
- MySQL
- Composer

### Steps

```bash
# 1. Clone the repo
git clone https://github.com/dani-hacker/Flora-Fetch-fyp.git
cd Flora-Fetch-fyp

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env
DB_DATABASE=florafetch_db
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations & seed
php artisan migrate --seed

# 6. Storage link
php artisan storage:link

# 7. Start server
php artisan serve
```

Open: **http://localhost:8000**

---

## 🔑 Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@florafetch.com | Admin@1234 |
| Customer | jane@example.com | Customer@1234 |

---

## 📁 Project Structure

```
florafetch/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # All controllers
│   │   └── Middleware/      # Auth & Admin middleware
│   └── Models/              # User, Plant, Order, OrderItem
├── database/
│   ├── migrations/          # 4 tables
│   └── seeders/             # Admin + 10 plants sample data
├── resources/views/         # Blade templates
│   ├── admin/               # Admin panel views
│   ├── auth/                # Login & Register
│   ├── cart/                # Cart & Checkout
│   ├── orders/              # Order history
│   └── plants/              # Plant catalog
├── routes/
│   └── web.php              # All routes
└── public/                  # Entry point
```

---

## 📋 Key Files Description

| # | File / Directory | Description |
|---|-----------------|-------------|
| 1 | `database/migrations/` | 4 tables — `users`, `plants`, `orders`, `order_items` |
| 2 | `app/Models/` | `User`, `Plant`, `Order`, `OrderItem` with relationships |
| 3 | `AuthController.php` | Register, Login, Logout with bcrypt password hashing |
| 4 | `PlantController.php` | Plant catalog with filters (category, sunlight, watering) |
| 5 | `CartController.php` | Session-based cart (add, update, remove, clear) |
| 6 | `OrderController.php` | COD order placement with DB transaction & stock deduction |
| 7 | `AdminDashboardController.php` | Admin stats — today's orders, pending, low stock, users |
| 8 | `AdminPlantController.php` | Full Plant CRUD (create, edit, update, delete + image upload) |
| 9 | `AdminOrderController.php` | Order status update (Pending → Processing → Delivered) |
| 10 | `AdminMiddleware.php` | Admin route protection — blocks non-admin users (403) |
| 11 | `resources/views/` | All Blade views — Catalog, Detail, Cart, Checkout, Admin |
| 12 | `DatabaseSeeder.php` | Seeds admin account + 10 sample plants with prices |
| 13 | `routes/web.php` | All public, customer & admin routes with middleware |

---

*FloraFetch FYP Project — 2024*
