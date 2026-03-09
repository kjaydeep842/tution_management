<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerformanceReport;
use App\Models\Student;
use App\Models\ExamMark;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PerformanceReportController extends Controller
{
    public function index()
    {
        $students = Student::with('tuitionClass')->get();
        return view('admin.performance.index', compact('students'));
    }

    public function create(Student $student)
    {
        // Calculate performance from exam marks
        $examMarks = ExamMark::with('exam.tuitionClass')
            ->where('student_id', $student->id)
            ->get();

        $subjectsPerformance = [];
        foreach ($examMarks as $mark) {
            $subject = $mark->exam->tuitionClass->subject;
            if (!isset($subjectsPerformance[$subject])) {
                $subjectsPerformance[$subject] = [
                    'marks' => 0,
                    'count' => 0,
                    'total_possible' => 0, // Assuming 100 per exam if not specified
                ];
            }
            $subjectsPerformance[$subject]['marks'] += $mark->marks_obtained;
            $subjectsPerformance[$subject]['count']++;
            $subjectsPerformance[$subject]['total_possible'] += 100; // Defaulting to 100
        }

        $weak_subjects = [];
        $strong_subjects = [];
        $marks_data = [];

        foreach ($subjectsPerformance as $subject => $data) {
            $percentage = ($data['marks'] / $data['total_possible']) * 100;
            $marks_data[$subject] = $percentage;

            if ($percentage < 45) {
                $weak_subjects[] = $subject;
            } elseif ($percentage > 75) {
                $strong_subjects[] = $subject;
            }
        }

        return view('admin.performance.create', compact('student', 'weak_subjects', 'strong_subjects', 'marks_data'));
    }

    public function store(Request $request, Student $student)
    {
        $request->validate([
            'report_date' => 'required|date',
            'suggestions' => 'nullable|string',
            'overall_performance' => 'nullable|string',
        ]);

        $report = PerformanceReport::create([
            'student_id' => $student->id,
            'teacher_id' => Auth::id(),
            'report_date' => $request->report_date,
            'weak_subjects' => $request->weak_subjects, // expecting array from form
            'strong_subjects' => $request->strong_subjects, // expecting array from form
            'marks_data' => $request->marks_data, // expecting json/array from form
            'suggestions' => $request->suggestions,
            'overall_performance' => $request->overall_performance,
        ]);

        // Send WhatsApp Notification to Parent
        try {
            $notificationService = new \App\Services\NotificationService();
            $notificationService->sendPerformanceReportNotification($report);
        } catch (\Exception $e) {
            \Log::error("Failed to send performance report WhatsApp: " . $e->getMessage());
        }

        return redirect()->route('performance-reports.index')->with('success', 'Performance report sent via WhatsApp to parent.');
    }

    public function download(PerformanceReport $report)
    {
        $report->load('student.tuitionClass', 'teacher');
        $pdf = Pdf::loadView('admin.performance.pdf', compact('report'));
        return $pdf->download('Performance_Report_' . $report->student->first_name . '.pdf');
    }
}
