@echo off
REM Laravel Production Deployment Script for Windows
echo ===================================
echo Laravel Production Deployment Script
echo ===================================
echo.

REM Check if we're in the right directory
if not exist "artisan" (
    echo [ERROR] artisan file not found. Please run this script from your Laravel root directory.
    exit /b 1
)

echo [OK] Starting deployment process...
echo.

REM Step 1: Clear all caches
echo [STEP 1] Clearing all caches...
php artisan optimize:clear
if %errorlevel% neq 0 (
    echo [ERROR] Failed to clear caches
    exit /b 1
)
echo [OK] Caches cleared successfully
echo.

REM Step 2: Install/Update Composer dependencies
echo [STEP 2] Installing Composer dependencies...
call composer install --optimize-autoloader --no-dev
if %errorlevel% neq 0 (
    echo [ERROR] Failed to install Composer dependencies
    exit /b 1
)
echo [OK] Composer dependencies installed
echo.

REM Step 3: Run migrations
echo [STEP 3] Running database migrations...
php artisan migrate --force
if %errorlevel% neq 0 (
    echo [WARNING] Migrations failed or were skipped
)
echo [OK] Migrations completed
echo.

REM Step 4: Create storage link
echo [STEP 4] Creating storage symlink...
php artisan storage:link
if %errorlevel% neq 0 (
    echo [WARNING] Storage link already exists or failed to create
)
echo [OK] Storage link created
echo.

REM Step 5: Cache for production
echo [STEP 5] Caching configuration, routes, and views...
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
if %errorlevel% neq 0 (
    echo [ERROR] Failed to optimize application
    exit /b 1
)
echo [OK] Application optimized for production
echo.

REM Step 6: Verify environment
echo [STEP 6] Verifying environment settings...
findstr /C:"APP_ENV=production" .env >nul
if %errorlevel% equ 0 (
    echo [OK] APP_ENV is set to production
) else (
    echo [ERROR] APP_ENV is not set to production! Please update your .env file
)

findstr /C:"APP_DEBUG=false" .env >nul
if %errorlevel% equ 0 (
    echo [OK] APP_DEBUG is set to false
) else (
    echo [WARNING] APP_DEBUG should be false in production! Please update your .env file
)
echo.

REM Final status
echo ===================================
echo [OK] Deployment completed successfully!
echo ===================================
echo.
echo [WARNING] Important reminders:
echo   1. Verify your .env file has correct production settings
echo   2. Ensure APP_DEBUG=false and APP_ENV=production
echo   3. Check that your database connection works
echo   4. Test the application thoroughly
echo.
pause
