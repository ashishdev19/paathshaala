# URGENT FIX - PHP 500 Error

## Problem Identified:
- ✅ HTML works (test.html loads)
- ❌ PHP fails (info.php gives 500 error)

This means: **PHP execution problem** or **.htaccess issue**

## IMMEDIATE FIX - Do This Now:

### Step 1: Check PHP Version in cPanel

1. Login to **cPanel**
2. Go to **"Select PHP Version"** or **"MultiPHP Manager"**
3. For domain `medniks.com`:
   - Select **PHP 8.1** or higher
   - Click **"Apply"**

### Step 2: Enable Required PHP Extensions

In same **Select PHP Version** page:
1. Click **"Extensions"** or **"Options"**
2. Enable these (check the boxes):
   - ✅ pdo
   - ✅ pdo_mysql
   - ✅ mbstring
   - ✅ openssl
   - ✅ xml
   - ✅ tokenizer
   - ✅ ctype
   - ✅ json
   - ✅ bcmath
   - ✅ fileinfo
   - ✅ curl
3. Click **"Save"**

### Step 3: Check PHP Handler

In cPanel → **MultiPHP INI Editor**:
- Domain: `medniks.com`
- Check that it's using **FPM** or **FastCGI** handler
- NOT **CGI** or **suPHP**

### Step 4: Check Error Logs

cPanel → **Errors** → **Error Log**
- Check latest error for `info.php`
- Screenshot and share the exact error

### Step 5: Temporarily Disable .htaccess

Via cPanel File Manager:

1. Go to: `/home/healthboat/medniks.com/public/`
2. Find `.htaccess` file
3. Rename to `.htaccess.disabled`
4. Visit: `http://medniks.com/info.php`

**If it works after disabling .htaccess:**
- Problem is in .htaccess rules
- Use the `.htaccess.new` file I created

**If still fails:**
- Problem is PHP configuration
- Check error logs in cPanel

### Step 6: Create php.ini (if needed)

Create file: `/home/healthboat/medniks.com/public/php.ini`

Content:
```ini
display_errors = On
error_reporting = E_ALL
memory_limit = 256M
max_execution_time = 300
upload_max_filesize = 64M
post_max_size = 64M
```

Save and test `info.php` again.

## Expected Result

After fixing PHP configuration:
- `http://medniks.com/info.php` should show PHP info page
- Then Laravel will work

## Quick Command Line Fix (If SSH Available)

```bash
cd /home/healthboat/medniks.com/public
mv .htaccess .htaccess.backup
# Test info.php
# If works, restore .htaccess
mv .htaccess.backup .htaccess
```

## Common cPanel PHP Issues:

### Issue: PHP Version Too Old
**Fix:** cPanel → MultiPHP Manager → Select PHP 8.1+

### Issue: PHP Handler Wrong
**Fix:** cPanel → MultiPHP Manager → Handler = ea-php81 (FPM)

### Issue: mod_security Blocking
**Fix:** cPanel → ModSecurity → Disable for domain

### Issue: Permissions
**Fix:** All PHP files should be 644
```bash
find /home/healthboat/medniks.com/public -name "*.php" -exec chmod 644 {} \;
```

## Next Steps:

1. ✅ Check cPanel → Select PHP Version (must be 8.1+)
2. ✅ Enable all required extensions
3. ✅ Check error log for exact error
4. ✅ Disable .htaccess temporarily to isolate issue
5. ✅ Share error log screenshot

Once `info.php` works, Laravel will work!
