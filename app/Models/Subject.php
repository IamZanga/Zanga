<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'code', 'is_registration'];

    protected function casts(): array
    {
        return ['is_registration' => 'boolean'];
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function teacherAssignments()
    {
        return $this->hasMany(TeacherAssignment::class);
    }
}
