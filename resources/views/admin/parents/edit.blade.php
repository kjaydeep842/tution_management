<x-admin-layout>
    <div style="margin-bottom:28px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0 0 4px;">Edit Parent</h1>
            <p style="color:#64748b; font-size:14px; margin:0;">Update parent account details and student associations.
            </p>
        </div>
        <a href="{{ route('admin.parents.index') }}" class="btn-secondary">← Back</a>
    </div>

    <form action="{{ route('admin.parents.update', $parent) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:24px;">
            {{-- Account Details --}}
            <div class="card">
                <h2
                    style="font-size:15px; font-weight:700; color:#374151; margin:0 0 20px; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                    Account Details</h2>
                <div style="display:flex; flex-direction:column; gap:16px;">
                    <div>
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Full
                            Name *</label>
                        <input type="text" name="name" class="input-field" required
                            value="{{ old('name', $parent->name) }}" placeholder="e.g. John Doe">
                        @error('name') <p style="color:#e11d48; font-size:12px; margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Email
                            Address *</label>
                        <input type="email" name="email" class="input-field" required
                            value="{{ old('email', $parent->email) }}" placeholder="parent@example.com">
                        @error('email') <p style="color:#e11d48; font-size:12px; margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Mobile
                            Number</label>
                        <input type="text" name="phone" class="input-field" value="{{ old('phone', $parent->phone) }}"
                            placeholder="+91 98765 43210">
                        @error('phone') <p style="color:#e11d48; font-size:12px; margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Security & Association --}}
            <div style="display:flex; flex-direction:column; gap:24px;">
                <div class="card">
                    <h2
                        style="font-size:15px; font-weight:700; color:#374151; margin:0 0 20px; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                        Security</h2>
                    <div style="display:flex; flex-direction:column; gap:16px;">
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">New
                                Password</label>
                            <input type="password" name="password" class="input-field"
                                placeholder="Leave blank to keep current">
                            <p style="color:#64748b; font-size:11px; margin-top:4px;">Only enter a password if you want
                                to change it.</p>
                            @error('password') <p style="color:#e11d48; font-size:12px; margin-top:4px;">{{ $message }}
                            </p> @enderror
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Confirm
                                Password</label>
                            <input type="password" name="password_confirmation" class="input-field">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h2
                        style="font-size:15px; font-weight:700; color:#374151; margin:0 0 20px; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                        Associate Students</h2>
                    <div>
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Select
                            Students</label>
                        <div
                            style="max-height: 200px; overflow-y: auto; padding: 10px; background: #f8fafc; border-radius: 12px; border: 1.5px solid #e2e8f0;">
                            @php $linkedIds = $parent->students->pluck('id')->toArray(); @endphp
                            @forelse($students as $student)
                                <label
                                    style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; cursor: pointer;">
                                    <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" {{ in_array($student->id, old('student_ids', $linkedIds)) ? 'checked' : '' }}
                                        style="width: 16px; height: 16px; accent-color: #6366f1;">
                                    <span style="font-size: 14px; color: #374151;">{{ $student->full_name }}
                                        ({{ $student->tuitionClass->name }})</span>
                                </label>
                            @empty
                                <p style="font-size:13px; color:#64748b; font-style:italic;">No students available.</p>
                            @endforelse
                        </div>
                        @error('student_ids') <p style="color:#e11d48; font-size:12px; margin-top:4px;">{{ $message }}
                        </p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:12px;">
            <button type="submit" class="btn-primary">Update Parent Account</button>
            <a href="{{ route('admin.parents.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</x-admin-layout>