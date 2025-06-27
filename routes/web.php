<?php

use App\Models\Event;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\CarProfileController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\EventFileController;
use App\Http\Controllers\CarEventRegistrationController;
use App\Http\Middleware\CheckAdminApproval;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicEventController::class, 'index'])->name('public.events.index');

Route::get('/event-details/{event:slug}', [PublicEventController::class, 'show'])->name('public.events.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Included from auth.php)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Profile routes (only require authentication)
    Route::prefix('profile')
        ->name('profile.')
        ->group(function () {
            Route::get('/', [ProfileController::class, 'edit'])->name('edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        });

    // Attendee registration
    Route::get('/events/attendee/{event:slug}/register', [EventRegistrationController::class, 'attendeeStore'])->name('event-attendee-registrations.create');

    // Email verified routes
    Route::middleware(['verified'])->group(function () {
        // Event registration routes
        Route::prefix('event-registrations')
            ->name('event-registrations.')
            ->group(function () {
                Route::get('/', [EventRegistrationController::class, 'index'])->name('index');
                Route::get('/{registration}', [EventRegistrationController::class, 'show'])->name('show');
                Route::get('/attend/{registration}', [EventRegistrationController::class, 'showAttend'])->name('attend.show');
                Route::get('/{registration}/confirmation', [EventRegistrationController::class, 'confirmation'])->name('confirmation');

                // Event registration creation
                Route::get('/events/{event:slug}/register', [EventRegistrationController::class, 'create'])->name('create');
                Route::post('/events/{event:slug}/register', [EventRegistrationController::class, 'store'])->name('store');
            });

        // Car profiles
        Route::resource('car-profiles', CarProfileController::class);

        // Admin approved user routes
        Route::middleware([CheckAdminApproval::class])->group(function () {
            // Event management (except index/show which are public)
            Route::resource('events', EventController::class)->except(['index', 'show']);

            // Event files
            Route::prefix('events/{event:slug}')->group(function () {
                Route::post('/upload-documents', [EventFileController::class, 'uploadEventDocuments'])->name('events.upload-documents');
            });

            Route::prefix('event-files')
                ->name('event-files.')
                ->group(function () {
                    Route::delete('/{eventFile}', [EventFileController::class, 'destroy'])->name('destroy');
                    Route::patch('/{eventFile}/toggle-visibility', [EventFileController::class, 'toggleVisibility'])->name('toggle-visibility');
                });
        });

        // Public event routes (read-only)
        Route::resource('events', EventController::class)->only(['index', 'show'])->parameters(['events' => 'event:slug']);

        // Car event registration management
        Route::prefix('car-registrants/{registration}')
            ->name('car-registrants.')
            ->group(function () {
                Route::get('/details', [CarEventRegistrationController::class, 'show'])->name('details');

                Route::prefix('status')->group(function () {
                    Route::get('/edit', [CarEventRegistrationController::class, 'editStatus'])->name('edit-status');
                    Route::patch('/', [CarEventRegistrationController::class, 'updateStatus'])->name('update-status');
                });

                Route::prefix('payment')->group(function () {
                    Route::get('/edit', [CarEventRegistrationController::class, 'editPayment'])->name('edit-payment');
                    Route::patch('/', [CarEventRegistrationController::class, 'updatePayment'])->name('update-payment');
                });
            });
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','verified', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // User management
        Route::resource('users', AdminUserController::class)->except(['show', 'create', 'store']);

        // User approval routes
        Route::patch('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
        Route::patch('/users/{user}/reject', [AdminUserController::class, 'reject'])->name('users.reject');
    });
