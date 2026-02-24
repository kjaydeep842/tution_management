<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\TuitionClass;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::with('tuitionClass')->latest()->paginate(15);
        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function home()
    {
        $classes = TuitionClass::all();
        $teachers = \App\Models\Teacher::where('is_active', true)->with('branch')->get();

        // Collect unique subjects from all active classes
        $subjects = $classes->pluck('subject')
            ->flatMap(fn($s) => array_map('trim', explode(',', $s)))
            ->filter()
            ->unique()
            ->values();

        $studentCount = \App\Models\Student::count();
        $teacherCount = $teachers->count();
        $subjectCount = $subjects->count();

        return view('home', compact('classes', 'teachers', 'subjects', 'studentCount', 'teacherCount', 'subjectCount'));
    }

    public function create()
    {
        $classes = TuitionClass::all();
        return view('public.inquiry', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'source' => 'nullable|string|max:255',
            'tuition_class_id' => 'nullable|exists:tuition_classes,id',
            'notes' => 'nullable|string',
        ]);

        Inquiry::create($validated + ['status' => 'pending']);

        return back()->with('success', 'Thank you for your inquiry! We will contact you soon.');
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $request->validate(['status' => 'required|in:pending,converted,closed']);

        // If converting → redirect to student enroll form pre-filled with inquiry data
        if ($request->status === 'converted') {
            return redirect()->route('students.create', ['inquiry_id' => $inquiry->id])
                ->with('info', "Pre-filling enrolment form from {$inquiry->name}'s inquiry.");
        }

        $inquiry->update(['status' => $request->status]);
        return back()->with('success', 'Inquiry status updated.');
    }

}
