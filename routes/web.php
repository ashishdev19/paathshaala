<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EnrollmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [HomeController::class, 'courses'])->name('courses.index');
Route::get('/courses/{id}', [HomeController::class, 'courseDetail'])->name('courses.show');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Role-based dashboard routing  
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('teacher')) {
        return redirect()->route('teacher.dashboard');
    } elseif ($user->hasRole('student')) {
        return redirect()->route('student.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('teachers', AdminTeacherController::class);
    Route::resource('students', StudentController::class);
    Route::resource('courses', AdminCourseController::class);
    Route::resource('offers', \App\Http\Controllers\Admin\OfferController::class);
    Route::resource('payments', AdminPaymentController::class);
    Route::resource('certificates', AdminCertificateController::class);
    Route::resource('online-classes', App\Http\Controllers\Admin\OnlineClassController::class);
});

// Teacher Routes
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [TeacherController::class, 'courses'])->name('courses');
    Route::get('/students', [TeacherController::class, 'students'])->name('students');
    Route::get('/classes', [TeacherController::class, 'classes'])->name('classes');
});

// Online Classes Routes
Route::middleware('auth')->group(function () {
    Route::resource('online-classes', App\Http\Controllers\OnlineClassController::class);
    Route::get('/online-classes/{onlineClass}/join', [App\Http\Controllers\OnlineClassController::class, 'join'])->name('online-classes.join');
    Route::get('/online-classes/{onlineClass}/watch', [App\Http\Controllers\OnlineClassController::class, 'watch'])->name('online-classes.watch');
    Route::post('/online-classes/{onlineClass}/attendance', [App\Http\Controllers\OnlineClassController::class, 'markAttendance'])->name('online-classes.attendance');
    Route::get('/api/upcoming-classes', [App\Http\Controllers\OnlineClassController::class, 'upcoming'])->name('api.upcoming-classes');

    // API routes for video progress tracking
    Route::post('/api/classes/{onlineClass}/progress', [App\Http\Controllers\OnlineClassController::class, 'updateProgress'])->name('api.classes.progress');
    Route::post('/api/classes/{onlineClass}/complete', [App\Http\Controllers\OnlineClassController::class, 'markCompleted'])->name('api.classes.complete');
});

// Enrollment Routes
Route::middleware('auth')->group(function () {
    Route::get('/courses/{course}/checkout', [App\Http\Controllers\EnrollmentController::class, 'checkout'])->name('enrollment.checkout');
    Route::post('/courses/{course}/enroll', [App\Http\Controllers\EnrollmentController::class, 'store'])->name('enrollment.store');
    Route::get('/enrollment/success', [App\Http\Controllers\EnrollmentController::class, 'success'])->name('enrollment.success');
});

// Notification Routes
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/recent', [App\Http\Controllers\NotificationController::class, 'getRecent'])->name('notifications.recent');
    Route::post('/notifications/{notification}/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/{notification}/mark-unread', [App\Http\Controllers\NotificationController::class, 'markAsUnread'])->name('notifications.mark-unread');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'show'])->name('notifications.show');
});

// Certificate Routes
Route::middleware('auth')->group(function () {
    Route::get('/certificates/{certificate}', [App\Http\Controllers\CertificateController::class, 'show'])->name('certificates.show');
    Route::get('/certificates/{certificate}/download', [App\Http\Controllers\CertificateController::class, 'download'])->name('certificates.download');
    Route::get('/certificates/verify/{code}', [App\Http\Controllers\CertificateController::class, 'verify'])->name('certificates.verify');
});

// Payment Receipt Routes
Route::middleware('auth')->group(function () {
    Route::get('/payments/{payment}/receipt', [App\Http\Controllers\PaymentController::class, 'receipt'])->name('payments.receipt');
    Route::get('/payments/{payment}/download', [App\Http\Controllers\PaymentController::class, 'downloadReceipt'])->name('payments.download');
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [App\Http\Controllers\Student\StudentController::class, 'courses'])->name('courses');
    Route::get('/courses/{id}', [App\Http\Controllers\Student\StudentController::class, 'courseDetail'])->name('courses.show');
    Route::get('/certificates', [App\Http\Controllers\Student\StudentController::class, 'certificates'])->name('certificates');
    Route::get('/payments', [App\Http\Controllers\Student\StudentController::class, 'payments'])->name('payments');
    Route::get('/classes', [App\Http\Controllers\Student\StudentController::class, 'classes'])->name('classes');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
