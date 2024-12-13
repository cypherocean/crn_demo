<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubdomainController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('signin', [AuthController::class, 'signIn'])->name('signin');


Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /** access control */
    /** role */
    Route::controller(RoleController::class)
        ->prefix('/roles')
        ->group(function () {
            Route::any('/', 'index')->name('roles');
            Route::get('/create', 'create')->name('roles.create');
            Route::post('/insert', 'insert')->name('roles.insert');
            Route::get('/view/{id}', 'view')->name('roles.view');
            Route::get('/edit/{id}', 'edit')->name('roles.edit');
            Route::patch('/update', 'update')->name('roles.update');
            Route::post('/delete', 'delete')->name('roles.delete');
        });
    /** role */

    /** permission */
    Route::controller(PermissionController::class)
        ->prefix('/permission')
        ->group(function () {
            Route::any('/', 'index')->name('permission');
            Route::get('/create', 'create')->name('permission.create');
            Route::post('/insert', 'insert')->name('permission.insert');
            Route::get('/view/{id}', 'view')->name('permission.view');
            Route::get('/edit/{id}', 'edit')->name('permission.edit');
            Route::patch('/update', 'update')->name('permission.update');
            Route::post('/delete', 'delete')->name('permission.delete');
        });
    /** permission */
    /** access control */

    // Users CRUD routes
    Route::controller(UserController::class)
        ->prefix('/users')
        ->group(function () {
            Route::any('/', 'index')->name('users');
            Route::get('/create', 'create')->name('users.create');
            Route::post('/insert', 'insert')->name('users.insert');
            Route::get('/view/{id}', 'view')->name('users.view');
            Route::get('/edit/{id}', 'edit')->name('users.edit');
            Route::patch('/update', 'update')->name('users.update');
            Route::post('/delete', 'delete')->name('users.delete');
        });

    // Subdomain CRUD routes
    Route::controller(SubdomainController::class)
        ->prefix('/sub-domain')
        ->group(function () {
            Route::any('/', 'index')->name('sub-domain');
            Route::get('/create', 'create')->name('sub-domain.create');
            Route::post('/insert', 'insert')->name('sub-domain.insert');
            Route::post('/delete', 'delete')->name('sub-domain.delete');
        });


    // Product CRUD routes
    Route::controller(ProductController::class)
        ->prefix('/products')
        ->group(function () {
            Route::any('/', 'index')->name('products');
            Route::get('/create', 'create')->name('products.create');
            Route::post('/insert', 'insert')->name('products.insert');
            Route::get('/view/{id}', 'view')->name('products.view');
            Route::get('/edit/{id}', 'edit')->name('products.edit');
            Route::patch('/update', 'update')->name('products.update');
            Route::post('/delete', 'delete')->name('products.delete');
        });
});

// Route::middleware('validate-subdomain')->group(function () {
Route::domain('{subdomain}.'. config('env.APP_URL'))->group(function () {
    Route::get('/', function ($subdomain) {
        return 'Welcome to ' . $subdomain . ' subdomain';
    });

    // Example: Define other routes like product management
    Route::controller(ProductController::class)
        ->prefix('/products')
        ->group(function () {
            Route::any('/', 'index')->name('sub.product');
            Route::get('/create', 'create')->name('sub.products.create');
            Route::post('/insert', 'insert')->name('sub.products.insert');
        });
});
// });
