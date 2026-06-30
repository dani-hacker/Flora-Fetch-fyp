#!/bin/bash

echo ""
echo "========================================="
echo " 🌿  FloraFetch — Automatic Setup (Mac/Linux)"
echo "========================================="
echo ""

# ── STEP 1: Check PHP ──────────────────────────────────────────────────────────
echo "[1/8] Checking PHP..."
if ! command -v php &> /dev/null; then
    echo " ❌ ERROR: PHP not found! Install PHP 8.1+ first."
    exit 1
fi
echo " ✅ PHP found: $(php --version | head -1)"

# ── STEP 2: Check Composer ─────────────────────────────────────────────────────
echo "[2/8] Checking Composer..."
if ! command -v composer &> /dev/null; then
    echo " ❌ ERROR: Composer not found!"
    echo "    Run: curl -sS https://getcomposer.org/installer | php"
    exit 1
fi
echo " ✅ Composer found!"

# ── STEP 3: Install Dependencies ──────────────────────────────────────────────
echo "[3/8] Installing PHP dependencies..."
composer install --no-interaction --optimize-autoloader
echo " ✅ Dependencies installed!"

# ── STEP 4: Setup .env ────────────────────────────────────────────────────────
echo "[4/8] Setting up .env file..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo " ✅ .env file created!"
else
    echo " ✅ .env already exists — skipping"
fi

# ── STEP 5: Generate App Key ──────────────────────────────────────────────────
echo "[5/8] Generating Application Key..."
php artisan key:generate --force
echo " ✅ App key generated!"

# ── STEP 6: Create Database ───────────────────────────────────────────────────
echo "[6/8] Creating database..."
mysql -u root -e "CREATE DATABASE IF NOT EXISTS florafetch_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null
if [ $? -ne 0 ]; then
    echo " ⚠️  Could not auto-create DB. Create 'florafetch_db' manually then press Enter..."
    read
else
    echo " ✅ Database created!"
fi

# ── STEP 7: Migrate + Seed ────────────────────────────────────────────────────
echo "[7/8] Running migrations and seeding..."
php artisan migrate --seed --force
echo " ✅ Database ready!"

# ── STEP 8: Storage Link ──────────────────────────────────────────────────────
echo "[8/8] Creating storage link..."
php artisan storage:link --force
echo " ✅ Storage link created!"

echo ""
echo "========================================="
echo " 🎉  Setup Complete! FloraFetch is Ready"
echo "========================================="
echo ""
echo " 🌐  Open: http://localhost:8000"
echo ""
echo " Admin    : admin@florafetch.com / Admin@1234"
echo " Customer : jane@example.com / Customer@1234"
echo ""
echo " Starting server... (CTRL+C to stop)"
echo ""
php artisan serve
