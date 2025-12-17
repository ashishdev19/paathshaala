# 📚 MEDNIKS (formerly Paathshaala) - Complete Project Analysis

## 🎯 PROJECT OVERVIEW

**Medniks** is a comprehensive **Learning Management System (LMS)** built specifically for medical education. It's a multi-role platform where admins manage the system, instructors create and teach courses, and students enroll and learn.

### **Core Purpose**
- Online medical education platform
- Course creation and management
- Live classes with video conferencing (Jitsi)
- Payment processing and wallet system
- Certificate generation
- Subscription-based instructor access

---

## 🏗️ TECH STACK

### **Backend**
- **Framework**: Laravel 12 (latest version)
- **PHP Version**: 8.2
- **Database**: MySQL 8.0
- **Authentication**: Laravel's built-in + Spatie Permissions

### **Frontend**
- **UI Framework**: Tailwind CSS 3.x
- **JavaScript**: Alpine.js, Livewire 3.x
- **Build Tool**: Vite
- **Icons**: Font Awesome 6.0

### **Key Packages**
```json
{
  "livewire/livewire": "^3.6.4",      // Dynamic interfaces without page reload
  "livewire/volt": "^1.7.0",           // Single-file Livewire components
  "spatie/laravel-permission": "^6.23" // Role & permission management
}
```

---

## 👥 USER ROLES & CAPABILITIES

### **1. Super Admin** (Highest Authority)
- **Access**: Complete system control
- **Capabilities**:
  - Manage all admins
  - System-wide settings
  - View all logs
  - Full database access
- **Dashboard**: `/superadmin/dashboard`

### **2. Admin**
- **Access**: Platform management
- **Capabilities**:
  - Approve/reject course submissions
  - Manage instructors (teachers/professors)
  - Manage students
  - Configure subscription plans
  - Monitor payments & withdrawals
  - Manage platform wallet
  - Generate reports
- **Dashboard**: `/admin/dashboard`

### **3. Instructor** (Teacher/Professor)
- **Access**: Course & class management
- **Capabilities**:
  - Create courses (pending admin approval)
  - Upload course materials (videos, PDFs, sections, lectures)
  - Schedule live classes via Jitsi
  - Track student enrollments
  - Manage earnings in wallet
  - Request withdrawals
  - View analytics
- **Dashboard**: `/instructor/dashboard`
- **Subscription Required**: Must subscribe to Silver/Gold/Platinum plan

### **4. Student**
- **Access**: Learning & enrollment
- **Capabilities**:
  - Browse and enroll in courses
  - Watch recorded lectures
  - Attend live classes
  - Track progress
  - Download certificates on completion
  - Wallet for payments
  - Leave reviews
- **Dashboard**: `/student/dashboard`

---

## 📂 PROJECT STRUCTURE

```
medniks.com/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/              # Admin panel controllers
│   │   │   ├── Instructor/         # Instructor panel controllers
│   │   │   ├── Student/            # Student panel controllers
│   │   │   ├── Auth/               # Login, register, logout
│   │   │   └── HomeController.php  # Public pages
│   │   ├── Middleware/             # Auth, role checks
│   │   └── Requests/               # Form validation
│   ├── Models/                     # Database models (see below)
│   ├── Policies/                   # Authorization policies
│   ├── Services/                   # Business logic
│   │   └── CertificateService.php  # PDF certificate generation
│   ├── Livewire/                   # Interactive components
│   └── Providers/                  # Service providers
├── database/
│   ├── migrations/                 # 47 migration files
│   └── seeders/                    # Test data & initial setup
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php       # Landing page
│   │   ├── admin/                  # Admin views
│   │   ├── instructor/             # Instructor views
│   │   ├── student/                # Student views
│   │   ├── components/             # Reusable UI components
│   │   └── layouts/                # Master layouts
│   ├── css/                        # Tailwind styles
│   └── js/                         # Alpine.js scripts
├── routes/
│   ├── web.php                     # Main routes (383 lines!)
│   ├── api.php                     # API endpoints
│   └── channels.php                # Broadcasting channels
├── public/                         # Publicly accessible
│   ├── index.php                   # Entry point
│   ├── css/                        # Compiled CSS
│   ├── js/                         # Compiled JS
│   └── storage -> ../storage/app/public
├── storage/
│   ├── app/
│   │   ├── public/                 # Uploaded files
│   │   └── certificates/           # Generated PDFs
│   ├── framework/                  # Cache, sessions, views
│   └── logs/                       # Application logs
├── config/                         # Configuration files
├── vendor/                         # Composer dependencies
└── .env                            # Environment variables
```

