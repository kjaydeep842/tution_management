<x-admin-layout>
    <div style="max-width:640px;">
        <div style="margin-bottom:28px;">
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0 0 4px;">Add New Branch</h1>
            <p style="color:#64748b; font-size:14px; margin:0;">Create a new tuition centre location</p>
        </div>

        <form action="{{ route('branches.store') }}" method="POST">
            @csrf
            <div class="card" style="margin-bottom:20px;">
                <div style="display:flex; flex-direction:column; gap:20px;">
                    <div>
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Branch
                            Name *</label>
                        <input type="text" name="name" class="input-field" required value="{{ old('name') }}"
                            placeholder="e.g. Nikol, Naroda …">
                        @error('name') <p style="color:#e11d48; font-size:12px; margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Address</label>
                        <input type="text" name="address" class="input-field" value="{{ old('address') }}"
                            placeholder="e.g. 102 Main Road, Nikol, Ahmedabad">
                    </div>
                    <div>
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Phone
                            Number</label>
                        <input type="text" name="phone" class="input-field" value="{{ old('phone') }}"
                            placeholder="e.g. 98765 43210">
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:12px;">
                <button type="submit" class="btn-primary">Create Branch</button>
                <a href="{{ route('branches.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>