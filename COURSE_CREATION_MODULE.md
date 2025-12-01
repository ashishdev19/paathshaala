# Complete Instructor Course Creation Module - Implementation Guide

## Overview
This is a comprehensive course creation module for instructors with a multi-step workflow, curriculum builder, pricing system, and admin approval process.

---

## 📁 Project Structure

### Migrations Created
```
database/migrations/
├── 2025_11_25_070000_update_courses_table_for_new_module.php
├── 2025_11_25_070100_create_course_sections_table.php
├── 2025_11_25_070200_create_course_lectures_table.php
└── 2025_11_25_070300_create_offline_batches_table.php
```

### Models Created
```
app/Models/
├── Course.php (updated)
├── CourseSection.php (new)
├── CourseLecture.php (new)
└── OfflineBatch.php (new)
```

### Controllers Created
```
app/Http/Controllers/
├── Instructor/
│   ├── InstructorCourseController.php (new)
│   ├── CourseSectionController.php (new)
│   └── CourseLectureController.php (new)
└── Admin/
    └── AdminCourseApprovalController.php (new)
```

### Form Requests
```
app/Http/Requests/
├── StoreCourseRequest.php (new)
└── UpdateCourseRequest.php (new)
```

### Policies
```
app/Policies/
└── CoursePolicy.php (new)
```

### Views Created
```
resources/views/
├── instructor/courses/create/
│   ├── basics.blade.php
│   ├── media.blade.php
│   ├── curriculum.blade.php
│   ├── pricing.blade.php
│   ├── seo.blade.php
│   └── review.blade.php
└── admin/courses/
    ├── approval-index.blade.php
    └── approval-show.blade.php
```

### JavaScript
```
public/js/
└── curriculum-builder.js (new)
```

### Seeders
```
database/seeders/
└── CourseSectionSeeder.php (new)
```

---

## 🚀 Installation Steps

### Step 1: Run Migrations
```bash
php artisan migrate
```

This will:
- Update courses table with new fields
- Create course_sections table
- Create course_lectures table
- Create offline_batches table

### Step 2: Register Policies
Add to `app/Providers/AppServiceProvider.php`:
```php
use App\Models\Course;
use App\Policies\CoursePolicy;

public function boot()
{
    Gate::policy(Course::class, CoursePolicy::class);
}
```

### Step 3: Clear Cache
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
```

### Step 4: Seed Sample Data (Optional)
```bash
php artisan db:seed --class=CourseSectionSeeder
```

---

## 📚 Module Workflow

### Instructor Course Creation (6 Steps)

#### Step 1: Basic Details
- **Route**: `/instructor/courses/create/basics`
- **Form Fields**:
  - Course Title (required)
  - Subtitle (optional)
  - Description (required, min 50 chars)
  - Category (required)
  - Level (beginner, intermediate, advanced)
  - Language
  - Course Mode (online, offline, hybrid)

#### Step 2: Upload Media
- **Route**: `/instructor/courses/create/media`
- **Uploads**:
  - Course Thumbnail (2MB max, image)
  - Promo Video URL (YouTube/Vimeo)
  - Sample PDF (5MB max)
  - Demo Lecture (50MB max, video)

#### Step 3: Build Curriculum
- **Route**: `/instructor/courses/create/curriculum`
- **Features**:
  - Add/Edit/Delete Sections
  - Add/Edit/Delete Lectures within sections
  - Drag & drop reordering (planned)
  - Preview of curriculum structure
  - Counts: Sections, Lectures, Duration

#### Step 4: Set Pricing
- **Route**: `/instructor/courses/create/pricing`
- **Options**:
  - Free/Paid toggle
  - Original Price
  - Discount Price
  - Validity Period (days or lifetime)
  - Discount percentage calculation

#### Step 5: SEO Settings
- **Route**: `/instructor/courses/create/seo`
- **Fields**:
  - Meta Title (160 chars)
  - Meta Description (160 chars)
  - URL Slug (auto-generate from title)
  - Live preview of search result

#### Step 6: Review & Submit
- **Route**: `/instructor/courses/create/review`
- **Features**:
  - Complete course overview
  - Edit links for all sections
  - Terms agreement checkbox
  - Submit for admin review

---

## 🔗 URL Routing

### Instructor Routes
```
GET  /instructor/courses                          - List all instructor's courses
GET  /instructor/courses/create/basics            - Step 1
POST /instructor/courses/create/basics            - Store Step 1
GET  /instructor/courses/create/media             - Step 2
POST /instructor/courses/create/media             - Store Step 2
GET  /instructor/courses/create/curriculum        - Step 3
GET  /instructor/courses/create/pricing           - Step 4
POST /instructor/courses/create/pricing           - Store Step 4
GET  /instructor/courses/create/seo               - Step 5
POST /instructor/courses/create/seo               - Store Step 5
GET  /instructor/courses/create/review            - Step 6
POST /instructor/courses/create/review            - Submit for Review
GET  /instructor/courses/{course}                 - View course
GET  /instructor/courses/{course}/edit            - Edit course
PUT  /instructor/courses/{course}                 - Update course
DELETE /instructor/courses/{course}               - Delete course

