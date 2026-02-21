<x-admin-layout>
    <div style="margin-bottom:24px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0 0 4px;">{{ $student->full_name }}</h1>
            <p style="color:#64748b; font-size:14px; margin:0;">Student Profile</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('students.edit', $student) }}" class="btn-primary">Edit Student</a>
            <a href="{{ route('students.index') }}" class="btn-secondary">← Back</a>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

        {{-- Personal Info --}}
        <div class="card">
            <h2
                style="font-size:15px; font-weight:700; color:#374151; margin:0 0 20px; display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" fill="none" stroke="#6366f1" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Personal Information
            </h2>
            <div style="display:flex; flex-direction:column; gap:14px;">
                <div
                    style="display:flex; justify-content:space-between; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                    <span style="font-size:13px; color:#94a3b8; font-weight:500;">Full Name</span>
                    <span style="font-size:14px; color:#0f172a; font-weight:600;">{{ $student->full_name }}</span>
                </div>
                <div
                    style="display:flex; justify-content:space-between; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                    <span style="font-size:13px; color:#94a3b8; font-weight:500;">Date of Birth</span>
                    <span
                        style="font-size:14px; color:#0f172a; font-weight:600;">{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d M Y') : '—' }}</span>
                </div>
                <div
                    style="display:flex; justify-content:space-between; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                    <span style="font-size:13px; color:#94a3b8; font-weight:500;">Gender</span>
                    <span
                        style="font-size:14px; color:#0f172a; font-weight:600;">{{ $student->gender ? ucfirst($student->gender) : '—' }}</span>
                </div>
                <div
                    style="display:flex; justify-content:space-between; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                    <span style="font-size:13px; color:#94a3b8; font-weight:500;">Email</span>
                    <span style="font-size:14px; color:#0f172a; font-weight:600;">{{ $student->email ?? '—' }}</span>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="font-size:13px; color:#94a3b8; font-weight:500;">Address</span>
                    <span
                        style="font-size:14px; color:#0f172a; font-weight:600; text-align:right; max-width:220px;">{{ $student->address ?? '—' }}</span>
                </div>
            </div>
        </div>

        {{-- Guardian & Class Info --}}
        <div class="card">
            <h2
                style="font-size:15px; font-weight:700; color:#374151; margin:0 0 20px; display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" fill="none" stroke="#6366f1" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Guardian &amp; Class
            </h2>
            <div style="display:flex; flex-direction:column; gap:14px;">
                <div
                    style="display:flex; justify-content:space-between; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                    <span style="font-size:13px; color:#94a3b8; font-weight:500;">Guardian Name</span>
                    <span style="font-size:14px; color:#0f172a; font-weight:600;">{{ $student->guardian_name }}</span>
                </div>
                <div
                    style="display:flex; justify-content:space-between; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                    <span style="font-size:13px; color:#94a3b8; font-weight:500;">Guardian Phone</span>
                    <span
                        style="font-size:14px; color:#0f172a; font-weight:600;">{{ $student->guardian_phone ?? '—' }}</span>
                </div>
                <div
                    style="display:flex; justify-content:space-between; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                    <span style="font-size:13px; color:#94a3b8; font-weight:500;">Roll No.</span>
                    <span style="font-size:14px; color:#0f172a; font-weight:600;">{{ $student->roll_no ?? '—' }}</span>
                </div>
                <div
                    style="display:flex; justify-content:space-between; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                    <span style="font-size:13px; color:#94a3b8; font-weight:500;">Batch / Class</span>
                    <span style="font-size:14px; color:#0f172a; font-weight:600;">
                        @if($student->tuitionClass)
                            <span class="badge badge-purple">{{ $student->tuitionClass->name }}</span>
                        @else
                            —
                        @endif
                    </span>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="font-size:13px; color:#94a3b8; font-weight:500;">Notes</span>
                    <span
                        style="font-size:14px; color:#0f172a; font-weight:600; text-align:right; max-width:220px;">{{ $student->notes ?? '—' }}</span>
                </div>
            </div>
        </div>

        {{-- Parent Account --}}
        <div class="card" style="grid-column:1/3;">
            <h2
                style="font-size:15px; font-weight:700; color:#374151; margin:0 0 16px; display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" fill="none" stroke="#6366f1" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Parent Portal Access
            </h2>

            @if(session('success'))
                <div
                    style="background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; padding:12px 16px; border-radius:10px; margin-bottom:16px; font-size:13px;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if($student->user_id)
                <div
                    style="background:#eef2ff; border:1px solid #c7d2fe; border-radius:12px; padding:14px 18px; display:flex; align-items:center; gap:12px;">
                    <span style="font-size:22px;">✅</span>
                    <div>
                        <div style="font-weight:700; color:#4338ca; font-size:14px;">Parent account is already linked</div>
                        <div style="color:#6366f1; font-size:13px; margin-top:2px;">This student's guardian can log in at
                            the same login page.</div>
                    </div>
                </div>
            @else
                <p style="font-size:13px; color:#64748b; margin:0 0 16px;">
                    Create a login account for this student's parent/guardian. They will be able to view attendance, fees,
                    and more on the parent portal.
                </p>
                <form action="{{ route('students.create-parent', $student) }}" method="POST"
                    style="display:flex; gap:10px; align-items:flex-end;">
                    @csrf
                    <div style="flex:1;">
                        <label
                            style="display:block; font-size:12px; font-weight:600; color:#374151; margin-bottom:6px;">Guardian
                            Email Address</label>
                        <input type="email" name="parent_email" required
                            style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;"
                            value="{{ old('parent_email', $student->guardian_email ?? '') }}"
                            placeholder="parent@email.com">
                        @error('parent_email')
                            <p style="color:#e11d48; font-size:12px; margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn-primary" style="white-space:nowrap;">
                        🔑 Create Parent Login
                    </button>
                </form>
            @endif
        </div>

    </div>
</x-admin-layout>
