<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\RecruitmentController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get("/adminDashboard", [PagesController::class, 'dashboard'])->name('adminDashboard')->middleware(['auth', 'verified']);
Route::get("/home", [PagesController::class, 'home'])->name('home');
Route::patch('/employees/{id}/archive', [EmployeeController::class, 'archive'])->name('employees.archive');
Route::patch('/employees/{id}/restore', [EmployeeController::class, 'restore'])->name('employees.restore');
Route::patch('/certificates/{id}/archive', [CertificateController::class, 'archive'])->name('certificates.archive');
Route::patch('/certificates/{id}/restore', [CertificateController::class, 'restore'])->name('certificates.restore');
Route::patch('/certificates/{id}/archiveDeath', [CertificateController::class, 'archiveDeathCertificate'])->name('certificates.archiveDeathCertificate');
Route::patch('/certificates/{id}/restoreDeath', [CertificateController::class, 'restoreDeathCertificate'])->name('certificates.restoreDeathCertificate');
Route::get("/archives", [PagesController::class, 'archives']);
Route::get("/certArchives", [PagesController::class, 'certArchives']);

Route::resource('/employees', EmployeeController::class);
Route::resource('/certificates', CertificateController::class);
Route::resource('/recruitment', RecruitmentController::class);
Route::post('/recruitment/positions', [RecruitmentController::class, 'createPosition']);

// New recruitment routes
Route::get('/recruitment/jobs/listings', [RecruitmentController::class, 'jobListings'])->name('recruitment.job.listings');
Route::get('/recruitment/jobs/{id}', [RecruitmentController::class, 'showJob'])->name('recruitment.job.details');
Route::get('/recruitment/apply/{id}', [RecruitmentController::class, 'applicationForm'])->name('recruitment.application.form');
Route::post('/recruitment/apply/{id}', [RecruitmentController::class, 'submitApplication'])->name('recruitment.application.submit');
Route::get('/recruitment/success', [RecruitmentController::class, 'applicationSuccess'])->name('recruitment.application.success');
Route::get('/recruitment/application/submitted/{trackingCode}', [RecruitmentController::class, 'applicationSubmitted'])->name('recruitment.application.submitted');
Route::get('/recruitment/application/status', [RecruitmentController::class, 'trackApplication'])->name('recruitment.trackApplication');

// Application Tracking Routes
Route::get('/api/recruitment/track/{applicationCode}', [RecruitmentController::class, 'trackApplicationStatus']);

// Define routes for the navigation menu
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
Route::get('/departments', [PagesController::class, 'departments'])->name('departments');
Route::get('/settings', [PagesController::class, 'settings'])->name('settings');

Route::get('/recruitment/applications/{id}', [RecruitmentController::class, 'getApplication']);
Route::put('/recruitment/applications/{id}/status', [RecruitmentController::class, 'updateApplicationStatus']);

Route::get('/api/recruitment/hr-interviewers', [RecruitmentController::class, 'getHrInterviewers']);

Route::post('/recruitment/interviews', [RecruitmentController::class, 'scheduleInterview']);

Route::get('/recruitment/interviews/date/{date}', [\App\Http\Controllers\RecruitmentController::class, 'getInterviewsByDate']);