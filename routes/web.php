<?php

use App\Models\Event;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\CarProfileController;
use App\Http\Controllers\EventRegistrationController;

Route::get('/', [PublicEventController::class, 'index'])->name('public.events.index');
Route::get('/event-details/{event}', [PublicEventController::class, 'show'])->name('public.events.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('events', EventController::class);
    Route::resource('car-profiles', CarProfileController::class);
    
    // Event Registration Routes
    Route::get('/events/{event}/register', [EventRegistrationController::class, 'create'])->name('event-registrations.create');
    Route::post('/events/{event}/register', [EventRegistrationController::class, 'store'])->name('event-registrations.store');
    Route::get('/event-registrations', [EventRegistrationController::class, 'index'])->name('event-registrations.index');
    Route::get('/event-registrations/{registration}', [EventRegistrationController::class, 'show'])->name('event-registrations.show');
    Route::get('/event-registrations/{registration}/confirmation', [EventRegistrationController::class, 'confirmation'])->name('event-registrations.confirmation');
});

require __DIR__.'/auth.php';
