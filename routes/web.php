<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\RecruitmentController;

// Route::get('/', function () {
//     return view('dashboard');
// });
Route::get("/", [PagesController::class, 'dashboard']);
Route::patch('/employees/{id}/archive', [EmployeeController::class, 'archive'])->name('employees.archive');
Route::patch('/employees/{id}/restore', [EmployeeController::class, 'restore'])->name('employees.restore');
Route::patch('/certificates/{id}/archive', [CertificateController::class, 'archive'])->name('certificates.archive');
Route::patch('/certificates/{id}/restore', [CertificateController::class, 'restore'])->name('certificates.restore');
Route::patch('/certificates/{id}/archiveDeath', [CertificateController::class, 'archiveDeathCertificate'])->name('certificates.archiveDeathCertificate');
Route::patch('/certificates/{id}/restoreDeath', [CertificateController::class, 'restoreDeathCertificate'])->name('certificates.restoreDeathCertificate');
Route::get("/archives", [PagesController::class, 'archives']);
Route::get("/certArchives", [PagesController::class, 'certArchives']);

Route::resource('/admin', EmployeeController::class);
Route::resource('/certificates', CertificateController::class);
Route::resource('/recruitment', RecruitmentController::class);
