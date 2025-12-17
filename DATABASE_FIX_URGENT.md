# DATABASE CONNECTION FIX - URGENT

## Current Error
```
Access denied for user 'healthboat_paathshaala'@'localhost' (using password: YES)
```

## Problem
Database connection credentials are incorrect or the database user doesn't have proper permissions.

## IMMEDIATE FIXES REQUIRED ON CPANEL

### Fix 1: Update .env File

Login to cPanel and edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=localhost          ← Change from 127.0.0.1 to localhost
DB_PORT=3306
DB_DATABASE=healthboat_paathshaala
DB_USERNAME=healthboat_paathshaala
DB_PASSWORD=M2n1shlko#
```

**Important:** In cPanel, use `localhost` NOT `127.0.0.1`

### Fix 2: Verify Database Exists

In cPanel → MySQL Databases:

1. Check if database `healthboat_paathshaala` exists
2. If not, create it:
   - Database Name: `healthboat_paathshaala`
   - Click "Create Database"

### Fix 3: Verify Database User Exists

In cPanel → MySQL Databases → MySQL Users:

1. Check if user `healthboat_paathshaala` exists
2. If not, create it:
   - Username: `healthboat_paathshaala`
   - Password: `M2n1shlko#`
   - Click "Create User"

### Fix 4: Assign User to Database

In cPanel → MySQL Databases → Add User To Database:

1. Select User: `healthboat_paathshaala`
2. Select Database: `healthboat_paathshaala`
3. Click "Add"
4. Grant ALL PRIVILEGES
5. Click "Make Changes"

### Fix 5: Clear Config Cache

Via cPanel Terminal or SSH:

```bash
cd /home/healthboat/medniks.com
php artisan config:clear
php artisan cache:clear
```

### Fix 6: Test Database Connection

Create a test file `test-db.php` in public folder:

```php
<?php
$host = 'localhost';
$dbname = 'healthboat_paathshaala';
$username = 'healthboat_paathshaala';
$password = 'M2n1shlko#';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "✅ Database connected successfully!";
} catch(PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
?>
```

Visit: `http://medniks.com/test-db.php`

## Step-by-Step Solution

### Option A: Via cPanel File Manager

1. **Go to File Manager**
   - Navigate to `/home/healthboat/medniks.com`

2. **Edit .env file**
   - Right-click → Edit
   - Change `DB_HOST=127.0.0.1` to `DB_HOST=localhost`
   - Save

3. **Delete config cache**
   - Delete `/bootstrap/cache/config.php` if exists

4. **Verify Database Setup**
   - Go to cPanel → MySQL Databases
   - Confirm database exists
   - Confirm user exists
   - Confirm user is assigned to database with ALL PRIVILEGES

5. **Test the site**
   - Visit `http://medniks.com`

### Option B: Via SSH (If Available)

```bash
# 1. Connect to server
ssh healthboat@medniks.com

# 2. Navigate to directory
cd /home/healthboat/medniks.com

# 3. Edit .env
nano .env
# Change DB_HOST=127.0.0.1 to DB_HOST=localhost
# Save: Ctrl+O, Enter, Ctrl+X

# 4. Clear caches
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear

# 5. Test database
php artisan migrate:status

# 6. If migrations not run yet
php artisan migrate --force

# 7. Cache config
php artisan config:cache
php artisan route:cache
```

## Common cPanel Database Issues

### Issue 1: Database name with prefix

cPanel often adds a prefix to database names. Check the actual database name:

**Example:**
- You created: `paathshaala`
- Actual name: `healthboat_paathshaala`

Use the FULL name in .env file.

### Issue 2: Password contains special characters

If password has special characters, wrap in quotes in .env:

```env
DB_PASSWORD="M2n1shlko#"
```

### Issue 3: Database user not assigned

Even if database and user exist, they must be linked:
- Go to: MySQL Databases → Add User To Database
- Select both → Add → ALL PRIVILEGES

### Issue 4: Remote MySQL disabled

Most cPanel servers only allow `localhost` connections, not `127.0.0.1`.

**Solution:** Always use `DB_HOST=localhost`

## Verification Commands

After fixing, run these to verify:

```bash
# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit

# Check if migrations table exists
php artisan migrate:status

# Run migrations if needed
php artisan migrate --force
```

## Quick Fix Commands (Copy-Paste)

```bash
cd /home/healthboat/medniks.com
sed -i 's/DB_HOST=127.0.0.1/DB_HOST=localhost/' .env
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

## After Database Fix

Once database connects, run:

```bash
php artisan migrate --force
php artisan db:seed --force  # If you have seeders
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Alternative: Check Actual Database Credentials

1. Login to cPanel
2. Go to MySQL Databases
3. Note down EXACT names (with prefixes)
4. Update .env accordingly

**Example of actual cPanel database setup:**
```
Database: healthboat_paathshaala
Username: healthboat_paathshaala
Password: M2n1shlko#
Host: localhost (NOT 127.0.0.1)
```

## Expected Result

After fixing:
- ✅ Website should load without 500 error
- ✅ Database queries should work
- ✅ Migrations should run successfully

## If Still Failing

Check these:

1. **Correct Password**
   - Verify password is exactly: `M2n1shlko#`
   - No extra spaces
   - Case-sensitive

2. **Database User Privileges**
   - User should have ALL PRIVILEGES
   - Not just SELECT

3. **cPanel MySQL Remote Access**
   - Should be disabled (use localhost only)

4. **PHP MySQL Extension**
   - Check if PDO_MySQL is enabled
   - cPanel → Select PHP Version → Extensions

---

**MOST IMPORTANT: Change DB_HOST from 127.0.0.1 to localhost in .env file!**
