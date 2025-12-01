# 🔐 PAATHSHAALA LOGIN CREDENTIALS

## Test Accounts for Each Dashboard

---

## 👨‍💼 ADMIN DASHBOARD

**Access URL**: `http://localhost/paathshaala/public/admin/dashboard`

| Field | Value |
|-------|-------|
| **Email** | `admin@paathshaala.com` |
| **Password** | `admin123` |
| **Name** | Admin User |
| **Role** | Administrator |

### Admin Capabilities:
- ✅ Full system access
- ✅ Manage all courses
- ✅ Manage teachers and students
- ✅ View payments and analytics
- ✅ System settings and configuration
- ✅ Generate reports

---

## 👨‍🏫 PROFESSOR/TEACHER DASHBOARD

**Access URL**: `http://localhost/paathshaala/public/professors/dashboard`

### Account 1 (Primary)
| Field | Value |
|-------|-------|
| **Email** | `professor@paathshaala.com` |
| **Password** | `professor123` |
| **Name** | Dr. Rajesh Kumar |
| **Role** | Professor/Teacher |

### Account 2 (Alternative)
| Field | Value |
|-------|-------|
| **Email** | `teacher@paathshaala.com` |
| **Password** | `teacher123` |
| **Name** | Prof. Priya Sharma |
| **Role** | Professor/Teacher |

### Professor Capabilities:
- ✅ Manage own courses
- ✅ View enrolled students
- ✅ Create and schedule online classes
- ✅ Upload course materials
- ✅ Grade assignments
- ✅ Track student progress

---

## 👨‍🎓 STUDENT DASHBOARD

**Access URL**: `http://localhost/paathshaala/public/students/dashboard`

### Account 1 (Primary)
| Field | Value |
|-------|-------|
| **Email** | `student@paathshaala.com` |
| **Password** | `student123` |
| **Name** | Amit Singh |
| **Role** | Student |

### Account 2 (Alternative)
| Field | Value |
|-------|-------|
| **Email** | `student2@paathshaala.com` |
| **Password** | `student123` |
| **Name** | Sneha Patel |
| **Role** | Student |

### Student Capabilities:
- ✅ Browse and enroll in courses
- ✅ Access course materials
- ✅ Attend online classes
- ✅ Submit assignments
- ✅ View grades and progress
- ✅ Download certificates

---

## 🚀 Quick Start Guide

### 1. **Setup Database**

Run migrations and seeders:

```bash
# Fresh migration (WARNING: Drops all tables)
php artisan migrate:fresh --seed

# Or just run seeders
php artisan db:seed
```

### 2. **Login Process**

1. Navigate to: `http://localhost/paathshaala/public/login`
2. Enter email and password from the table above
3. Click "Login"
4. You'll be automatically redirected to the appropriate dashboard

### 3. **Dashboard Redirects**

After login, users are automatically redirected based on their role:

- **Admin** → `/admin/dashboard`
- **Professor/Teacher** → `/professors/dashboard`
- **Student** → `/students/dashboard`

---

## 📝 All Credentials Quick Reference

```
╔═══════════════════════════════════════════════════════════════╗
║                     LOGIN CREDENTIALS                         ║
╠═══════════════════════════════════════════════════════════════╣
║                                                               ║
║  👨‍💼 ADMIN                                                     ║
║  ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━  ║
║  Email:    admin@paathshaala.com                              ║
║  Password: admin123                                           ║
║                                                               ║
║  👨‍🏫 PROFESSOR                                                 ║
║  ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━  ║
║  Email:    professor@paathshaala.com                          ║
║  Password: professor123                                       ║
║                                                               ║
║  Alternative:                                                 ║
║  Email:    teacher@paathshaala.com                            ║
║  Password: teacher123                                         ║
║                                                               ║
║  👨‍🎓 STUDENT                                                   ║
║  ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━  ║
║  Email:    student@paathshaala.com                            ║
║  Password: student123                                         ║
║                                                               ║
║  Alternative:                                                 ║
║  Email:    student2@paathshaala.com                           ║
║  Password: student123                                         ║
║                                                               ║
╚═══════════════════════════════════════════════════════════════╝
```

---

## 🔒 Security Notes

### For Development:
- ✅ These are test credentials for development only
- ✅ Simple passwords for easy testing
- ✅ All accounts are pre-verified

### For Production:
- ❌ **NEVER** use these credentials in production
- ✅ Use strong passwords (min 12 characters)
- ✅ Enable two-factor authentication
- ✅ Change default admin credentials immediately
- ✅ Implement password complexity rules

---

## 🧪 Testing Different Roles

### Test Admin Access:
1. Login with `admin@paathshaala.com`
2. Access admin dashboard
3. Try managing courses, teachers, students
4. View system analytics

### Test Professor Access:
1. Login with `professor@paathshaala.com`
2. Access professor dashboard
3. Create a new course
4. Schedule an online class
5. Verify students cannot be managed globally

### Test Student Access:
1. Login with `student@paathshaala.com`
2. Access student dashboard
3. Browse available courses
4. Enroll in a course
5. Verify admin features are not accessible

---

## 🛠️ Troubleshooting

### "Invalid credentials" error:
```bash
# Re-run the seeder
php artisan db:seed --class=AdminSeeder
```

### "User already exists" error:
```bash
# Fresh migration (drops all data)
php artisan migrate:fresh --seed
```

### Database not found:
```bash
# Create database in MySQL
mysql -u root -p
CREATE DATABASE paathshaala;
exit;

# Then run migrations
php artisan migrate --seed
```

### Role not assigned:
```bash
# Run role seeder first
php artisan db:seed --class=RoleSeeder

# Then run admin seeder
php artisan db:seed --class=AdminSeeder
```

---

## 📊 User Data Summary

| Role | Count | Email Pattern | Password |
|------|-------|---------------|----------|
| Admin | 1 | admin@paathshaala.com | admin123 |
| Professor | 2 | professor@paathshaala.com, teacher@paathshaala.com | professor123 / teacher123 |
| Student | 2 | student@paathshaala.com, student2@paathshaala.com | student123 |
| **Total** | **5** | - | - |

---

## 🔄 Password Reset

If you forget a password or need to reset:

```php
// Run in tinker
php artisan tinker

// Reset admin password
$user = User::where('email', 'admin@paathshaala.com')->first();
$user->password = Hash::make('newpassword');
$user->save();
```

---

## 📧 Email Configuration

For password reset and email verification to work:

1. Configure `.env` file:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@paathshaala.com
MAIL_FROM_NAME="Paathshaala"
```

2. Or use Mailtrap for testing:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
```

---

## 🎯 Next Steps

1. ✅ Run `php artisan migrate:fresh --seed`
2. ✅ Login with any of the above credentials
3. ✅ Test role-based access control
4. ✅ Verify dashboard redirection works
5. ✅ Test each role's specific features
6. ✅ Customize user data as needed

---

**Last Updated**: November 21, 2025  
**Laravel Version**: 12.37.0  
**Database**: MySQL  
**Authentication**: Custom + Spatie Permissions

---

## 💡 Tips

- 🔑 Passwords are visible in this document for development convenience
- 📝 Update passwords before deploying to production
- 🧪 Create additional test users as needed
- 🔄 Re-run seeders anytime with `php artisan db:seed`
- 🎨 Customize user profiles in the seeder file

**Happy Testing! 🚀**
