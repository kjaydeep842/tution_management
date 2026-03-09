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
        $classes = \App\Models\TuitionClass::all();
        $feeTypes = \App\Models\FeeType::all();
        return view('admin.fees.create', compact('students', 'classes', 'feeTypes'));
    }

    public function store(Request $request)
    {
        $rules = [
            'amount' => 'required|numeric|min:0',
            'fee_type' => 'required|string|max:255',
            'fee_target' => 'required|in:single,bulk',
        ];

        if ($request->fee_target === 'single') {
            $rules['student_id'] = 'required|exists:students,id';
        } else {
            $rules['tuition_class_id'] = 'required|exists:tuition_classes,id';
        }

        $validated = $request->validate($rules);

        $commonData = [
            'amount' => $validated['amount'],
            'fee_type' => $validated['fee_type'],
            'user_id' => auth()->id(),
            'status' => 'unpaid',
        ];

        if ($request->fee_target === 'single') {
            $commonData['student_id'] = $validated['student_id'];
            $commonData['invoice_no'] = 'INV-' . strtoupper(uniqid());
            Fee::create($commonData);
            $msg = 'Fee record created for student.';
        } else {
            $students = Student::where('tuition_class_id', $validated['tuition_class_id'])->get();
            if ($students->isEmpty()) {
                return back()->with('error', 'No students found in the selected class.')->withInput();
            }

            foreach ($students as $student) {
                $studentFee = $commonData;
                $studentFee['student_id'] = $student->id;
                $studentFee['invoice_no'] = 'INV-' . strtoupper(uniqid());
                Fee::create($studentFee);
            }
            $msg = 'Fee records created for ' . $students->count() . ' students.';
        }

        return redirect()->route('fees.index')->with('success', $msg);
    }
}
