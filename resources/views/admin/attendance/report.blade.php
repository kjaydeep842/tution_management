<x-admin-layout>
    <style>
        .report-tab {
            padding: 8px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            color: #64748b;
            text-decoration: none;
            transition: all .15s;
        }

        .report-tab.active,
        .report-tab:hover {
            background: #6366f1;
            color: #fff;
            border-color: #6366f1;
        }

        .stat-box {
            background: #fff;
            border-radius: 14px;
            padding: 20px 24px;
            border: 1px solid #f1f5f9;
            text-align: center;
        }

        .stat-num {
            font-size: 32px;
            font-weight: 800;
        }

        .badge-present {
            background: #d1fae5;
            color: #065f46;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-absent {
            background: #fee2e2;
            color: #991b1b;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-late {
            background: #fef3c7;
            color: #92400e;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-none {
            background: #f1f5f9;
            color: #94a3b8;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
        }

        .filter-form input,
        .filter-form select {
            padding: 8px 12px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 13px;
            background: #f8fafc;
            outline: none;
        }

        .filter-form input:focus,
        .filter-form select:focus {
            border-color: #6366f1;
            background: #fff;
        }

        .grid-cell {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
        }

        .gc-P {
            background: #d1fae5;
            color: #065f46;
        }

        .gc-A {
            background: #fee2e2;
            color: #991b1b;
        }

        .gc-L {
            background: #fef3c7;
            color: #92400e;
        }

        .gc-x {
            background: #f1f5f9;
            color: #cbd5e1;
        }

        tfoot td {
            font-weight: 700;
            background: #f8fafc;
        }
    </style>

    <div
        style="margin-bottom:24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0 0 4px;">Attendance Report</h1>
            <p style="color:#64748b; font-size:14px; margin:0;">View and filter attendance records</p>
        </div>
        <a href="{{ route('attendance.index') }}" class="btn-secondary">← Mark Attendance</a>
    </div>

    {{-- Report Type Tabs --}}
    @php
        $rt = $reportType;
        $base = ['report_type' => '', 'class_id' => $class_id, 'student_id' => $student_id];
    @endphp
    <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:24px;">
        @foreach(['daily' => 'Daily', 'weekly' => 'This Week', 'monthly' => 'Monthly', 'custom' => 'Custom Range', 'student' => 'Student-Wise'] as $key => $label)
            <a href="{{ route('attendance.report', array_merge(request()->query(), ['report_type' => $key])) }}"
                class="report-tab {{ $rt === $key ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>

    {{-- Filters Form --}}
    <div class="card filter-form" style="margin-bottom:24px;">
        <form method="GET" action="{{ route('attendance.report') }}"
            style="display:flex; flex-wrap:wrap; gap:14px; align-items:flex-end;">
            <input type="hidden" name="report_type" value="{{ $rt }}">

            @if($rt === 'daily')
                <div>
                    <label
                        style="display:block; font-size:12px; font-weight:600; color:#64748b; margin-bottom:4px;">Date</label>
                    <input type="date" name="date" value="{{ request('date', now()->toDateString()) }}">
                </div>
            @elseif($rt === 'monthly')
                <div>
                    <label
                        style="display:block; font-size:12px; font-weight:600; color:#64748b; margin-bottom:4px;">Month</label>
                    <input type="month" name="month" value="{{ request('month', now()->format('Y-m')) }}">
                </div>
            @elseif($rt === 'custom' || $rt === 'student')
                <div>
                    <label
                        style="display:block; font-size:12px; font-weight:600; color:#64748b; margin-bottom:4px;">From</label>
                    <input type="date" name="from" value="{{ request('from', now()->startOfWeek()->toDateString()) }}">
                </div>
                <div>
                    <label
                        style="display:block; font-size:12px; font-weight:600; color:#64748b; margin-bottom:4px;">To</label>
                    <input type="date" name="to" value="{{ request('to', now()->toDateString()) }}">
                </div>
            @endif

            <div>
                <label style="display:block; font-size:12px; font-weight:600; color:#64748b; margin-bottom:4px;">Batch /
                    Class</label>
                <select name="class_id">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if($rt === 'student')
                <div>
                    <label
                        style="display:block; font-size:12px; font-weight:600; color:#64748b; margin-bottom:4px;">Student</label>
                    <select name="student_id">
                        <option value="">All Students</option>
                        @foreach($students as $s)
                            <option value="{{ $s->id }}" {{ $student_id == $s->id ? 'selected' : '' }}>{{ $s->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <button type="submit" class="btn-primary" style="padding:8px 20px;">Apply</button>
            <a href="{{ route('attendance.report', ['report_type' => $rt]) }}" class="btn-secondary"
                style="padding:8px 20px;">Reset</a>
        </form>
    </div>

    {{-- Date Range Label --}}
    <div style="margin-bottom:18px; font-size:13px; color:#64748b;">
        Showing records from <strong style="color:#0f172a;">{{ $from->format('d M Y') }}</strong>
        @if($from->toDateString() !== $to->toDateString())
            to <strong style="color:#0f172a;">{{ $to->format('d M Y') }}</strong>
        @endif
    </div>

    {{-- Summary Stats --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:28px;">
        <div class="stat-box">
            <div class="stat-num" style="color:#6366f1;">{{ $total }}</div>
            <div style="font-size:13px; color:#64748b; margin-top:4px;">Total Records</div>
        </div>
        <div class="stat-box">
            <div class="stat-num" style="color:#10b981;">{{ $present }}</div>
            <div style="font-size:13px; color:#64748b; margin-top:4px;">Present</div>
        </div>
        <div class="stat-box">
            <div class="stat-num" style="color:#ef4444;">{{ $absent }}</div>
            <div style="font-size:13px; color:#64748b; margin-top:4px;">Absent</div>
        </div>
        <div class="stat-box">
            <div class="stat-num" style="color:#f59e0b;">{{ $late }}</div>
            <div style="font-size:13px; color:#64748b; margin-top:4px;">Late</div>
        </div>
    </div>

    {{-- ===== STUDENT-WISE / CUSTOM: Date Grid View ===== --}}
    @if(in_array($rt, ['student', 'custom', 'weekly', 'monthly']))

        @if(count($reportStudents) > 0)
            <div class="card" style="overflow-x:auto;">
                <h2 style="font-size:15px; font-weight:700; color:#374151; margin:0 0 16px;">Student-wise Attendance Grid</h2>
                <table style="width:100%; border-collapse:collapse; min-width:600px;">
                    <thead>
                        <tr>
                            <th
                                style="text-align:left; padding:8px 12px; font-size:12px; color:#94a3b8; border-bottom:1px solid #f1f5f9; white-space:nowrap;">
                                Student</th>
                            @foreach($dates as $d)
                                <th
                                    style="padding:6px 4px; font-size:11px; color:#64748b; text-align:center; border-bottom:1px solid #f1f5f9; white-space:nowrap;">
                                    {{ \Carbon\Carbon::parse($d)->format('d') }}<br>
                                    <span style="color:#94a3b8;">{{ \Carbon\Carbon::parse($d)->format('D') }}</span>
                                </th>
                            @endforeach
                            <th
                                style="padding:8px 12px; font-size:12px; color:#94a3b8; text-align:center; border-bottom:1px solid #f1f5f9;">
                                P</th>
                            <th
                                style="padding:8px 12px; font-size:12px; color:#94a3b8; text-align:center; border-bottom:1px solid #f1f5f9;">
                                A</th>
                            <th
                                style="padding:8px 12px; font-size:12px; color:#94a3b8; text-align:center; border-bottom:1px solid #f1f5f9;">
                                L</th>
                            <th
                                style="padding:8px 12px; font-size:12px; color:#94a3b8; text-align:center; border-bottom:1px solid #f1f5f9;">
                                %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportStudents as $s)
                            @php
                                $sMap = $studentDateMap[$s->id] ?? [];
                                $sP = collect($sMap)->filter(fn($v) => $v === 'present')->count();
                                $sA = collect($sMap)->filter(fn($v) => $v === 'absent')->count();
                                $sL = collect($sMap)->filter(fn($v) => $v === 'late')->count();
                                $sTotal = $sP + $sA + $sL;
                                $pct = $sTotal > 0 ? round(($sP / $sTotal) * 100) : 0;
                            @endphp
                            <tr style="border-bottom:1px solid #f8fafc;">
                                <td style="padding:8px 12px; font-size:13px; font-weight:600; color:#0f172a; white-space:nowrap;">
                                    {{ $s->full_name }}</td>
                                @foreach($dates as $d)
                                    @php $st = $sMap[$d] ?? null; @endphp
                                    <td style="padding:4px; text-align:center;">
                                        @if($st === 'present')
                                            <div class="grid-cell gc-P" style="margin:auto;" title="{{ $d }} - Present">P</div>
                                        @elseif($st === 'absent')
                                            <div class="grid-cell gc-A" style="margin:auto;" title="{{ $d }} - Absent">A</div>
                                        @elseif($st === 'late')
                                            <div class="grid-cell gc-L" style="margin:auto;" title="{{ $d }} - Late">L</div>
                                        @else
                                            <div class="grid-cell gc-x" style="margin:auto;" title="{{ $d }} - Not Marked">–</div>
                                        @endif
                                    </td>
                                @endforeach
                                <td style="text-align:center; font-size:13px; color:#10b981; font-weight:700;">{{ $sP }}</td>
                                <td style="text-align:center; font-size:13px; color:#ef4444; font-weight:700;">{{ $sA }}</td>
                                <td style="text-align:center; font-size:13px; color:#f59e0b; font-weight:700;">{{ $sL }}</td>
                                <td style="text-align:center;">
                                    <span
                                        style="font-size:13px; font-weight:700; color:{{ $pct >= 75 ? '#10b981' : ($pct >= 50 ? '#f59e0b' : '#ef4444') }};">{{ $pct }}%</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="padding:8px 12px; font-size:12px; color:#374151;">Total</td>
                            @foreach($dates as $d)
                                @php
                                    $dayPresent = collect($studentDateMap)->filter(fn($m) => ($m[$d] ?? null) === 'present')->count();
                                    $dayTotal = collect($studentDateMap)->filter(fn($m) => isset($m[$d]))->count();
                                @endphp
                                <td style="text-align:center; font-size:11px; color:#64748b;">
                                    {{ $dayPresent }}/{{ $dayTotal }}
                                </td>
                            @endforeach
                            <td style="text-align:center; color:#10b981;">{{ $present }}</td>
                            <td style="text-align:center; color:#ef4444;">{{ $absent }}</td>
                            <td style="text-align:center; color:#f59e0b;">{{ $late }}</td>
                            <td style="text-align:center; color:#6366f1;">
                                {{ $total > 0 ? round(($present / $total) * 100) : 0 }}%
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="card" style="text-align:center; padding:48px; color:#94a3b8;">No attendance records found for the
                selected range.</div>
        @endif

        {{-- ===== DAILY VIEW ===== --}}
    @else
        <div class="card" style="overflow-x:auto;">
            <h2 style="font-size:15px; font-weight:700; color:#374151; margin:0 0 16px;">
                Daily Report — {{ $from->format('d M Y') }}
            </h2>
            @if($records->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th style="text-align:left;">#</th>
                            <th style="text-align:left;">Student</th>
                            <th style="text-align:left;">Class</th>
                            <th style="text-align:left;">Date</th>
                            <th style="text-align:center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $i => $rec)
                            <tr>
                                <td style="color:#94a3b8; font-size:13px;">{{ $i + 1 }}</td>
                                <td style="font-weight:600; color:#0f172a;">{{ $rec->student?->full_name ?? '—' }}</td>
                                <td style="color:#64748b; font-size:13px;">{{ $rec->tuitionClass?->name ?? '—' }}</td>
                                <td style="color:#64748b; font-size:13px;">{{ \Carbon\Carbon::parse($rec->date)->format('d M Y') }}
                                </td>
                                <td style="text-align:center;">
                                    @if($rec->status === 'present')
                                        <span class="badge-present">Present</span>
                                    @elseif($rec->status === 'absent')
                                        <span class="badge-absent">Absent</span>
                                    @elseif($rec->status === 'late')
                                        <span class="badge-late">Late</span>
                                    @else
                                        <span class="badge-none">{{ ucfirst($rec->status ?? '—') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align:center; padding:48px; color:#94a3b8;">No attendance records for this date.</p>
            @endif
        </div>
    @endif

</x-admin-layout>