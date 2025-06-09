<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'waitlisted', 'denied'])->default('pending');
            $table->string('crew_name')->nullable();
            $table->string('class')->nullable();
            $table->text('notes_to_organizer')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->text('payment_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_event_registrations');
    }
};