---

## 🗄️ DATABASE ARCHITECTURE

### **Core Tables** (39 tables total)

#### **User Management**
```
users                    # All users (students, instructors, admins)
├── id, name, email, password
├── role_id             # Links to roles table
├── wallet_balance      # For transactions
└── profile fields      # Phone, bio, etc.

roles                    # admin, instructor, student, etc.
permissions              # Fine-grained access control
role_permissions         # Many-to-many relationship
```

#### **Course System**
```
courses                  # Main course table
├── id, title, description
├── instructor_id       # Who created it
├── category_id         # Course category
├── price, discounted_price
├── status              # pending, approved, published
├── validity_days       # Access duration
└── course_image        # Thumbnail

course_categories        # Medical specialties
├── NEET PG, INICET, FMGE, etc.

course_sections          # Course chapters/modules
├── course_id, title, order

course_lectures          # Individual lessons
├── section_id, title, video_url, duration, order
└── content_type        # video, pdf, text
```

#### **Enrollment & Payment**
```
enrollments              # Student course access
├── student_id, course_id
├── enrollment_date, expiry_date
├── progress_percentage
├── payment_status
└── is_completed

payments                 # Transaction records
├── user_id, course_id
├── amount, discount, final_amount
├── payment_method      # razorpay, wallet, etc.
├── transaction_id
└── status              # pending, completed, failed
```

#### **Live Classes**
```
live_classes             # Scheduled sessions
├── instructor_id, course_id
├── title, meeting_url  # Jitsi link
├── scheduled_at
├── duration_minutes
└── status              # scheduled, live, completed
```

#### **Certificates**
```
certificates             # Generated PDFs
├── enrollment_id
├── student_id, course_id
├── certificate_number  # Unique ID
├── issue_date
└── certificate_path    # Storage location
```

#### **Instructor Subscription**
```
subscription_plans       # Silver, Gold, Platinum
├── name, price, duration_months
├── max_courses, max_students
├── features            # JSON array
└── is_active

teacher_subscriptions    # Active subscriptions
├── teacher_id, plan_id
├── start_date, end_date
├── payment_status
└── is_active

teacher_subscription_history  # Payment records
```

#### **Wallet System**
```
wallets                  # User balances
├── user_id
├── balance
└── updated_at

wallet_transactions      # Debit/Credit history
├── wallet_id
├── type                # credit, debit, withdrawal
├── amount, description
└── related_id          # Payment/course ID

wallet_topups            # Money added to wallet
├── user_id, amount
├── payment_method
└── status

withdraw_requests        # Instructor cash-outs
├── teacher_id, amount
├── bank_details        # JSON
├── status              # pending, approved, rejected
└── processed_at
```

#### **Other Features**
```
reviews                  # Course ratings
notifications            # User alerts
offers                   # Discount codes
offline_batches          # In-person classes
platform_settings        # System configuration
```

---

## 🔐 AUTHENTICATION & AUTHORIZATION

### **Authentication Flow**
```
1. User visits /login
2. CustomLoginController validates credentials
3. If valid: Create session, redirect to dashboard
4. Dashboard route checks user role via:
   - $user->isSuperAdmin()
   - $user->isAdmin()
   - $user->isInstructor()
   - $user->isStudent()
5. Redirect to appropriate panel
```

