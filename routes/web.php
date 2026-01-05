<?php

use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\WalletManagementController;
use App\Http\Controllers\Instructor\SubscriptionController;
use App\Http\Controllers\Instructor\WalletController as InstructorWalletController;
use App\Http\Controllers\Student\WalletController as StudentWalletController;
use App\Http\Controllers\Instructor\InstructorEnquiryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Admin\ProfessionalTeacherController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Instructor\InstructorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [HomeController::class, 'courses'])->name('courses.index');
Route::get('/courses/{id}', [HomeController::class, 'courseDetail'])->name('courses.show');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Working Authentication Routes (replace problematic Livewire routes)
Route::get('/login', [App\Http\Controllers\Auth\CustomLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\CustomLoginController::class, 'login']);
Route::get('/register', [App\Http\Controllers\Auth\CustomRegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\CustomRegisterController::class, 'register']);

// Test routes for debugging
Route::get('/test-login', [App\Http\Controllers\Auth\CustomLoginController::class, 'showLoginForm'])->name('custom.login.form');
Route::post('/test-login', [App\Http\Controllers\Auth\CustomLoginController::class, 'login'])->name('custom.login');
Route::get('/test-register', [App\Http\Controllers\Auth\CustomRegisterController::class, 'showRegistrationForm'])->name('custom.register.form');
Route::post('/test-register', [App\Http\Controllers\Auth\CustomRegisterController::class, 'register'])->name('custom.register');

// Custom logout route
Route::post('/logout', [App\Http\Controllers\Auth\CustomLogoutController::class, 'logout'])->name('custom.logout');

