# 🐛 Troubleshooting & FAQ Guide

## Common Issues & Solutions

---

## 🔴 Issue 1: Routes Not Found (404 Error)

### Symptoms
- `/instructor/courses/create/basics` returns 404
- Admin routes not accessible
- Routes listed in error message as "undefined"

### Causes
- Route cache not cleared
- Routes not registered properly
- Web middleware not applied

### Solutions

**Option 1: Clear Route Cache** ✅ RECOMMENDED
```bash
php artisan route:clear
php artisan cache:clear
```

**Option 2: Regenerate Routes**
```bash
php artisan route:cache
php artisan route:clear
```

**Option 3: Check Route File**
```bash
# Verify routes are in web.php
grep -n "instructor/courses/create" routes/web.php

# List all routes
php artisan route:list | grep instructor
```

**Option 4: Restart Web Server**
```bash
# If using Laragon, restart it
# Or run development server
php artisan serve
```

---

## 🔴 Issue 2: File Uploads Not Working

### Symptoms
- Files not saving when uploading
- Uploaded files not visible
- 500 error on file upload
- "Storage path not found" error

### Causes
- Storage symlink missing
- Directory permissions wrong
- Storage driver misconfigured
- Disk space full

### Solutions

**Option 1: Create Storage Symlink** ✅ MOST COMMON FIX
```bash
php artisan storage:link
```
This creates: `public/storage` → `storage/app/public`

