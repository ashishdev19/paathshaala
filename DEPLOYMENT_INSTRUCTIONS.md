# Fix for Category Icons Not Showing on Live Server

## Problem
Course category icons are showing as default stethoscope icons on live server instead of the proper custom icons (lungs, robot, leaf, etc.)

## Root Cause
The database migration `2026_01_27_update_category_icons.php` has been run on local environment but NOT on live server.

## Solution - Run Migration on Live Server

### Method 1: SSH into Live Server (Recommended)
```bash
# 1. SSH into your live server
ssh user@your-live-server.com

# 2. Navigate to project directory
cd /path/to/paathshaala2

# 3. Run the migration
php artisan migrate

# 4. Verify the migration ran
php artisan migrate:status
```

### Method 2: Through cPanel/Hosting Panel
```bash
# If your hosting provides terminal access:
php artisan migrate
```

### Method 3: Manual Database Update (If Migration Fails)
If you cannot run migrations, execute this SQL directly on live database:

```sql
-- Update category icons
UPDATE course_categories SET icon_class = 'fa-lungs' WHERE name = 'Advanced Cardiac Life Support (ACLS – Theory)';
UPDATE course_categories SET icon_class = 'fa-robot' WHERE name = 'AI in Healthcare (Intro)';
UPDATE course_categories SET icon_class = 'fa-leaf' WHERE name = 'Ayurveda Lifestyle Course';
UPDATE course_categories SET icon_class = 'fa-heart-pulse' WHERE name = 'Basic Life Support (BLS – Theory)';
UPDATE course_categories SET icon_class = 'fa-dna' WHERE name = 'Bioinformatics (Intro)';
UPDATE course_categories SET icon_class = 'fa-flask' WHERE name = 'Clinical Biochemistry';
UPDATE course_categories SET icon_class = 'fa-clipboard-list' WHERE name = 'Clinical Documentation Training';
UPDATE course_categories SET icon_class = 'fa-brain' WHERE name = 'Clinical Psychology Basics';
UPDATE course_categories SET icon_class = 'fa-microscope' WHERE name = 'Clinical Research';
UPDATE course_categories SET icon_class = 'fa-apple-whole' WHERE name = 'Diet & Nutrition';
UPDATE course_categories SET icon_class = 'fa-laptop-medical' WHERE name = 'Digital Health & Telemedicine';
UPDATE course_categories SET icon_class = 'fa-file-medical' WHERE name = 'Electronic Health Records (EHR)';
```

## Verification
After running the migration, verify by:
1. Clear cache: `php artisan cache:clear`
2. Visit your courses page and check if icons appear correctly
3. Check database: `SELECT name, icon_class FROM course_categories;`

## Prevention for Future
Always run migrations when deploying to live:
```bash
php artisan migrate --force
```

## Migration File Location
`database/migrations/2026_01_27_update_category_icons.php`