// Role-based dashboard routing  
Route::get('/dashboard', function () {
    $user = Auth::user();
    
    \Log::info('Dashboard route accessed', [
        'user_id' => $user->id,
        'email' => $user->email,
        'roles' => $user->getRoleNames(),
    ]);
    
    if ($user->isSuperAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isInstructor()) {
        return redirect()->route('instructor.dashboard');
    } elseif ($user->isStudent()) {
        return redirect()->route('student.dashboard');
    }
    
    \Log::warning('Dashboard: No matching role found', [
        'user_id' => $user->id,
        'email' => $user->email,
        'roles' => $user->getRoleNames(),
    ]);
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// Super Admin Routes
Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\SuperAdmin\SuperAdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', [App\Http\Controllers\SuperAdmin\SuperAdminDashboardController::class, 'settings'])->name('settings');
    Route::get('/logs', [App\Http\Controllers\SuperAdmin\SuperAdminDashboardController::class, 'logs'])->name('logs');
    
    // Temporary redirect routes for system management (controllers to be implemented)
    Route::get('/users', function () { return redirect()->route('superadmin.dashboard'); });
    Route::get('/roles', function () { return redirect()->route('superadmin.dashboard'); });
    Route::get('/permissions', function () { return redirect()->route('superadmin.dashboard'); });
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    // Backwards-compatibility: redirect legacy teachers index to instructors index
    Route::get('/teachers', function () {
        return redirect()->route('admin.instructors.index');
    })->name('teachers.redirect');
    Route::resource('teachers', AdminTeacherController::class);
    // Also expose the same teacher management under 'instructors' URI and route names
    // Keep route-model binding working by mapping the resource parameter to 'teacher'
    Route::resource('instructors', AdminTeacherController::class)->parameters([
        'instructors' => 'teacher'
    ]);
    Route::resource('professional-teachers', ProfessionalTeacherController::class);
    Route::resource('students', StudentController::class);
    Route::resource('courses', AdminCourseController::class);
    
    // Course Approval Routes (for new course creation module)
    Route::prefix('course-approvals')->name('course-approvals.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminCourseApprovalController::class, 'index'])->name('index');
        Route::get('/{course}', [App\Http\Controllers\Admin\AdminCourseApprovalController::class, 'show'])->name('show');
        Route::post('/{course}/approve', [App\Http\Controllers\Admin\AdminCourseApprovalController::class, 'approve'])->name('approve');
        Route::post('/{course}/reject', [App\Http\Controllers\Admin\AdminCourseApprovalController::class, 'reject'])->name('reject');
        Route::post('/{course}/request-changes', [App\Http\Controllers\Admin\AdminCourseApprovalController::class, 'requestChanges'])->name('request-changes');
    });
    
    Route::resource('offers', \App\Http\Controllers\Admin\OfferController::class);
    Route::resource('payments', AdminPaymentController::class);
    Route::resource('certificates', AdminCertificateController::class);
    Route::resource('online-classes', App\Http\Controllers\Admin\OnlineClassController::class);
    
    // Reports and Settings Routes
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports.index');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    // Subscription Management Routes
    Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
        // Plans Management
        Route::get('/plans', [SubscriptionPlanController::class, 'plansIndex'])->name('plans.index');
        Route::get('/plans/create', [SubscriptionPlanController::class, 'plansCreate'])->name('plans.create');
        Route::post('/plans', [SubscriptionPlanController::class, 'plansStore'])->name('plans.store');
        Route::get('/plans/{plan}/edit', [SubscriptionPlanController::class, 'plansEdit'])->name('plans.edit');
        Route::put('/plans/{plan}', [SubscriptionPlanController::class, 'plansUpdate'])->name('plans.update');
        Route::delete('/plans/{plan}', [SubscriptionPlanController::class, 'plansDestroy'])->name('plans.destroy');

        // Enquiries Management
        Route::get('/enquiries', [SubscriptionPlanController::class, 'enquiriesIndex'])->name('enquiries.index');
        Route::get('/enquiries/{enquiry}', [SubscriptionPlanController::class, 'enquiriesShow'])->name('enquiries.show');
        Route::post('/enquiries/{enquiry}/approve', [SubscriptionPlanController::class, 'enquiriesApprove'])->name('enquiries.approve');
        Route::post('/enquiries/{enquiry}/reject', [SubscriptionPlanController::class, 'enquiriesReject'])->name('enquiries.reject');

        // Subscriptions Management
        Route::get('/list', [SubscriptionPlanController::class, 'subscriptionsIndex'])->name('list');
        Route::get('/{subscription}', [SubscriptionPlanController::class, 'subscriptionsShow'])->name('show');

        // History Management
        Route::get('/history/all', [SubscriptionPlanController::class, 'historyIndex'])->name('history.index');
    });

    // Wallet Management Routes
    Route::prefix('wallet')->name('wallet.')->group(function () {
        Route::get('/', [WalletManagementController::class, 'index'])->name('index');
        Route::get('/withdraw-requests', [WalletManagementController::class, 'withdrawRequests'])->name('withdraw-requests');
        Route::get('/withdraw-requests/{withdrawRequest}', [WalletManagementController::class, 'showWithdrawRequest'])->name('withdraw-requests.show');
        Route::post('/withdraw-requests/{withdrawRequest}/approve', [WalletManagementController::class, 'approveWithdraw'])->name('withdraw-requests.approve');
        Route::post('/withdraw-requests/{withdrawRequest}/mark-paid', [WalletManagementController::class, 'markWithdrawPaid'])->name('withdraw-requests.mark-paid');
        Route::post('/withdraw-requests/{withdrawRequest}/reject', [WalletManagementController::class, 'rejectWithdraw'])->name('withdraw-requests.reject');
        Route::get('/settings', [WalletManagementController::class, 'settings'])->name('settings');
        Route::post('/settings', [WalletManagementController::class, 'updateSettings'])->name('settings.update');
        Route::get('/all-wallets', [WalletManagementController::class, 'allWallets'])->name('all-wallets');
        Route::get('/user/{userId}', [WalletManagementController::class, 'userWallet'])->name('user-wallet');
        Route::post('/user/{userId}/adjust', [WalletManagementController::class, 'manualAdjustment'])->name('user-wallet.adjust');
    });

    // ════════════════════════════════════════════════════════════════════════════
    // Admin Sub-Accounts, Roles & Permissions Management
    // ════════════════════════════════════════════════════════════════════════════
    
    // Unified Access Control Management (Roles & Permissions)
    Route::get('access-control', [App\Http\Controllers\Admin\AccessControlController::class, 'index'])->name('access-control.index');
    
    // Admin Roles Management
    Route::resource('roles', App\Http\Controllers\Admin\AdminRoleController::class);
    
    // Admin Permissions Management
    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminPermissionController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\AdminPermissionController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\AdminPermissionController::class, 'store'])->name('store');
        Route::get('/assign', [App\Http\Controllers\Admin\AdminPermissionController::class, 'assign'])->name('assign');
        Route::post('/assign', [App\Http\Controllers\Admin\AdminPermissionController::class, 'assignStore'])->name('assign-store');
        Route::put('/{permission}', [App\Http\Controllers\Admin\AdminPermissionController::class, 'update'])->name('update');
        Route::delete('/{permission}', [App\Http\Controllers\Admin\AdminPermissionController::class, 'destroy'])->name('destroy');
    });
    
    // Admin Accounts Management
    Route::resource('accounts', App\Http\Controllers\Admin\AdminAccountController::class);
    Route::post('/accounts/{account}/toggle-status', [App\Http\Controllers\Admin\AdminAccountController::class, 'toggleStatus'])->name('accounts.toggle-status');
    
    // Course Categories Management
    Route::resource('course-categories', App\Http\Controllers\Admin\CourseCategoryController::class);
    Route::post('/course-categories/{courseCategory}/toggle-status', [App\Http\Controllers\Admin\CourseCategoryController::class, 'toggleStatus'])->name('course-categories.toggle-status');
});

