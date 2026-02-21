<x-admin-layout>
    <style>
        .ms-wrapper {
            position: relative;
        }

        .ms-trigger {
            width: 100%;
            min-height: 46px;
            padding: 8px 40px 8px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
            cursor: pointer;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            align-items: center;
            user-select: none;
            transition: border-color .2s;
            position: relative;
        }

        .ms-trigger:hover,
        .ms-trigger.open {
            border-color: #6366f1;
            background: #fff;
        }

        .ms-trigger::after {
            content: '▾';
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
            pointer-events: none;
        }

        .ms-trigger.open::after {
            content: '▴';
        }

        .ms-tag {
            background: #eef2ff;
            color: #4f46e5;
            font-size: 12px;
            font-weight: 600;
            padding: 3px 10px 3px 8px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .ms-tag .rm {
            cursor: pointer;
            color: #818cf8;
            font-size: 14px;
        }

        .ms-tag .rm:hover {
            color: #4f46e5;
        }

        .ms-placeholder {
            color: #94a3b8;
            font-size: 14px;
        }

        .ms-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .12);
            z-index: 1000;
            max-height: 260px;
            overflow-y: auto;
        }

        .ms-dropdown.open {
            display: block;
        }

        .ms-search {
            padding: 10px 14px;
            border-bottom: 1px solid #f1f5f9;
            position: sticky;
            top: 0;
            background: #fff;
        }

        .ms-search input {
            width: 100%;
            padding: 7px 12px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
        }

        .ms-search input:focus {
            border-color: #6366f1;
        }

        .ms-option {
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 14px;
            color: #374151;
            transition: background .15s;
        }

        .ms-option:hover {
            background: #f5f3ff;
        }

        .ms-option.selected {
            background: #eef2ff;
            color: #4f46e5;
            font-weight: 600;
        }

        .ms-option input[type=checkbox] {
            accent-color: #6366f1;
            width: 16px;
            height: 16px;
        }
    </style>

    <div style="max-width:700px;">
        <div style="margin-bottom:28px;">
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0 0 4px;">Edit Teacher —
                {{ $teacher->name }}</h1>
            <p style="color:#64748b; font-size:14px; margin:0;">Update teacher details</p>
        </div>

        @php
            $selSubjects = $teacher->subject_ids ?? array_filter(array_map('trim', explode(',', $teacher->subject_specialisation ?? '')));
            $selBranches = is_array($teacher->branch_id) ? $teacher->branch_id : ($teacher->branch_id ? [$teacher->branch_id] : []);
        @endphp

        <form action="{{ route('teachers.update', $teacher) }}" method="POST">
            @csrf @method('PUT')
            <div class="card" style="margin-bottom:20px;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                    <div style="grid-column:1/3;">
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Full
                            Name *</label>
                        <input type="text" name="name" class="input-field" required
                            value="{{ old('name', $teacher->name) }}">
                        @error('name') <p style="color:#e11d48; font-size:12px; margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Phone
                            Number</label>
                        <input type="text" name="phone" class="input-field" value="{{ old('phone', $teacher->phone) }}">
                    </div>
                    <div>
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Email
                            Address</label>
                        <input type="email" name="email" class="input-field"
                            value="{{ old('email', $teacher->email) }}">
                    </div>

                    {{-- Subject Multi-Select --}}
                    <div style="grid-column:1/3;">
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Subject
                            Specialisation <span style="font-weight:400; color:#94a3b8;">(select one or
                                more)</span></label>
                        <div class="ms-wrapper" id="subject-ms">
                            <div class="ms-trigger" onclick="toggleMS('subject-ms')">
                                <span class="ms-placeholder">Select subjects…</span>
                            </div>
                            <div class="ms-dropdown">
                                <div class="ms-search"><input type="text" placeholder="Search…"
                                        oninput="filterMS('subject-ms', this.value)"></div>
                                @foreach($subjects as $subject)
                                    @php $chk = in_array($subject, old('subjects', (array) $selSubjects)); @endphp
                                    <label class="ms-option{{ $chk ? ' selected' : '' }}" data-value="{{ $subject }}">
                                        <input type="checkbox" name="subjects[]" value="{{ $subject }}" {{ $chk ? 'checked' : '' }} onchange="updateTags('subject-ms')">
                                        {{ $subject }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Branch Multi-Select --}}
                    <div style="grid-column:1/3;">
                        <label
                            style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Branch
                            <span style="font-weight:400; color:#94a3b8;">(select one or more)</span></label>
                        <div class="ms-wrapper" id="branch-ms">
                            <div class="ms-trigger" onclick="toggleMS('branch-ms')">
                                <span class="ms-placeholder">Select branches…</span>
                            </div>
                            <div class="ms-dropdown">
                                @foreach($branches as $branch)
                                    @php $chk = in_array($branch->id, old('branch_ids', $selBranches)); @endphp
                                    <label class="ms-option{{ $chk ? ' selected' : '' }}" data-value="{{ $branch->id }}">
                                        <input type="checkbox" name="branch_ids[]" value="{{ $branch->id }}" {{ $chk ? 'checked' : '' }} onchange="updateTags('branch-ms')">
                                        {{ $branch->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div style="grid-column:1/3; display:flex; align-items:center; gap:10px;">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" id="is_active" {{ $teacher->is_active ? 'checked' : '' }} style="width:18px; height:18px; accent-color:#6366f1;">
                        <label for="is_active"
                            style="font-size:14px; font-weight:600; color:#374151; cursor:pointer;">Teacher is
                            Active</label>
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:12px;">
                <button type="submit" class="btn-primary">Save Changes</button>
                <a href="{{ route('teachers.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        function toggleMS(id) {
            const w = document.getElementById(id), t = w.querySelector('.ms-trigger'), d = w.querySelector('.ms-dropdown');
            const open = d.classList.contains('open');
            document.querySelectorAll('.ms-dropdown.open').forEach(x => x.classList.remove('open'));
            document.querySelectorAll('.ms-trigger.open').forEach(x => x.classList.remove('open'));
            if (!open) { d.classList.add('open'); t.classList.add('open'); }
        }
        function updateTags(id) {
            const w = document.getElementById(id), t = w.querySelector('.ms-trigger'), ph = t.querySelector('.ms-placeholder');
            const cbs = w.querySelectorAll('input[type=checkbox]:checked');
            t.querySelectorAll('.ms-tag').forEach(x => x.remove());
            if (!cbs.length) { if (ph) ph.style.display = ''; }
            else {
                if (ph) ph.style.display = 'none';
                cbs.forEach(cb => {
                    const tag = document.createElement('span'); tag.className = 'ms-tag';
                    const lbl = cb.closest('label');
                    tag.innerHTML = (lbl ? lbl.textContent.trim() : cb.value) + '<span class="rm" onclick="removeTag(event,\'' + id + '\',\'' + cb.value.replace(/'/g, "\\'") + '\')">×</span>';
                    t.insertBefore(tag, ph || null);
                });
            }
            w.querySelectorAll('.ms-option').forEach(o => { const c = o.querySelector('input[type=checkbox]'); o.classList.toggle('selected', c && c.checked); });
        }
        function removeTag(e, id, val) {
            e.stopPropagation();
            const cb = document.getElementById(id).querySelector('input[value="' + val + '"]');
            if (cb) cb.checked = false;
            updateTags(id);
        }
        function filterMS(id, q) {
            document.getElementById(id).querySelectorAll('.ms-option').forEach(o => {
                o.style.display = o.textContent.trim().toLowerCase().includes(q.toLowerCase()) ? '' : 'none';
            });
        }
        document.addEventListener('click', e => {
            if (!e.target.closest('.ms-wrapper')) {
                document.querySelectorAll('.ms-dropdown.open').forEach(d => d.classList.remove('open'));
                document.querySelectorAll('.ms-trigger.open').forEach(t => t.classList.remove('open'));
            }
        });
        document.addEventListener('DOMContentLoaded', () => { updateTags('subject-ms'); updateTags('branch-ms'); });
    </script>
</x-admin-layout>