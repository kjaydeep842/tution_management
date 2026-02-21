<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'tuition_class_id',
        'title',
        'description',
        'due_date',
        'file_path'
    ];

    public function tuitionClass()
    {
        return $this->belongsTo(TuitionClass::class);
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }
}
