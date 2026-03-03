<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\GuidanceRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuidanceController extends Controller
{
    public function index()
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        $requests = GuidanceRequest::where('student_id', $student->id)
            ->latest()
            ->get();

        return view('parent.guidance.index', compact('student', 'requests'));
    }

    public function create()
    {
        $student = Student::where('user_id', Auth::id())->with('tuitionClass')->firstOrFail();

        // Extract subjects from comma-separated string in tuition_classes table
        $subjects = array_map('trim', explode(',', $student->tuitionClass->subject));

        return view('parent.guidance.create', compact('student', 'subjects'));
    }

    public function store(Request $request)
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'subject' => 'required|string',
            'parent_message' => 'required|string|min:10',
        ]);

        GuidanceRequest::create([
            'student_id' => $student->id,
            'tuition_class_id' => $student->tuition_class_id,
            'subject' => $validated['subject'],
            'parent_message' => $validated['parent_message'],
            'status' => 'pending',
        ]);

        return redirect()->route('parent.guidance.index')->with('success', 'Guidance request submitted successfully!');
    }
}
