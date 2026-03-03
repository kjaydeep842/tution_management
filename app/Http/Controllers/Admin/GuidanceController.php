<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuidanceRequest;
use Illuminate\Http\Request;

class GuidanceController extends Controller
{
    public function index()
    {
        $requests = GuidanceRequest::with(['student', 'tuitionClass'])
            ->latest()
            ->paginate(15);

        return view('admin.guidance.index', compact('requests'));
    }

    public function show(GuidanceRequest $guidance)
    {
        $guidance->load(['student.tuitionClass']);
        return view('admin.guidance.show', compact('guidance'));
    }

    public function respond(Request $request, GuidanceRequest $guidance)
    {
        $validated = $request->validate([
            'admin_response' => 'required|string|min:10',
            'status' => 'required|in:pending,resolved',
        ]);

        $guidance->update([
            'admin_response' => $validated['admin_response'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.guidance.index')->with('success', 'Response recorded successfully.');
    }
}
