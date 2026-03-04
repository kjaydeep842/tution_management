<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\Payment;
use App\Models\Fee;
use Illuminate\Http\Request;

class PaymentRequestController extends Controller
{
    public function index()
    {
        $requests = PaymentRequest::with('student', 'fee')->latest()->paginate(15);
        return view('admin.payment_requests.index', compact('requests'));
    }

    public function approve(PaymentRequest $paymentRequest)
    {
        if ($paymentRequest->status !== 'pending') {
            return back()->with('error', 'Request already processed.');
        }

        // Create the actual payment record
        Payment::create([
            'fee_id' => $paymentRequest->fee_id,
            'student_id' => $paymentRequest->student_id,
            'amount' => $paymentRequest->amount,
            'payment_mode' => $paymentRequest->payment_mode,
            'txn_id' => $paymentRequest->txn_id,
            'paid_on' => now(),
            'receipt_no' => 'REC-' . strtoupper(uniqid())
        ]);

        // Update fee status
        $fee = $paymentRequest->fee;
        $totalPaid = $fee->payments()->sum('amount');
        if ($totalPaid >= $fee->amount) {
            $fee->update(['status' => 'paid']);
        } elseif ($totalPaid > 0) {
            $fee->update(['status' => 'partial']);
        }

        $paymentRequest->update(['status' => 'approved']);

        return back()->with('success', 'Payment approved successfully.');
    }

    public function reject(Request $request, PaymentRequest $paymentRequest)
    {
        if ($paymentRequest->status !== 'pending') {
            return back()->with('error', 'Request already processed.');
        }

        $paymentRequest->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes
        ]);

        return back()->with('success', 'Payment request rejected.');
    }
}
