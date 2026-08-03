<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->string('day'); // Monday..Friday
            $table->string('period'); // e.g. "Period 1", "08:00-08:40"
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('last_updated')->useCurrent();
            $table->timestamps();

            $table->unique(['class_id', 'day', 'period'], 'timetable_slot_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
