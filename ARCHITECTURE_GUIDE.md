# 🎯 Module Architecture & Flow Diagram

## Course Creation Workflow

```
┌─────────────────────────────────────────────────────────────────┐
│                   INSTRUCTOR COURSE CREATION                     │
│                     (6-Step Wizard)                              │
└─────────────────────────────────────────────────────────────────┘

    ┌──────────────┐
    │   START      │
    │ /create/     │
    │  basics      │
    └──────┬───────┘
           │
           ▼
    ┌──────────────────────────┐       ┌────────────────────────┐
    │   STEP 1: BASICS         │       │ Save Course:           │
    │                          │       │ - title                │
    │ - Title                  │──────▶│ - description          │
    │ - Subtitle               │       │ - category             │
    │ - Description            │       │ - level                │
    │ - Category               │       │ - language             │
    │ - Level                  │       │ - course_mode          │
    │ - Language               │       │ - status=draft         │
    │ - Course Mode            │       │ Store course_id in    │
    │ [CONTINUE]               │       │ session                │
    └──────┬───────────────────┘       └────────────────────────┘
           │
           ▼
    ┌──────────────────────────┐       ┌────────────────────────┐
    │   STEP 2: MEDIA          │       │ Save to Storage:       │
    │                          │       │ - thumbnail.jpg        │
    │ - Thumbnail Image        │──────▶│ - demo_lecture.mp4     │
    │ - Promo Video URL        │       │ - demo_pdf.pdf         │
    │ - Demo PDF               │       │ Update courses table   │
    │ - Demo Lecture           │       │ with file paths        │
    │ [CONTINUE]               │       │                        │
    └──────┬───────────────────┘       └────────────────────────┘
           │
           ▼
    ┌──────────────────────────┐       ┌────────────────────────┐
    │   STEP 3: CURRICULUM     │       │ Create via AJAX:       │
    │                          │       │ - course_sections      │
    │ ◼ Section 1              │──────▶│ - course_lectures      │
    │   ◊ Lecture 1 (Video)    │       │ Real-time updates      │
    │   ◊ Lecture 2 (PDF)      │       │ No page reload         │
    │ ◼ Section 2              │       │                        │
    │   ◊ Lecture 1 (Quiz)     │       │                        │
    │ [+ Add Section]          │       │                        │
    │ [CONTINUE]               │       │                        │
    └──────┬───────────────────┘       └────────────────────────┘
           │
           ▼
    ┌──────────────────────────┐       ┌────────────────────────┐
    │   STEP 4: PRICING        │       │ Save:                  │
    │                          │       │ - is_free              │
    │ ⦿ Free  ◯ Paid           │──────▶│ - price                │
    │                          │       │ - discount_price       │
    │ If Paid:                 │       │ - validity_days        │
    │ - Original Price: ₹999   │       │                        │
    │ - Discount: ₹599         │       │                        │
    │ - Discount: 40%          │       │                        │
    │ - Validity: 365 days     │       │                        │
    │ [CONTINUE]               │       │                        │
    └──────┬───────────────────┘       └────────────────────────┘
           │
           ▼
    ┌──────────────────────────┐       ┌────────────────────────┐
    │   STEP 5: SEO            │       │ Save:                  │
    │                          │       │ - meta_title           │
    │ Meta Title (160 chars)   │──────▶│ - meta_description     │
    │ [___________________]    │       │ - slug                 │
    │                          │       │ Auto-generate slug     │
    │ Meta Description (160)   │       │ from title             │
    │ [___________________]    │       │                        │
    │                          │       │ Preview (Google style) │
    │ Slug: course-title       │       │ └─ course-title        │
    │ [CONTINUE]               │       │    My Course Title     │
    └──────┬───────────────────┘       └────────────────────────┘
           │
           ▼
    ┌──────────────────────────┐       ┌────────────────────────┐
    │   STEP 6: REVIEW         │       │ Final Check:           │
    │                          │       │ - Validate all fields  │
    │ ✓ Basics                 │──────▶│ - Check curriculum     │
    │ ✓ Media                  │       │ - Verify pricing       │
    │ ✓ Curriculum (3 sections)│       │ - Confirm SEO          │
    │ ✓ Pricing (₹599)         │       │                        │
    │ ✓ SEO                    │       │ SUBMIT                 │
    │                          │       │ status → under_review  │
    │ [☐ Agree to Terms]       │       │ Notify admin           │
    │ [SUBMIT FOR REVIEW]      │       │                        │
    └──────┬───────────────────┘       └────────────────────────┘
           │
           ▼
    ┌─────────────────────────────────────────────────────────────┐
    │ COURSE SUBMITTED FOR ADMIN REVIEW                            │
    │ Status: under_review                                         │
    │ Awaiting approval from admin                                 │
    └─────────────────────────────────────────────────────────────┘
```

