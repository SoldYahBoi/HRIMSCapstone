<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PagesController;

// Route::get('/', function () {
//     return view('dashboard');
// });
Route::get("/", [PagesController::class, 'dashboard']);
Route::patch('/employees/{id}/archive', [EmployeeController::class, 'archive'])->name('employees.archive');
Route::patch('/employees/{id}/restore', [EmployeeController::class, 'restore'])->name('employees.restore');
Route::get("/archives", [PagesController::class, 'archives']);

Route::resource('/admin', EmployeeController::class);
