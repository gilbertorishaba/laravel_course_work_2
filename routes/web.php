<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisteredController;
use App\Http\Controllers\SearchController;


//default route
    Route::get('/', function () {
        return view('welcome');
    });

//dashboard routes
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/{courseId}', [DashboardController::class, 'index'])->name('dashboard.withCourse');
});


//student routes
    Route::get('/student/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/store-student',[StudentController::class,'store'])->name('students.store');
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');


// course routes
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses-create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{id}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');


//Report Controllers
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}/edit', [ReportController::class, 'edit'])->name('reports.edit');
    Route::put('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');


//routes accessed by the
    Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}/edit', [ReportController::class, 'edit'])->name('reports.edit');
    Route::put('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');

});

    Route::middleware(['auth', 'verified'])->get('/logout-sessions', function ()
    {return view('auth.logout-other-browser-sessions');
    })->name('logout-sessions');

//admin routes for course enrollment
    Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/show/{course}', [EnrollmentController::class, 'show'])->name('admin.show');
    Route::get('/admin/enroll', [EnrollmentController::class, 'showEnrollmentForm'])->name('admin.enroll');
    Route::post('/admin/enroll', [EnrollmentController::class, 'store'])->name('admin.store');


});

    Route::middleware(['auth', 'admin'])->get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/welcome', [HomeController::class, 'index'])->name('welcome');

//setting routes
    Route::middleware('auth')->get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::middleware('auth')->post('/settings', [SettingsController::class, 'update'])->name('settings.update');

//logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//registered students
    Route::get('/dashboard', [RegisteredController::class, 'index']);


//search
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/dashboard', [RegisteredController::class, 'index'])->name('dashboard');





















