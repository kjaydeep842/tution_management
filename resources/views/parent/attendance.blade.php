@extends('layouts.parent')
@section('content')
    <div
        style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size:22px; font-weight:800; color:#0f172a; margin:0 0 4px;">Attendance Record</h1>
            <p style="color:#64748b; font-size:14px; margin:0;">{{ $student->full_name }}</p>
        </div>
        <form method="GET" action="{{ route('parent.attendance') }}" style="display:flex; gap:8px; align-items:center;">
            <input type="month" name="month" value="{{ $month }}"
                style="padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; outline:none;">
            <button type="submit"
                style="padding:8px 16px; background:#6366f1; color:#fff; border:none; border-radius:10px; font-size:13px; font-weight:600; cursor:pointer;">Go</button>
        </form>
    </div>

    {{-- Monthly Stats --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(140px, 1fr)); gap:14px; margin-bottom:24px;">
        @foreach([['Present', $present, '#10b981'], ['Absent', $absent, '#ef4444'], ['Late', $late, '#f59e0b'], ['Attendance', $pct . '%', $pct >= 75 ? '#10b981' : ($pct >= 50 ? '#f59e0b' : '#ef4444')]] as [$label, $val, $col])
            <div class="card" style="text-align:center; padding:16px;">
                <div style="font-size:26px; font-weight:800; color:{{ $col }};">{{ $val }}</div>
                <div style="font-size:12px; color:#64748b; margin-top:2px;">{{ $label }}</div>
            </div>
        @endforeach
    </div>

    {{-- Calendar Grid --}}
    <div class="card">
        <h2 style="font-size:14px; font-weight:700; color:#374151; margin:0 0 16px;">
            {{ $from->format('F Y') }}
        </h2>

        <div style="overflow-x: auto;">
            <div style="min-width: 300px;">
                {{-- Day headers --}}
                <div style="display:grid; grid-template-columns:repeat(7,1fr); gap:6px; margin-bottom:6px;">
                    @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $d)
                        <div style="text-align:center; font-size:11px; font-weight:700; color:#94a3b8;">{{ $d }}</div>
                    @endforeach
                </div>

                {{-- Offset for first day --}}
                @php
                    $firstDay = \Carbon\Carbon::parse($dates[0])->dayOfWeekIso; // 1=Mon
                    $emptySlots = $firstDay - 1;
                @endphp

                <div style="display:grid; grid-template-columns:repeat(7,1fr); gap:6px;">
                    @for($i = 0; $i < $emptySlots; $i++)
                        <div></div>
                    @endfor

                    @foreach($dates as $date)
                        @php
                            $rec = $attendances[$date] ?? null;
                            $status = $rec?->status;
                            $bg = match ($status) {
                                'present' => '#d1fae5',
                                'absent' => '#fee2e2',
                                'late' => '#fef3c7',
                                default => '#f8fafc',
                            };
                            $color = match ($status) {
                                'present' => '#065f46',
                                'absent' => '#991b1b',
                                'late' => '#92400e',
                                default => '#cbd5e1',
                            };
                            $label = match ($status) {
                                'present' => 'P',
                                'absent' => 'A',
                                'late' => 'L',
                                default => \Carbon\Carbon::parse($date)->day,
                            };
                        @endphp
                        <div title="{{ $date }}{{ $status ? ' – ' . ucfirst($status) : '' }}" style="aspect-ratio:1; display:flex; flex-direction:column; align-items:center; justify-content:center;
                                                    background:{{ $bg }}; border-radius:10px; cursor:default;">
                            <span style="font-size:10px; color:#94a3b8;">{{ \Carbon\Carbon::parse($date)->day }}</span>
                            @if($status)
                                <span style="font-size:12px; font-weight:800; color:{{ $color }};">{{ $label }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Legend --}}
        <div
            style="display:flex; gap:16px; margin-top:16px; padding-top:12px; border-top:1px solid #f1f5f9; flex-wrap:wrap;">
            @foreach([['P', '#d1fae5', '#065f46', 'Present'], ['A', '#fee2e2', '#991b1b', 'Absent'], ['L', '#fef3c7', '#92400e', 'Late']] as [$l, $bg, $c, $label])
                <div style="display:flex; align-items:center; gap:6px;">
                    <div
                        style="width:22px; height:22px; background:{{ $bg }}; border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:800; color:{{ $c }};">
                        {{ $l }}
                    </div>
                    <span style="font-size:12px; color:#64748b;">{{ $label }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endsection