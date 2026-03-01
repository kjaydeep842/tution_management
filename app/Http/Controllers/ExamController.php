<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamMark;
use App\Models\TuitionClass;
use App\Models\Student;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('tuitionClass')->latest()->paginate(10);
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $classes = TuitionClass::all();

        // Get all subjects, split them if they are comma-separated, and get unique values
        $subjects = TuitionClass::pluck('subject')
            ->flatMap(fn($item) => explode(',', $item))
            ->map(fn($item) => trim($item))
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('admin.exams.create', compact('classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tuition_class_id' => 'required|exists:tuition_classes,id',
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'total_marks' => 'required|numeric|min:1',
            'passing_marks' => 'nullable|numeric|min:0',
        ]);

        Exam::create($validated);

        return redirect()->route('exams.index')->with('success', 'Exam scheduled successfully.');
    }

    public function marks(Exam $exam)
    {
        $students = Student::where('tuition_class_id', $exam->tuition_class_id)->get();
        $marks = ExamMark::where('exam_id', $exam->id)->get()->keyBy('student_id');

        return view('admin.exams.marks', compact('exam', 'students', 'marks'));
    }

    public function storeMarks(Request $request, Exam $exam)
    {
        $request->validate([
            'marks' => 'required|array',
        ]);

        foreach ($request->marks as $student_id => $data) {
            ExamMark::updateOrCreate(
                ['exam_id' => $exam->id, 'student_id' => $student_id],
                [
                    'marks_obtained' => $data['marks_obtained'] ?? 0,
                    'remarks' => $data['remarks'] ?? '',
                ]
            );
        }

        return redirect()->route('exams.index')->with('success', 'Marks updated successfully.');
    }
}
