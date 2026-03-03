<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'tuition_class_id',
        'date',
        'status',
        'user_id',
        'notified_at',
    ];

    protected $casts = [
        'notified_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function tuitionClass()
    {
        return $this->belongsTo(TuitionClass::class);
    }

    public function marker()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
