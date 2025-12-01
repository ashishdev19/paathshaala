# Quick Start Guide - Course Creation Module

## 🎯 Quick Navigation URLs

### For Instructors (Teacher Role Required)

**Course Creation Wizard (6 Steps):**
```
Step 1 - Basics:     http://localhost/instructor/courses/create/basics
Step 2 - Media:      http://localhost/instructor/courses/create/media
Step 3 - Curriculum: http://localhost/instructor/courses/create/curriculum
Step 4 - Pricing:    http://localhost/instructor/courses/create/pricing
Step 5 - SEO:        http://localhost/instructor/courses/create/seo
Step 6 - Review:     http://localhost/instructor/courses/create/review
```

**Course Management:**
```
List Courses:   http://localhost/instructor/courses
View Course:    http://localhost/instructor/courses/{course-id}
Edit Course:    http://localhost/instructor/courses/{course-id}/edit
```

### For Admin Users (Admin Role Required)

**Course Approval System:**
```
Pending Courses: http://localhost/admin/course-approvals
Review Course:   http://localhost/admin/course-approvals/{course-id}
```

---

## 📋 Step-by-Step Course Creation

### Step 1️⃣: Basic Details
**URL**: `/instructor/courses/create/basics`

**What you'll do:**
1. Enter Course Title
2. Enter Subtitle (optional)
3. Enter Description (min 50 chars)
4. Select Category
5. Select Level (Beginner, Intermediate, Advanced)
6. Select Language
7. Select Course Mode (Online, Offline, Hybrid)
8. Click "Continue to Media"

**Database Action**: 
- Course created in `courses` table with status='draft'
- Course ID stored in session

---

### Step 2️⃣: Upload Media
**URL**: `/instructor/courses/create/media`

**What you'll do:**
1. Drag & drop or select Thumbnail Image (2MB max)
2. Enter Promo Video URL (optional)
3. Upload Demo PDF (5MB max, optional)
4. Upload Demo Lecture (50MB max, optional)
5. Click "Continue to Curriculum"

**Database Action**:
- Files uploaded to `storage/app/public/courses/`
- File paths saved to `courses` table

---

### Step 3️⃣: Build Curriculum
**URL**: `/instructor/courses/create/curriculum`

**What you'll do:**
1. Click "Add Section" button
2. Enter section title and description
3. In section, click "Add Lecture"
4. Enter lecture details:
   - Title
   - Type (Video, PDF, Quiz, Assignment, Live)
   - Video URL or File
   - Duration (if video)
   - Mark as Preview (free preview)
   - Description
5. Repeat to add more lectures
6. Click "Continue to Pricing"

**Database Actions**:
- AJAX calls create `course_sections` records
- AJAX calls create `course_lectures` records
- No page reload - real-time updates

---

### Step 4️⃣: Set Pricing
**URL**: `/instructor/courses/create/pricing`

**What you'll do:**
1. Choose Free or Paid course
   - If Free: Skip to next step
   - If Paid:
     - Enter Original Price (e.g., ₹999)
     - Enter Discount Price (e.g., ₹599)
     - See auto-calculated discount percentage
2. Set Validity (days or lifetime)
3. Click "Continue to SEO"

**Database Action**:
- `is_free` set to true/false
- `price` and `discount_price` saved

---

### Step 5️⃣: Configure SEO
**URL**: `/instructor/courses/create/seo`

**What you'll do:**
1. Enter Meta Title (max 160 chars)
   - See character counter
2. Enter Meta Description (max 160 chars)
   - See character counter
3. Review auto-generated URL Slug
   - Can edit if needed
4. See live preview of how it appears in Google search results
5. Click "Continue to Review"

**Database Action**:
- `meta_title`, `meta_description`, `slug` saved

---

### Step 6️⃣: Review & Submit
**URL**: `/instructor/courses/create/review`

**What you'll do:**
1. Review all course information:
   - Basic details
   - Media uploads
   - Curriculum sections/lectures
   - Pricing settings
   - SEO information
2. Click edit links to change any section
3. Check "I agree to course creation terms"
4. Click "Submit for Admin Review"

**Database Action**:
- Course status changed from 'draft' to 'under_review'
- Course becomes invisible to students
- Course appears in admin approval queue

---

## 👨‍💼 Admin Review Process

### View Pending Courses
**URL**: `/admin/course-approvals`

**What you'll see:**
- Dashboard with stats:
  - Pending courses count
  - Published courses count
  - Rejected courses count
- Searchable table of pending courses
- Action buttons: "Review"

---

### Review Course Details
**URL**: `/admin/course-approvals/{course-id}`

**What you'll see:**
1. Complete course information
2. Curriculum breakdown (sections & lectures)
3. Pricing details
4. SEO information
5. Media preview
6. Three action buttons:
   - **Approve** - Makes course live
   - **Reject** - Denies course, can add reason
   - **Request Changes** - Sends back to draft for revision

---

## 🔗 API Routes (AJAX)

### Section Management
```
POST   /instructor/sections
       Create new section
       Body: { course_id, title, description }

PUT    /instructor/sections/{id}
       Update section
       Body: { title, description }

DELETE /instructor/sections/{id}
       Delete section
       
POST   /instructor/sections/reorder
       Reorder sections
       Body: { sections: [{id, order}, ...] }
```

### Lecture Management
```
POST   /instructor/lectures
       Create new lecture
       Body: { section_id, title, type, file_path, video_url, duration, is_preview }

PUT    /instructor/lectures/{id}
       Update lecture
       Body: { title, type, file_path, video_url, duration, is_preview }

DELETE /instructor/lectures/{id}
       Delete lecture
       
POST   /instructor/lectures/reorder
       Reorder lectures
       Body: { lectures: [{id, order}, ...] }
```