API Routes (AJAX):
POST /instructor/sections                        - Create section
PUT  /instructor/sections/{section}              - Update section
DELETE /instructor/sections/{section}            - Delete section
POST /instructor/sections/reorder                - Reorder sections

POST /instructor/lectures                        - Create lecture
PUT  /instructor/lectures/{lecture}              - Update lecture
DELETE /instructor/lectures/{lecture}            - Delete lecture
POST /instructor/lectures/reorder                - Reorder lectures
```

### Admin Routes
```
GET  /admin/course-approvals              - List pending courses
GET  /admin/course-approvals/{course}     - Review course
POST /admin/course-approvals/{course}/approve  - Approve
POST /admin/course-approvals/{course}/reject   - Reject
POST /admin/course-approvals/{course}/request-changes - Request changes
```

---

## 📊 Database Schema

### courses (Updated fields)
```
- subtitle: string|nullable
- language: string
- course_mode: enum(online, offline, hybrid)
- promo_video_url: string|nullable
- demo_pdf: string|nullable
- demo_lecture: string|nullable
- is_free: boolean (default: false)
- discount_price: decimal|nullable
- meta_title: string|nullable
- meta_description: text|nullable
- slug: string|unique|nullable
- status: enum(draft, under_review, published, rejected)
- rejection_reason: text|nullable
- approved_by: foreign key to users
```

### course_sections
```
- id: primary key
- course_id: foreign key
- title: string
- description: text|nullable
- order: integer
- timestamps
```

### course_lectures
```
- id: primary key
- section_id: foreign key
- title: string
- type: enum(video, pdf, quiz, assignment, live)
- file_path: string|nullable
- video_url: string|nullable
- duration: integer (seconds)|nullable
- is_preview: boolean
- description: text|nullable
- order: integer
- timestamps
```

### offline_batches
```
- id: primary key
- course_id: foreign key
- batch_name: string
- start_date: datetime
- end_date: datetime
- location: string
- capacity: integer
- enrolled_count: integer
- schedule: json
- status: enum(active, inactive, completed)
- timestamps
```

---

## 🔐 Authorization

### Course Policy
```php
- view(): Anyone can view published courses, instructor can view own
- create(): Only teachers/instructors
- update(): Only course owner and status != published
- delete(): Only course owner and status != published
- approve(): Only admin and status = under_review
- reject(): Only admin and status = under_review
```

### Model Relationships
```php
Course
  - has many sections
  - has many lectures (through sections)
  - has many offline_batches
  - belongs to teacher (User)
  - belongs to approver (User)

CourseSection
  - belongs to course
  - has many lectures

CourseLecture
  - belongs to section
  - can access course through section

OfflineBatch
  - belongs to course
