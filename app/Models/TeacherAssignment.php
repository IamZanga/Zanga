<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAssignment extends Model
{
    protected $fillable = [
        'teacher_id', 'class_id', 'subject_id', 'is_grade_teacher',
        'periods_per_week', 'double_periods_per_week',
    ];

    protected function casts(): array
    {
        return ['is_grade_teacher' => 'boolean'];
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
