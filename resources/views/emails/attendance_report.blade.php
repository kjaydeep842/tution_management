<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #374151;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .button {
            background: #6366f1;
            color: #ffffff;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            display: inline-block;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <h2>{{ $monthName }} Attendance Report</h2>
            <p>Dear {{ $student->guardian_name }},</p>
            <p>Please find attached the monthly attendance report for <strong>{{ $student->full_name }}</strong> for the
                month of {{ $monthName }} {{ $year }}.</p>

            <div style="background: #f8fafc; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <p style="margin: 0; font-size: 14px;"><strong>Summary:</strong></p>
                <p style="margin: 5px 0 0; font-size: 18px; color: #6366f1;">{{ $present }} Present / {{ $total }} Total
                    Days ({{ $pct }}%)</p>
            </div>

            <p>If you have any questions regarding your child's attendance, please feel free to contact us.</p>

            <p>Best regards,<br>
                <strong>{{ \App\Models\Setting::get('site_name', 'BrightMind') }} Administration</strong>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'BrightMind') }}. All rights reserved.
        </div>
    </div>
</body>

</html>