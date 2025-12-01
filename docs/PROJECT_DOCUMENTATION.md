# Paathshaala - Learning Management System (LMS)

## 📋 Project Overview

Paathshaala is a comprehensive Learning Management System built with Laravel 12, featuring role-based authentication and dedicated dashboards for Admins, Teachers, and Students.

### 🎯 Key Features
- **Role-based Authentication**: Admin, Teacher, Student roles with specific permissions
- **Admin Dashboard**: Complete system management with analytics
- **Teacher Dashboard**: Course and class management
- **Student Dashboard**: Learning portal with progress tracking
- **Online Classes**: Live and recorded session management
- **Payment System**: Integrated payment processing
- **Certificate Management**: Automated certificate generation
- **Review System**: Course and teacher ratings

## 🏗️ Current Project Structure

### ✅ Already Implemented

#### Models & Database
- ✅ **User Model** with HasRoles trait (Spatie Permission)
- ✅ **Course Model** with relationships
- ✅ **Enrollment Model** for student-course relationships
- ✅ **Payment Model** for transaction tracking
- ✅ **Certificate Model** for student certifications
- ✅ **OnlineClass Model** for live/recorded sessions
- ✅ **Review Model** for ratings and feedback
- ✅ **Offer Model** for discount management

#### Database Migrations
- ✅ Users table with additional fields (phone, address, profile_image)
- ✅ All core tables (courses, enrollments, payments, certificates, etc.)
- ✅ Spatie Permission tables

#### Authentication & Authorization
- ✅ Laravel Breeze installed (in composer.json)
- ✅ Spatie Laravel Permission configured
- ✅ Role-based middleware in routes
- ✅ AdminSeeder with default users and roles

#### Basic Controllers & Routes
- ✅ Admin routes with CRUD operations
- ✅ Teacher and Student route groups
- ✅ Landing page controller
- ✅ Role-based dashboard routing

### 🔧 Needs Implementation/Enhancement

## 📝 Detailed Implementation Plan

### Phase 1: Authentication & Role Setup
1. **Laravel Breeze Configuration**
   - Configure registration form for students
   - Add role selection during registration
   - Customize login to redirect based on roles

2. **Permission System Enhancement**
   - Define granular permissions for each role
   - Create role-specific middleware
   - Setup proper permission seeding

### Phase 2: Admin Dashboard Development
#### Features to Implement:
- **Dashboard Analytics**
  - Total courses count
  - Total enrollments count
  - Total teachers count
  - Revenue statistics
  - Recent activities

- **Teacher Management**
  - List all teachers
  - Add new teachers
  - Edit teacher profiles
  - Assign teachers to courses

- **Student Management**
  - List all students
  - View student progress
  - Manage student enrollments

- **Course Management**
  - Create/Edit/Delete courses
  - Set course pricing and duration
  - Upload course materials
  - Assign teachers to courses

- **Offer Management**
  - Create discount offers
  - Set offer validity periods
  - Apply offers to specific courses

- **Payment Management**
  - View all transactions
  - Generate payment reports
  - Handle refunds

- **Certificate Management**
  - Issue certificates to students
  - Design certificate templates
  - Track certificate status

### Phase 3: Teacher Dashboard Development
#### Features to Implement:
- **Dashboard Overview**
  - Total students per teacher's courses
  - Upcoming classes
  - Recent enrollments

- **Course Management**
  - Manage assigned courses
  - Update course content
  - Set class timings and fees

- **Online Class Management**
  - Schedule live classes
  - Upload recorded sessions
  - Manage class attendance

- **Student Progress Tracking**
  - View enrolled students
  - Track completion rates
  - Generate progress reports

### Phase 4: Student Dashboard Development
#### Features to Implement:
- **Dashboard Overview**
  - Enrolled courses
  - Learning progress
  - Upcoming classes

- **Course Access**
  - View course materials
  - Access online classes
  - Watch recorded sessions

- **Progress Tracking**
  - View certificates earned
  - Download payment receipts
  - Track course completion

- **Review System**
  - Rate and review courses
  - Provide teacher feedback

### Phase 5: Landing Page & Public Features
#### Features to Implement:
- **Homepage**
  - Featured courses showcase
  - Course categories
  - Teacher highlights

- **Course Catalog**
  - Browse all courses
  - Filter by category/price
  - Course details page

