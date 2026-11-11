<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// PUBLIC ROUTES
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'register']);
});

// AUTHENTICATED ROUTES
Route::middleware('auth')->group(function () {

    // ALL USERS
    Route::get('/', [EquipmentController::class, 'index'])
        ->name('dashboard');

    Route::get('/equipment', [EquipmentController::class, 'inventory'])
        ->name('equipment.index');

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    // BORROWING HISTORY
    Route::get('/borrowings', [BorrowingController::class, 'index'])
        ->name('borrowings.index');

    // STUDENT BORROWING
    Route::middleware('role:student')->group(function () {

        Route::get('/borrowings/create', [BorrowingController::class, 'create'])
            ->name('borrowings.create');

        Route::post('/borrowings', [BorrowingController::class, 'store'])
            ->name('borrowings.store');
    });

    // ADMIN AND TEACHER APPROVAL
    Route::middleware('role:admin,administrator,teacher')->group(function () {

        Route::post('/borrowings/{id}/approve', [BorrowingController::class, 'approve'])
            ->name('borrowings.approve');

        Route::post('/borrowings/{id}/reject', [BorrowingController::class, 'reject'])
            ->name('borrowings.reject');
    });

    // EQUIPMENT RELEASE AND RETURN
    Route::middleware('role:admin,administrator,staff,teacher')->group(function () {

        Route::post('/borrowings/{id}/release', [BorrowingController::class, 'release'])
            ->name('borrowings.release');

        Route::post('/borrowings/{id}/return', [BorrowingController::class, 'markReturned'])
            ->name('borrowings.return');
    });

    // ADMIN, STAFF AND TEACHER - EQUIPMENT
    Route::middleware('role:admin,administrator,staff,teacher')->group(function () {

        Route::get('/equipment/create', [EquipmentController::class, 'create'])
            ->name('equipment.create');

        Route::post('/equipment', [EquipmentController::class, 'store'])
            ->name('equipment.store');

        Route::get('/equipment/{id}/edit', [EquipmentController::class, 'edit'])
            ->name('equipment.edit');

        Route::put('/equipment/{id}', [EquipmentController::class, 'update'])
            ->name('equipment.update');
    });

    // ADMIN ONLY
    Route::middleware('role:admin,administrator')->group(function () {

        Route::delete('/equipment/{id}', [EquipmentController::class, 'destroy'])
            ->name('equipment.destroy');

        Route::get('/analytics', [EquipmentController::class, 'analytics'])
            ->name('analytics');

        Route::get('/settings', [EquipmentController::class, 'settings'])
            ->name('settings');

        // USER MANAGEMENT
        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');

        Route::get('/users/create', [UserController::class, 'create'])
            ->name('users.create');

        Route::post('/users', [UserController::class, 'store'])
            ->name('users.store');

        Route::get('/users/{id}/edit', [UserController::class, 'edit'])
            ->name('users.edit');

        Route::put('/users/{id}', [UserController::class, 'update'])
            ->name('users.update');

        Route::delete('/users/{id}', [UserController::class, 'destroy'])
            ->name('users.destroy');
    });
});
