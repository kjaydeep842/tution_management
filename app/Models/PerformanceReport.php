<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceReport extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'report_date',
        'weak_subjects',
        'strong_subjects',
        'marks_data',
        'suggestions',
        'overall_performance',
    ];

    protected $casts = [
        'weak_subjects' => 'array',
        'strong_subjects' => 'array',
        'marks_data' => 'array',
        'report_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
