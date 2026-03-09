<x-admin-layout>
    <div style="margin-bottom:28px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0 0 4px;">Enroll New Student</h1>
            <p style="color:#64748b; font-size:14px; margin:0;">
                @if($inquiry) Pre-filled from inquiry — verify and complete the details. @else Add a new student to the
                system. @endif
            </p>
        </div>
        <a href="{{ $inquiry ? route('inquiries.index') : route('students.index') }}" class="btn-secondary">← Back</a>
    </div>

    @if($inquiry)
        <div
            style="background:#eef2ff; border:1.5px solid #c7d2fe; border-radius:14px; padding:14px 20px; margin-bottom:24px; display:flex; align-items:center; gap:12px;">
            <svg width="20" height="20" fill="none" stroke="#6366f1" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span style="font-size:14px; color:#4338ca; font-weight:500;">
                Converting inquiry from <strong>{{ $inquiry->name }}</strong> ({{ $inquiry->contact }}).
                Fields have been pre-filled — please review before enrolling.
            </span>
        </div>
    @endif

    @php
        // Split inquiry name into first/last for pre-fill
        $nameParts = $inquiry ? explode(' ', trim($inquiry->name), 2) : ['', ''];
        $firstName = old('first_name', $nameParts[0] ?? '');
        $lastName = old('last_name', $nameParts[1] ?? '');
        $guardPhone = old('guardian_phone', $inquiry->contact ?? '');
        $preClassId = old('tuition_class_id', $inquiry->tuition_class_id ?? '');
    @endphp

    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Pass inquiry_id so controller can mark it converted --}}
        @if($inquiry)
            <input type="hidden" name="inquiry_id" value="{{ $inquiry->id }}">
        @endif

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
                        <input type="file" name="profile_image" class="input-field" accept="image/*">
                        @error('profile_image') <p style="color:#e11d48; font-size:12px; margin-top:4px;">{{ $message }}
                        </p> @enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">First
                                Name *</label>
                            <input type="text" name="first_name" class="input-field" required value="{{ $firstName }}"
                                placeholder="e.g. Rahul">
                            @error('first_name') <p style="color:#e11d48; font-size:12px; margin-top:4px;">
                                {{ $message }}
                            </p> @enderror
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Last
                                Name *</label>
                            <input type="text" name="last_name" class="input-field" required value="{{ $lastName }}"
                                placeholder="e.g. Sharma">
                            @error('last_name') <p style="color:#e11d48; font-size:12px; margin-top:4px;">{{ $message }}
                            </p> @enderror
                        </div>
                    </div>

                    <div>
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Email
                            Address</label>
                        <input type="email" name="email" class="input-field" value="{{ old('email') }}"
                            placeholder="student@example.com">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Date
                                of Birth</label>
                            <input type="date" name="dob" class="input-field" value="{{ old('dob') }}">
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Gender</label>
                            <select name="gender" class="input-field">
                                <option value="">— Select —</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Address</label>
                        <textarea name="address" class="input-field" rows="3" style="resize:vertical;"
                            placeholder="Student's home address">{{ old('address') }}</textarea>
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
                                    <option value="{{ $class->id }}" {{ $preClassId == $class->id ? 'selected' : '' }}>
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
                            <input type="text" name="roll_no" class="input-field" value="{{ old('roll_no') }}"
                                placeholder="e.g. T-2024-001">
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Notes</label>
                            <textarea name="notes" class="input-field" rows="2" style="resize:vertical;"
                                placeholder="Any additional notes">{{ old('notes', $inquiry->notes ?? '') }}</textarea>
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
                                value="{{ old('guardian_name') }}" placeholder="Parent / Guardian name">
                            @error('guardian_name') <p style="color:#e11d48; font-size:12px; margin-top:4px;">
                                {{ $message }}
                            </p> @enderror
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Guardian
                                Phone *</label>
                            <input type="text" name="guardian_phone" class="input-field" required
                                value="{{ $guardPhone }}" placeholder="+91 98765 43210">
                            @error('guardian_phone') <p style="color:#e11d48; font-size:12px; margin-top:4px;">
                                {{ $message }}
                            </p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:12px;">
            <button type="submit" class="btn-primary">
                {{ $inquiry ? '✓ Enroll & Convert Inquiry' : 'Enroll Student' }}
            </button>
            <a href="{{ $inquiry ? route('inquiries.index') : route('students.index') }}"
                class="btn-secondary">Cancel</a>
        </div>
    </form>
</x-admin-layout>