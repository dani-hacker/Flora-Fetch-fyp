# 🌿 FloraFetch — Setup Guide

**FYP Project | Shahzaib Haider CH | Supervisor: Muhammad Hassaan**

---

## What's Included

| Layer    | Technology                                    |
| -------- | --------------------------------------------- |
| Backend  | PHP 8.1 + Laravel 10 (MVC)                    |
| Database | MySQL 8.0 (4 tables, fully normalized to 3NF) |
| Frontend | Blade Templates + Tailwind CSS (CDN)          |
| Auth     | Laravel session-based auth with bcrypt        |

---

## Project Structure

```
florafetch/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Register, Login, Logout
│   │   │   ├── PlantController.php         # Catalog + Detail (FR-03)
│   │   │   ├── CartController.php          # Session cart (FR-04)
│   │   │   ├── OrderController.php         # Place order, history (FR-05)
│   │   │   └── AdminController.php         # Dashboard, CRUD, Order mgmt
│   │   └── Middleware/
│   │       └── AdminMiddleware.php         # Protects /admin/* routes
│   └── Models/
│       ├── User.php                        # role: admin | customer
│       ├── Plant.php                       # Full fields incl. watering_need
│       ├── Order.php                       # Status: Pending/Processing/Delivered
│       └── OrderItem.php                   # Bridge table (Many-to-Many fix)
├── database/
│   ├── migrations/
│   │   ├── ..._create_users_table.php
│   │   ├── ..._create_plants_table.php
│   │   └── ..._create_orders_table.php     # Creates both orders + order_items
│   └── seeders/
│       └── DatabaseSeeder.php              # Admin + demo customer + 10 plants
├── resources/views/
│   ├── layouts/app.blade.php               # Main layout with navbar
│   ├── auth/{login,register}.blade.php
│   ├── plants/{index,show}.blade.php       # GUI 1 & 2
│   ├── cart/{index,checkout}.blade.php     # GUI 3
│   ├── orders/index.blade.php              # Customer order history
│   └── admin/
│       ├── dashboard.blade.php             # GUI 4
│       ├── plants/{index,create,edit}
│       └── orders/index.blade.php
└── routes/web.php                          # All routes
```

---

## Step-by-Step Setup

### Step 1 — Install Laravel (if starting fresh)

```bash
composer create-project laravel/laravel florafetch
cd florafetch
```

Then **copy all files from this zip** into the project folder, overwriting as needed.

### Step 2 — Configure Database

```bash
# Copy the env file
cp .env.example .env

# Edit .env and set your MySQL credentials:
DB_DATABASE=florafetch_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create the database in MySQL:

```sql
CREATE DATABASE florafetch_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 3 — Install Dependencies & Generate Key

```bash
composer install
php artisan key:generate
```

### Step 4 — Run Migrations & Seed Data

```bash
# Creates all 4 tables (users, plants, orders, order_items)
php artisan migrate

# Seeds admin account + 10 sample plants
php artisan db:seed
```

### Step 5 — Register Middleware

In `app/Http/Kernel.php`, add to `$routeMiddleware`:

```php
'admin' => \App\Http\Middleware\AdminMiddleware::class,
```

### Step 6 — Storage for Images

```bash
php artisan storage:link
```

### Step 7 — Run the App

```bash
php artisan serve
```

Visit: **http://localhost:8000**

---

## Default Login Credentials

| Account  | Email                | Password      |
| -------- | -------------------- | ------------- |
| Admin    | admin@florafetch.com | Admin@1234    |
| Customer | jane@example.com     | Customer@1234 |

---

## Database Schema (Quick Reference)

```
users          → id, name, email, password, role (ENUM: admin/customer)
plants         → id, name, category, price, sunlight_requirement,
                 watering_need, stock_quantity, image_url, description
orders         → id, user_id (FK), total_amount, status (ENUM), shipping_address
order_items    → id, order_id (FK), plant_id (FK), quantity, price_at_purchase
```

**All fixes from SRS v4.0 are implemented:**

- ✅ `order_items` table added (was missing from v3.0 DB design)
- ✅ `watering_need` field added to plants
- ✅ `image_url` and `description` fields added to plants
- ✅ `price_at_purchase` in order_items locks historical pricing
- ✅ Passwords hashed with bcrypt (NFR-02)
- ✅ DB transactions on order placement (NFR-03)
- ✅ Indexed columns for fast filtering (NFR-01)
- ✅ Admin middleware protecting all /admin/\* routes

---

## Routes Summary

| Method   | URL                       | Description              |
| -------- | ------------------------- | ------------------------ |
| GET      | /                         | Plant catalog (homepage) |
| GET      | /plants/{id}              | Plant detail page        |
| GET/POST | /register                 | Customer registration    |
| GET/POST | /login                    | Login                    |
| POST     | /logout                   | Logout                   |
| GET      | /cart                     | View cart                |
| POST     | /cart/{plant}             | Add to cart              |
| GET      | /checkout                 | Checkout form (COD)      |
| POST     | /orders                   | Place order              |
| GET      | /orders                   | Customer order history   |
| GET      | /admin/dashboard          | Admin dashboard          |
| GET/POST | /admin/plants             | Plant CRUD               |
| GET      | /admin/orders             | All orders               |
| PATCH    | /admin/orders/{id}/status | Update order status      |

## Full Project Zip

**🗂️ FloraFetch_Complete_Project.zip**
Poora Laravel project structure with:

| File / Directory      | Kya karta hai (Description)                                  |
| --------------------- | ------------------------------------------------------------ |
| `migrations/`         | 4 tables — users, plants, orders, order_items                |
| `Models/`             | User, Plant, Order, OrderItem with relationships             |
| `AuthController.php`  | Register, Login, Logout with bcrypt                          |
| `PlantController.php` | Catalog + filters (category, sunlight, watering)             |
| `CartController.php`  | Session-based cart                                           |
| `OrderController.php` | COD order placement with DB transaction                      |
| `AdminController.php` | Dashboard, Plant CRUD, Order status update                   |
| `AdminMiddleware.php` | Admin route protection                                       |
| `views/`              | Sab 4 GUIs — Catalog, Detail, Cart/Checkout, Admin Dashboard |
| `DatabaseSeeder.php`  | Admin account + 10 sample plants                             |
| `README.md`           | Step-by-step setup guide                                     |
