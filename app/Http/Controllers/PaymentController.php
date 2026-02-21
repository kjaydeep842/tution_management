<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Fee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('student', 'fee')->latest()->paginate(15);
        return view('admin.payments.index', compact('payments'));
    }

    public function create(Fee $fee)
    {
        return view('admin.payments.create', compact('fee'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fee_id' => 'required|exists:fees,id',
            'amount' => 'required|numeric|min:0',
            'payment_mode' => 'required|string',
            'txn_id' => 'nullable|string',
            'paid_on' => 'required|date',
        ]);

        $fee = Fee::findOrFail($validated['fee_id']);

        $validated['student_id'] = $fee->student_id;
        $validated['receipt_no'] = 'REC-' . strtoupper(uniqid());

        $payment = Payment::create($validated);

        // Update fee status
        $totalPaid = $fee->payments()->sum('amount');
        if ($totalPaid >= $fee->amount) {
            $fee->update(['status' => 'paid']);
        } elseif ($totalPaid > 0) {
            $fee->update(['status' => 'partial']);
        }

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
    }

    public function receipt(Payment $payment)
    {
        $pdf = Pdf::loadView('admin.payments.receipt_pdf', compact('payment'));
        return $pdf->download("receipt-{$payment->receipt_no}.pdf");
    }
}
