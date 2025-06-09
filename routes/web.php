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
    Route::get('/event-registrations/attend/{registration}', [EventRegistrationController::class, 'showAttend'])->name('event-registrations.attend.show');
    Route::get('/event-registrations/{registration}/confirmation', [EventRegistrationController::class, 'confirmation'])->name('event-registrations.confirmation');

    Route::post('/events/{event}/attendee-register', [EventRegistrationController::class, 'attendeeStore'])
    ->name('event-attendee-registrations.store');
    Route::get('/events/attendee/{event}/register', [EventRegistrationController::class, 'attendeeCreate'])
    ->name('event-attendee-registrations.create'); // use this name to match the button

    // Event Files Routes
    Route::post('/events/{event}/upload-documents', [EventFileController::class, 'uploadEventDocuments'])->name('events.upload-documents');
    Route::delete('/event-files/{eventFile}', [EventFileController::class, 'destroy'])->name('event-files.destroy');
    
    // Car Event Registration Management Routes
    Route::get('/car-registrants/{registration}/details', [CarEventRegistrationController::class, 'show'])->name('car-registrants.details');
    Route::get('/car-registrants/{registration}/edit-status', [CarEventRegistrationController::class, 'editStatus'])->name('car-registrants.edit-status');
    Route::patch('/car-registrants/{registration}/status', [CarEventRegistrationController::class, 'updateStatus'])->name('car-registrants.update-status');
    Route::get('/car-registrants/{registration}/edit-payment', [CarEventRegistrationController::class, 'editPayment'])->name('car-registrants.edit-payment');
    Route::patch('/car-registrants/{registration}/payment', [CarEventRegistrationController::class, 'updatePayment'])->name('car-registrants.update-payment');
});

require __DIR__.'/auth.php';