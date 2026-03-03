<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Attendance Update – {{ \App\Models\Setting::get('site_name', 'BrightMind') }}</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; margin: 0; padding: 0; }
        .wrapper { max-width: 560px; margin: 32px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08); }
        .header { background: linear-gradient(135deg, #22c55e, #16a34a); padding: 32px; text-align: center; color: #fff; }
        .header h1 { margin: 0; font-size: 22px; font-weight: 800; }
        .header p { margin: 8px 0 0; font-size: 14px; opacity: .85; }
        .body { padding: 32px; }
        .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f5f9; }
        .info-row:last-child { border-bottom: none; }
        .label { font-size: 13px; color: #94a3b8; }
        .value { font-size: 14px; font-weight: 700; color: #0f172a; }
        .message { background: #f0fdf4; border-left: 4px solid #22c55e; padding: 16px; border-radius: 8px; margin: 24px 0; font-size: 14px; color: #374151; line-height: 1.6; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; background: #f8fafc; }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <h1>✅ Attendance Update</h1>
            <p>Your child was marked Present today</p>
        </div>
        <div class="body">
            <div class="info-row"><span class="label">Student Name</span><span class="value">{{ $student->full_name }}</span></div>
            <div class="info-row"><span class="label">Date</span><span class="value">{{ \Carbon\Carbon::parse($date)->format('l, d M Y') }}</span></div>
            <div class="info-row"><span class="label">Class / Batch</span><span class="value">{{ $className }}</span></div>
            <div class="info-row"><span class="label">Status</span><span class="value" style="color:#22c55e;">Present</span></div>

            <div class="message">
                Dear Parent/Guardian,<br><br>
                This is to inform you that <strong>{{ $student->full_name }}</strong> was marked <strong>Present</strong> on <strong>{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</strong> for the class <strong>{{ $className }}</strong>.<br><br>
                Thank you for ensuring regular attendance.
            </div>
        </div>
        <div class="footer">
            {{ \App\Models\Setting::get('site_name', 'BrightMind') }} Tuition Centre &nbsp;·&nbsp; This is an automated message, please do not reply.
        </div>
    </div>
</body>

</html>
