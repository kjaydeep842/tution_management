<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Performance Report</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #4f46e5;
            margin-bottom: 30px;
            padding-bottom: 10px;
        }

        .title {
            font-size: 24px;
            font-bold;
            color: #4f46e5;
            margin: 0;
        }

        .subtitle {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            background: #f3f4f6;
            padding: 5px 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .student-info {
            margin-bottom: 30px;
            width: 100%;
            border-collapse: collapse;
        }

        .student-info td {
            padding: 5px;
            font-size: 14px;
        }

        .label {
            font-weight: bold;
            color: #666;
            width: 30%;
        }

        .subject-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .subject-table th,
        .subject-table td {
            padding: 10px;
            border: 1px solid #e5e7eb;
            text-align: left;
            font-size: 13px;
        }

        .subject-table th {
            background: #f9fafb;
            font-weight: bold;
        }

        .tag {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 11px;
            margin-right: 5px;
        }

        .tag-green {
            background: #dcfce7;
            color: #166534;
        }

        .tag-red {
            background: #fee2e2;
            color: #991b1b;
        }

        .suggestions {
            font-size: 14px;
            color: #444;
            white-space: pre-line;
            background: #fffbeb;
            border: 1px solid #fef3c7;
            padding: 15px;
            border-radius: 8px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }

        .performance-bar {
            width: 100%;
            background: #eee;
            height: 10px;
            border-radius: 5px;
            margin-top: 5px;
        }

        .performance-fill {
            height: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 class="title">STUDENT PERFORMANCE REPORT</h1>
        <p class="subtitle">Personalized Academic Assessment and Growth Plan</p>
    </div>

    <div class="section">
        <table class="student-info">
            <tr>
                <td class="label">Student Name:</td>
                <td>{{ $report->student->full_name }}</td>
                <td class="label">Report Date:</td>
                <td>{{ $report->report_date->format('M d, Y') }}</td>
            </tr>
            <tr>
                <td class="label">Roll Number:</td>
                <td>{{ $report->student->roll_no ?? 'N/A' }}</td>
                <td class="label">Class:</td>
                <td>{{ $report->student->tuitionClass->name }}</td>
            </tr>
            <tr>
                <td class="label">Teacher:</td>
                <td>{{ $report->teacher->name }}</td>
                <td class="label">Status:</td>
                <td><strong>{{ $report->overall_performance }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Academic Subject Analysis</div>
        <table class="subject-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Average Score (%)</th>
                    <th>Analysis</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report->marks_data as $subject => $percent)
                    <tr>
                        <td>{{ $subject }}</td>
                        <td width="30%">
                            {{ round($percent) }}%
                            <div class="performance-bar">
                                <div class="performance-fill"
                                    style="width:{{ $percent }}%; background: {{ $percent < 45 ? '#ef4444' : ($percent > 75 ? '#22c55e' : '#4f46e5') }}">
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($percent < 45)
                                <span class="tag tag-red">Needs Focus</span>
                            @elseif($percent > 75)
                                <span class="tag tag-green">Strong Hold</span>
                            @else
                                <span style="color: #666">Satisfactory</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Strengths & Improvement Areas</div>
        <div style="margin-top: 10px;">
            <p><strong>Strong Subjects:</strong>
                @forelse($report->strong_subjects ?? [] as $s) {{ $s }}{{ !$loop->last ? ',' : '' }} @empty None
                identified @endforelse
            </p>
            <p><strong>Weak Subjects:</strong>
                @forelse($report->weak_subjects ?? [] as $s) {{ $s }}{{ !$loop->last ? ',' : '' }} @empty None
                identified @endforelse
            </p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Teacher's Recommendations & Management Strategy</div>
        <div class="suggestions">
            {{ $report->suggestions }}
        </div>
    </div>

    <div class="footer">
        This is a computer-generated report analysis provided by the Tuition Class Management System.
        <br>Generated on {{ date('Y-m-d H:i:s') }}
    </div>
</body>

</html>