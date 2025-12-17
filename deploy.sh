#!/bin/bash

echo "==================================="
echo "Laravel Production Deployment Script"
echo "==================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}[✓]${NC} $1"
}

print_error() {
    echo -e "${RED}[✗]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[!]${NC} $1"
}

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    print_error "artisan file not found. Please run this script from your Laravel root directory."
    exit 1
fi

print_status "Starting deployment process..."
echo ""

# Step 1: Clear all caches
print_status "Step 1: Clearing all caches..."
php artisan optimize:clear
if [ $? -eq 0 ]; then
    print_status "Caches cleared successfully"
else
    print_error "Failed to clear caches"
    exit 1
fi
echo ""

# Step 2: Install/Update Composer dependencies
print_status "Step 2: Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev
if [ $? -eq 0 ]; then
    print_status "Composer dependencies installed"
else
    print_error "Failed to install Composer dependencies"
    exit 1
fi
echo ""

# Step 3: Set proper permissions
print_status "Step 3: Setting file permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Try to set ownership (may require sudo)
if [ "$(id -u)" = "0" ]; then
    chown -R www-data:www-data storage
    chown -R www-data:www-data bootstrap/cache
    print_status "Ownership set to www-data"
else
    print_warning "Not running as root. You may need to set ownership manually:"
    echo "    sudo chown -R www-data:www-data storage bootstrap/cache"
fi
print_status "Permissions set successfully"
echo ""

# Step 4: Run migrations
print_status "Step 4: Running database migrations..."
php artisan migrate --force
if [ $? -eq 0 ]; then
    print_status "Migrations completed"
else
    print_warning "Migrations failed or were skipped"
fi
echo ""

# Step 5: Create storage link
print_status "Step 5: Creating storage symlink..."
php artisan storage:link
if [ $? -eq 0 ]; then
    print_status "Storage link created"
else
    print_warning "Storage link already exists or failed to create"
fi
echo ""

# Step 6: Cache for production
print_status "Step 6: Caching configuration, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
if [ $? -eq 0 ]; then
    print_status "Application optimized for production"
else
    print_error "Failed to optimize application"
    exit 1
fi
echo ""

# Step 7: Verify environment
print_status "Step 7: Verifying environment settings..."
if grep -q "APP_ENV=production" .env; then
    print_status "APP_ENV is set to production"
else
    print_error "APP_ENV is not set to production! Please update your .env file"
fi

if grep -q "APP_DEBUG=false" .env; then
    print_status "APP_DEBUG is set to false"
else
    print_warning "APP_DEBUG should be false in production! Please update your .env file"
fi
echo ""

# Final status
echo "==================================="
print_status "Deployment completed successfully!"
echo "==================================="
echo ""
print_warning "Important reminders:"
echo "  1. Verify your .env file has correct production settings"
echo "  2. Ensure APP_DEBUG=false and APP_ENV=production"
echo "  3. Check that your database connection works"
echo "  4. Test the application thoroughly"
echo ""
