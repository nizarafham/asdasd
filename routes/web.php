<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Mentor\MentorController;
use App\Http\Controllers\Mentor\MyCourseController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//admin routes
Route::middleware(['auth', 'adminMiddleware'])->group(function(){

    Route::get('/admin/dashboard',[AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/courses/pending', [AdminCourseController::class, 'pending'])->name('admin.courses.pending');
    Route::post('/admin/courses/{course}/approve', [AdminCourseController::class, 'approve'])->name('admin.courses.approve');
    Route::post('/admin/courses/{course}/reject', [AdminCourseController::class, 'reject'])->name('admin.courses.reject');

});

//user routes
Route::middleware(['auth', 'userMiddleware', 'cors'])->group(function(){

    Route::get('courses/{id}', [CourseController::class, 'show'])->name('courses.show');
    Route::post('/transaction/create/{id}', [TransactionController::class, 'createTransaction'])->name('transaction.create');
    Route::get('/coursetry', function () {
        return view('course/course');
    });

});

//mentor routes
Route::middleware(['auth', 'mentorMiddleware'])->group(function () {
    Route::get('/mentor/dashboard', [MentorController::class, 'dashboard'])->name('mentor.dashboard');
    Route::get('/mentor/students/{class}', [MentorController::class, 'students'])->name('mentor.students');
    Route::resource('mycourses', MyCourseController::class)->names('mentor.mycourse');
});

Route::get('/dashboard',[UserController::class, 'index'])->name('dashboard');
Route::get('/courses',[CourseController::class, 'index'])->name('courses');


// root payment
Route::get('/payment', function () {
    return view('payment/payment');
});

// root course


Route::options('{any}', function () {
    return response()->json('OK', 200);
})->where('any', '.*');