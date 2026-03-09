<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\TuitionClass;
use App\Mail\AttendanceAbsentMail;
use App\Mail\AttendancePresentMail;
use App\Mail\AttendanceLateMail;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        $class_id = $request->get('class_id');

        $classes = TuitionClass::all();
        $students = [];

        if ($class_id) {
            $students = Student::where('tuition_class_id', $class_id)->get();
            $existingAttendance = Attendance::where('date', $date)
                ->where('tuition_class_id', $class_id)
                ->get()
                ->keyBy('student_id');

            foreach ($students as $student) {
                $student->attendance_status = $existingAttendance[$student->id]->status ?? null;
            }
        }

        return view('admin.attendance.index', compact('classes', 'students', 'date', 'class_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'tuition_class_id' => 'required|exists:tuition_classes,id',
            'attendance' => 'required|array',
        ]);

        foreach ($request->attendance as $student_id => $status) {
            $attendance = Attendance::where([
                'student_id' => $student_id,
                'tuition_class_id' => $request->tuition_class_id,
                'date' => $request->date,
            ])->first();

            $updateData = [
                'status' => $status,
                'user_id' => auth()->id(),
            ];

            // If status changed, reset the notification flag to allow a new email
            if ($attendance && $attendance->status !== $status) {
                $updateData['notified_at'] = null;
            }

            Attendance::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'tuition_class_id' => $request->tuition_class_id,
                    'date' => $request->date,
                ],
                $updateData
            );
        }

        // Send email notifications for students newly marked (or status changed)
        $className = TuitionClass::find($request->tuition_class_id)?->name ?? 'your class';

        // Eager load all students in the request
        $students = Student::whereIn('id', array_keys($request->attendance))->get()->keyBy('id');

        foreach ($request->attendance as $student_id => $status) {
            $student = $students[$student_id] ?? null;
            $attendance = Attendance::where([
                'student_id' => $student_id,
                'tuition_class_id' => $request->tuition_class_id,
                'date' => $request->date,
            ])->first();

            // Only send if not already notified for this status
            if ($student && $attendance && !$attendance->notified_at) {
                try {
                    $notificationService = new NotificationService();
                    $notificationService->sendAttendanceNotification($attendance, ['whatsapp']);

                    // Mark as notified (already handled in sendAttendanceNotification would be better, but keeping consistency)
                    $attendance->update(['notified_at' => now()]);
                } catch (\Exception $e) {
                    \Log::warning("Attendance notification failed for student {$student_id}: " . $e->getMessage());
                }
            }
        }

        return back()->with('success', 'Attendance marked successfully.');
    }

    public function report(Request $request)
    {
        $classes = TuitionClass::all();
        $students = Student::orderBy('first_name')->get();

        $reportType = $request->get('report_type', 'daily');
        $class_id = $request->get('class_id');
        $student_id = $request->get('student_id');

        // Determine date range based on report_type
        $today = Carbon::today();
        switch ($reportType) {
            case 'daily':
                $from = Carbon::parse($request->get('date', $today->toDateString()));
                $to = $from->copy();
                break;
            case 'weekly':
                $from = $today->copy()->startOfWeek();
                $to = $today->copy()->endOfWeek();
                break;
            case 'monthly':
                $month = $request->get('month', $today->format('Y-m'));
                $from = Carbon::parse($month . '-01')->startOfMonth();
                $to = $from->copy()->endOfMonth();
                break;
            case 'custom':
                $from = Carbon::parse($request->get('from', $today->toDateString()));
                $to = Carbon::parse($request->get('to', $today->toDateString()));
                break;
            default:
                $from = $today->copy();
                $to = $today->copy();
        }

        // Build query
        $query = Attendance::with(['student', 'tuitionClass'])
            ->whereBetween('date', [$from->toDateString(), $to->toDateString()])
            ->orderBy('date');

        if ($class_id) {
            $query->where('tuition_class_id', $class_id);
        }
        if ($student_id) {
            $query->where('student_id', $student_id);
        }

        $records = $query->get();

        // Summary stats
        $total = $records->count();
        $present = $records->where('status', 'present')->count();
        $absent = $records->where('status', 'absent')->count();
        $late = $records->where('status', 'late')->count();

        // For student-wise grouping
        $byStudent = $records->groupBy('student_id');

        // All dates in range (for the grid)
        $dates = [];
        $cursor = $from->copy();
        while ($cursor->lte($to)) {
            $dates[] = $cursor->toDateString();
            $cursor->addDay();
        }

        // Map: student_id => [date => status]
        $studentDateMap = [];
        foreach ($records as $rec) {
            $studentDateMap[$rec->student_id][$rec->date] = $rec->status;
        }

        // Unique students in result
        $reportStudents = $records->pluck('student')->unique('id')->filter();

        return view('admin.attendance.report', compact(
            'classes',
            'students',
            'records',
            'reportType',
            'from',
            'to',
            'class_id',
            'student_id',
            'total',
            'present',
            'absent',
            'late',
            'byStudent',
            'dates',
            'studentDateMap',
            'reportStudents',
            'request'
        ));
    }
}