### **Middleware Protection**
```php
// In routes/web.php
Route::middleware(['auth', 'admin'])->prefix('admin')->group(...);
Route::middleware(['auth', 'instructor'])->prefix('instructor')->group(...);
Route::middleware(['auth', 'student'])->prefix('student')->group(...);
```

### **Permission System (Spatie)**
```php
// Check permissions
$user->hasPermissionTo('create courses');
$user->hasRole('admin');

// Assign roles
$user->assignRole('instructor');

// Gate-based authorization
Gate::allows('manage-users');
```

---

## 🎓 KEY FEATURES EXPLAINED

### **1. Course Creation Module**
**Workflow:**
```
Instructor Dashboard
  └─> Create Course
       ├─> Add Course Details (title, description, price, category)
       ├─> Upload Thumbnail
       ├─> Create Sections
       │    └─> Add Lectures (video upload/URL, PDFs)
       ├─> Set Pricing & Validity
       └─> Submit for Approval
            └─> Admin Reviews
                 ├─> Approve → Course Published
                 ├─> Reject → Deleted
                 └─> Request Changes → Back to Instructor
```

**Technologies:**
- File uploads via Laravel Storage
- Video hosting: YouTube embed or direct upload
- Section/Lecture hierarchy for organization

### **2. Live Class System (Jitsi Integration)**
**How It Works:**
```
1. Instructor schedules live class
   - Sets date, time, duration
   - System generates unique Jitsi room URL

2. Students see "Join Class" button when live

3. Clicking button:
   - Opens Jitsi Meet in iframe
   - Auto-configures: username, room name, toolbar

4. Features:
   - Screen sharing
   - Chat
   - Recording (if enabled)
   - Participant management
```

**Code Location:**
- `resources/views/instructor/live-classes/join.blade.php`
- `resources/views/student/live-classes/join.blade.php`
- Jitsi External API integration via CDN

### **3. Payment & Wallet System**
**Student Enrollment Flow:**
```
Student browses course
  └─> Click "Enroll Now"
       ├─> Has wallet balance?
       │    ├─> Yes: Deduct from wallet
       │    └─> No: Redirect to payment gateway (Razorpay)
       └─> Payment Success
            ├─> Create enrollment record
            ├─> Set expiry date (based on course validity)
            └─> Grant course access
```

**Instructor Earnings:**
```
Student pays ₹1000 for course
  ├─> Platform fee (10%): ₹100
  └─> Instructor earns: ₹900 (added to wallet)

Instructor requests withdrawal
  ├─> Admin reviews
  ├─> If approved: Transfer to bank
  └─> Update wallet balance
```

### **4. Certificate Generation**
**Service:** `App\Services\CertificateService.php`

**Process:**
```
1. Student completes course (100% progress)
2. System triggers certificate generation
3. PDF created with:
   - Student name
   - Course title
   - Completion date
   - Unique certificate number
   - QR code for verification
4. Stored in storage/app/certificates/
5. Student can download from dashboard
```

**Technology:**
- TCPDF or similar library for PDF generation
- Dynamic template with brand logo
- Watermark for authenticity

### **5. Subscription System (Instructors)**
**Plans:**
```
SILVER (₹2,999/month)
├─> 5 courses max
├─> 100 students per course
├─> Basic analytics
└─> Email support

GOLD (₹4,999/month)
├─> 20 courses max
├─> 500 students per course
├─> Advanced analytics
├─> Live class recording
└─> Priority support

PLATINUM (₹9,999/month)
├─> Unlimited courses
├─> Unlimited students
├─> Full analytics dashboard
├─> Custom branding
├─> Dedicated account manager
└─> API access
```

**Enforcement:**
- Middleware checks active subscription before course creation
- Cron job checks expiry daily
- Grace period of 7 days

---

## 🛣️ ROUTING STRUCTURE

### **Public Routes** (No Auth Required)
```
/                        → Landing page
/courses                 → Course catalog
/courses/{id}            → Course details
/about                   → About page
/contact                 → Contact form
/login                   → Login page
/register                → Registration
```

