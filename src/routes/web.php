<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
});
Route::post('/store', [AttendanceController::class, 'store']);
Route::get('/attendance', [AttendanceController::class, 'attendance'])->name('date');
Route::get('/attendanceUser', [AttendanceController::class, 'attendanceUser'])->name('auth');
Route::get('/attendanceUser/search', [AttendanceController::class, 'searchUser']);