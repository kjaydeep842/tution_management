<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Attendance Report - {{ $student->full_name }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #6366f1;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            color: #6366f1;
        }

        .header p {
            margin: 5px 0 0;
            color: #64748b;
        }

        .info-section {
            margin-bottom: 30px;
        }

        .info-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .info-grid td {
            padding: 5px 0;
        }

        .stats-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .stats-box {
            border: 1px solid #e2e8f0;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
        }

        .stats-value {
            font-size: 24px;
            font-weight: bold;
            color: #6366f1;
        }

        .stats-label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
        }

        table.attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table.attendance-table th {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 10px;
            text-align: left;
            font-size: 12px;
            color: #64748b;
        }

        table.attendance-table td {
            border-bottom: 1px solid #f1f5f9;
            padding: 10px;
            font-size: 13px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }

        .status-present {
            background: #d1fae5;
            color: #065f46;
        }

        .status-absent {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-late {
            background: #fef3c7;
            color: #92400e;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Attendance Report</h1>
        <p>{{ $monthName }} {{ $year }}</p>
    </div>

    <div class="info-section">
        <table class="info-grid">
            <tr>
                <td width="50%"><strong>Student:</strong> {{ $student->full_name }}</td>
                <td width="50%" align="right"><strong>Batch:</strong> {{ $student->tuitionClass->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Guardian:</strong> {{ $student->guardian_name }}</td>
                <td align="right"><strong>Student ID:</strong> #{{ $student->id }}</td>
            </tr>
        </table>
    </div>

    <table class="stats-grid">
        <tr>
            <td width="25%">
                <div class="stats-box">
                    <div class="stats-value">{{ $total }}</div>
                    <div class="stats-label">Total Days</div>
                </div>
            </td>
            <td width="25%">
                <div class="stats-box">
                    <div class="stats-value" style="color: #10b981;">{{ $present }}</div>
                    <div class="stats-label">Present</div>
                </div>
            </td>
            <td width="25%">
                <div class="stats-box">
                    <div class="stats-value" style="color: #ef4444;">{{ $absent }}</div>
                    <div class="stats-label">Absent</div>
                </div>
            </td>
            <td width="25%">
                <div class="stats-box">
                    <div class="stats-value">{{ $pct }}%</div>
                    <div class="stats-label">Attendance</div>
                </div>
            </td>
        </tr>
    </table>

    <h3>Daily Records</h3>
    <table class="attendance-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Day</th>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $date => $attendance)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($date)->format('l') }}</td>
                    <td>
                        @if($attendance)
                            <span class="status-badge status-{{ $attendance->status }}">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        @else
                            <span style="color: #94a3b8;">Not Marked</span>
                        @endif
                    </td>
                    <td>{{ $attendance->remarks ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generated on {{ now()->format('d M Y H:i') }} | {{ \App\Models\Setting::get('site_name', 'BrightMind') }}
    </div>
</body>

</html>