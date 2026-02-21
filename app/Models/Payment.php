<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'fee_id',
        'student_id',
        'amount',
        'payment_mode',
        'txn_id',
        'paid_on',
        'receipt_no'
    ];

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
