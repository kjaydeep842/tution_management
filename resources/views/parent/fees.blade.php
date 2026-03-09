@extends('layouts.parent')
@section('content')
    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:800; color:#0f172a; margin:0 0 4px;">Fee Records</h1>
        <p style="color:#64748b; font-size:14px; margin:0;">{{ $student->full_name }}</p>
    </div>


    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:20px; margin-bottom:24px;">
        <div class="card" style="background:white; border-left:4px solid #6366f1;">
            <div style="font-size:12px; color:#64748b; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">Total Fees</div>
            <div style="font-size:24px; font-weight:800; color:#0f172a;">₹{{ number_format($totalAmount, 2) }}</div>
        </div>
        <div class="card" style="background:white; border-left:4px solid #10b981;">
            <div style="font-size:12px; color:#64748b; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">Amount Paid</div>
            <div style="font-size:24px; font-weight:800; color:#10b981;">₹{{ number_format($totalPaid, 2) }}</div>
        </div>
        <div class="card" style="background:white; border-left:4px solid #ef4444;">
            <div style="font-size:12px; color:#64748b; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">Pending Amount</div>
            <div style="font-size:24px; font-weight:800; color:#ef4444;">₹{{ number_format($totalPending, 2) }}</div>
        </div>
    </div>

    <div class="card" style="padding:0; overflow:hidden;">
        <div style="padding:16px 20px; border-bottom:1px solid #f1f5f9; background:#f8fafc;">
            <h3 style="margin:0; font-size:14px; font-weight:700; color:#475569;">Detailed Fee Records</h3>
        </div>
        <div style="overflow-x: auto;">
            @if($fees->count())
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#fff;">
                            <th style="padding:12px 20px; text-align:left; font-size:11px; text-transform:uppercase; color:#94a3b8; border-bottom:1px solid #f1f5f9;">Fee For</th>
                            <th style="padding:12px 20px; text-align:left; font-size:11px; text-transform:uppercase; color:#94a3b8; border-bottom:1px solid #f1f5f9;">Total Amount</th>
                            <th style="padding:12px 20px; text-align:left; font-size:11px; text-transform:uppercase; color:#94a3b8; border-bottom:1px solid #f1f5f9;">Paid</th>
                            <th style="padding:12px 20px; text-align:left; font-size:11px; text-transform:uppercase; color:#94a3b8; border-bottom:1px solid #f1f5f9;">Balance</th>
                            <th style="padding:12px 20px; text-align:left; font-size:11px; text-transform:uppercase; color:#94a3b8; border-bottom:1px solid #f1f5f9;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fees as $fee)
                            @php
                                $paid = $fee->payments->sum('amount');
                                $balance = $fee->amount - $paid;
                            @endphp
                            <tr style="border-bottom:1px solid #f8fafc; transition:background 0.2s;" onmouseover="this.style.background='#fbfcfe'" onmouseout="this.style.background='transparent'">
                                <td style="padding:14px 20px;">
                                    <div style="font-weight:700; color:#0f172a; font-size:14px;">{{ $fee->fee_type ?? 'Monthly Tuition' }}</div>
                                    <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Due: {{ $fee->due_date ? \Carbon\Carbon::parse($fee->due_date)->format('d M Y') : '—' }}</div>
                                </td>
                                <td style="padding:14px 20px; font-weight:600; color:#334155;">₹{{ number_format($fee->amount, 2) }}</td>
                                <td style="padding:14px 20px; color:#10b981; font-weight:600;">₹{{ number_format($paid, 2) }}</td>
                                <td style="padding:14px 20px; color:{{ $balance > 0 ? '#ef4444' : '#64748b' }}; font-weight:700;">₹{{ number_format($balance, 2) }}</td>
                                <td style="padding:14px 20px;">
                                    @if($fee->status === 'paid' || $balance <= 0)
                                        <span style="background:#dcfce7; color:#166534; padding:4px 10px; border-radius:6px; font-size:11px; font-weight:700;">Fully Paid</span>
                                    @elseif($paid > 0)

                                        <span style="background:#dbeafe; color:#1e40af; padding:4px 10px; border-radius:6px; font-size:11px; font-weight:700;">Partially Paid</span>
                                    @else
                                        <span style="background:#fee2e2; color:#991b1b; padding:4px 10px; border-radius:6px; font-size:11px; font-weight:700;">Unpaid</span>
                                    @endif

                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="padding:40px; text-align:center;">
                    <div style="font-size:14px; color:#94a3b8;">No fee records available.</div>
                </div>
            @endif
        </div>
    </div>
@endsection