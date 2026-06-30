# 📋 FloraFetch — System Requirements

## ✅ Required Software

| Software | Minimum Version | Download Link |
|----------|----------------|---------------|
| **PHP** | 8.1 or higher | https://www.php.net/downloads |
| **MySQL** | 5.7 or higher | Included in XAMPP |
| **Composer** | 2.x | https://getcomposer.org/Composer-Setup.exe |
| **XAMPP** | Latest (Windows) | https://www.apachefriends.org |
| **Git** | Any | https://git-scm.com/downloads |

---

## ✅ Required PHP Extensions

These must be enabled in your `php.ini` file:

| Extension | Required For |
|-----------|-------------|
| `extension=pdo_mysql` | Database connection |
| `extension=mbstring` | String handling |
| `extension=openssl` | Encryption & App Key |
| `extension=zip` | Composer package downloads |
| `extension=fileinfo` | File uploads |
| `extension=curl` | HTTP requests |
| `extension=gd` OR `extension=imagick` | Image processing |

> **XAMPP Users:** Open `C:\xampp\php\php.ini` and uncomment these lines (remove the `;` at start)

---

## 🚀 One-Command Setup

### Windows (CMD or PowerShell as Administrator):

**Step 1 — Clone the project:**
```cmd
git clone https://github.com/dani-hacker/Flora-Fetch-fyp.git
cd Flora-Fetch-fyp
```

**Step 2 — Run setup (single command):**
```cmd
setup.bat
```

> ✅ That's it! The script will automatically:
> - Install all PHP dependencies (`composer install`)
> - Create the `.env` file
> - Generate the application key
> - Create the `florafetch_db` database
> - Run all migrations (create 4 tables)
> - Seed sample data (Admin + 10 Plants)
> - Create storage symlink
> - Start the development server

---

### Mac / Linux:

```bash
git clone https://github.com/dani-hacker/Flora-Fetch-fyp.git
cd Flora-Fetch-fyp
chmod +x setup.sh
./setup.sh
```

---

## ⚙️ Before Running Setup

### 1. Make sure XAMPP is running:
- ✅ Apache — **Started**
- ✅ MySQL — **Started**

### 2. PHP must be in your PATH:
```cmd
php --version
```
If not found, add to PATH: `C:\xampp\php`

### 3. Composer must be installed:
```cmd
composer --version
```
If not found: Download from https://getcomposer.org/Composer-Setup.exe

---

## 🌐 After Setup

Open your browser and go to:
```
http://localhost:8000
```

### Login Credentials:
| Role | Email | Password |
|------|-------|----------|
| 🔑 Admin | admin@florafetch.com | Admin@1234 |
| 👤 Customer | jane@example.com | Customer@1234 |

---

## ❌ Common Errors & Fixes

| Error | Fix |
|-------|-----|
| `php is not recognized` | Add `C:\xampp\php` to Windows PATH |
| `composer not found` | Download & install Composer from getcomposer.org |
| `SQLSTATE: Connection refused` | Start MySQL in XAMPP Control Panel |
| `Zip extension missing` | Enable `extension=zip` in php.ini |
| `Access denied for user root` | Check DB_PASSWORD in `.env` file |
| `Target class does not exist` | Run `composer dump-autoload` |
| `No application encryption key` | Run `php artisan key:generate` |

---

## 📁 What Gets Installed

```
florafetch/
├── vendor/          ← PHP packages (composer install)
├── .env             ← Environment config (auto-created)
├── public/storage   ← Storage symlink (auto-created)
└── florafetch_db    ← MySQL database with 4 tables + sample data
```

---

## 🔄 Manual Setup (if script fails)

```bash
composer install
cp .env.example .env
php artisan key:generate
# Create database 'florafetch_db' in phpMyAdmin
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

---

*FloraFetch FYP Project — Laravel 10 | PHP 8.1+*
