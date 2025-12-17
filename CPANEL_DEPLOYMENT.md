# cPanel Laravel Deployment Configuration

## Files Created for cPanel

### 1. Root `.htaccess` (Main Directory)
- **Location**: `/` (root of your application)
- **Purpose**: Redirects all requests to the `public` folder
- **Content**: Simple rewrite rule to forward traffic

### 2. Root `index.php` (Main Directory)
- **Location**: `/` (root of your application)
- **Purpose**: Fallback redirect to `public/index.php`
- **Content**: PHP header redirect

### 3. Public `.htaccess` (Already exists)
- **Location**: `/public/`
- **Purpose**: Laravel's standard routing rules
- **Content**: Standard Laravel rewrite rules

## cPanel Directory Structure

```
public_html/                    ← Your application root (not public/)
├── .htaccess                   ← Redirects to public/ (NEW)
├── index.php                   ← Redirects to public/index.php (MODIFIED)
├── .env                        ← Production environment file
├── artisan
├── composer.json
├── app/
├── bootstrap/
├── config/
├── database/
├── public/                     ← Laravel public directory
│   ├── .htaccess              ← Standard Laravel rules
│   ├── index.php              ← Main Laravel entry point
│   ├── css/
│   ├── js/
│   └── storage -> ../../storage/app/public
├── resources/
├── routes/
├── storage/
└── vendor/
```

## How It Works

1. **User visits**: `http://medniks.com/`
2. **Server reads**: `/public_html/.htaccess`
3. **Rewrites to**: `/public_html/public/index.php`
4. **Laravel handles**: The request from public directory

## Alternative: Subdomain Method

If your hosting allows, you can also:

1. Point your domain to `/public_html/public` directly in cPanel
2. Delete root `.htaccess` and `index.php`
3. Use only the standard Laravel structure

**How to set in cPanel:**
- Go to: **Domains** → **Addon Domains** or **Parked Domains**
- Set Document Root: `/home/username/public_html/public`

## File Permissions for cPanel

```bash
# Via SSH or cPanel Terminal
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Files should be:
chmod 644 .env
chmod 644 .htaccess
chmod 644 index.php
```

## Deployment Steps for cPanel

### Method 1: File Manager (No SSH)

1. **Upload Files**
   - Upload all files to `public_html/`
   - Ensure `.htaccess` and `index.php` in root
   - Ensure `public/.htaccess` exists

2. **Set Permissions**
   - Right-click `storage` → Change Permissions → 755
   - Right-click `bootstrap/cache` → Change Permissions → 755

3. **Configure .env**
   - Upload `.env.production` as `.env`
   - Edit with correct database credentials

4. **PHP Version**
   - Go to: **Select PHP Version** in cPanel
   - Choose PHP 8.1 or higher
   - Enable required extensions

5. **Run Commands** (via cPanel Terminal if available)
   ```bash
   cd public_html
   php artisan optimize:clear
   php artisan config:cache
   php artisan route:cache
   php artisan storage:link
   ```

### Method 2: SSH Access

```bash
# 1. Connect via SSH
ssh username@medniks.com

# 2. Navigate to directory
cd public_html

# 3. Set permissions
chmod -R 755 storage bootstrap/cache

# 4. Install dependencies
composer install --optimize-autoloader --no-dev

# 5. Configure environment
cp .env.production .env
nano .env  # Edit database credentials

# 6. Clear and cache
php artisan optimize:clear
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Final permissions
chmod 644 .env
```

## Troubleshooting cPanel Issues

### Issue: 500 Internal Server Error

**Solutions:**
1. Check `.htaccess` syntax
2. Verify PHP version (8.1+)
3. Check storage permissions
4. Review error logs in cPanel

**Enable Error Display (temporarily):**
```php
// In public/index.php (temporarily)
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

### Issue: "RewriteEngine not allowed here"

**Solution:** Enable `.htaccess` in cPanel or contact hosting support

### Issue: Blank Page

**Causes:**
- Wrong PHP version
- Missing .env file
- Cached config

**Solutions:**
```bash
php artisan config:clear
php artisan cache:clear
```

### Issue: CSS/JS Not Loading

**Causes:**
- Wrong APP_URL in .env
- Missing storage link

**Solutions:**
```bash
# Update .env
APP_URL=http://medniks.com
ASSET_URL=http://medniks.com

# Clear and recache
php artisan config:clear
php artisan config:cache
```

## Production .env Settings for cPanel

```env
APP_NAME=Medniks
APP_ENV=production
APP_KEY=base64:SzrXg13i5Jtu++Re317jxYWqwA5zJGm3ngk4ocL0ecw=
APP_DEBUG=false
APP_URL=http://medniks.com
ASSET_URL=http://medniks.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=healthboat_paathshaala
DB_USERNAME=healthboat_paathshaala
DB_PASSWORD=M2n1shlko#

LOG_LEVEL=error
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

## Verification Checklist

- ✅ Root `.htaccess` redirects to public/
- ✅ Root `index.php` redirects to public/index.php
- ✅ Public `.htaccess` has Laravel rules
- ✅ `.env` file configured for production
- ✅ `storage/` permissions set to 755
- ✅ `bootstrap/cache/` permissions set to 755
- ✅ PHP version 8.1+ selected
- ✅ All Composer dependencies installed
- ✅ Configuration cached
- ✅ Storage link created

## Quick Test

Visit these URLs to verify:
1. `http://medniks.com/` → Should load homepage
2. `http://medniks.com/login` → Should load login page
3. `http://medniks.com/css/app.css` → Should load CSS (or 404 if not built)

## Support

If issues persist:
1. Check `storage/logs/laravel.log`
2. Check cPanel Error Logs
3. Verify database connection
4. Contact hosting support if .htaccess issues persist
