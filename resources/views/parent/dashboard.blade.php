@extends('layouts.parent')
@section('content')
    <div style="margin-bottom:28px;">
        <h1 style="font-size:24px; font-weight:800; color:#0f172a; margin:0 0 4px;">Welcome back!</h1>
        <p style="color:#64748b; font-size:14px; margin:0;">Here's an overview for
            <strong>{{ $student->full_name }}</strong>
        </p>
    </div>

    {{-- Student Info Banner --}}
    <div class="card"
        style="margin-bottom:24px; display:flex; align-items:center; gap:24px; background:linear-gradient(135deg, #6366f1, #8b5cf6); color:#fff; border:none; flex-wrap: wrap; padding: 20px;">
        <div
            style="width:60px; height:60px; border-radius:50%; background:rgba(255,255,255,0.25); display:flex; align-items:center; justify-content:center; font-size:24px; font-weight:800; flex-shrink:0;">
            {{ strtoupper(substr($student->first_name, 0, 1)) }}
        </div>
        <div>
            <div style="font-size:20px; font-weight:800;">{{ $student->full_name }}</div>
            <div style="opacity:.85; font-size:14px;">
                {{ $student->tuitionClass->name ?? 'No batch assigned' }}
                @if($student->roll_no) &nbsp;·&nbsp; Roll No. {{ $student->roll_no }} @endif
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-grid"
        style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px, 1fr)); gap:16px; margin-bottom:24px;">
        <div class="card" style="text-align:center; padding: 16px;">
            <div
                style="font-size:28px; font-weight:800; color:{{ $pct >= 75 ? '#10b981' : ($pct >= 50 ? '#f59e0b' : '#ef4444') }};">
                {{ $pct }}%
            </div>
            <div style="font-size:12px; color:#64748b; margin-top:4px;">Attendance (30d)</div>
        </div>
        <div class="card" style="text-align:center; padding: 16px;">
            <div style="font-size:28px; font-weight:800; color:#10b981;">{{ $present }}</div>
            <div style="font-size:12px; color:#64748b; margin-top:4px;">Days Present</div>
        </div>
        <div class="card" style="text-align:center; padding: 16px;">
            <div style="font-size:28px; font-weight:800; color:#ef4444;">{{ $absent }}</div>
            <div style="font-size:12px; color:#64748b; margin-top:4px;">Days Absent</div>
        </div>
        <div class="card" style="text-align:center; padding: 16px;">
            <div style="font-size:28px; font-weight:800; color:#f59e0b;">₹{{ number_format($feesDue, 0) }}</div>
            <div style="font-size:12px; color:#64748b; margin-top:4px;">Fees Pending</div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:24px; margin-bottom: 24px;">
        {{-- Progress Report Section --}}
        <div class="card">
            <h2
                style="font-size:15px; font-weight:700; color:#374151; margin:0 0 16px; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                Student Progress Report</h2>
            @if($performanceReports->count())
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($performanceReports as $report)
                        <div
                            style="padding: 12px; border: 1px solid #f1f5f9; border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-size: 13px; font-weight: 700; color: #0f172a;">
                                    {{ $report->report_date->format('F Y') }}</div>
                                <div style="font-size: 11px; color: #64748b;">Status: {{ $report->overall_performance }}</div>
                            </div>
                            <a href="{{ route('parent.performance.download', $report) }}"
                                style="font-size: 11px; color: #6366f1; font-weight: 700; text-decoration: none; padding: 6px 10px; background: #eef2ff; border-radius: 6px;">Download</a>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="color:#94a3b8; text-align:center; padding:24px 0;">No progress reports yet.</p>
            @endif
            <div style="margin-top:14px;">
                <a href="{{ route('parent.performance') }}"
                    style="font-size:13px; color:#6366f1; font-weight:600; text-decoration:none;">View all reports →</a>
            </div>
        </div>

        {{-- Recent Absences --}}
        <div class="card">
            <h2
                style="font-size:15px; font-weight:700; color:#374151; margin:0 0 16px; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                Recent Absences</h2>
            @if($recentAbsent->count())
                <table style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAbsent as $a)
                            <tr>
                                <td style="font-weight:600;">{{ \Carbon\Carbon::parse($a->date)->format('d M Y') }}</td>
                                <td><span class="badge-absent">Absent</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="color:#94a3b8; text-align:center; padding:24px 0;">No absences recently 🎉</p>
            @endif
            <div style="margin-top:14px;">
                <a href="{{ route('parent.attendance') }}"
                    style="font-size:13px; color:#6366f1; font-weight:600; text-decoration:none;">View full attendance
                    →</a>
            </div>
        </div>

        {{-- Fee Summary --}}
        <div class="card">
            <h2
                style="font-size:15px; font-weight:700; color:#374151; margin:0 0 16px; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                Fee Summary</h2>
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div
                    style="display:flex; justify-content:space-between; align-items:center; padding:10px 14px; background:#f0fdf4; border-radius:10px;">
                    <span style="font-size:14px; color:#374151; font-weight:500;">Total Paid</span>
                    <span style="font-size:16px; font-weight:800; color:#10b981;">₹{{ number_format($feesPaid, 0) }}</span>
                </div>
                <div
                    style="display:flex; justify-content:space-between; align-items:center; padding:10px 14px; background:#fef2f2; border-radius:10px;">
                    <span style="font-size:14px; color:#374151; font-weight:500;">Pending / Due</span>
                    <span style="font-size:16px; font-weight:800; color:#ef4444;">₹{{ number_format($feesDue, 0) }}</span>
                </div>
            </div>
            <div style="margin-top:14px;">
                <a href="{{ route('parent.fees') }}"
                    style="font-size:13px; color:#6366f1; font-weight:600; text-decoration:none;">View all fees →</a>
            </div>
        </div>
    </div>
@endsection