```

---

## 🎯 Key Features

### Curriculum Builder
- Add/remove sections dynamically
- Add/remove lectures with different types (video, pdf, quiz, assignment, live)
- Mark lectures as preview/free
- Automatic duration calculation
- Session-based course ID tracking

### Media Management
- Thumbnail image upload (2MB)
- Promo video URL integration
- Sample PDF document (5MB)
- Demo lecture video (50MB)
- Drag & drop uploads (planned)

### Pricing System
- Free/Paid toggle
- Original and discount pricing
- Automatic discount percentage calculation
- Validity period configuration
- Lifetime access option

### SEO Optimization
- Meta title and description fields
- Auto-slug generation from title
- Live search result preview
- Character count indicators

### Admin Review System
- Pending courses queue
- Detailed course review interface
- Approve with one click
- Reject with custom reason
- Request changes without outright rejection
- Status tracking (draft → under_review → published/rejected)

---

## 📝 Usage Examples

### Creating a Course (Step by Step)

1. **Start Creation**
   - Instructor visits `/instructor/courses/create/basics`
   - Fills in basic details
   - Course created in `draft` status with session ID

2. **Add Media**
   - Navigates to `/instructor/courses/create/media`
   - Uploads thumbnail, demo files
   - Session maintains course_id

3. **Build Curriculum**
   - Navigates to `/instructor/courses/create/curriculum`
   - Uses AJAX to add/remove sections and lectures
   - Saves automatically via API

4. **Set Pricing**
   - Navigates to `/instructor/courses/create/pricing`
   - Configures pricing options
   - Calculates discounts

5. **Add SEO**
   - Navigates to `/instructor/courses/create/seo`
   - Sets meta information
   - Previews search result

6. **Review & Submit**
   - Navigates to `/instructor/courses/create/review`
   - Reviews all information
   - Agrees to terms
   - Clicks "Submit for Review"
   - Status changes to `under_review`

### Admin Review Process

1. **View Pending Courses**
   - Admin visits `/admin/course-approvals`
   - Sees list of courses under review

2. **Review Course**
   - Clicks "Review" to view details
   - Sees complete curriculum, pricing, media

3. **Make Decision**
   - **Approve**: Course → published, is_active = true
   - **Reject**: Course → rejected, is_active = false, reason saved
   - **Request Changes**: Course → draft, reason saved for instructor

---

## 🔧 Configuration

### File Upload Paths
```
- Thumbnails: storage/app/public/courses/thumbnails
- PDFs: storage/app/public/courses/pdfs
- Demo Lectures: storage/app/public/courses/demos
- Lecture Files: storage/app/public/courses/lectures
```

### Link Symlink
```bash
php artisan storage:link
```

### Session Configuration
Uses `session('course_id')` to track current course during multi-step creation

---

## 🐛 Troubleshooting

### Issue: Files not visible after upload
**Solution**: Run `php artisan storage:link`

### Issue: Views not updating
**Solution**: Run `php artisan view:clear`

### Issue: Routes not found
**Solution**: Run `php artisan route:clear`

### Issue: Session loses course_id between steps
**Solution**: Ensure session is configured in `.env` with FILE driver or better

### Issue: CSRF token mismatch
**Solution**: Ensure `@csrf` is in all forms and JavaScript sends correct header

---

## 📋 Checklist for Integration

- [ ] Run migrations
- [ ] Register policies in AppServiceProvider
- [ ] Clear cache/views/routes
- [ ] Ensure file upload storage is configured
- [ ] Create symlink for storage
- [ ] Test instructor course creation flow
- [ ] Test admin approval workflow
- [ ] Configure email notifications for approvals
- [ ] Add instructor menu link to dashboard
- [ ] Add admin course approvals to admin panel
- [ ] Test all validations
- [ ] Test authorization policies
- [ ] Configure stage in git/version control

---

## 🚀 Future Enhancements

1. **Drag & Drop Curriculum Reordering**
   - Implement full drag/drop with SortableJS

2. **Email Notifications**
   - Course approved/rejected notifications
   - Status change notifications

3. **Bulk Upload**
   - Upload multiple lectures at once
   - Progress tracking

4. **Video Processing**
   - Automatic video transcoding
   - Thumbnail extraction
   - Duration calculation from uploaded video

5. **Advanced Analytics**
   - Course performance metrics
   - Student engagement tracking
   - Revenue reports

6. **Revision Control**
   - Track course changes
   - Revert to previous versions
   - Change history

7. **Certificates**
   - Auto-generate certificates
   - Certificate templates
   - Verification system

---

## 📞 Support & Documentation

For detailed API documentation and examples, refer to:
- Controllers in `app/Http/Controllers/Instructor/`
- Migrations in `database/migrations/`
- Views in `resources/views/instructor/courses/` and `resources/views/admin/courses/`

---

## ✅ Testing Checklist

### Instructor Side
- [ ] Create course with all fields
- [ ] Navigate through all 6 steps
- [ ] Edit course details
- [ ] Add/remove sections
- [ ] Add/remove lectures
- [ ] Upload media files
- [ ] Set pricing and discounts
- [ ] Configure SEO settings
- [ ] Submit for review
- [ ] View course after approval

### Admin Side
- [ ] View pending courses list
- [ ] Review course details
- [ ] Approve course
- [ ] Reject course with reason
- [ ] Request changes
- [ ] View approved courses
- [ ] Track course status

### Validation
- [ ] Required fields validation
- [ ] File size limits
- [ ] Character limits
- [ ] URL format validation
- [ ] Price comparisons (discount < price)

---

Generated: November 25, 2025
Framework: Laravel 11.x
Database: MySQL
CSS: Tailwind CSS
JavaScript: Vanilla JS with AJAX

