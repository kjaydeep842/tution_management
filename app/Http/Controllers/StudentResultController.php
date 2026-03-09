<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StudentResult;
use Illuminate\Support\Facades\Storage;

class StudentResultController extends Controller
{
    public function index()
    {
        $results = StudentResult::latest()->paginate(10);
        return view('admin.results.index', compact('results'));
    }

    public function create()
    {
        return view('admin.results.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'exam_name' => 'required|string|max:255',
            'marks_percentage' => 'required|string|max:20',
            'image' => 'nullable|image|max:2048',
            'achievement' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('results', 'public');
        }

        StudentResult::create($validated);

        return redirect()->route('results.index')->with('success', 'Student result added successfully.');
    }

    public function edit(StudentResult $result)
    {
        return view('admin.results.edit', compact('result'));
    }

    public function update(Request $request, StudentResult $result)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'exam_name' => 'required|string|max:255',
            'marks_percentage' => 'required|string|max:20',
            'image' => 'nullable|image|max:2048',
            'achievement' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($result->image) {
                Storage::disk('public')->delete($result->image);
            }
            $validated['image'] = $request->file('image')->store('results', 'public');
        }

        $result->update($validated);

        return redirect()->route('results.index')->with('success', 'Student result updated successfully.');
    }

    public function destroy(StudentResult $result)
    {
        if ($result->image) {
            Storage::disk('public')->delete($result->image);
        }
        $result->delete();

        return back()->with('success', 'Student result deleted successfully.');
    }

    public function showPublic(Request $request)
    {
        $results = StudentResult::where('is_active', true)->latest()->paginate(12);
        return view('results', compact('results'));
    }
}
