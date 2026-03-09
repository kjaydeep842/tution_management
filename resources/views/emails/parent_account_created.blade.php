<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Parent Portal Access – {{ \App\Models\Setting::get('site_name', 'BrightMind') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            max-width: 560px;
            margin: 32px auto;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        }

        .header {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            padding: 36px 32px;
            text-align: center;
            color: #fff;
        }

        .header h1 {
            margin: 0 0 6px;
            font-size: 22px;
            font-weight: 800;
        }

        .header p {
            margin: 0;
            font-size: 14px;
            opacity: .85;
        }

        .body {
            padding: 32px;
        }

        .greeting {
            font-size: 15px;
            color: #374151;
            margin: 0 0 20px;
            line-height: 1.6;
        }

        .credentials-box {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px 24px;
            margin: 24px 0;
        }

        .credentials-box h3 {
            margin: 0 0 14px;
            font-size: 13px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .cred-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .cred-row:last-child {
            border-bottom: none;
        }

        .cred-label {
            font-size: 13px;
            color: #64748b;
        }

        .cred-value {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            font-family: monospace;
        }

        .btn-block {
            text-align: center;
            margin: 28px 0 16px;
        }

        .btn {
            display: inline-block;
            padding: 14px 36px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            border-radius: 10px;
            letter-spacing: .2px;
        }

        .url-note {
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            margin-top: 8px;
            word-break: break-all;
        }

        .note {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            color: #78350f;
            margin-top: 20px;
            line-height: 1.6;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #94a3b8;
            background: #f8fafc;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <h1>🎓 Welcome to the Parent Portal</h1>
            <p>{{ \App\Models\Setting::get('site_name', 'BrightMind') }} Tuition Centre</p>
        </div>
        <div class="body">
            <p class="greeting">
                Dear <strong>{{ $guardianName }}</strong>,<br><br>
                A parent portal account has been created for you to track <strong>{{ $studentName }}</strong>'s
                attendance, fees, and academic progress. Below are your login credentials:
            </p>

            <div class="credentials-box">
                <h3>Your Login Credentials</h3>
                <div class="cred-row">
                    <span class="cred-label">Mobile Number (Login ID)</span>
                    <span class="cred-value">{{ $phone }}</span>
                </div>
                <div class="cred-row">
                    <span class="cred-label">Temporary Password</span>
                    <span class="cred-value">{{ $password }}</span>
                </div>
                <div class="cred-row">
                    <span class="cred-label">Student</span>
                    <span class="cred-value">{{ $studentName }}</span>
                </div>
            </div>

            <div class="btn-block">
                <a href="{{ $portalUrl }}" class="btn">Login to Parent Portal →</a>
            </div>
            <p class="url-note">Or copy this link: {{ $portalUrl }}</p>

            <div class="note">
                <strong>Important:</strong> Please change your password after logging in for the first time.
                Keep these credentials safe. If you did not expect this email, please contact us immediately.
            </div>
        </div>
        <div class="footer">
            {{ \App\Models\Setting::get('site_name', 'BrightMind') }} Tuition Centre &nbsp;·&nbsp; This is an automated
            message, please do not reply.
        </div>
    </div>
</body>

</html>