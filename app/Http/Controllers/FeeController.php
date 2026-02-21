<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Student;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::with('student')->latest()->paginate(15);
        return view('admin.fees.index', compact('fees'));
    }

    public function create()
    {
        $students = Student::all();
        return view('admin.fees.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'fee_type' => 'required|string|max:255',
            'due_date' => 'required|date',
        ]);

        $validated['invoice_no'] = 'INV-' . strtoupper(uniqid());
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'unpaid';

        Fee::create($validated);

        return redirect()->route('fees.index')->with('success', 'Fee record created.');
    }
}
