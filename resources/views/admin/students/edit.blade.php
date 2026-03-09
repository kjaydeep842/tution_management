<x-admin-layout>
    <div style="margin-bottom:28px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0 0 4px;">Edit Student</h1>
            <p style="color:#64748b; font-size:14px; margin:0;">Update details for {{ $student->full_name }}</p>
        </div>
        <a href="{{ route('students.show', $student) }}" class="btn-secondary">← Back to Profile</a>
    </div>

    <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data"
        style="max-w:900px;">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

            {{-- Personal Details --}}
            <div class="card">
                <h2
                    style="font-size:15px; font-weight:700; color:#374151; margin:0 0 20px; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                    Personal Details</h2>
                <div class="flex flex-col gap-4">
                    <div class="mb-4">
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Profile
                            Image</label>
                        @if($student->profile_image)
                            <div style="margin-bottom: 15px;">
                                <img src="{{ asset('storage/' . $student->profile_image) }}" alt="Profile Image"
                                    style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0;">
                            </div>
                        @endif
                        <input type="file" name="profile_image" class="input-field" accept="image/*">
                        @error('profile_image') <p style="color:#e11d48; font-size:12px; margin-top:4px;">{{ $message }}
                        </p> @enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">First
                                Name *</label>
                            <input type="text" name="first_name" class="input-field" required
                                value="{{ old('first_name', $student->first_name) }}">
                            @error('first_name') <p style="color:#e11d48; font-size:12px; margin-top:4px;">
                                {{ $message }}
                            </p> @enderror
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Last
                                Name *</label>
                            <input type="text" name="last_name" class="input-field" required
                                value="{{ old('last_name', $student->last_name) }}">
                        </div>
                    </div>

                    <div>
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Email
                            Address</label>
                        <input type="email" name="email" class="input-field" value="{{ old('email', $student->email) }}"
                            placeholder="student@example.com">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Date
                                of Birth</label>
                            <input type="date" name="dob" class="input-field"
                                value="{{ old('dob', $student->dob ? \Carbon\Carbon::parse($student->dob)->format('Y-m-d') : '') }}">
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Gender</label>
                            <select name="gender" class="input-field">
                                <option value="">— Select —</option>
                                <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>
                                    Male</option>
                                <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender', $student->gender) == 'Other' ? 'selected' : '' }}>
                                    Other</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Address</label>
                        <textarea name="address" class="input-field" rows="3" style="resize:vertical;"
                            placeholder="Student's home address">{{ old('address', $student->address) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Academic & Guardian --}}
            <div class="flex flex-col gap-6">
                <div class="card">
                    <h2
                        style="font-size:15px; font-weight:700; color:#374151; margin:0 0 20px; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                        Academic Details</h2>
                    <div class="flex flex-col gap-4">
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Assign
                                Batch / Class *</label>
                            <select name="tuition_class_id" class="input-field" required>
                                <option value="">— Select Batch —</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('tuition_class_id', $student->tuition_class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}{{ $class->branch ? ' · ' . $class->branch->name : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tuition_class_id') <p style="color:#e11d48; font-size:12px; margin-top:4px;">
                                {{ $message }}
                            </p> @enderror
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Roll
                                Number</label>
                            <input type="text" name="roll_no" class="input-field"
                                value="{{ old('roll_no', $student->roll_no) }}" placeholder="e.g. T-2024-001">
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Notes</label>
                            <textarea name="notes" class="input-field" rows="2"
                                style="resize:vertical;">{{ old('notes', $student->notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h2
                        style="font-size:15px; font-weight:700; color:#374151; margin:0 0 20px; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                        Guardian Details</h2>
                    <div class="flex flex-col gap-4">
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Guardian
                                Name *</label>
                            <input type="text" name="guardian_name" class="input-field" required
                                value="{{ old('guardian_name', $student->guardian_name) }}">
                            @error('guardian_name') <p style="color:#e11d48; font-size:12px; margin-top:4px;">
                                {{ $message }}
                            </p> @enderror
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Guardian
                                Phone *</label>
                            <input type="text" name="guardian_phone" class="input-field" required
                                value="{{ old('guardian_phone', $student->guardian_phone) }}">
                            @error('guardian_phone') <p style="color:#e11d48; font-size:12px; margin-top:4px;">
                                {{ $message }}
                            </p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:12px;">
            <button type="submit" class="btn-primary">Save Changes</button>
            <a href="{{ route('students.show', $student) }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</x-admin-layout>