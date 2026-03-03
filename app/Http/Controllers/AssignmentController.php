<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\TuitionClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with('tuitionClass')->latest()->paginate(10);
        return view('admin.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $classes = TuitionClass::all();
        return view('admin.assignments.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tuition_class_id' => 'required|exists:tuition_classes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('assignments', 'public');
        }

        $assignment = Assignment::create($validated);

        // Send notifications if requested
        if ($request->has('notify_channels')) {
            try {
                $notificationService = new \App\Services\NotificationService();
                $notificationService->sendAssignmentNotification($assignment, $request->get('notify_channels'));
            } catch (\Exception $e) {
                \Log::error("Assignment notification failed: " . $e->getMessage());
            }
        }

        return redirect()->route('assignments.index')->with('success', 'Assignment created and notifications sent.');
    }

    public function show(Assignment $assignment)
    {
        $assignment->load('submissions.student');
        return view('admin.assignments.show', compact('assignment'));
    }
}