### **Admin Routes** (`/admin/*`)
```
/admin/dashboard         → Overview stats
/admin/instructors       → Manage teachers
/admin/students          → Student list
/admin/courses           → All courses
/admin/course-approvals  → Pending approvals
/admin/subscription-plans → Plan management
/admin/wallets           → Wallet overview
/admin/withdrawals       → Payout requests
/admin/offers            → Discount codes
/admin/payments          → Transaction history
```

### **Instructor Routes** (`/instructor/*`)
```
/instructor/dashboard    → My stats
/instructor/courses      → My courses (CRUD)
/instructor/courses/{id}/sections    → Course structure
/instructor/courses/{id}/lectures    → Add lessons
/instructor/live-classes → Schedule sessions
/instructor/students     → Enrolled students
/instructor/earnings     → Revenue analytics
/instructor/wallet       → Balance & withdrawals
/instructor/subscription → Plan details
```

### **Student Routes** (`/student/*`)
```
/student/dashboard       → My courses
/student/courses         → Browse catalog
/student/courses/{id}    → Watch lectures
/student/live-classes    → Upcoming sessions
/student/certificates    → Downloads
/student/wallet          → Top-up balance
/student/payments        → Transaction history
```

---

## 📊 DASHBOARD METRICS

### **Admin Dashboard**
- Total students count
- Total instructors count
- Total courses (approved/pending)
- Revenue this month
- Active subscriptions
- Pending withdrawals
- Recent enrollments graph

### **Instructor Dashboard**
- My courses count
- Total students enrolled
- Revenue earned (this month)
- Upcoming live classes
- Pending course approvals
- Student engagement metrics

### **Student Dashboard**
- Enrolled courses
- Course progress bars
- Upcoming live classes
- Certificates earned
- Wallet balance
- Recommended courses

---

## 💳 PAYMENT INTEGRATION

### **Gateway:** Razorpay (India's leading payment gateway)

**Configuration:**
```env
# .env
RAZORPAY_KEY_ID=rzp_test_xxxxxx
RAZORPAY_KEY_SECRET=xxxxxxxxxxxxxx
```

**Payment Flow:**
```javascript
// Frontend (Blade template)
var options = {
    key: "{{ env('RAZORPAY_KEY_ID') }}",
    amount: {{ $course->price * 100 }}, // Paise
    currency: "INR",
    name: "Medniks",
    description: "Course Enrollment",
    handler: function (response){
        // Send payment_id to backend
        $.post('/verify-payment', {
            payment_id: response.razorpay_payment_id
        });
    }
};
var rzp = new Razorpay(options);
rzp.open();
```

**Backend Verification:**
```php
// PaymentController.php
public function verifyPayment(Request $request)
{
    $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
    $payment = $api->payment->fetch($request->payment_id);
    
    if ($payment->status === 'captured') {
        // Create enrollment
        // Add to instructor wallet
        // Send confirmation email
    }
}
```

---

## 🔧 IMPORTANT SERVICES

### **1. CertificateService**
**Location:** `app/Services/CertificateService.php`

**Methods:**
- `generateCertificate($enrollment)` → Creates PDF
- `getCertificateNumber()` → Unique ID generator
- `verifyCertificate($certNumber)` → QR code validation

### **2. NotificationService** (if exists)
- Email notifications via Laravel Mail
- In-app notifications stored in `notifications` table
- Real-time alerts using Livewire events

### **3. WalletService**
- `credit($userId, $amount, $description)`
- `debit($userId, $amount, $description)`
- `getBalance($userId)`
- `transferToInstructor($courseId, $amount)`

---

## 🌐 FRONTEND TECHNOLOGIES

### **Tailwind CSS**
**Utility-first framework** for rapid UI development

**Example:**
```html
<button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Enroll Now
</button>
```

**Configuration:** `tailwind.config.js`

### **Alpine.js**
**Lightweight JavaScript** for interactivity

**Example:**
```html
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open">Content</div>
</div>
```

