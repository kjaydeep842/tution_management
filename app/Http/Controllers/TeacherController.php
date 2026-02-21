<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Branch;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    private array $subjects = [
        'Accountancy',
        'Business Studies',
        'Economics',
        'Mathematics & Statistics',
        'English',
        'Hindi',
        'Gujarati',
        'Commercial Law & Secretarial Practice',
        'Information Technology (IT)',
        'Organisation of Commerce',
    ];

    public function index()
    {
        $teachers = Teacher::with('branch')->latest()->paginate(15);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        $subjects = $this->subjects;
        return view('admin.teachers.create', compact('branches', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'subjects' => 'nullable|array',
            'subjects.*' => 'string|max:255',
            'branch_ids' => 'nullable|array',
            'branch_ids.*' => 'exists:branches,id',
        ]);

        $subjects = $request->input('subjects', []);
        $branchIds = $request->input('branch_ids', []);
        $primaryBranch = count($branchIds) > 0 ? $branchIds[0] : null;

        Teacher::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'subject_specialisation' => implode(', ', $subjects),
            'subject_ids' => $subjects,
            'branch_id' => $primaryBranch,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully.');
    }

    public function edit(Teacher $teacher)
    {
        $branches = Branch::where('is_active', true)->get();
        $subjects = $this->subjects;
        return view('admin.teachers.edit', compact('teacher', 'branches', 'subjects'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'subjects' => 'nullable|array',
            'subjects.*' => 'string|max:255',
            'branch_ids' => 'nullable|array',
            'branch_ids.*' => 'exists:branches,id',
            'is_active' => 'boolean',
        ]);

        $subjects = $request->input('subjects', []);
        $branchIds = $request->input('branch_ids', []);
        $primaryBranch = count($branchIds) > 0 ? $branchIds[0] : null;

        $teacher->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'subject_specialisation' => implode(', ', $subjects),
            'subject_ids' => $subjects,
            'branch_id' => $primaryBranch,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher removed.');
    }
}
