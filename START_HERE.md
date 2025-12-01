# 🎓 Paathshaala - Educational Platform

Modern educational platform built with Laravel 12, featuring role-based dashboards for Admin, Professors, and Students.

---

## 🚀 Quick Start

### 1. **Prerequisites**
- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js & NPM
- Laragon (recommended for Windows)

### 2. **Installation**

```bash
# Clone the repository
cd c:\laragon\www\paathshaala

# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=paathshaala
DB_USERNAME=root
DB_PASSWORD=

# Run migrations and seed database
php artisan migrate:fresh --seed

# Build assets
npm run build
```

### 3. **Access the Application**

Visit: `http://localhost/paathshaala/public`

---

## 🔐 Login Credentials

### Quick Reference

| Role | Email | Password | Dashboard URL |
|------|-------|----------|---------------|
| **Admin** | admin@paathshaala.com | admin123 | `/admin/dashboard` |
| **Professor** | professor@paathshaala.com | professor123 | `/professors/dashboard` |
| **Student** | student@paathshaala.com | student123 | `/students/dashboard` |

**📖 Full credentials list**: See `LOGIN_CREDENTIALS.md`  
**💡 Quick display**: Run `php show-credentials.php`

---

## 📁 Project Structure

```
paathshaala/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin controllers
│   │   ├── Teacher/        # Teacher controllers
│   │   └── Student/        # Student controllers
│   ├── Models/             # Eloquent models
│   └── Policies/           # Authorization policies
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   └── views/
│       ├── admin/          # Admin dashboard views
│       ├── professors/     # Professor dashboard views
│       ├── students/       # Student dashboard views
│       ├── components/     # Reusable UI components
│       ├── layouts/        # Master layouts
│       └── auth/           # Authentication pages
├── routes/
│   └── web.php            # Web routes
└── docs/                  # Documentation
```

**📖 View Structure**: See `docs/NEW_VIEW_STRUCTURE.md`

---

## 👥 User Roles

### 1. **Admin** 👨‍💼
- Manage all courses, teachers, and students
- View system analytics and reports
- Configure system settings
- Handle payments and subscriptions

### 2. **Professor/Teacher** 👨‍🏫
- Create and manage own courses
- Track enrolled students
- Schedule online classes
- Upload course materials
- Grade assignments

### 3. **Student** 👨‍🎓
- Browse and enroll in courses
- Access course materials
- Attend online classes
- Track learning progress
- Download certificates

---

## 🎨 Features

### ✅ **Implemented**
- Role-based authentication & authorization
- Separate dashboards for each role
- Course management system
- Enrollment system with payments
- Online class scheduling
- Certificate generation
- Email notifications
- Responsive UI with Tailwind CSS

### 🚧 **In Development**
- Real-time notifications
- Live video classes integration
- Advanced analytics
- Mobile app
- API for third-party integrations

---

## 🛠️ Development

### Run Development Server
```bash
php artisan serve
# Visit: http://127.0.0.1:8000
```

### Compile Assets (Watch Mode)
```bash
npm run dev
```

### Run Tests
```bash
php artisan test
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 📚 Documentation

| Document | Description |
|----------|-------------|
| `LOGIN_CREDENTIALS.md` | Complete login credentials guide |
| `docs/DASHBOARD_ROUTING_GUIDE.md` | Dashboard routing documentation |
| `docs/NEW_VIEW_STRUCTURE.md` | View structure reference |
| `CREDENTIALS.txt` | Quick credentials reference |

---

## 🔄 Database Management

### Fresh Migration (Drops all tables)
```bash
php artisan migrate:fresh --seed
```

### Run Specific Seeder
```bash
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=CourseSeeder
```

### Rollback Migration
```bash
php artisan migrate:rollback
```

---

## 🧪 Testing

### Login Testing
1. Visit `/login`
2. Use credentials from `LOGIN_CREDENTIALS.md`
3. Verify auto-redirect to role dashboard
4. Test role-specific features

### Role Testing
- **Admin**: Try managing all resources
- **Professor**: Try creating courses
- **Student**: Try enrolling in courses

---

## 🐛 Troubleshooting

### Common Issues

**Issue**: Database connection error  
**Solution**: Check MySQL is running in Laragon

**Issue**: Class not found  
**Solution**: Run `composer dump-autoload`

**Issue**: Assets not loading  
**Solution**: Run `npm run build`

**Issue**: Routes not working  
**Solution**: Run `php artisan route:cache`

**Issue**: View not found  
**Solution**: Check `docs/NEW_VIEW_STRUCTURE.md` for correct paths

---

## 🔒 Security

**⚠️ IMPORTANT**: These are development credentials!

### For Production:
- ❌ Never use default credentials
- ✅ Change all passwords immediately
- ✅ Use strong passwords (12+ characters)
- ✅ Enable two-factor authentication
- ✅ Set proper environment variables
- ✅ Use HTTPS
- ✅ Regular security updates

---

## 📞 Support

### Resources
- **Documentation**: Check `/docs` folder
- **Credentials**: Run `php show-credentials.php`
- **Laravel Docs**: https://laravel.com/docs

---

## 📝 Version Information

- **Laravel**: 12.37.0
- **PHP**: 8.2+
- **MySQL**: 8.0+
- **Tailwind CSS**: 3.x
- **Alpine.js**: 3.x
- **Spatie Permissions**: Latest

---

## 🎯 Quick Commands Reference

```bash
# View all routes
php artisan route:list

# Create new controller
php artisan make:controller Admin/ExampleController

# Create new model
php artisan make:model Example -m

# Run queue workers
php artisan queue:work

# Clear everything
php artisan optimize:clear

# Display credentials
php show-credentials.php
```

---

## 📊 Project Stats

- **Total Views**: 46 files
- **Components**: 17 reusable components
- **Controllers**: 15+ controllers
- **Models**: 12+ models
- **Routes**: 100+ routes
- **Seeders**: 6 seeders

---

## 🤝 Contributing

1. Create a feature branch
2. Make your changes
3. Test thoroughly
4. Submit a pull request

---

## 📄 License

This project is proprietary and confidential.

---

**Last Updated**: November 21, 2025  
**Built with ❤️ using Laravel**

---

## 🎉 Getting Started Checklist

- [ ] Install dependencies (`composer install`, `npm install`)
- [ ] Configure `.env` file
- [ ] Start MySQL in Laragon
- [ ] Run migrations (`php artisan migrate:fresh --seed`)
- [ ] Build assets (`npm run build`)
- [ ] Visit login page
- [ ] Test all three dashboards
- [ ] Read documentation in `/docs`

**Happy Coding! 🚀**
