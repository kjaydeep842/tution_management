<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['tuition_class_id', 'name', 'subject', 'exam_date', 'start_time', 'end_time', 'total_marks', 'passing_marks'];

    public function tuitionClass()
    {
        return $this->belongsTo(TuitionClass::class);
    }

    public function examMarks()
    {
        return $this->hasMany(ExamMark::class);
    }
}