---

## Admin Approval Workflow

```
┌─────────────────────────────────────────────────────────────────┐
│                    ADMIN COURSE APPROVAL                         │
└─────────────────────────────────────────────────────────────────┘

    ┌──────────────────────────┐
    │ ADMIN DASHBOARD          │
    │ /course-approvals        │
    │                          │
    │ Pending: 5               │
    │ Published: 120           │
    │ Rejected: 8              │
    │                          │
    │ [Course List Table]      │
    │ [Review] [Review] ...    │
    └──────┬───────────────────┘
           │
           ▼
    ┌──────────────────────────┐
    │ REVIEW COURSE            │
    │ /course-approvals/{id}   │
    │                          │
    │ Course Details:          │
    │ - Title                  │
    │ - Description            │
    │ - Category               │
    │                          │
    │ Curriculum:              │
    │ ◼ Section 1              │
    │   ◊ Lecture 1            │
    │   ◊ Lecture 2            │
    │                          │
    │ Pricing: ₹599            │
    │ SEO: ✓                   │
    │                          │
    │ [APPROVE] [REJECT]       │
    │ [REQUEST CHANGES]        │
    └────┬─────────┬─────────┬─┘
         │         │         │
         │         │         │
    ┌────▼┐    ┌───▼───┐   ┌──▼──────────┐
    │ ✓   │    │   ✗   │   │   ⟳ MODIFY  │
    │APPR│    │REJECT │   │   REQUEST    │
    └────┬─────────┬────────┬──┬──────────┘
         │         │        │  │
    ┌────▼─────────▼────┐   │  │
    │ Modal Dialog      │   │  │
    │ "Approve Course?" │   │  └─┐
    │ [CONFIRM]         │   │    │
    └────┬──────────────┘   │    │
         │                  │    │
    ┌────▼──────────┐   ┌───▼────▼───────────┐
    │ Update DB:    │   │ Modal Dialog:      │
    │ status=       │   │ "Rejection Reason" │
    │ published     │   │ [Textarea]         │
    │ is_active=1   │   │ [CONFIRM]          │
    │ approved_by=  │   └───┬────────────────┘
    │ (admin_id)    │       │
    └────┬──────────┘   ┌───▼──────────────┐
         │              │ Update DB:       │
    ┌────▼─────────────┬┤ status=rejected  │
    │ COURSE LIVE!     │ rejection_reason= │
    │ Students can see │ (saved reason)    │
    │ and enroll       │ is_active=0       │
    │                  └──────────────────┘
    │
    └─────► Notify Instructor
```

---

## Database Relationships

