@extends('layouts.parent')
@section('content')
    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:800; color:#0f172a; margin:0 0 4px;">Fee Records</h1>
        <p style="color:#64748b; font-size:14px; margin:0;">{{ $student->full_name }}</p>
    </div>

    @php
        $totalDue = $fees->where('status', '!=', 'paid')->sum('amount_due');
        $totalPaid = $fees->where('status', 'paid')->sum('amount_due');
    @endphp

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">
        <div class="card" style="background:linear-gradient(135deg,#10b981,#059669); color:#fff; border:none;">
            <div style="font-size:13px; opacity:.85; margin-bottom:4px;">Total Paid</div>
            <div style="font-size:30px; font-weight:800;">₹{{ number_format($totalPaid, 2) }}</div>
        </div>
        <div class="card" style="background:linear-gradient(135deg,#ef4444,#dc2626); color:#fff; border:none;">
            <div style="font-size:13px; opacity:.85; margin-bottom:4px;">Pending Amount</div>
            <div style="font-size:30px; font-weight:800;">₹{{ number_format($totalDue, 2) }}</div>
        </div>
    </div>

    <div class="card">
        @if($fees->count())
            <table>
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Amount Due</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fees as $fee)
                        <tr>
                            <td style="font-weight:600; color:#0f172a;">{{ $fee->month ?? '—' }}</td>
                            <td style="color:#374151;">₹{{ number_format($fee->amount_due, 2) }}</td>
                            <td style="color:#64748b; font-size:13px;">
                                {{ $fee->due_date ? \Carbon\Carbon::parse($fee->due_date)->format('d M Y') : '—' }}
                            </td>
                            <td>
                                @if($fee->status === 'paid')
                                    <span class="badge-present">Paid</span>
                                @elseif($fee->status === 'partial')
                                    <span
                                        style="background:#dbeafe; color:#1e40af; padding:3px 10px; border-radius:6px; font-size:12px; font-weight:700;">Partial</span>
                                @else
                                    <span class="badge-absent">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align:center; color:#94a3b8; padding:40px 0;">No fee records found.</p>
        @endif
    </div>
@endsection