**Option 2: Fix Directory Permissions**
```bash
# Windows (Laragon usually handles this)
icacls "C:\laragon\www\paathshaala\storage" /grant Everyone:F /T

# Linux/Mac
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

**Option 3: Verify Storage Configuration**
```php
// config/filesystems.php
'disks' => [
    'public' => [
        'driver' => 'local',
        'path' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
]
```

**Option 4: Check Upload Directories Exist**
```bash
# Create directories if missing
mkdir -p storage/app/public/courses/thumbnails
mkdir -p storage/app/public/courses/pdfs
mkdir -p storage/app/public/courses/demos
mkdir -p storage/app/public/courses/lectures
```

**Option 5: Verify Disk Space**
```bash
# Check available space
df -h
# On Windows
Get-Volume
```

---

## 🔴 Issue 3: Session Data Lost Between Steps

### Symptoms
- Course ID lost after redirect
- Session shows empty/null
- "Course ID not found in session" error
- Step 2 doesn't know about Step 1 data

### Causes
- Session driver not configured
- Session timeout too short
- Session storage corrupted
- Browser cookies disabled

### Solutions

**Option 1: Verify Session Configuration**
```php
// .env
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

**Option 2: Clear Session Storage**
```bash
# Remove all session files
rm -rf storage/framework/sessions/*

# On Windows
del C:\laragon\www\paathshaala\storage\framework\sessions\*
```

**Option 3: Use Database Sessions**
```php
// .env
SESSION_DRIVER=database

// Then run migration
php artisan session:table
php artisan migrate
```

**Option 4: Check Session Path in Code**
```php
// Controller
session(['course_id' => $course->id]); // WRITE
$courseId = session('course_id');      // READ
```

**Option 5: Enable Browser Cookies**
- Check browser cookie settings
- Allow cookies for localhost
- Check for private browsing mode

---

## 🔴 Issue 4: AJAX Requests Failing

### Symptoms
- Section/lecture add/edit/delete doesn't work
- Browser console shows AJAX errors
- 419 Token Mismatch error
- 403 Forbidden error
- Silent failure (nothing happens)

### Causes
- CSRF token missing or invalid
- Middleware blocking request
- JavaScript errors preventing AJAX call
- API endpoint not found

### Solutions

**Option 1: Verify CSRF Token in Meta Tag**
```html
<!-- In base layout or create view -->
<meta name="csrf-token" content="{{ csrf_token() }}">
```

**Option 2: Verify CSRF Token in JavaScript**
```javascript
// curriculum-builder.js should have
const token = document.querySelector('meta[name="csrf-token"]').content;
```

**Option 3: Check Browser Console**
```
F12 → Console tab
Look for JavaScript errors:
- Uncaught ReferenceError
- Uncaught SyntaxError
- Network errors (red requests)
```

**Option 4: Verify API Routes Exist**
```bash
php artisan route:list | grep sections
php artisan route:list | grep lectures
```

Should show:
```
POST   /instructor/sections
PUT    /instructor/sections/{id}
DELETE /instructor/sections/{id}
```

**Option 5: Check Middleware**
```php
// routes/web.php - Verify routes are in correct group
Route::middleware(['auth', 'verified', 'role:teacher'])->group(function () {
    Route::post('/sections', [CourseSectionController::class, 'store']);
    // ...
});
```

**Option 6: Test with Simple Request**
```javascript
// In browser console
fetch('/instructor/sections', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        course_id: 1,
        title: 'Test Section'
    })
})
.then(r => r.json())
.then(data => console.log(data))
.catch(e => console.error(e))
```

---

## 🔴 Issue 5: Database Migration Errors

### Symptoms
- Migration fails with SQL error
- Column already exists
- Foreign key constraint error
- Column type mismatch

### Causes
- Migration already ran
- Table already exists
- Column already added
- Foreign key constraint violation

### Solutions

**Option 1: Check Migration Status**
```bash
php artisan migrate:status

# Shows which migrations have run
# Look for "Batch" column
```

**Option 2: Rollback Migrations** ⚠️ CAREFUL - DELETES DATA
```bash
# Rollback all
php artisan migrate:rollback

# Rollback specific batch
php artisan migrate:rollback --batch=3

# Then re-run
php artisan migrate
```

**Option 3: Drop & Recreate Database** ⚠️ DELETES ALL DATA
```bash
# Fresh migration (development only)
php artisan migrate:fresh

# With seeding
php artisan migrate:fresh --seed
```

**Option 4: Check for Duplicate Migrations**
```bash
# List migration files
ls database/migrations/ | grep 2025_11_25

# Check for duplicates
# If found, remove one
```

**Option 5: Verify Migration Syntax**
```php
// Check the migration file
// Verify column definitions match database current state
```

---

## 🔴 Issue 6: Authorization/Permission Denied

### Symptoms
- 403 Forbidden error
- "This action is unauthorized"
- Can't create/edit/delete course
- Can't access admin approval page

### Causes
- User doesn't have required role
- Course not owned by user
- Admin not authorized
- Policy not registered

### Solutions

**Option 1: Verify User Role**
```bash
# Check user roles in database
# Users table doesn't have 'role' column
# Roles are in 'model_has_roles' table via Spatie

# Assign role to user
php artisan tinker
> $user = App\Models\User::find(1);
> $user->assignRole('teacher'); // or 'admin'
> exit
```

**Option 2: Verify Policy Registered**
```php
// app/Providers/AppServiceProvider.php
use App\Models\Course;
use App\Policies\CoursePolicy;

public function boot(): void
{
    Gate::policy(Course::class, CoursePolicy::class);
}
```

**Option 3: Check Policy Authorization**
```php
// app/Policies/CoursePolicy.php

public function create(User $user): bool
{
    // Only 'teacher' role can create
    return $user->hasRole('teacher');
}

public function update(User $user, Course $course): bool
{
    // Only owner can update
    return $user->id === $course->teacher_id;
}
```

**Option 4: Grant Admin Role**
```bash
php artisan tinker
> $admin = App\Models\User::find(2); // Your admin user
> $admin->assignRole('admin');
> exit
```

**Option 5: Debug Authorization**
```php
// In controller
if (auth()->user()->cannot('create', Course::class)) {
    abort(403, 'Not authorized to create course');
}
```

---

## 🔴 Issue 7: Seeder Fails

### Symptoms
- `php artisan db:seed` returns error
- "Class not found" error
- "Cannot declare class" error
- No data inserted

### Causes
- Seeder class doesn't exist
- Duplicate class name
- Wrong namespace
- Missing model

### Solutions

**Option 1: Verify Seeder File Exists**
```bash
ls database/seeders/CourseSectionSeeder.php

# Should exist and contain class named CourseSectionSeeder
```

**Option 2: Check Class Name Matches Filename**
```php
// database/seeders/CourseSectionSeeder.php
class CourseSectionSeeder extends Seeder // ✅ Must match filename
```

**Option 3: Verify Namespace**
```php
namespace Database\Seeders; // ✅ Required

class CourseSectionSeeder extends Seeder
```

**Option 4: Run Seeder Specifically**
```bash
php artisan db:seed --class=CourseSectionSeeder

# Add verbose flag for more details
php artisan db:seed --class=CourseSectionSeeder -vvv
```

**Option 5: Check for Duplicates**
```bash
# Search for duplicate class names
grep -r "class CourseSeeder" database/seeders/

# Should only appear once in CourseSectionSeeder.php
```

---

## 🟡 Issue 8: Images Not Displaying

### Symptoms
- Thumbnail placeholder shows instead of image
- Broken image icon
- Image URL is wrong
- Image saved but not accessible

### Causes
- Storage symlink missing
- Image file not uploaded correctly
- Wrong file path in database
- Asset helper not used

### Solutions

**Option 1: Create Storage Symlink**
```bash
php artisan storage:link
```

**Option 2: Use Asset Helper in Views**
```blade
<!-- WRONG ❌ -->
<img src="{{ $course->thumbnail }}" alt="Course">

<!-- CORRECT ✅ -->
<img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Course">

<!-- OR if path already has storage/ ✅ -->
<img src="{{ asset($course->thumbnail) }}" alt="Course">
```

**Option 3: Verify File Exists**
```php
// In view or controller
if (file_exists(storage_path('app/public/' . $course->thumbnail))) {
    // File exists, use it
    echo asset('storage/' . $course->thumbnail);
} else {
    // File missing, use placeholder
    echo asset('images/placeholder.jpg');
}
```

**Option 4: Check Correct Storage Path**
```php
// When saving upload
$path = $request->file('thumbnail')
    ->store('courses/thumbnails', 'public');
    // Saves to: storage/app/public/courses/thumbnails/...
    // Access via: asset('storage/courses/thumbnails/...')
```

**Option 5: Verify Public Permissions**
```bash
# Ensure public/storage is readable
ls -la public/storage

# On Windows (Laragon handles this)
icacls "C:\laragon\www\paathshaala\public\storage" /grant Everyone:F
```

---

## 🟡 Issue 9: Views Not Showing Updated Data

### Symptoms
- Form shows old data after submission
- Changes don't reflect
- Cache showing stale content
- Edited course still shows old values

### Causes
- View cache not cleared
- Data not refreshed in model
- Wrong variable passed to view
- Browser cache

### Solutions

**Option 1: Clear View Cache**
```bash
php artisan view:clear
```

**Option 2: Clear All Caches**
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
```

**Option 3: Hard Refresh Browser**
```
Windows: Ctrl + Shift + Delete
Mac: Cmd + Shift + Delete
Or just Ctrl/Cmd + F5
```

**Option 4: Verify Data in Database**
```bash
php artisan tinker
> DB::table('courses')->where('id', 1)->first()
```

**Option 5: Check Variable Assignment**
```php
// In controller
$course = Course::findOrFail($id); // Fresh from DB
return view('courses.show', compact('course'));
```

---

## 🟡 Issue 10: Email Notifications Not Sending

### Symptoms
- Course approval email not received
- No email in log
- Silent failure (no error)

### Causes
- Mail driver not configured
- MAIL_FROM not set in .env
- Email service not running
- Template missing

### Solutions

**Option 1: Configure Mail Driver**
```php
// .env
MAIL_DRIVER=log  // For testing, writes to log
// OR
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_FROM_ADDRESS=noreply@paathshaala.com
MAIL_FROM_NAME="PaathShaala"
```

**Option 2: Check Logs**
```bash
tail -f storage/logs/laravel.log

# Look for mail-related entries
# Should show "Mailable sent" or similar
```

**Option 3: Test Mail Configuration**
```bash
php artisan tinker
> Mail::raw('Test email', function($msg) { $msg->to('your@email.com'); })
> exit

# Check if email sent
```

**Option 4: Create Mailable Class**
```bash
php artisan make:mail CourseApproved

# Then implement in controller:
# Mail::to($instructor)->send(new CourseApproved($course));
```

---

## 🟡 Issue 11: CORS/Cross-Origin Errors

### Symptoms
- "Access-Control-Allow-Origin" error
- AJAX from different domain fails
- Fetch request blocked

### Causes
- Different domain/port
- CORS middleware not configured
- Ajax request to external domain

### Solutions

**Option 1: Same-Domain Development**
```
Development URL: http://localhost:8000
All requests should go to: http://localhost:8000/*
NOT http://127.0.0.1:8000/* (different!)
```

**Option 2: Add CORS Middleware** (if needed)
```bash
php artisan make:middleware Cors
```

**Option 3: Check Request Origin**
```php
// Make sure AJAX requests are to same domain/port
// In curriculum-builder.js:
fetch('/instructor/sections', { ... })  // ✅ Same domain
// NOT
fetch('http://other-domain.com/instructor/sections', { ... })  // ❌ Different domain
```

---

## 🟡 Issue 12: Slug Not Auto-Generating

### Symptoms
- Slug field empty on SEO step
- Manual slug entry required
- Auto-generation not working

### Causes
- JavaScript not running
- Event listener not attached
- JavaScript file not loaded
- Validation failing before slug set

### Solutions

**Option 1: Check JavaScript Console**
```
F12 → Console tab
Look for any JavaScript errors
```

**Option 2: Verify JavaScript Loaded**
```
F12 → Sources/Resources tab
Search for "curriculum-builder.js"
Should be listed under public/js/
```

**Option 3: Check Script Tag in View**
```html
<!-- In create/seo.blade.php or layout -->
<script src="{{ asset('js/curriculum-builder.js') }}"></script>
```

**Option 4: Verify Event Listener**
```javascript
// In curriculum-builder.js
document.getElementById('title').addEventListener('blur', function() {
    // Generate slug from title
    let slug = this.value
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
    
    document.getElementById('slug').value = slug;
});
```

**Option 5: Manually Generate**
```php
// If auto-generation fails, generate manually
use Illuminate\Support\Str;

$slug = Str::slug($request->input('title'));
```

---

## 📊 Useful Debugging Commands

```bash
# Check all routes
php artisan route:list

# Check migrations
php artisan migrate:status

# List all registered policies
php artisan tinker
> Gate::policies()
> exit

# Clear everything
php artisan clear-all  # (custom command if available)
# OR manually:
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear

# Check database
php artisan db

# View application logs
tail -f storage/logs/laravel.log
```

---

## ✅ Verification Steps

After fixing an issue, verify with these steps:

```
1. ✅ Clear all caches
   php artisan cache:clear && php artisan view:clear && php artisan route:clear

2. ✅ Restart web server or development server

3. ✅ Test in incognito/private window (avoid browser cache)

4. ✅ Check browser console (F12) for JavaScript errors

5. ✅ Check laravel.log for server errors
   tail -f storage/logs/laravel.log

6. ✅ Test the specific feature

7. ✅ If still broken, check with previous steps
```

---

## 🆘 Getting Help

### 1. Check Documentation
- `COURSE_CREATION_MODULE.md` - Feature documentation
- `QUICK_START.md` - Quick reference
- `ARCHITECTURE_GUIDE.md` - Technical overview

### 2. Check Logs
```bash
# Application log
tail -f storage/logs/laravel.log

# Database errors shown here
# PHP errors shown here
# All exceptions logged
```

### 3. Enable Debug Mode
```php
// .env
APP_DEBUG=true

# Shows detailed error pages (development only!)
```

### 4. Use Tinker REPL
```bash
php artisan tinker

# Query database directly
> DB::table('courses')->count()
> App\Models\Course::where('status', 'draft')->get()

# Check relationships
> $course = App\Models\Course::find(1);
> $course->sections()->count()

# Assign roles
> $user = App\Models\User::find(1);
> $user->assignRole('teacher')

# Exit
> exit
```

### 5. Test API with cURL
```bash
# Get courses
curl http://localhost/instructor/courses

# Create section (requires CSRF, so use browser)
```

---

## 🎓 Common Laravel Error Messages

| Error | Meaning | Fix |
|-------|---------|-----|
| 404 Not Found | Route doesn't exist | Clear route cache |
| 403 Forbidden | Not authorized | Check user role/policy |
| 419 Token Mismatch | CSRF token missing | Verify @csrf in form |
| 500 Server Error | General failure | Check laravel.log |
| Column not found | Database issue | Check migration ran |
| Class not found | File missing | Check file exists/namespace |
| Undefined variable | View variable missing | Check controller return |
| Method not found | Missing function | Check controller method |

---

## 📝 Final Checklist

If everything fails, verify:

- [ ] Routes exist: `php artisan route:list | grep instructor`
- [ ] Migrations ran: `php artisan migrate:status`
- [ ] Database tables exist: `php artisan tinker` → `DB::connection()->getDoctrineSchemaManager()->listTableNames()`
- [ ] Storage symlink: `ls -la public/storage` (should be symlink)
- [ ] User has role: In DB, check `model_has_roles` table
- [ ] Policy registered: In AppServiceProvider.php
- [ ] Files exist: Check all file paths
- [ ] Permissions OK: Read/write access to storage/
- [ ] No syntax errors: Run `php -l app/file.php`
- [ ] Cache cleared: All cache commands run

---

**Last Updated**: November 25, 2025
**Framework**: Laravel 11.x