- **Enrollment Process**
  - Course selection
  - Payment integration
  - Confirmation system

### Phase 6: Online Classes System
#### Features to Implement:
- **Live Class Management**
  - Integration with video conferencing
  - Class scheduling
  - Attendance tracking

- **Recorded Sessions**
  - Video upload and storage
  - Streaming capabilities
  - Progress tracking

## 🗃️ Database Schema

### Core Tables
```sql
users (id, name, email, password, phone, address, profile_image, timestamps)
courses (id, title, description, teacher_id, price, duration, status, timestamps)
enrollments (id, student_id, course_id, enrollment_date, status, timestamps)
payments (id, student_id, course_id, amount, payment_method, status, timestamps)
certificates (id, student_id, course_id, issued_date, certificate_url, timestamps)
online_classes (id, course_id, title, description, scheduled_at, type, url, timestamps)
reviews (id, student_id, course_id, teacher_id, rating, comment, timestamps)
offers (id, title, description, discount_percentage, valid_from, valid_to, timestamps)
```

### Permission Tables (Spatie)
```sql
roles (id, name, guard_name, timestamps)
permissions (id, name, guard_name, timestamps)
role_has_permissions (permission_id, role_id)
model_has_permissions (permission_id, model_type, model_id)
model_has_roles (role_id, model_type, model_id)
```

## 🎭 Role Definitions

### Admin Role
**Permissions:**
- Manage all users (teachers, students)
- Manage all courses
- View all payments and generate reports
- Issue certificates
- Create and manage offers
- Access system analytics

### Teacher Role
**Permissions:**
- Manage assigned courses
- Create and manage online classes
- View enrolled students
- Upload course materials
- Track student progress

### Student Role
**Permissions:**
- View enrolled courses
- Access course materials
- Attend online classes
- Submit reviews and ratings
- Download certificates and payment receipts

## 🚀 Technology Stack

- **Backend**: Laravel 12.0
- **Authentication**: Laravel Breeze
- **Authorization**: Spatie Laravel Permission
- **Frontend**: Blade Templates, Tailwind CSS
- **Database**: MySQL/PostgreSQL
- **Build Tools**: Vite

## 📁 File Structure

```
paathshaala/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   ├── Teacher/
│   │   │   ├── Student/
│   │   │   └── LandingPageController.php
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Course.php
│   │   ├── Enrollment.php
│   │   ├── Payment.php
│   │   ├── Certificate.php
│   │   ├── OnlineClass.php
│   │   ├── Review.php
│   │   └── Offer.php
│   └── Providers/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   ├── teacher/
│   │   ├── student/
│   │   └── landing/
│   ├── css/
│   └── js/
└── routes/
    ├── web.php
    └── auth.php
```

## 🛠️ Development Steps

### Step 1: Environment Setup
```bash
# Install dependencies
composer install
npm install

# Environment configuration
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate:fresh --seed

# Build assets
npm run dev
```

### Step 2: Authentication Enhancement
1. Customize Laravel Breeze registration
2. Add role selection during registration
3. Implement role-based redirects

### Step 3: Dashboard Development
1. Admin dashboard with analytics
2. Teacher dashboard with course management
3. Student dashboard with learning portal

### Step 4: Feature Implementation
1. Online class system
2. Payment integration
3. Certificate generation
4. Review system

### Step 5: Frontend Polish
1. Landing page design
2. Responsive layouts
3. User experience optimization

## 🧪 Testing Strategy

### Unit Tests
- Model relationships
- Permission system
- Business logic

### Feature Tests
- Authentication flows
- Role-based access
- CRUD operations
- Dashboard functionality

### Browser Tests
- End-to-end user journeys
- Payment workflows
- Class attendance flows

## 📋 Deployment Checklist

- [ ] Environment variables configured
- [ ] Database migrations run
- [ ] Seeders executed
- [ ] File permissions set
- [ ] SSL certificate installed
- [ ] Backup strategy implemented
- [ ] Monitoring tools configured

## 🔒 Security Considerations

- Role-based access control
- Input validation and sanitization
- CSRF protection
- SQL injection prevention
- File upload security
- Password hashing
- Session management

## 📞 Support & Maintenance

- Regular security updates
- Database backup procedures
- Performance monitoring
- User support documentation
- Bug tracking and resolution

---

**Project Status**: Development Phase
**Last Updated**: November 7, 2025
**Version**: 1.0.0-dev