### **Livewire**
**Full-stack framework** - No need to write separate API

**Example Component:**
```php
// app/Livewire/CourseList.php
class CourseList extends Component
{
    public $search = '';
    
    public function render()
    {
        return view('livewire.course-list', [
            'courses' => Course::where('title', 'like', "%{$this->search}%")->get()
        ]);
    }
}
```

```html
<!-- resources/views/livewire/course-list.blade.php -->
<div>
    <input type="text" wire:model.live="search" placeholder="Search courses">
    @foreach($courses as $course)
        <div>{{ $course->title }}</div>
    @endforeach
</div>
```

**No page reload needed!** Typing in search auto-updates list.

---

## 🔄 KEY WORKFLOWS

### **New Student Registration**
```
1. Visit /register
2. Fill form (name, email, password, phone)
3. Submit → CustomRegisterController@register
4. Validation
5. Create user with role='student'
6. Send welcome email
7. Auto-login
8. Redirect to /student/dashboard
```

### **Course Enrollment**
```
1. Student clicks "Enroll" on course page
2. Check: Already enrolled?
3. Check: Has valid offer code?
4. Calculate: final_price = course_price - discount
5. Payment:
   a. If wallet balance >= final_price → Deduct
   b. Else → Razorpay gateway
6. Create enrollment with expiry_date
7. Redirect to course player
```

### **Live Class Attendance**
```
1. Instructor schedules class
   → Creates record in live_classes table
2. System sends notification to enrolled students
3. 5 minutes before start: "Join" button appears
4. Student clicks join:
   → Opens Jitsi Meet iframe
   → Configures with student name, room ID
5. Class ends → Status updated to 'completed'
6. Recording saved (if enabled)
```

---

## 🐛 COMMON ISSUES & SOLUTIONS

### **Issue 1: 500 Internal Server Error**
**Causes:**
- Wrong file permissions (files writable by group)
- Database connection failure
- Missing .env file

**Fix:**
```bash
# Correct permissions
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 755 storage bootstrap/cache

# Test database
php artisan migrate:status

# Clear cache
php artisan config:clear
```

### **Issue 2: Livewire Not Working**
**Causes:**
- JavaScript not loaded
- CSRF token mismatch

**Fix:**
```html
<!-- Add to layout -->
@livewireStyles
@livewireScripts
```

### **Issue 3: Payment Verification Fails**
**Causes:**
- Wrong Razorpay keys
- Callback URL incorrect

**Fix:**
```env
# Check .env
RAZORPAY_KEY_ID=rzp_live_xxxxx  # Use 'live' not 'test'
APP_URL=https://medniks.com     # Match exactly
```

---

## 📦 DEPLOYMENT CHECKLIST

### **Pre-Deployment**
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Update `APP_URL=http://medniks.com`
- [ ] Configure database credentials
- [ ] Add Razorpay live keys
- [ ] Set up email (SMTP/Mailgun)

### **On Server**
```bash
# 1. Upload files
# 2. Install dependencies
composer install --no-dev --optimize-autoloader

# 3. Set permissions
chmod -R 755 storage bootstrap/cache
find . -type f -exec chmod 644 {} \;

# 4. Run migrations
php artisan migrate --force

# 5. Seed data (optional)
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=CourseCategoriesSeeder

# 6. Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Create storage link
php artisan storage:link

# 8. Test
curl -I http://medniks.com
```

---

## 🎨 CUSTOMIZATION POINTS

### **Branding**
- **Logo:** `public/images/logo.png`
- **Favicon:** `public/favicon.ico`
- **Colors:** `tailwind.config.js` → `theme.extend.colors`
- **Fonts:** `resources/css/app.css` → Google Fonts import

### **Email Templates**
- **Location:** `resources/views/emails/`
- **Modify:** Welcome email, payment receipt, certificate notification

### **Landing Page**
- **File:** `resources/views/welcome.blade.php`
- **Sections:** Hero, Features, Courses, Testimonials, Footer

---

## 🔐 SECURITY FEATURES

