<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    protected $fillable = [
        'fee_id',
        'student_id',
        'amount',
        'payment_mode',
        'txn_id',
        'receipt_path',
        'status',
        'admin_notes'
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
