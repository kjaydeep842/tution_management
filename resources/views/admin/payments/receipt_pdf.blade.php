<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Receipt {{ $payment->receipt_no }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #1f2937;
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 24px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 16px;
        }

        .header h1 {
            color: #4f46e5;
            font-size: 22px;
            margin: 0;
        }

        .header p {
            color: #6b7280;
            margin: 4px 0 0;
        }

        .receipt-title {
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #374151;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td {
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
        }

        td:first-child {
            font-weight: 600;
            background: #f9fafb;
            width: 40%;
        }

        .total-row td {
            background: #4f46e5;
            color: white;
            font-weight: bold;
            font-size: 15px;
        }

        .footer {
            text-align: center;
            color: #9ca3af;
            font-size: 11px;
            margin-top: 40px;
            border-top: 1px dashed #e5e7eb;
            padding-top: 16px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ \App\Models\Setting::get('site_name', 'BrightMind') }} Tuition Centre</h1>
        <p>{{ \App\Models\Setting::get('site_address', '123 Education Lane, Mumbai') }} | +91 98765 43210 | {{ \App\Models\Setting::get('contact_email',
            'admissions@brightmind.in') }}</p>
    </div>

    <div class="receipt-title">Official Payment Receipt</div>

    <table>
        <tr>
            <td>Receipt Number</td>
            <td>{{ $payment->receipt_no }}</td>
        </tr>
        <tr>
            <td>Date of Payment</td>
            <td>{{ \Carbon\Carbon::parse($payment->paid_on)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td>Student Name</td>
            <td>{{ $payment->student->full_name }}</td>
        </tr>
        <tr>
            <td>Invoice Reference</td>
            <td>{{ $payment->fee->invoice_no ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Fee Type</td>
            <td>{{ $payment->fee->fee_type ?? 'Tuition Fee' }}</td>
        </tr>
        <tr>
            <td>Payment Mode</td>
            <td>{{ $payment->payment_mode }}</td>
        </tr>
        @if($payment->txn_id)
            <tr>
                <td>Transaction ID</td>
                <td>{{ $payment->txn_id }}</td>
            </tr>
        @endif
        <tr class="total-row">
            <td>Amount Paid</td>
            <td>₹{{ number_format($payment->amount, 2) }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>This is a computer-generated receipt. No signature required.</p>
        <p>Thank you for your prompt payment! | {{ \App\Models\Setting::get('site_name', 'BrightMind') }}</p>
    </div>
</body>

</html>