<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ParentManagementController extends Controller
{
    public function index()
    {
        $parentRole = Role::where('name', 'Parent')->first();
        $parents = User::where('role_id', $parentRole->id)
            ->with('students')
            ->paginate(10);

        return view('admin.parents.index', compact('parents'));
    }

    public function create()
    {
        $students = Student::whereNull('user_id')->get();
        return view('admin.parents.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $parentRole = Role::where('name', 'Parent')->first();

        $password = $validated['password'] ?? Str::random(10);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($password),
            'role_id' => $parentRole->id,
        ]);

        if (!empty($validated['student_ids'])) {
            Student::whereIn('id', $validated['student_ids'])->update(['user_id' => $user->id]);
        }

        return redirect()->route('admin.parents.index')->with('success', 'Parent created successfully.' . (isset($validated['password']) ? '' : " Auto-generated password: $password"));
    }

    public function show(User $parent)
    {
        if (!$parent->isParent()) {
            abort(403);
        }
        $parent->load('students.tuitionClass');
        return view('admin.parents.show', compact('parent'));
    }

    public function edit(User $parent)
    {
        if (!$parent->isParent()) {
            abort(403);
        }
        $parent->load('students');
        // Get all students that either have no parent or are currently linked to this parent
        $students = Student::where(function ($query) use ($parent) {
            $query->whereNull('user_id')
                ->orWhere('user_id', $parent->id);
        })->get();

        return view('admin.parents.edit', compact('parent', 'students'));
    }

    public function update(Request $request, User $parent)
    {
        if (!$parent->isParent()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $parent->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $parent->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        if (!empty($validated['password'])) {
            $parent->update(['password' => Hash::make($validated['password'])]);
        }

        // Sync students: first clear current associations, then add new ones
        Student::where('user_id', $parent->id)->update(['user_id' => null]);
        if (!empty($validated['student_ids'])) {
            Student::whereIn('id', $validated['student_ids'])->update(['user_id' => $parent->id]);
        }

        return redirect()->route('admin.parents.index')->with('success', 'Parent updated successfully.');
    }

    public function destroy(User $parent)
    {
        if (!$parent->isParent()) {
            abort(403);
        }

        // Students will have user_id set to null automatically due to nullOnDelete in migration
        $parent->delete();

        return redirect()->route('admin.parents.index')->with('success', 'Parent deleted successfully.');
    }
}
