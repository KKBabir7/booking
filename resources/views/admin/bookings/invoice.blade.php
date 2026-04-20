<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $booking->transaction_id ?? $booking->id }} - Nice Guest House</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #000000;
            line-height: 1.5;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 40px;
            border: 1px solid #e5e7eb;
        }
        
        .header-section {
            border-bottom: 2px solid #000000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .hotel-name {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        
        .invoice-id {
            font-size: 20px;
            font-weight: 700;
        }
        
        .label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #000000;
            margin-bottom: 4px;
        }
        
        .section-title {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border-bottom: 1px solid #000000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .table-simple {
            width: 100%;
            margin-bottom: 30px;
        }
        
        .table-simple th {
            border-bottom: 2px solid #000000;
            padding: 10px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
        }
        
        .table-simple td {
            padding: 15px 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }
        
        .summary-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
        
        .summary-box {
            width: 300px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }
        
        .summary-row.total {
            border-top: 2px solid #000000;
            margin-top: 10px;
            padding-top: 15px;
            font-weight: 800;
            font-size: 18px;
        }

        .no-print {
            text-align: center;
            margin-bottom: 20px;
        }

        @media print {
            .no-print { display: none !important; }
            .invoice-container {
                margin: 0;
                padding: 0;
                border: none;
                max-width: 100%;
            }
            body { font-size: 12pt; }
        }
    </style>
</head>
<body>

@php
    $type = $booking->type;
    $duration = 0;
    
    if ($type === 'room' || $type === 'conference') {
        $start = \Carbon\Carbon::parse($booking->check_in);
        $end = \Carbon\Carbon::parse($booking->check_out);
        $duration = (int) $start->diffInDays($end);
        
        if ($type === 'conference') {
            $duration += 1; // Inclusive days
        } else {
            $duration = $duration > 0 ? $duration : 1; // Min 1 night for rooms
        }
    }
    
    $unit = ($type === 'conference') ? 'Day' : 'Night';
@endphp

<div class="no-print mt-4">
    <button onclick="window.print()" class="btn btn-dark rounded-pill px-4">
        <i class="bi bi-printer-fill pe-2"></i> Print Invoice
    </button>
    <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-outline-dark rounded-pill px-4 ms-2">
        Back to Dashboard
    </a>
</div>

