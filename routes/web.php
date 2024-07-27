<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
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
//Admin panel
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'showUsers'])->name('index');
        Route::get('create', [AdminController::class, 'createUser'])->name('create');
        Route::post('store', [UserController::class, 'storeUser'])->name('store');
        Route::delete('{user}', [UserController::class, 'deleteUser'])->name('delete');
        Route::put('{user}', [UserController::class, 'updateUser'])->name('update');
        Route::get('{user}/edit', [AdminController::class, 'editUser'])->name('edit');
    });
    Route::prefix('categories')->name('categories.')->group(
        function () {
            Route::get('/', [AdminController::class, 'showCategories'])->name('index');
            Route::get('create', [AdminController::class, 'createCategory'])->name('create');
            Route::post('store', [CategoryController::class, 'storeCategory'])->name('store');

        }
    );
});
