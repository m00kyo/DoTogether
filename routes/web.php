<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show_login'])->name('login');
    Route::get('/register', [AuthController::class, 'show_register'])->name('register');

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
    
    // UUID constraints added to {id} route parameters below
    Route::get('/activities/{id}', [ActivityController::class, 'details'])->name('activities.details')->whereUuid('id');
    Route::get('/activities/{id}/edit', [ActivityController::class, 'edit'])->name('activities.edit')->whereUuid('id');

    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::put('/activities/{id}', [ActivityController::class, 'update'])->name('activities.update')->whereUuid('id');
    Route::delete('/activities/{id}', [ActivityController::class, 'delete'])->name('activities.delete')->whereUuid('id');
});

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('profile.index');
        Route::get('/activities', 'activities')->name('profile.activities');
        Route::get('/participations', 'participations')->name('profile.participations');
        Route::get('/edit', 'edit')->name('profile.edit');
        Route::put('/edit', 'update')->name('profile.update');
    });
});

Route::middleware('auth')->group(function () {
    // Note: If activityId or userId are UUIDs, you can optionally chain ->whereUuid() here too
    Route::post('/activities/{activityId}/join', [ParticipationController::class, 'join'])->name('activities.join');
    Route::delete('/activities/{activityId}/remove/{userId}', [ParticipationController::class, 'remove'])->name('activities.remove');
    Route::delete('/activities/{activityId}/leave', [ParticipationController::class, 'leave'])->name('activities.leave');
    Route::post('/activities/{activityId}/report-user/{userId}', [ReportController::class, 'report_user'])->name('report.user');
});

Route::middleware('auth')->group(function () {
    Route::post('/activities/{activityId}/report', [ReportController::class, 'report_activity'])->name('report.activity');
    Route::post('/activities/{activityId}/report/{userId}', [ReportController::class, 'report_user'])->name('report.user');
    Route::get('/profile/user-reports', [ReportController::class, 'user_reports'])->name('profile.user_reports');
    Route::get('/profile/activity-reports', [ReportController::class, 'activity_reports'])->name('profile.activity_reports');

    Route::post('/report/activity/{id}/resolve', [ReportController::class, 'resolve_activity_report'])->name('report.activity.resolve')->whereUuid('id');
    Route::post('/report/activity/{id}/reject', [ReportController::class, 'reject_activity_report'])->name('report.activity.reject')->whereUuid('id');
    Route::post('/report/user/{id}/resolve', [ReportController::class, 'resolve_user_report'])->name('report.user.resolve')->whereUuid('id');
    Route::post('/report/user/{id}/reject', [ReportController::class, 'reject_user_report'])->name('report.user.reject')->whereUuid('id');
});