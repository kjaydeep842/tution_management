<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'name',
        'contact',
        'source',
        'tuition_class_id',
        'status',
        'notes'
    ];

    public function tuitionClass()
    {
        return $this->belongsTo(TuitionClass::class);
    }
}
