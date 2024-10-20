<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth')->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
});
Route::post('/store', [AttendanceController::class, 'store']);

// ログインページの表示
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// ログイン処理
Route::post('/login', [AuthController::class, 'login']);

// 登録ページの表示
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
// 登録処理
Route::post('/register', [AuthController::class, 'register']);

Route::get('/attendance', [AttendanceController::class, 'attendance'])->name('date');
Route::get('/attendanceUser', [AttendanceController::class, 'attendanceUser'])->name('auth');
Route::get('/attendanceUser/search', [AttendanceController::class, 'searchUser']);