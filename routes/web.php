<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('login', [UserController::class, 'showLoginForm'])->name('login.form')->middleware(RedirectIfAuthenticated::class);
Route::post('login', [UserController::class, 'login'])->name('login');
Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::get('register', [UserController::class, 'showRegistrationForm'])->name('register.form');
Route::post('register/store', [UserController::class, 'register'])->name('register.store');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/')->with('successMessage', 'Your account is verified successfully.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('admin',[AdminController::class,'index'])->name('admin.dashboard');
Route::get('admin',[AdminController::class,'index3'])->name('admin.dashboard');
