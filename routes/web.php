<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [LoginController::class, 'get_home'])->name('get-home');
Route::get('/register', [LoginController::class, 'get_register'])->name('get-register');
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::get('/login', [LoginController::class, 'get_login'])->name('get-login');
Route::post('/login', [LoginController::class, 'login']);


Route::middleware('cust-auth', 'is-member')->group(function() {
    Route::post('/logout', [LogoutController:: class, 'logout'])->name('logout');
    Route::get('/dashboard/borrowed_books',[AuthController::class, 'get_borrowed_books'])->name('get-borrowed-books');

    Route::middleware('is-assistant')->group(function() {
        Route::get('/dashboard/inventory', [AuthController::class, 'get_dashboard'])->name('dashboard-inventory');
        Route::put('/dashboard/inventory/{id}', [AuthController::class, 'update_dashboard'])->name('update-inventory');
        Route::get('/dashboard/borrow_request', [AuthController::class, 'get_borrow_request'])->name('get-borrow-request');

        Route::middleware('is-admin')->group(function() {
            Route::get('/dashboard/books', [BookController:: class, 'get_books'])->name('get-books');
            Route::delete('/dashboard/books/{id}', [BookController:: class, 'delete_books'])->name('delete-books');
            Route::put('/dashboard/books/{id}', [BookController:: class, 'edit_books'])->name('edit-books');
            Route::post('/dashboard/books', [BookController:: class, 'add_books'])->name('add-books');
            Route::get('/dashboard/users', [UserController::class, 'get_users'])->name('get-users');
            Route::delete('/dashboard/users/{id}', [UserController::class, 'delete_user'])->name('delete-users');
            Route::put('/dashboard/users/{id}', [UserController::class, 'update_user'])->name('update-users');
        });
    });
});


