<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'title', 'class_id', 'subject_id', 'material_type', 'file_path',
        'description', 'extracted_text', 'extracted_text_cached_at',
        'uploaded_by', 'last_updated',
    ];

    protected function casts(): array
    {
        return ['extracted_text_cached_at' => 'datetime'];
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
