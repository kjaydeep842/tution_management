@extends('layouts.parent')

@section('content')
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">My Profile</h1>
        <p style="color: #64748b; font-size: 14px; margin: 0;">Manage your account information and password.</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        {{-- Profile Info Card --}}
        <div class="card">
            <h2
                style="font-size: 16px; font-weight: 700; color: #374151; margin: 0 0 20px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                Account Details</h2>
            <form action="{{ route('parent.profile.update') }}" method="POST">
                @csrf
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div>
                        <label
                            style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Your
                            Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            style="width: 100%; padding: 12px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; outline: none; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99, 102, 241, 0.1)'"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                        @error('name') <p style="color: #e11d48; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Email
                            Address</label>
                        <input type="email" value="{{ $user->email }}" disabled
                            style="width: 100%; padding: 12px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; background: #f8fafc; color: #64748b;">
                        <p style="font-size: 12px; color: #94a3b8; margin-top: 6px;">Email address cannot be changed. Please
                            contact admin for changes.</p>
                    </div>

                    <div style="margin-top: 10px; padding-top: 20px; border-top: 1px solid #f1f5f9;">
                        <h3 style="font-size: 15px; font-weight: 700; color: #374151; margin-bottom: 16px;">Update Password
                        </h3>

                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            <div>
                                <label
                                    style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">New
                                    Password</label>
                                <input type="password" name="password" placeholder="Leave blank to keep current"
                                    style="width: 100%; padding: 12px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99, 102, 241, 0.1)'"
                                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                @error('password') <p style="color: #e11d48; font-size: 12px; margin-top: 6px;">
                                {{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label
                                    style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Confirm
                                    New Password</label>
                                <input type="password" name="password_confirmation"
                                    style="width: 100%; padding: 12px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99, 102, 241, 0.1)'"
                                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 12px;">
                        <button type="submit"
                            style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; padding: 12px 24px; border: none; border-radius: 12px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);">
                            Save Profile Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Linked Students Info --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="card">
                <h2 style="font-size: 16px; font-weight: 700; color: #374151; margin: 0 0 16px;">Linked Students</h2>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @php $parent = auth()->user()->load('students.tuitionClass'); @endphp
                    @foreach($parent->students as $s)
                        <div
                            style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: #f8fafc; border-radius: 12px; border: 1px solid #f1f5f9;">
                            <div>
                                <p style="font-size: 14px; font-weight: 700; color: #0f172a; margin: 0;">{{ $s->full_name }}</p>
                                <p style="font-size: 12px; color: #64748b; margin: 2px 0 0;">{{ $s->tuitionClass->name }}</p>
                            </div>
                            <span class="badge-present">Active</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card" style="background: #eff6ff; border-color: #dbeafe;">
                <div style="display: flex; gap: 12px;">
                    <div style="color: #3b82f6;">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-size: 14px; font-weight: 700; color: #1e40af; margin: 0 0 4px;">Portal Security</h3>
                        <p style="font-size: 13px; color: #3b82f6; margin: 0; line-height: 1.5;">Protect your account by
                            using a strong password. If you suspect any unauthorized access, change your password
                            immediately or contact our support team.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection