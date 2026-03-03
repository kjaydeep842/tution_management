@extends('layouts.parent')
@section('content')
    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:800; color:#0f172a; margin:0 0 4px;">Past Records</h1>
        <p style="color:#64748b; font-size:14px; margin:0;">Historical performance and academic records for
            {{ $student->full_name }}</p>
    </div>

    <div style="display:grid; grid-template-columns: 1fr; gap:24px;">
        {{-- Past Reports --}}
        <div class="card">
            <h2
                style="font-size:16px; font-weight:700; color:#374151; margin:0 0 16px; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                All Performance Reports</h2>
            @if($pastReports->count())
                <div style="overflow-x: auto;">
                    <table style="min-width: 600px;">
                        <thead>
                            <tr>
                                <th>Month/Year</th>
                                <th>Date Generated</th>
                                <th>Overall Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pastReports as $report)
                                <tr>
                                    <td style="font-weight:600; color:#0f172a;">{{ $report->report_date->format('F Y') }}</td>
                                    <td style="color:#64748b;">{{ $report->report_date->format('d M Y') }}</td>
                                    <td>
                                        <span class="px-2 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-full">
                                            {{ $report->overall_performance }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('parent.performance.download', $report) }}"
                                            style="color:#6366f1; text-decoration:none; font-weight:600; font-size:13px;">Download
                                            PDF</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="text-align:center; color:#94a3b8; padding:30px 0;">No past reports found.</p>
            @endif
        </div>

        {{-- Past Exams --}}
        <div class="card">
            <h2
                style="font-size:16px; font-weight:700; color:#374151; margin:0 0 16px; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                All Exam Records</h2>
            @if($pastExams->count())
                <div style="overflow-x: auto;">
                    <table style="min-width: 600px;">
                        <thead>
                            <tr>
                                <th>Exam Name</th>
                                <th>Subject</th>
                                <th>Marks</th>
                                <th>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pastExams as $mark)
                                <tr>
                                    <td style="font-weight:600; color:#0f172a;">{{ $mark->exam->name }}</td>
                                    <td style="color:#6366f1; font-weight:600;">{{ $mark->exam->subject }}</td>
                                    <td style="font-weight:700;">{{ $mark->marks_obtained }} / {{ $mark->exam->total_marks }}</td>
                                    <td>
                                        @php 
                                                                                $percentage = ($mark->marks_obtained / $mark->exam->total_marks) * 100;
                                            $isPass = $percentage >= ($mark->exam->passing_marks ?? 35);
                                        @endphp
                                              @if($isPass)
                                                <span class="badge-present">PASSED</span>
                                            @else
                                            <span class="badge-absent">FAILED</span>
                                        @endif
                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                    </table>
                    </div>
            @else
                <p style="text-align:center; color:#94a3b8; padding:30px 0;">No past exam records found.</p>
            @endif
            </div>
        </div>
@endsection