<div class="invoice-container">
    <!-- Header -->
    <div class="header-section">
        <div class="row align-items-center">
            <div class="col-8">
                <div class="hotel-name">NICE GUEST HOUSE</div>
                <div style="font-size: 11px; font-weight: 500;">
                    Uzzalpur, Maijdee Court, Sadar, Noakhali.<br>
                    Tel: +880-0321-61658, +8801821159478<br>
                    Email: niceguesthouse.th@gmail.com
                </div>
            </div>
            <div class="col-4 text-end">
                <div class="label">Invoice Reference</div>
                <div class="invoice-id">#{{ $booking->transaction_id ?? $booking->id }}</div>
                <div style="font-size: 11px;">Issued: {{ now()->format('d M, Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Info Grid -->
    <div class="info-grid">
        <div>
            <div class="section-title">Guest Information</div>
            <div style="font-size: 16px; font-weight: 700;">{{ $booking->user->name ?? 'Guest' }}</div>
            <div style="font-size: 12px; color: #4b5563;">{{ $booking->user->email ?? '' }}</div>
            <div style="font-size: 12px; color: #4b5563;">Phone: {{ $booking->user->phone ?? 'N/A' }}</div>
        </div>
        <div class="text-end">
            <div class="section-title">Schedule Information</div>
            @if($type === 'restaurant')
                <div style="font-size: 14px; font-weight: 700;">Dining Date: {{ \Carbon\Carbon::parse($booking->date)->format('d M, Y') }}</div>
                <div style="font-size: 12px; color: #4b5563;">Slot: {{ $booking->time_slot }}</div>
            @else
                <div style="font-size: 14px; font-weight: 700;">{{ $booking->check_in }} — {{ $booking->check_out }}</div>
                <div style="font-size: 12px; font-weight: 700; text-transform: uppercase;">Duration: {{ $duration }} {{ $unit }}{{ $duration > 1 ? 's' : '' }}</div>
            @endif
        </div>
    </div>

    <!-- Breakdown Table -->
    <div class="section-title">Financial Breakdown</div>
    <table class="table-simple">
        <thead>
            <tr>
                <th style="width: 50%">Description</th>
                <th class="text-center">Quantity/Days</th>
                <th class="text-end">Base Rate</th>
                <th class="text-end">Amount</th>
            </tr>
        </thead>
        <tbody>
            @if($type === 'restaurant')
                <tr>
                    <td>Booking Deposit (Manual Reservation)</td>
                    <td class="text-center">1</td>
                    <td class="text-end">TK {{ number_format($booking->deposit_amount ?: 500) }}</td>
                    <td class="text-end">TK {{ number_format($booking->deposit_amount ?: 500) }}</td>
                </tr>
                @if($booking->food_bill > 0)
                <tr>
                    <td>Food & Additional Services</td>
                    <td class="text-center">1</td>
                    <td class="text-end">TK {{ number_format($booking->food_bill) }}</td>
                    <td class="text-end">TK {{ number_format($booking->food_bill) }}</td>
                </tr>
                @endif
                @if($booking->service_charge > 0)
                <tr>
                    <td>Service Fee</td>
                    <td class="text-center">-</td>
                    <td class="text-end">TK {{ number_format($booking->service_charge) }}</td>
                    <td class="text-end">TK {{ number_format($booking->service_charge) }}</td>
                </tr>
                @endif
                @if($booking->tax > 0)
                <tr>
                    <td>Taxes / VAT</td>
                    <td class="text-center">-</td>
                    <td class="text-end">TK {{ number_format($booking->tax) }}</td>
                    <td class="text-end">TK {{ number_format($booking->tax) }}</td>
                </tr>
                @endif
            @else
                <tr>
                    <td>
                        <div style="font-weight: 700;">{{ $booking->title }}</div>
                        <div style="font-size: 10px; color: #6b7280;">Stay Period: {{ $booking->check_in }} to {{ $booking->check_out }}</div>
                    </td>
                    <td class="text-center">{{ $duration }} {{ $unit }}{{ $duration > 1 ? 's' : '' }}</td>
                    @php
                        $item = ($type === 'room') ? $booking->room : $booking->conferenceHall;
                        $rate = $item ? $item->price : 0;
                        $totalService = ($item ? $item->service_charge : 0) * $duration;
                        $totalTax = ($item ? $item->tax : 0) * $duration;
                    @endphp
                    <td class="text-end">TK {{ number_format($rate) }}</td>
                    <td class="text-end">TK {{ number_format($rate * $duration) }}</td>
                </tr>
                @if($totalService > 0)
                <tr>
                    <td>Service Fee (Dynamic)</td>
                    <td class="text-center">{{ $duration }} {{ $unit }}{{ $duration > 1 ? 's' : '' }}</td>
                    <td class="text-end">TK {{ number_format($item->service_charge) }}</td>
                    <td class="text-end">TK {{ number_format($totalService) }}</td>
                </tr>
                @endif
                @if($totalTax > 0)
                <tr>
                    <td>VAT / Taxes</td>
                    <td class="text-center">{{ $duration }} {{ $unit }}{{ $duration > 1 ? 's' : '' }}</td>
                    <td class="text-end">TK {{ number_format($item->tax) }}</td>
                    <td class="text-end">TK {{ number_format($totalTax) }}</td>
                </tr>
                @endif
            @endif
        </tbody>
    </table>

    <!-- Summary Box -->
    <div class="summary-section">
        <div class="summary-box">
            <div class="summary-row">
                <span>Grand Total Amount</span>
                <span>TK {{ number_format($booking->total_price) }}</span>
            </div>
            <div class="summary-row" style="color: #4b5563;">
                <span>Total Amount Paid</span>
                <span>TK {{ number_format($booking->amount_paid) }}</span>
            </div>
            <div class="summary-row total">
                <span>Balance Due</span>
                <span>TK {{ number_format($booking->total_price - $booking->amount_paid) }}</span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div style="margin-top: 60px; text-align: center; font-size: 10px; color: #6b7280; font-style: italic;">
        Thank you for choosing Nice Guest House. We look forward to serving you again.<br>
        This is a digitally generated invoice. No signature required.
    </div>
</div>

<script>
    window.onload = function() {
        setTimeout(function() {
            window.print();
        }, 800);
    };
</script>

</body>
</html>