// Professor Routes - DEPRECATED (Use instructor routes instead)
// Route::middleware(['auth', 'professor'])->prefix('professor')->name('professor.')->group(function () {
//     Route::get('/dashboard', [App\Http\Controllers\Professor\ProfessorDashboardController::class, 'index'])->name('dashboard');
//     Route::get('/courses', [App\Http\Controllers\Professor\ProfessorDashboardController::class, 'courses'])->name('courses');
//     Route::get('/students', [App\Http\Controllers\Professor\ProfessorDashboardController::class, 'students'])->name('students');
// });

// Student Routes
Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses', [App\Http\Controllers\Student\StudentDashboardController::class, 'courses'])->name('courses');
    Route::get('/courses/{course}/progress', [App\Http\Controllers\Student\StudentDashboardController::class, 'progress'])->name('progress');
    Route::get('/explore', [App\Http\Controllers\Student\StudentDashboardController::class, 'explore'])->name('explore');
});

// Instructor Routes (Existing - keeping for backward compatibility)
Route::middleware(['auth', 'instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', [InstructorController::class, 'dashboard'])->name('dashboard');
    Route::put('/profile', [InstructorController::class, 'updateProfile'])->name('profile.update');
    
    // New Course Creation Module Routes
    // Redirect /courses/create to /courses/create/basics
    Route::get('/courses/create', function () {
        return redirect()->route('instructor.courses.create.basics');
    });
    
    Route::prefix('courses/create')->name('courses.create.')->group(function () {
        Route::get('/basics', [App\Http\Controllers\Instructor\InstructorCourseController::class, 'createBasics'])->name('basics');
        Route::post('/basics', [App\Http\Controllers\Instructor\InstructorCourseController::class, 'storeBasics'])->name('store-basics');
        Route::get('/media', [App\Http\Controllers\Instructor\InstructorCourseController::class, 'createMedia'])->name('media');
        Route::post('/media', [App\Http\Controllers\Instructor\InstructorCourseController::class, 'storeMedia'])->name('store-media');
        Route::get('/curriculum', [App\Http\Controllers\Instructor\InstructorCourseController::class, 'createCurriculum'])->name('curriculum');
        Route::get('/pricing', [App\Http\Controllers\Instructor\InstructorCourseController::class, 'createPricing'])->name('pricing');
        Route::post('/pricing', [App\Http\Controllers\Instructor\InstructorCourseController::class, 'storePricing'])->name('store-pricing');
    });
    
    // Course Section and Lecture Management (API routes for AJAX)
    Route::post('/sections', [App\Http\Controllers\Instructor\CourseSectionController::class, 'store']);
    Route::put('/sections/{section}', [App\Http\Controllers\Instructor\CourseSectionController::class, 'update']);
    Route::delete('/sections/{section}', [App\Http\Controllers\Instructor\CourseSectionController::class, 'destroy']);
    Route::post('/sections/reorder', [App\Http\Controllers\Instructor\CourseSectionController::class, 'reorder']);
    
    Route::post('/lectures', [App\Http\Controllers\Instructor\CourseLectureController::class, 'store']);
    Route::put('/lectures/{lecture}', [App\Http\Controllers\Instructor\CourseLectureController::class, 'update']);
    Route::delete('/lectures/{lecture}', [App\Http\Controllers\Instructor\CourseLectureController::class, 'destroy']);
    
    // Course Management
    Route::get('/courses', [App\Http\Controllers\Instructor\InstructorCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [App\Http\Controllers\Instructor\InstructorCourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/edit', [App\Http\Controllers\Instructor\InstructorCourseController::class, 'edit'])->name('courses.edit');
    Route::get('/courses/{course}/curriculum', [App\Http\Controllers\Instructor\InstructorCourseController::class, 'editCurriculum'])->name('courses.curriculum.edit');
    Route::put('/courses/{course}', [App\Http\Controllers\Instructor\InstructorCourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [App\Http\Controllers\Instructor\InstructorCourseController::class, 'destroy'])->name('courses.destroy');
    
    // Resourceful routes for instructor-managed courses (create/store/edit/update/destroy)
    // Note: Using explicit routes instead of resource() to avoid conflicts
    // Route::resource('courses', App\Http\Controllers\Instructor\CourseController::class)->except(['index']);
    Route::get('/students', [InstructorController::class, 'students'])->name('students.index');
    Route::get('/classes', [InstructorController::class, 'classes'])->name('classes.index');

    // Live Classes Routes
    Route::prefix('live-classes')->name('live-classes.')->group(function () {
        Route::get('/', [App\Http\Controllers\Instructor\LiveClassController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Instructor\LiveClassController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Instructor\LiveClassController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\Instructor\LiveClassController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\Instructor\LiveClassController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\Instructor\LiveClassController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Instructor\LiveClassController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/reschedule', [App\Http\Controllers\Instructor\LiveClassController::class, 'reschedule'])->name('reschedule');
        Route::put('/{id}/reschedule', [App\Http\Controllers\Instructor\LiveClassController::class, 'updateReschedule'])->name('update-reschedule');
        Route::get('/{id}/share-invite', [App\Http\Controllers\Instructor\LiveClassController::class, 'shareInvite'])->name('share-invite');
        Route::get('/{id}/attendance', [App\Http\Controllers\Instructor\LiveClassController::class, 'attendance'])->name('attendance');
        Route::get('/join/{id}', [App\Http\Controllers\Instructor\LiveClassController::class, 'join'])->name('join');
        Route::post('/end/{id}', [App\Http\Controllers\Instructor\LiveClassController::class, 'end'])->name('end');
        Route::post('/cancel/{id}', [App\Http\Controllers\Instructor\LiveClassController::class, 'cancel'])->name('cancel');
    });

    // Wallet Routes
    Route::prefix('wallet')->name('wallet.')->group(function () {
        Route::get('/', [InstructorWalletController::class, 'index'])->name('index');
        Route::get('/withdraw', [InstructorWalletController::class, 'withdrawForm'])->name('withdraw');
        Route::post('/withdraw-request', [InstructorWalletController::class, 'createWithdrawRequest'])->name('withdraw-request');
        Route::get('/withdraw-request/{withdrawRequest}', [InstructorWalletController::class, 'showWithdrawRequest'])->name('withdraw-request.show');
        Route::get('/transaction/{transactionId}', [InstructorWalletController::class, 'transactionDetails'])->name('transaction-details');
    });

    // Subscription Routes
    Route::get('/subscription', [SubscriptionController::class, 'show'])->name('subscription.show');
    Route::get('/subscription/management', [SubscriptionController::class, 'management'])->name('subscription.management');
    Route::get('/subscription/upgrade', [SubscriptionController::class, 'upgrade'])->name('subscription.upgrade');
    Route::post('/subscription/upgrade', [SubscriptionController::class, 'processUpgrade'])->name('subscription.process-upgrade');
    Route::get('/subscription/payment/{plan}', [SubscriptionController::class, 'paymentPage'])->name('subscription.payment');
    Route::post('/subscription/payment/{plan}', [SubscriptionController::class, 'processPayment'])->name('subscription.payment-process');
    Route::get('/subscription/payment/{plan}/pending', [SubscriptionController::class, 'paymentPending'])->name('subscription.payment-pending');
    Route::get('/subscription/payment/{plan}/success', [SubscriptionController::class, 'paymentSuccess'])->name('subscription.payment-success');
    Route::get('/subscription/payment/{plan}/failed', [SubscriptionController::class, 'paymentFailed'])->name('subscription.payment-failed');
    Route::get('/subscription/renew', [SubscriptionController::class, 'renew'])->name('subscription.renew');
    Route::post('/subscription/renew', [SubscriptionController::class, 'processRenew'])->name('subscription.process-renew');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::get('/subscription/certificate', [SubscriptionController::class, 'downloadCertificate'])->name('subscription.certificate');
    
    // Course Sections & Lectures API Routes
    Route::post('/sections', [App\Http\Controllers\Instructor\CourseSectionController::class, 'store'])->name('sections.store');
    Route::put('/sections/{section}', [App\Http\Controllers\Instructor\CourseSectionController::class, 'update'])->name('sections.update');
    Route::delete('/sections/{section}', [App\Http\Controllers\Instructor\CourseSectionController::class, 'destroy'])->name('sections.destroy');
    Route::post('/sections/reorder', [App\Http\Controllers\Instructor\CourseSectionController::class, 'reorder'])->name('sections.reorder');
    
    Route::post('/lectures', [App\Http\Controllers\Instructor\CourseLectureController::class, 'store'])->name('lectures.store');
    Route::get('/lectures/{lecture}', [App\Http\Controllers\Instructor\CourseLectureController::class, 'show'])->name('lectures.show');
    Route::put('/lectures/{lecture}', [App\Http\Controllers\Instructor\CourseLectureController::class, 'update'])->name('lectures.update');
    Route::delete('/lectures/{lecture}', [App\Http\Controllers\Instructor\CourseLectureController::class, 'destroy'])->name('lectures.destroy');
    Route::post('/lectures/reorder', [App\Http\Controllers\Instructor\CourseLectureController::class, 'reorder'])->name('lectures.reorder');
    
    // Simple Course Creation (Category-based)
    // Commented out to avoid route conflicts - using explicit routes above instead
    // Route::resource('courses', App\Http\Controllers\Instructor\CourseController::class)->except(['index', 'show']);
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

    // Teacher Enquiry Routes (Public registration)
    Route::get('/teacher/register', [InstructorEnquiryController::class, 'create'])->name('teacher.enquiry.create');
    Route::post('/teacher/register', [InstructorEnquiryController::class, 'store'])->name('teacher.enquiry.store');
    Route::get('/teacher/enquiry-status', [InstructorEnquiryController::class, 'status'])->name('teacher.enquiry.status');
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
    Route::put('/profile', [App\Http\Controllers\Student\StudentController::class, 'updateProfile'])->name('profile.update');
    Route::get('/courses', [App\Http\Controllers\Student\StudentController::class, 'courses'])->name('courses.index');
    Route::get('/my-courses', [App\Http\Controllers\Student\StudentController::class, 'courses'])->name('courses');
    Route::get('/browse-courses', [App\Http\Controllers\Student\StudentController::class, 'browseCourses'])->name('courses.browse');
    Route::get('/course/{id}/preview', [App\Http\Controllers\Student\StudentController::class, 'coursePreview'])->name('courses.preview');
    Route::get('/courses/{id}', [App\Http\Controllers\Student\StudentController::class, 'courseDetail'])->name('courses.show');
    Route::get('/lectures/{lecture}', [App\Http\Controllers\Student\StudentController::class, 'watchLecture'])->name('lectures.watch');
    Route::post('/courses/{id}/review', [App\Http\Controllers\Student\StudentController::class, 'storeReview'])->name('courses.review.store');
    Route::get('/enrollments', [App\Http\Controllers\Student\StudentController::class, 'enrollments'])->name('enrollments.index');
    Route::get('/certificates', [App\Http\Controllers\Student\StudentController::class, 'certificates'])->name('certificates.index');
    Route::get('/payments', [App\Http\Controllers\Student\StudentController::class, 'payments'])->name('payments');
    Route::get('/classes', [App\Http\Controllers\Student\StudentController::class, 'classes'])->name('classes');

    // Live Classes Routes
    Route::prefix('live-classes')->name('live-classes.')->group(function () {
        Route::get('/', [App\Http\Controllers\Student\LiveClassController::class, 'index'])->name('index');
        Route::get('/join/{id}', [App\Http\Controllers\Student\LiveClassController::class, 'join'])->name('join');
    });

    // Wallet Routes
    Route::prefix('wallet')->name('wallet.')->group(function () {
        Route::get('/', [StudentWalletController::class, 'index'])->name('index');
        Route::get('/topup', [StudentWalletController::class, 'topupForm'])->name('topup');
        Route::post('/topup', [StudentWalletController::class, 'initiateTopup'])->name('topup.initiate');
        Route::get('/topup/{topupId}/success', [StudentWalletController::class, 'handleTopupSuccess'])->name('topup.success');
        Route::post('/webhook', [StudentWalletController::class, 'webhook'])->name('topup.webhook');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
