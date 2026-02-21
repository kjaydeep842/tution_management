<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'subject_specialisation',
        'subject_ids',
        'branch_id',
        'is_active'
    ];

    protected $casts = [
        'subject_ids' => 'array',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function tuitionClasses()
    {
        return $this->hasMany(TuitionClass::class);
    }
}
