<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['tuition_class_id', 'title', 'exam_date'];

    public function tuitionClass()
    {
        return $this->belongsTo(TuitionClass::class);
    }

    public function examMarks()
    {
        return $this->hasMany(ExamMark::class);
    }
}
