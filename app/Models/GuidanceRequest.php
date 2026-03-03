<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuidanceRequest extends Model
{
    protected $fillable = [
        'student_id',
        'tuition_class_id',
        'subject',
        'parent_message',
        'admin_response',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function tuitionClass()
    {
        return $this->belongsTo(TuitionClass::class);
    }
}
