<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckAuthenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home')->middleware(CheckAuthenticate::class);
Route::post('upload-image', [ImageUploadController::class, 'uploadImage'])->name('upload.image')->middleware(CheckAuthenticate::class);
Route::get('about', [PageController::class, 'about'])->name('about');
Route::get('contact', [PageController::class, 'contact'])->name('contact');

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
Route::prefix('admin')->name('admin.')->middleware(CheckAdmin::class)->group(function () {
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
            Route::delete('{category}', [CategoryController::class, 'deleteCategory'])->name('delete');
            Route::get('{category}/edit', [AdminController::class, 'editCategory'])->name('edit');
            Route::put('{category}', [CategoryController::class, 'updateCategory'])->name('update');
        }
    );
    Route::prefix('posts')->name('posts.')->group(
        function () {
            Route::get('create', [AdminController::class, 'createPost'])->name('create');
            Route::post('store', [PostController::class, 'storePost'])->name('store');
            Route::get('/', [AdminController::class, 'showPosts'])->name('index');
            Route::get('{id}', [PostController::class, 'showPost'])->name('show');
            Route::delete('{post}', [PostController::class, 'deletePost'])->name('delete');
            Route::get('{post}/edit', [AdminController::class, 'editPost'])->name('edit');
            Route::put('{post}', [PostController::class, 'updatePost'])->name('update');
        }
    );
});
Route::prefix('comments')->name('comments.')->middleware(CheckAuthenticate::class)->group(function () {
    Route::post('/submit', [CommentController::class, 'store'])->name('submit');
    Route::post('/reply', [CommentController::class, 'reply'])->name('reply');
    Route::post('/reaction', [PostController::class, 'handleReaction'])->name('reaction');
});
Route::prefix('profile')->name('profile.')->middleware(CheckAuthenticate::class)->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('show');
    Route::put('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('photo.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});
Route::prefix('posts')->name('posts.')->middleware(CheckAuthenticate::class)->group(function () {
    Route::get('/{id}', [PostController::class, 'show'])->name('show');
    Route::get('', [PostController::class, 'index'])->name('index');
    Route::get('/category/{category_id}', [PostController::class, 'postsByCategory'])->name('category');
});
Route::prefix('categories')->name('categories.')->middleware(CheckAuthenticate::class)->group(function () {
    Route::get('', [CategoryController::class, 'index'])->name('index');
    Route::get('subcategories/{parent_id}', [CategoryController::class, 'subcategories'])->name('subcategories');
});
