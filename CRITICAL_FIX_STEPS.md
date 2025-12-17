# CRITICAL FIX - Step by Step

## Current Status
Website shows 500 Internal Server Error
Browser Network tab shows main document failing with 500 status

## STEP-BY-STEP FIX

### Step 1: Upload Diagnostic File
1. Upload `public/diagnose.php` to your server
2. Visit: **http://medniks.com/diagnose.php**
3. Check what's red (✗) or orange (⚠)

### Step 2: Fix Database Connection (Most Likely Issue)

**Via cPanel File Manager:**

1. Navigate to: `/home/healthboat/medniks.com/`
2. Edit `.env` file
3. Make these EXACT changes:

```env
# CHANGE THIS:
DB_HOST=127.0.0.1

# TO THIS:
DB_HOST=localhost

# AND WRAP PASSWORD IN QUOTES:
DB_PASSWORD="M2n1shlko#"
```

4. Save the file

### Step 3: Clear Config Cache

**Option A - Via cPanel Terminal:**
```bash
cd /home/healthboat/medniks.com
php artisan config:clear
php artisan cache:clear
```

**Option B - Via File Manager:**
Delete these files if they exist:
- `/bootstrap/cache/config.php`
- `/bootstrap/cache/routes-v7.php`
- `/bootstrap/cache/services.php`

### Step 4: Fix Permissions

**Via cPanel Terminal:**
```bash
cd /home/healthboat/medniks.com
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

**Via File Manager:**
Right-click these folders → Change Permissions → 755:
- `storage` (and all subfolders)
- `bootstrap/cache`

### Step 5: Verify Database Exists

**Via cPanel → MySQL Databases:**

1. Check "Current Databases" section
2. Should see: `healthboat_paathshaala`
3. If missing, create it

4. Check "Current Users" section
5. Should see: `healthboat_paathshaala`
6. If missing, create it with password: `M2n1shlko#`

7. Scroll to "Add User To Database"
8. Select user: `healthboat_paathshaala`
9. Select database: `healthboat_paathshaala`
10. Click "Add"
11. Select "ALL PRIVILEGES"
12. Click "Make Changes"

### Step 6: Test Again

1. Visit: http://medniks.com/diagnose.php
2. All should be green (✓)
3. Visit: http://medniks.com/
4. Should work!

## If Still Not Working

### Quick Debug - Enable Error Display

Edit `public/index.php` - Add these lines at the very top:

```php
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ... rest of the file
```

Then visit the site to see the actual error.

**REMEMBER TO REMOVE THESE LINES AFTER FIXING!**

## Common cPanel Issues & Solutions

### Issue 1: "Can't write to storage"
```bash
chmod -R 755 storage
```

### Issue 2: "Database access denied"
- Change `DB_HOST=127.0.0.1` to `DB_HOST=localhost`
- Verify user assigned to database in cPanel

### Issue 3: "Class not found"
```bash
composer install --no-dev --optimize-autoloader
```

### Issue 4: "APP_KEY not set"
```bash
php artisan key:generate --force
```

### Issue 5: Cached old config
```bash
rm -f bootstrap/cache/*.php
php artisan config:clear
```

## Production Checklist

After fixing, ensure:

- [ ] `APP_ENV=production` in .env
- [ ] `APP_DEBUG=false` in .env
- [ ] `DB_HOST=localhost` (not 127.0.0.1)
- [ ] Database credentials correct
- [ ] User assigned to database with ALL PRIVILEGES
- [ ] Storage permissions: 755
- [ ] Bootstrap/cache permissions: 755
- [ ] Config cache cleared
- [ ] Composer installed with --no-dev
- [ ] Delete diagnose.php after fixing

## Contact Server Admin If...

- Can't access cPanel
- Can't access Terminal
- Database won't create
- Permissions won't change
- PHP version is below 8.1

Provide them with the output from diagnose.php
