<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TuitionClass extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'user_id',
        'teacher_id',
        'branch_id',
        'branch_ids',
        'schedule_info',
        'class_time',
    ];

    protected $casts = [
        'branch_ids' => 'array',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /** Returns branch names from branch_ids JSON */
    public function getBranchNames(): array
    {
        if (empty($this->branch_ids))
            return [];
        return Branch::whereIn('id', $this->branch_ids)->pluck('name')->toArray();
    }
}
