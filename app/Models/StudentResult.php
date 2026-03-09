<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentResult extends Model
{
    protected $fillable = [
        'student_name',
        'exam_name',
        'marks_percentage',
        'image',
        'achievement',
        'is_active',
    ];
}
