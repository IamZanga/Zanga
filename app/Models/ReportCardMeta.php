<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportCardMeta extends Model
{
    protected $table = 'report_card_meta';

    protected $fillable = ['student_id', 'term_id', 'teacher_comment', 'generated_at'];

    protected function casts(): array
    {
        return ['generated_at' => 'datetime'];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}
