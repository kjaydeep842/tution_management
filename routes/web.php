<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TuitionClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [InquiryController::class, 'home'])->name('home');

// Redirect /admin to dashboard
Route::get('/admin', function () {
    return redirect()->route('dashboard');
});

// Public Inquiry Routes
Route::get('/inquiry', [InquiryController::class, 'create'])->name('inquiry.create');
Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Inquiry Management
    Route::get('/admin/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::patch('/admin/inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.update-status');

    // Branch & Teacher Management
    Route::resource('branches', BranchController::class);
    Route::resource('teachers', TeacherController::class);

    // Student Management
    Route::resource('students', StudentController::class);

    // Parent Management
    Route::resource('parents', \App\Http\Controllers\Admin\ParentManagementController::class)->names('admin.parents');

    // Tuition Class Management
    Route::resource('tuition-classes', TuitionClassController::class);

    // Fees & Payments
    Route::resource('fees', FeeController::class);
    Route::get('/payments/create/{fee}', [PaymentController::class, 'create'])->name('payments.create-for-fee');
    Route::resource('payments', PaymentController::class);
    Route::get('/payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');

    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');


    // Academic
    Route::resource('assignments', AssignmentController::class);
    Route::resource('exams', ExamController::class);
    Route::get('/exams/{exam}/marks', [ExamController::class, 'marks'])->name('exams.marks');
    Route::post('/exams/{exam}/marks', [ExamController::class, 'storeMarks'])->name('exams.store-marks');

    // Site Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Create Parent Account for a student
    Route::post('/students/{student}/create-parent', [StudentController::class, 'createParentAccount'])->name('students.create-parent');

    // Performance Reports
    Route::get('/performance-reports', [App\Http\Controllers\PerformanceReportController::class, 'index'])->name('performance-reports.index');
    Route::get('/performance-reports/{student}/create', [App\Http\Controllers\PerformanceReportController::class, 'create'])->name('performance-reports.create');
    Route::post('/performance-reports/{student}', [App\Http\Controllers\PerformanceReportController::class, 'store'])->name('performance-reports.store');
    Route::get('/performance-reports/{report}/download', [App\Http\Controllers\PerformanceReportController::class, 'download'])->name('performance-reports.download');

    // Payment Verification
    Route::get('/payment-requests', [\App\Http\Controllers\Admin\PaymentRequestController::class, 'index'])->name('payment-requests.index');
    Route::post('/payment-requests/{paymentRequest}/approve', [\App\Http\Controllers\Admin\PaymentRequestController::class, 'approve'])->name('payment-requests.approve');
    Route::post('/payment-requests/{paymentRequest}/reject', [\App\Http\Controllers\Admin\PaymentRequestController::class, 'reject'])->name('payment-requests.reject');
});

// Parent Portal (separate middleware group)
Route::middleware(['auth', 'verified', 'parent.portal'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\ParentController::class, 'dashboard'])->name('dashboard');
    Route::get('/attendance', [\App\Http\Controllers\ParentController::class, 'attendance'])->name('attendance');
    Route::get('/fees', [\App\Http\Controllers\ParentController::class, 'fees'])->name('fees');
    Route::get('/performance', [\App\Http\Controllers\ParentController::class, 'performance'])->name('performance');
    Route::get('/performance/{report}/download', [App\Http\Controllers\PerformanceReportController::class, 'download'])->name('performance.download');
    // Exam Marks
    Route::get('/exam-marks', [\App\Http\Controllers\ParentController::class, 'examMarks'])->name('exams');

    // Past Records
    Route::get('/past-records', [\App\Http\Controllers\ParentController::class, 'pastRecords'])->name('past-records');

    // Weak Subject Guidance
    Route::prefix('guidance')->group(function () {
        Route::get('/', [\App\Http\Controllers\Parent\GuidanceController::class, 'index'])->name('guidance.index');
        Route::get('/create', [\App\Http\Controllers\Parent\GuidanceController::class, 'create'])->name('guidance.create');
        Route::post('/', [\App\Http\Controllers\Parent\GuidanceController::class, 'store'])->name('guidance.store');
    });

    // Fee Payment Notifications
    Route::get('/fees/{fee}/notify', [\App\Http\Controllers\ParentController::class, 'showPaymentRequestForm'])->name('fees.notify');
    Route::post('/fees/{fee}/notify', [\App\Http\Controllers\ParentController::class, 'storePaymentRequest'])->name('fees.store-notify');
    Route::get('/profile', [\App\Http\Controllers\ParentController::class, 'profile'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\ParentController::class, 'updateProfile'])->name('profile.update');
});

// Admin Guidance Routes (Assuming admin routes are prefixed or grouped)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::prefix('guidance')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\GuidanceController::class, 'index'])->name('admin.guidance.index');
        Route::get('/{guidance}', [\App\Http\Controllers\Admin\GuidanceController::class, 'show'])->name('admin.guidance.show');
        Route::patch('/{guidance}', [\App\Http\Controllers\Admin\GuidanceController::class, 'respond'])->name('admin.guidance.respond');
    });
});


require __DIR__ . '/auth.php';
