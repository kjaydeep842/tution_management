<?php

namespace App\Http\Controllers;

use App\Models\TuitionClass;
use App\Models\Branch;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TuitionClassController extends Controller
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
        $classes = TuitionClass::with(['teacher', 'branch'])->latest()->paginate(15);
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        $teachers = Teacher::where('is_active', true)->with('branch')->get();
        $subjects = $this->subjects;
        return view('admin.classes.create', compact('branches', 'teachers', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'string|max:255',
            'teacher_id' => 'nullable|exists:teachers,id',
            'branch_ids' => 'nullable|array',
            'branch_ids.*' => 'exists:branches,id',
            'schedule_info' => 'nullable|string',
            'class_time' => 'nullable|date_format:H:i',
        ]);

        // Store subject as comma-separated for display, branch_ids as JSON
        $subjects = $request->input('subjects', []);
        $branchIds = $request->input('branch_ids', []);
        $primaryBranch = count($branchIds) > 0 ? $branchIds[0] : null;

        TuitionClass::create([
            'name' => $validated['name'],
            'subject' => implode(', ', $subjects),
            'teacher_id' => $validated['teacher_id'] ?? null,
            'branch_id' => $primaryBranch,
            'branch_ids' => $branchIds,
            'schedule_info' => $validated['schedule_info'] ?? null,
            'class_time' => $validated['class_time'] ?? null,
        ]);

        return redirect()->route('tuition-classes.index')->with('success', 'Batch created successfully.');
    }

    public function edit(TuitionClass $tuitionClass)
    {
        $branches = Branch::where('is_active', true)->get();
        $teachers = Teacher::where('is_active', true)->with('branch')->get();
        $subjects = $this->subjects;
        return view('admin.classes.edit', compact('tuitionClass', 'branches', 'teachers', 'subjects'));
    }

    public function update(Request $request, TuitionClass $tuitionClass)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'string|max:255',
            'teacher_id' => 'nullable|exists:teachers,id',
            'branch_ids' => 'nullable|array',
            'branch_ids.*' => 'exists:branches,id',
            'schedule_info' => 'nullable|string',
            'class_time' => 'nullable|date_format:H:i',
        ]);

        $subjects = $request->input('subjects', []);
        $branchIds = $request->input('branch_ids', []);
        $primaryBranch = count($branchIds) > 0 ? $branchIds[0] : null;

        $tuitionClass->update([
            'name' => $validated['name'],
            'subject' => implode(', ', $subjects),
            'teacher_id' => $validated['teacher_id'] ?? null,
            'branch_id' => $primaryBranch,
            'branch_ids' => $branchIds,
            'schedule_info' => $validated['schedule_info'] ?? null,
            'class_time' => $validated['class_time'] ?? null,
        ]);

        return redirect()->route('tuition-classes.index')->with('success', 'Batch updated successfully.');
    }

    public function destroy(TuitionClass $tuitionClass)
    {
        $tuitionClass->delete();
        return redirect()->route('tuition-classes.index')->with('success', 'Batch deleted.');
    }
}
