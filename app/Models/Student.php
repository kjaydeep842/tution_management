<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'dob',
        'gender',
        'guardian_name',
        'guardian_phone',
        'guardian_email',
        'email',
        'address',
        'tuition_class_id',
        'roll_no',
        'notes',
        'user_id',
    ];

    public function tuitionClass()
    {
        return $this->belongsTo(TuitionClass::class);
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function assignmentSubmissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function examMarks()
    {
        return $this->hasMany(ExamMark::class);
    }

    public function parentUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
