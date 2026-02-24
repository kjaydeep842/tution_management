<x-admin-layout>
    <style>
        /* ---- Custom Multi-Select Dropdown ---- */
        .ms-wrapper { position: relative; }
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
        .ms-trigger:hover, .ms-trigger.open { border-color: #6366f1; background: #fff; }
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
        .ms-trigger.open::after { content: '▴'; }
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
        .ms-tag .rm { cursor: pointer; color: #818cf8; font-size: 14px; line-height: 1; }
        .ms-tag .rm:hover { color: #4f46e5; }
        .ms-placeholder { color: #94a3b8; font-size: 14px; }
        .ms-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            left: 0; right: 0;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0,0,0,.12);
            z-index: 1000;
            overflow: hidden;
            max-height: 260px;
            overflow-y: auto;
        }
        .ms-dropdown.open { display: block; }
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
            background: #f8fafc;
        }
        .ms-search input:focus { border-color: #6366f1; background: #fff; }
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
        .ms-option:hover { background: #f5f3ff; }
        .ms-option.selected { background: #eef2ff; color: #4f46e5; font-weight: 600; }
        .ms-option input[type=checkbox] { accent-color: #6366f1; width: 16px; height: 16px; }
        .ms-empty { padding: 16px; text-align: center; color: #94a3b8; font-size: 13px; }
    </style>

    <div style="max-width:720px;">
        <div style="margin-bottom:28px;">
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0 0 4px;">Create New Batch</h1>
            <p style="color:#64748b; font-size:14px; margin:0;">Set up a new tuition class and assign a teacher.</p>
        </div>

        <form action="{{ route('tuition-classes.store') }}" method="POST" id="batchForm">
            @csrf
            <div class="card" style="margin-bottom:20px;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

                    {{-- Batch Name --}}
                    <div style="grid-column:1/3;">
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Batch / Class Name *</label>
                        <input type="text" name="name" class="input-field" required value="{{ old('name') }}" placeholder="e.g. Grade 12 – Commerce A">
                        @error('name') <p style="color:#e11d48; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                    </div>

                    {{-- Subject Multi-Select --}}
                    <div style="grid-column:1/3;">
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Subjects * <span style="font-weight:400; color:#94a3b8;">(select one or more)</span></label>
                        <div class="ms-wrapper" id="subject-ms">
                            <div class="ms-trigger" onclick="toggleMS('subject-ms')">
                                <span class="ms-placeholder" id="subject-ms-placeholder">Select subjects…</span>
                            </div>
                            <div class="ms-dropdown" id="subject-ms-dropdown">
                                <div class="ms-search"><input type="text" placeholder="Search subject…" oninput="filterMS('subject-ms', this.value)"></div>
                                @foreach($subjects as $subject)
                                    <label class="ms-option{{ in_array($subject, old('subjects', [])) ? ' selected' : '' }}" data-value="{{ $subject }}">
                                        <input type="checkbox" name="subjects[]" value="{{ $subject }}"
                                            {{ in_array($subject, old('subjects', [])) ? 'checked' : '' }}
                                            onchange="updateTags('subject-ms')">
                                        {{ $subject }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @error('subjects') <p style="color:#e11d48; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                    </div>

                    {{-- Branch Multi-Select --}}
                    <div>
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Branch <span style="font-weight:400; color:#94a3b8;">(select one or more)</span></label>
                        <div class="ms-wrapper" id="branch-ms">
                            <div class="ms-trigger" onclick="toggleMS('branch-ms')">
                                <span class="ms-placeholder" id="branch-ms-placeholder">Select branches…</span>
                            </div>
                            <div class="ms-dropdown" id="branch-ms-dropdown">
                                @foreach($branches as $branch)
                                    <label class="ms-option{{ in_array($branch->id, old('branch_ids', [])) ? ' selected' : '' }}" data-value="{{ $branch->id }}">
                                        <input type="checkbox" name="branch_ids[]" value="{{ $branch->id }}"
                                            {{ in_array($branch->id, old('branch_ids', [])) ? 'checked' : '' }}
                                            onchange="updateTags('branch-ms')">
                                        {{ $branch->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Teacher --}}
                    <div>
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Assign Teacher</label>
                        <select name="teacher_id" class="input-field">
                            <option value="">— Not Assigned —</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}{{ $teacher->branch ? ' (' . $teacher->branch->name . ')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Schedule --}}
                    <div>
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">Schedule / Timing</label>
                        <input type="text" name="schedule_info" class="input-field" value="{{ old('schedule_info') }}" placeholder="e.g. Mon/Wed/Fri – 4:00 PM to 5:30 PM">
                    </div>

                    {{-- Class Start Time (for absence cron job) --}}
                    <div>
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;">
                            Class Start Time
                            <span style="font-weight:400; color:#94a3b8;">(for absent email — sent 30 min after)</span>
                        </label>
                        <input type="time" name="class_time" class="input-field" value="{{ old('class_time') }}"
                               style="max-width:200px;">
                        @error('class_time') <p style="color:#e11d48; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:12px;">
                <button type="submit" class="btn-primary">Create Batch</button>
                <a href="{{ route('tuition-classes.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        function toggleMS(id) {
            const wrapper  = document.getElementById(id);
            const trigger  = wrapper.querySelector('.ms-trigger');
            const dropdown = wrapper.querySelector('.ms-dropdown');
            const isOpen   = dropdown.classList.contains('open');
            // Close all
            document.querySelectorAll('.ms-dropdown.open').forEach(d => d.classList.remove('open'));
            document.querySelectorAll('.ms-trigger.open').forEach(t => t.classList.remove('open'));
            if (!isOpen) {
                dropdown.classList.add('open');
                trigger.classList.add('open');
            }
        }

        function updateTags(id) {
            const wrapper     = document.getElementById(id);
            const trigger     = wrapper.querySelector('.ms-trigger');
            const placeholder = wrapper.querySelector('.ms-placeholder') || wrapper.querySelector('span[id$="-placeholder"]');
            const checkboxes  = wrapper.querySelectorAll('input[type=checkbox]:checked');

            // Remove old tags
            trigger.querySelectorAll('.ms-tag').forEach(t => t.remove());
            const ph = trigger.querySelector('.ms-placeholder');

            if (checkboxes.length === 0) {
                if (ph) ph.style.display = '';
            } else {
                if (ph) ph.style.display = 'none';
                checkboxes.forEach(cb => {
                    const tag = document.createElement('span');
                    tag.className = 'ms-tag';
                    tag.dataset.val = cb.value;
                    const label = cb.closest('label');
                    tag.innerHTML = (label ? label.textContent.trim() : cb.value)
                        + '<span class="rm" onclick="removeTag(event, \'' + id + '\', \'' + cb.value.replace(/'/g,"\\'")+'\')">×</span>';
                    trigger.insertBefore(tag, ph || null);
                });
            }
            // Update selected styling on options
            wrapper.querySelectorAll('.ms-option').forEach(opt => {
                const cb = opt.querySelector('input[type=checkbox]');
                opt.classList.toggle('selected', cb && cb.checked);
            });
        }

        function removeTag(e, id, val) {
            e.stopPropagation();
            const wrapper = document.getElementById(id);
            const cb = wrapper.querySelector('input[value="' + val + '"]');
            if (cb) { cb.checked = false; }
            updateTags(id);
        }

        function filterMS(id, query) {
            const wrapper = document.getElementById(id);
            wrapper.querySelectorAll('.ms-option').forEach(opt => {
                const label = opt.querySelector('input') ? opt.textContent.trim().toLowerCase() : '';
                opt.style.display = label.includes(query.toLowerCase()) ? '' : 'none';
            });
        }

        // Close on outside click
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.ms-wrapper')) {
                document.querySelectorAll('.ms-dropdown.open').forEach(d => d.classList.remove('open'));
                document.querySelectorAll('.ms-trigger.open').forEach(t => t.classList.remove('open'));
            }
        });

        // Init tags for old() values on page load
        document.addEventListener('DOMContentLoaded', () => {
            updateTags('subject-ms');
            updateTags('branch-ms');
        });
    </script>
</x-admin-layout>