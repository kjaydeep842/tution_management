<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = [
        'student_id',
        'amount',
        'fee_type',
        'due_date',
        'status',
        'invoice_no',
        'user_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentRequests()
    {
        return $this->hasMany(PaymentRequest::class);
    }
}
