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
        Schema::create('event_day_instructions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->text('arrival_instructions')->nullable();
            $table->text('gate_instructions')->nullable();
            $table->text('items_to_bring')->nullable();
            $table->text('important_notes')->nullable();
            $table->timestamps();
            
            // Ensure one-to-one relationship with events
            $table->unique('event_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_day_instructions');
    }
};