---

## 📊 Database Sample Data

The seeder creates **3 sample courses** with complete curriculum:

### Course 1: "Advanced Medical Anatomy"
- Category: Medical
- Level: Advanced
- Mode: Online
- Free: No
- Sections: 3
  - Section: "Human Body Systems"
    - Lecture 1: "Video" - Cardiology
    - Lecture 2: "PDF" - Anatomy Atlas
    - Lecture 3: "Quiz" - Body Systems Quiz
  - Section: "Organ Functions"
    - Lecture 1: "Video" - Organ Anatomy
    - Lecture 2: "Video" - Organ Functions
    - Lecture 3: "Assignment" - Organ Analysis
  - Section: "Clinical Applications"
    - Lecture 1: "Video" - Clinical Diagnosis
    - Lecture 2: "Live" - Q&A Session
    - Lecture 3: "PDF" - Case Studies

### Course 2: "Healthcare Management Essentials"
- Category: Healthcare
- Level: Intermediate
- Mode: Hybrid
- Free: Yes
- Sections: 3

### Course 3: "Pediatric Care Fundamentals"
- Category: Medical
- Level: Beginner
- Mode: Online
- Free: No
- Sections: 3

---

## 🔐 Required User Roles

### Teacher/Instructor Role
```
✅ Can create courses
✅ Can view own courses
✅ Can edit own draft courses
✅ Can delete own draft courses
✅ Cannot edit published courses
✅ Cannot see other instructors' courses
```

### Admin Role
```
✅ Can view all pending courses
✅ Can approve courses
✅ Can reject courses
✅ Can request changes
✅ Can view all published courses
```

### Student Role
```
✅ Can browse published courses
✅ Can enroll in free courses
✅ Can purchase paid courses
✅ Can access enrolled courses
```

---

## ✅ Testing Checklist

### Before Starting
- [ ] Login as a teacher/instructor user
- [ ] Ensure you have 'teacher' role assigned

### Create Sample Course
- [ ] Navigate to `/instructor/courses/create/basics`
- [ ] Fill all required fields
- [ ] Click "Continue"
- [ ] Upload a thumbnail image
- [ ] Add demo files if desired
- [ ] Click "Continue"
- [ ] Add at least 1 section with 2 lectures
- [ ] Click "Continue"
- [ ] Set course to Paid with ₹999 price
- [ ] Click "Continue"
- [ ] Enter SEO information
- [ ] Click "Continue"
- [ ] Review all information
- [ ] Click "Submit for Admin Review"

### As Admin
- [ ] Login as admin user
- [ ] Navigate to `/admin/course-approvals`
- [ ] See the submitted course in the list
- [ ] Click "Review"
- [ ] Verify all course details
- [ ] Click "Approve" to publish
- [ ] Course status should change to 'published'

### Verify Published Course
- [ ] Login as student
- [ ] Navigate to browse courses
- [ ] See the approved course in the list
- [ ] Click to view course details
- [ ] See curriculum structure
- [ ] See pricing information

---

## 🐛 Troubleshooting

### Course doesn't appear in creation flow
**Solution**: Clear route cache
```bash
php artisan route:clear
php artisan cache:clear
```

### File uploads fail
**Solution**: Ensure storage symlink exists
```bash
php artisan storage:link
```

### SEO slug not auto-generating
**Solution**: Check JavaScript console for errors
- Open Developer Tools (F12)
- Check Console tab for JS errors
- Verify `curriculum-builder.js` is loaded

### Admin approval routes not found
**Solution**: Check if you have 'admin' role
- Verify user has admin role assigned
- Run `php artisan cache:clear`

### Can't edit section/lecture
**Solution**: AJAX may have failed silently
- Check browser console (F12)
- Verify CSRF token in meta tag
- Check server logs in `storage/logs/laravel.log`

---

## 📚 Related Files

**Documentation:**
- `COURSE_CREATION_MODULE.md` - Detailed documentation
- `SETUP_VERIFICATION.md` - Installation verification
- `IMPLEMENTATION_STATUS.md` - Project status

**Controllers:**
- `app/Http/Controllers/Instructor/InstructorCourseController.php`
- `app/Http/Controllers/Admin/AdminCourseApprovalController.php`

**Views:**
- `resources/views/instructor/courses/create/` (6 step views)
- `resources/views/admin/courses/` (2 admin views)

**Models:**
- `app/Models/Course.php`
- `app/Models/CourseSection.php`
- `app/Models/CourseLecture.php`
- `app/Models/OfflineBatch.php`

---

## 🎓 Sample Usage

**Create a course in 5 minutes:**

1. Go to: `/instructor/courses/create/basics`
2. Enter:
   - Title: "Introduction to Web Development"
   - Subtitle: "Learn Web Dev from Scratch"
   - Description: "Complete guide to modern web development with HTML, CSS, and JavaScript"
   - Category: "Technology"
   - Level: "Beginner"
   - Language: "English"
   - Mode: "Online"
3. Click Continue
4. Upload a cover image
5. Click Continue (skip media for now)
6. Add Section: "Getting Started"
   - Add Lecture: "Welcome Video" (video type)
7. Add Section: "HTML Basics"
   - Add Lecture: "HTML Introduction" (video)
   - Add Lecture: "HTML Tags" (pdf)
8. Click Continue
9. Set Price: ₹999 (Paid)
10. Click Continue
11. Meta Title: "Learn Web Development"
12. Meta Desc: "Master HTML, CSS, JS"
13. Click Continue
14. Review and Submit
15. Logout, login as admin
16. Go to: `/admin/course-approvals`
17. Click Review
18. Click Approve

**Congratulations!** Your course is now live for students to enroll.

---

**Last Updated**: November 25, 2025
