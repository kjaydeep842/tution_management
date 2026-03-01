<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Inter', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 24px;
        }

        .title {
            color: #4f46e5;
            font-size: 20px;
            font-weight: bold;
        }

        .content {
            margin-bottom: 24px;
        }

        .footer {
            font-size: 12px;
            color: #6b7280;
            text-align: center;
            border-top: 1px solid #f3f4f6;
            padding-top: 16px;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 16px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 class="title">Academic Performance Report</h1>
        </div>
        <div class="content">
            <p>Dear Parent,</p>
            <p>The academic performance report for <strong>{{ $report->student->full_name }}</strong> for the period
                ending {{ $report->report_date->format('M d, Y') }} is now available.</p>

            <p><strong>Teacher's Overall Assessment:</strong> {{ $report->overall_performance }}</p>

            <p>We have attached a detailed PDF report containing subject-wise analysis and teacher's recommendations for
                improvement.</p>

            <p>You can also view this report and past records in the Parent Portal.</p>

            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="button text-white">Login to Parent Portal</a>
            </div>
        </div>
        <div class="footer">
            This is an automated message from {{ config('app.name') }}. Please do not reply to this email.
        </div>
    </div>
</body>

</html>