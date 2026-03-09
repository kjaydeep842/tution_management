<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ParentController extends Controller
{
    private function getStudent()
    {
        $student = Student::with(['tuitionClass', 'fees', 'attendances'])
            ->where('user_id', auth()->id())
            ->firstOrFail();
        return $student;
    }

    public function dashboard()
    {
        $student = $this->getStudent();

        // Attendance stats (last 30 days)
        $from = Carbon::now()->subDays(30)->toDateString();
        $attendances = Attendance::where('student_id', $student->id)
            ->where('date', '>=', $from)
            ->get();

        $total = $attendances->count();
        $present = $attendances->where('status', 'present')->count();
        $absent = $attendances->where('status', 'absent')->count();
        $late = $attendances->where('status', 'late')->count();
        $pct = $total > 0 ? round(($present / $total) * 100) : 0;

        // Recent absences
        $recentAbsent = Attendance::where('student_id', $student->id)
            ->where('status', 'absent')
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        // Fees summary
        $fees = $student->fees()->with('payments')->get();
        $totalAmount = $fees->sum('amount');
        $totalPaid = $fees->flatMap->payments->sum('amount');
        $feesDue = $totalAmount - $totalPaid;
        $feesPaid = $totalPaid;

        // Progress Reports (Recent Performance)
        $performanceReports = \App\Models\PerformanceReport::where('student_id', $student->id)
            ->orderBy('report_date', 'desc')
            ->take(3)
            ->get();

        return view('parent.dashboard', compact(
            'student',
            'total',
            'present',
            'absent',
            'late',
            'pct',
            'recentAbsent',
            'feesDue',
            'feesPaid',
            'performanceReports'
        ));
    }

    public function pastRecords()
    {
        $student = $this->getStudent();
        // For now, showing past performance reports and exam marks as "records"
        $pastReports = \App\Models\PerformanceReport::where('student_id', $student->id)
            ->orderBy('report_date', 'desc')
            ->get();

        $pastExams = \App\Models\ExamMark::with('exam')
            ->where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('parent.past_records', compact('student', 'pastReports', 'pastExams'));
    }

    public function attendance(Request $request)
    {
        $student = $this->getStudent();

        $month = $request->get('month', now()->format('Y-m'));
        $from = Carbon::parse($month . '-01')->startOfMonth();
        $to = $from->copy()->endOfMonth();

        $attendances = Attendance::where('student_id', $student->id)
            ->whereBetween('date', [$from->toDateString(), $to->toDateString()])
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Build calendar dates
        $dates = [];
        $cursor = $from->copy();
        while ($cursor->lte($to)) {
            $dates[] = $cursor->toDateString();
            $cursor->addDay();
        }

        $present = $attendances->where('status', 'present')->count();
        $absent = $attendances->where('status', 'absent')->count();
        $late = $attendances->where('status', 'late')->count();
        $total = $attendances->count();
        $pct = $total > 0 ? round(($present / $total) * 100) : 0;

        return view('parent.attendance', compact(
            'student',
            'attendances',
            'dates',
            'month',
            'from',
            'present',
            'absent',
            'late',
            'total',
            'pct'
        ));
    }

    public function fees()
    {
        $student = $this->getStudent();
        $fees = $student->fees()->with('payments')->orderBy('created_at', 'desc')->get();

        $totalAmount = $fees->sum('amount');
        $totalPaid = $fees->flatMap->payments->sum('amount');
        $totalPending = $totalAmount - $totalPaid;

        return view('parent.fees', compact('student', 'fees', 'totalAmount', 'totalPaid', 'totalPending'));
    }

    public function performance()
    {
        $student = $this->getStudent();
        $reports = \App\Models\PerformanceReport::where('student_id', $student->id)
            ->with('teacher')
            ->orderBy('report_date', 'desc')
            ->get();
        return view('parent.performance', compact('student', 'reports'));
    }

    public function examMarks()
    {
        $student = $this->getStudent();
        $examMarks = \App\Models\ExamMark::with('exam.tuitionClass')
            ->where('student_id', $student->id)
            ->get();
        return view('parent.exams', compact('student', 'examMarks'));
    }

    public function profile()
    {
        $student = $this->getStudent();
        $user = auth()->user();
        return view('parent.profile', compact('student', 'user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
