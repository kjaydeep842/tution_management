<x-admin-layout>
    <div style="max-width:640px;">
        <div style="margin-bottom:28px;">
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0 0 4px;">Edit Branch — {{ $branch->name }}</h1>
            <p style="color:#64748b; font-size:14px; margin:0;">Update branch details</p>
        </div>

        <form action="{{ route('branches.update', $branch) }}" method="POST">
            @csrf @method('PUT')
            <div class="card" style="margin-bottom:20px;">
                <div style="display:flex; flex-direction:column; gap:20px;">
                    <div>
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Branch Name *</label>
                        <input type="text" name="name" class="input-field" required value="{{ old('name', $branch->name) }}">
                        @error('name') <p style="color:#e11d48; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Address</label>
                        <input type="text" name="address" class="input-field" value="{{ old('address', $branch->address) }}">
                    </div>
                    <div>
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Phone Number</label>
                        <input type="text" name="phone" class="input-field" value="{{ old('phone', $branch->phone) }}">
                    </div>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" id="is_active" {{ $branch->is_active ? 'checked' : '' }}
                            style="width:18px; height:18px; accent-color:#6366f1;">
                        <label for="is_active" style="font-size:14px; font-weight:600; color:#374151; cursor:pointer;">Branch is Active</label>
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:12px;">
                <button type="submit" class="btn-primary">Save Changes</button>
                <a href="{{ route('branches.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