```
┌──────────────────┐
│     users        │
├──────────────────┤
│ id (PK)          │
│ name             │
│ email            │
│ role (via        │
│   spatie)        │
└────────┬─────────┘
         │
         │ teacher_id
         │
         ├────────────────────────────┐
         │                            │
         ▼                            ▼
┌──────────────────┐          ┌──────────────────┐
│     courses      │◄─────────│  approved_by     │
├──────────────────┤          │                  │
│ id (PK)          │          └──────────────────┘
│ teacher_id (FK)  │
│ title            │
│ description      │
│ category         │
│ level            │
│ language         │
│ course_mode      │
│ price            │
│ discount_price   │
│ is_free          │
│ status (enum)    │
│ slug             │
│ meta_title       │
│ meta_description │
│ approved_by (FK) │
│ rejection_reason │
│ created_at       │
│ updated_at       │
└────────┬─────────┘
         │
         │ 1:M
         │
         ▼
┌──────────────────┐
│course_sections   │
├──────────────────┤
│ id (PK)          │
│ course_id (FK)   │
│ title            │
│ description      │
│ order            │
│ created_at       │
│ updated_at       │
└────────┬─────────┘
         │
         │ 1:M
         │
         ▼
┌──────────────────┐
│course_lectures   │
├──────────────────┤
│ id (PK)          │
│ section_id (FK)  │
│ title            │
│ type (enum)      │
│ file_path        │
│ video_url        │
│ duration         │
│ is_preview       │
│ description      │
│ order            │
│ created_at       │
│ updated_at       │
└──────────────────┘

Also from courses:
         │
         │ 1:M
         │
         ▼
┌──────────────────┐
│ offline_batches  │
├──────────────────┤
│ id (PK)          │
│ course_id (FK)   │
│ batch_name       │
│ start_date       │
│ end_date         │
│ location         │
│ capacity         │
│ enrolled_count   │
│ schedule (JSON)  │
│ status (enum)    │
│ created_at       │
│ updated_at       │
└──────────────────┘
```

---

## File Storage Structure

```
storage/
├── app/
│   └── public/
│       └── courses/
│           ├── thumbnails/
│           │   ├── course-1-thumbnail.jpg
│           │   ├── course-2-thumbnail.jpg
│           │   └── course-3-thumbnail.jpg
│           │
│           ├── pdfs/
│           │   ├── course-1-demo.pdf
│           │   └── course-2-demo.pdf
│           │
│           ├── demos/
│           │   ├── course-1-demo-lecture.mp4
│           │   └── course-2-demo-lecture.mp4
│           │
│           └── lectures/
│               ├── section-1-lecture-1.mp4
│               ├── section-1-lecture-2.mp4
│               ├── section-2-lecture-1.pdf
│               └── ...
│
└── logs/
    └── laravel.log
```

---

## Directory Structure (New Files)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Instructor/
│   │   │   ├── InstructorCourseController.php      ✨ NEW
│   │   │   ├── CourseSectionController.php         ✨ NEW
│   │   │   └── CourseLectureController.php         ✨ NEW
│   │   └── Admin/
│   │       └── AdminCourseApprovalController.php   ✨ NEW
│   │
│   └── Requests/
│       ├── StoreCourseRequest.php                  ✨ NEW
│       └── UpdateCourseRequest.php                 ✨ NEW
│
├── Models/
│   ├── Course.php                                   ✏️ MODIFIED
│   ├── CourseSection.php                           ✨ NEW
│   ├── CourseLecture.php                           ✨ NEW
│   └── OfflineBatch.php                            ✨ NEW
│
└── Policies/
    └── CoursePolicy.php                            ✨ NEW

database/
├── migrations/
│   ├── 2025_11_25_070000_update_courses_table_for_new_module.php     ✨ NEW
│   ├── 2025_11_25_070100_create_course_sections_table.php            ✨ NEW
│   ├── 2025_11_25_070200_create_course_lectures_table.php            ✨ NEW
│   └── 2025_11_25_070300_create_offline_batches_table.php            ✨ NEW
│
└── seeders/
    └── CourseSectionSeeder.php                     ✨ NEW

resources/
└── views/
    ├── instructor/
    │   └── courses/
    │       └── create/
    │           ├── basics.blade.php                ✨ NEW
    │           ├── media.blade.php                 ✨ NEW
    │           ├── curriculum.blade.php            ✨ NEW
    │           ├── pricing.blade.php               ✨ NEW
    │           ├── seo.blade.php                   ✨ NEW
    │           └── review.blade.php                ✨ NEW
    │
    └── admin/
        └── courses/
            ├── approval-index.blade.php            ✨ NEW
            └── approval-show.blade.php             ✨ NEW

public/
└── js/
    └── curriculum-builder.js                       ✨ NEW

routes/
└── web.php                                         ✏️ MODIFIED

