<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teacher_assignments', function (Blueprint $table) {
            $table->unsignedTinyInteger('periods_per_week')->default(1)->after('is_grade_teacher');
            $table->unsignedTinyInteger('double_periods_per_week')->default(0)->after('periods_per_week');
        });
    }

    public function down(): void
    {
        Schema::table('teacher_assignments', function (Blueprint $table) {
            $table->dropColumn(['periods_per_week', 'double_periods_per_week']);
        });
    }
};
