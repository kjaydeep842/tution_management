<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TuitionClass;
use App\Models\Inquiry;
use App\Models\User;
use App\Models\Role;
use App\Mail\ParentAccountCreatedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('tuitionClass')->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create(Request $request)
    {
        $classes = TuitionClass::all();
        $inquiry = null;
        if ($request->filled('inquiry_id')) {
            $inquiry = Inquiry::find($request->inquiry_id);
        }
        return view('admin.students.create', compact('classes', 'inquiry'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:20',
            'tuition_class_id' => 'required|exists:tuition_classes,id',
            'email' => 'nullable|email|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
            'roll_no' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        Student::create($validated);

        // Mark source inquiry as converted
        if ($request->filled('inquiry_id')) {
            Inquiry::where('id', $request->inquiry_id)->update(['status' => 'converted']);
            return redirect()->route('inquiries.index')->with('success', 'Student enrolled and inquiry marked as Converted.');
        }

        return redirect()->route('students.index')->with('success', 'Student enrolled successfully.');
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classes = TuitionClass::all();
        return view('admin.students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:20',
            'tuition_class_id' => 'required|exists:tuition_classes,id',
            'email' => 'nullable|email|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
            'roll_no' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student record updated.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student record deleted.');
    }

    public function createParentAccount(Request $request, Student $student)
    {
        if ($student->user_id) {
            return back()->with('info', 'This student already has a parent login account.');
        }

        $email = $request->validate([
            'parent_email' => 'required|email|unique:users,email',
        ])['parent_email'];

        $password = Str::random(10);
        $parentRole = Role::where('name', 'Parent')->first();

        $user = User::create([
            'name' => $student->guardian_name ?? $student->full_name . ' (Parent)',
            'email' => $email,
            'phone' => $student->guardian_phone,
            'password' => Hash::make($password),
            'role_id' => $parentRole?->id,
        ]);

        $student->update(['user_id' => $user->id]);

        // Send welcome email with credentials and portal URL
        try {
            Mail::to($email)->send(new ParentAccountCreatedMail(
                guardianName: $student->guardian_name ?? 'Guardian',
                studentName: $student->full_name,
                email: $email,
                password: $password,
                portalUrl: route('parent.dashboard')
            ));
            $msg = "Parent account created and login credentials emailed to {$email} successfully.";
        } catch (\Exception $e) {
            \Log::warning('Parent welcome email failed: ' . $e->getMessage());
            $msg = "Parent account created! Email: {$email} | Password: {$password} — (Email delivery failed, please share manually.)";
        }

        return back()->with('success', $msg);
    }
}