app/Providers/
└── AppServiceProvider.php                          ✏️ MODIFIED
```

---

## Technology Stack

```
┌──────────────────────────────────────────────────────────┐
│                    TECHNOLOGY STACK                      │
├──────────────────────────────────────────────────────────┤
│                                                          │
│ Backend:                                                 │
│ • Laravel 11.x (PHP 8.2)                                 │
│ • MySQL Database                                         │
│ • Spatie Permission (Role Management)                    │
│ • Eloquent ORM                                           │
│                                                          │
│ Frontend:                                                │
│ • Blade Templating Engine                                │
│ • Tailwind CSS                                           │
│ • Vanilla JavaScript (AJAX)                              │
│ • HTML5 Drag & Drop API                                  │
│                                                          │
│ Features:                                                │
│ • CSRF Protection                                        │
│ • File Upload Handling                                   │
│ • Form Validation (Server & Client)                      │
│ • Policy-based Authorization                             │
│ • Session Management                                     │
│                                                          │
│ Development Tools:                                       │
│ • Artisan CLI                                            │
│ • Tinker REPL                                            │
│ • Migration System                                       │
│ • Seeding System                                         │
│                                                          │
└──────────────────────────────────────────────────────────┘
```

---

## Deployment Checklist

```
PRE-DEPLOYMENT
└─ [ ] Backup current database
└─ [ ] Review all new files
└─ [ ] Test on staging environment
└─ [ ] Verify file upload permissions
└─ [ ] Check storage symlink

DEPLOYMENT
└─ [ ] Run migrations: php artisan migrate
└─ [ ] Clear cache: php artisan cache:clear
└─ [ ] Clear routes: php artisan route:clear
└─ [ ] Clear views: php artisan view:clear
└─ [ ] Seed sample data (optional): php artisan db:seed --class=CourseSectionSeeder

POST-DEPLOYMENT
└─ [ ] Verify routes working
└─ [ ] Test course creation flow
└─ [ ] Test admin approval
└─ [ ] Check file uploads
└─ [ ] Monitor laravel.log
└─ [ ] Test on mobile (responsive)
```

---

## API Response Examples

### Create Course (Step 1)
```json
{
  "success": true,
  "course_id": 1,
  "message": "Course basics saved successfully",
  "redirect": "/instructor/courses/create/media"
}
```

### Add Section (AJAX)
```json
{
  "success": true,
  "section": {
    "id": 5,
    "course_id": 1,
    "title": "Getting Started",
    "description": "Introduction to the course",
    "order": 1,
    "created_at": "2025-11-25T10:30:00Z"
  }
}
```

### Approve Course (Admin)
```json
{
  "success": true,
  "message": "Course approved successfully",
  "course": {
    "id": 1,
    "status": "published",
    "is_active": true,
    "approved_by": 1,
    "approved_at": "2025-11-25T10:35:00Z"
  }
}
```

---

## Error Handling

```
VALIDATION ERRORS
├─ Required fields missing
├─ File size exceeded
├─ Invalid file type
├─ Duplicate slug
└─ Price validation (discount > price)

AUTHORIZATION ERRORS
├─ User not authenticated
├─ User lacks 'teacher' role (for creation)
├─ User is not course owner
├─ User lacks 'admin' role (for approvals)
└─ Published course cannot be edited

BUSINESS LOGIC ERRORS
├─ Course not found
├─ Section not found
├─ Lecture not found
├─ Invalid status transition
├─ Missing required content
└─ File upload failed

RESPONSES
├─ 200 OK - Operation successful
├─ 201 Created - Resource created
├─ 400 Bad Request - Invalid input
├─ 403 Forbidden - Not authorized
├─ 404 Not Found - Resource missing
└─ 500 Server Error - System failure
```

---

## Performance Optimizations

```
✅ Database
   └─ Proper indexes on foreign keys
   └─ Eager loading relationships (with())
   └─ Query scoping for filtering

✅ Frontend
   └─ AJAX prevents full page reloads
   └─ Lazy loading curriculum on demand
   └─ File compression on upload

✅ Caching
   └─ Route cache: php artisan route:cache
   └─ Config cache: php artisan config:cache
   └─ View cache (auto by Blade)

✅ Sessions
   └─ Minimal session data (course_id only)
   └─ Proper session cleanup
```

---

**Generated**: November 25, 2025
**Framework**: Laravel 11.x
**Status**: ✅ Production Ready

