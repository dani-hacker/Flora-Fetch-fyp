@echo off
title FloraFetch — Auto Setup
color 0A

echo.
echo  =========================================
echo   🌿  FloraFetch — Automatic Setup
echo  =========================================
echo.

:: ── CHECK: Must be inside XAMPP htdocs ────────────────────────────────────────
echo [0/8] Checking project location...
set "CURRENT=%CD%"
echo "%CURRENT%" | findstr /i "htdocs" >nul
if %errorlevel% neq 0 (
    echo.
    echo  ⚠️  WARNING: Project is not inside XAMPP htdocs folder!
    echo.
    echo  Please clone the project correctly:
    echo    cd C:\xampp\htdocs
    echo    git clone https://github.com/dani-hacker/Flora-Fetch-fyp.git florafetch
    echo    cd florafetch
    echo    setup.bat
    echo.
    pause
    exit /b 1
)
echo  ✅ Location OK: %CURRENT%

:: ── STEP 1: Check PHP ────────────────────────────────────────────────────────
echo [1/8] Checking PHP...
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo  ❌ ERROR: PHP not found in PATH!
    echo     Please add PHP to your system PATH first.
    echo     Usually: C:\xampp\php  or  C:\php
    pause
    exit /b 1
)
echo  ✅ PHP found!

:: ── STEP 2: Check Composer ────────────────────────────────────────────────────
echo [2/8] Checking Composer...
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo  ❌ ERROR: Composer not found!
    echo     Download from: https://getcomposer.org/Composer-Setup.exe
    pause
    exit /b 1
)
echo  ✅ Composer found!

:: ── STEP 3: Install Dependencies ─────────────────────────────────────────────
echo [3/8] Installing PHP dependencies (composer install)...
composer install --no-interaction --optimize-autoloader
if %errorlevel% neq 0 (
    echo  ❌ ERROR: composer install failed!
    pause
    exit /b 1
)
echo  ✅ Dependencies installed!

:: ── STEP 4: Setup .env ────────────────────────────────────────────────────────
echo [4/8] Setting up .env file...
if not exist .env (
    copy .env.example .env >nul
    echo  ✅ .env file created from .env.example
) else (
    echo  ✅ .env file already exists — skipping
)

:: ── STEP 5: Generate App Key ──────────────────────────────────────────────────
echo [5/8] Generating Application Key...
php artisan key:generate --force
if %errorlevel% neq 0 (
    echo  ❌ ERROR: key:generate failed!
    pause
    exit /b 1
)
echo  ✅ App key generated!

:: ── STEP 6: Create Database ───────────────────────────────────────────────────
echo [6/8] Creating database (florafetch_db)...
mysql -u root -e "CREATE DATABASE IF NOT EXISTS florafetch_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>nul
if %errorlevel% neq 0 (
    echo  ⚠️  Could not auto-create database.
    echo     Please manually create database 'florafetch_db' in phpMyAdmin.
    echo     Then press any key to continue...
    pause >nul
) else (
    echo  ✅ Database created!
)

:: ── STEP 7: Run Migrations + Seed ────────────────────────────────────────────
echo [7/8] Running migrations and seeding data...
php artisan migrate --seed --force
if %errorlevel% neq 0 (
    echo  ❌ ERROR: Migration failed! Is MySQL running?
    echo     Start XAMPP MySQL and try again.
    pause
    exit /b 1
)
echo  ✅ Database tables created and seeded!

:: ── STEP 8: Storage Link ─────────────────────────────────────────────────────
echo [8/8] Creating storage symlink...
php artisan storage:link --force >nul 2>&1
echo  ✅ Storage link created!

:: ── DONE! ─────────────────────────────────────────────────────────────────────
echo.
echo  =========================================
echo   🎉  Setup Complete! FloraFetch is Ready
echo  =========================================
echo.
echo   🌐 Open in browser: http://localhost:8000
echo.
echo   Login Credentials:
echo   ┌─────────────────────────────────────────┐
echo   │  Admin    : admin@florafetch.com         │
echo   │  Password : Admin@1234                   │
echo   ├─────────────────────────────────────────┤
echo   │  Customer : jane@example.com             │
echo   │  Password : Customer@1234                │
echo   └─────────────────────────────────────────┘
echo.
echo  Starting development server...
echo  (Press CTRL+C to stop the server)
echo.
php artisan serve
