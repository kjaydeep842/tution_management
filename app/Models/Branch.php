<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name', 'address', 'phone', 'is_active'];

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function tuitionClasses()
    {
        return $this->hasMany(TuitionClass::class);
    }
}