1. **CSRF Protection** - All forms have `@csrf` token
2. **Password Hashing** - bcrypt with 12 rounds
3. **SQL Injection Prevention** - Eloquent ORM
4. **XSS Protection** - Blade `{{ }}` auto-escapes
5. **Role-Based Access** - Middleware + Policies
6. **API Rate Limiting** - Throttle middleware
7. **HTTPS Enforcement** - TrustProxies middleware

---

## 📈 ANALYTICS & REPORTING

### **Instructor Analytics**
- Daily/Monthly revenue charts
- Student enrollment trends
- Course completion rates
- Most popular courses

### **Admin Analytics**
- Platform-wide revenue
- User growth metrics
- Course approval turnaround
- Withdrawal processing time

### **Tools Used**
- Chart.js for graphs
- Laravel Excel for reports export
- Carbon for date manipulation

---

## 🚀 PERFORMANCE OPTIMIZATION

### **Already Implemented**
- ✅ Database indexing on foreign keys
- ✅ Eager loading (`with()`) to prevent N+1 queries
- ✅ Config/route/view caching in production
- ✅ Asset bundling via Vite

### **Recommended Additions**
- [ ] Redis for session storage
- [ ] CDN for static assets
- [ ] Database query caching
- [ ] Image optimization (WebP format)
- [ ] Lazy loading for videos

---

## 🧪 TESTING

### **Run Tests**
```bash
php artisan test
```

### **Available Tests**
- Feature tests for authentication
- Unit tests for wallet calculations
- Browser tests for enrollment flow

### **Create New Test**
```bash
php artisan make:test CourseEnrollmentTest
```

---

## 📚 DOCUMENTATION FILES

The project includes extensive documentation:

- `ARCHITECTURE_GUIDE.md` - System design
- `COURSE_CREATION_MODULE.md` - Course management
- `WALLET_SYSTEM_README.md` - Payment flows
- `RBAC_DOCUMENTATION.md` - Permissions system
- `JITSI_EXPLAINED.md` - Live class setup
- `CPANEL_DEPLOYMENT.md` - Hosting guide

---

## 🎓 LEARNING RESOURCES

### **For Developers Joining Project**
1. **Laravel Docs**: https://laravel.com/docs
2. **Livewire Docs**: https://livewire.laravel.com
3. **Tailwind Docs**: https://tailwindcss.com
4. **Spatie Permissions**: https://spatie.be/docs/laravel-permission

### **Understand Codebase**
```bash
# Explore routes
php artisan route:list

# See database schema
php artisan schema:dump

# Check policies
php artisan policy:list
```

---

## 🆘 SUPPORT & MAINTENANCE

### **Common Commands**
```bash
# Clear everything
php artisan optimize:clear

# View logs
tail -f storage/logs/laravel.log

# Database backup
php artisan backup:run

# Queue workers
php artisan queue:work

# Schedule checker
php artisan schedule:run
```

### **Contact**
- **System Admin**: admin@medniks.com
- **Technical Support**: tech@medniks.com
- **Server Issues**: hosting@medniks.com

---

## ✅ PROJECT STATUS

**Current Status:** ✅ **Production Ready**

**Deployed At:** http://medniks.com

**Database:** healthboat_paathshaala @ localhost

**Server:** VPS (Apache, PHP 8.2, MySQL 8.0)

**Last Updated:** December 11, 2025

---

## 🎉 CONCLUSION

**Medniks (Paathshaala)** is a **feature-complete LMS** designed for medical education. It handles:
- Multi-role access (Admin, Instructor, Student)
- Full course lifecycle (creation → approval → enrollment)
- Payment processing with wallet system
- Live classes via Jitsi
- Certificate generation
- Instructor subscription model

The codebase follows **Laravel best practices**, uses **modern frontend tools** (Livewire, Tailwind), and is **ready for production use**.

For any questions about specific features, check the detailed documentation files or explore the code with the guidance above!

---

**Made with ❤️ for Medical Education**
