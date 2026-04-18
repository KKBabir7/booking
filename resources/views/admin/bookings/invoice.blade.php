<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $booking->transaction_id }} - Nice Guest House</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap');
        
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        
        .invoice-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: none;
            margin-top: 50px;
            margin-bottom: 50px;
        }
        
        .invoice-header {
            background: linear-gradient(135deg, #f76156 0%, #ff8e86 100%);
            padding: 40px;
            color: white;
        }
        
        .hotel-logo {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .invoice-label {
            text-transform: uppercase;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 5px;
        }
        
        .section-title {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
            margin-bottom: 20px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
        }
        
        .table-custom th {
            background-color: #f8fafc;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border: none;
        }
        
        .table-custom td {
            font-size: 13px;
            font-weight: 600;
            padding: 15px 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .summary-box {
            background-color: #f8fafc;
            border-radius: 16px;
            padding: 20px;
        }
        
        .total-row {
            font-size: 18px;
            font-weight: 800;
            color: #f76156;
        }
        
        .badge-status {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }
        
        @media print {
            @page {
                size: portrait;
                margin: 0;
            }
            body { 
                background: white; 
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .invoice-card { 
                margin: 0 !important; 
                box-shadow: none !important; 
                border-radius: 0 !important;
                width: 100% !important;
            }
            .no-print { display: none !important; }
            .invoice-header { 
                -webkit-print-color-adjust: exact !important; 
                print-color-adjust: exact !important;
            }
            /* Force everything onto one page */
            html, body {
                height: 99%;
                overflow: hidden;
            }
        }
    </style>
</head>
<body class="bg-white">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="no-print mt-4 text-center">
                <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 font-weight-bold" style="background-color: #f76156; border: none;">
                    <i class="bi bi-printer-fill me-2"></i> Print Again
                </button>
                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-outline-secondary rounded-pill px-4 ms-2">
                    <i class="bi bi-arrow-left me-2"></i> Back to Console
                </a>
            </div>

            <div class="invoice-card">
                <!-- Header -->
                <div class="invoice-header">
                    <div class="row align-items-center">
                        <div class="col-md-7 mb-4 mb-md-0">
                            <div class="hotel-logo mb-2 text-white">
                                <i class="bi bi-house-door-fill"></i> NICE GUEST HOUSE
                            </div>
                            <div style="font-size: 12px; font-weight: 600; opacity: 0.9;">
                                <i class="bi bi-geo-alt-fill"></i> Uzzalpur, Maijdee Court, Sadar, Noakhali.<br>
                                <i class="bi bi-telephone-fill"></i> +880-0321-61658, +8801821159478<br>
                                <i class="bi bi-envelope-fill"></i> niceguesthouse.th@gmail.com
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="invoice-label">Invoice Reference</div>
                            <h2 class="fw-bold mb-3">#{{ $booking->transaction_id ?? $booking->id }}</h2>
                            <div class="d-flex justify-content-md-end gap-3 text-[11px]">
                                <div>
                                    <div class="invoice-label">Date Issued</div>
                                    <div class="fw-bold font-size-12">{{ now()->format('d M Y') }}</div>
                                </div>
                                <div>
                                    <div class="invoice-label">Booking Status</div>
                                    <span class="badge {{ $booking->status === 'completed' ? 'bg-success' : 'bg-primary' }} text-white text-uppercase" style="font-size: 8px;">{{ $booking->status }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-5">
                    <div class="row mb-5">
                        <!-- Guest Info -->
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="section-title">Guest Information</div>
                            <h5 class="fw-bold mb-1">{{ $booking->user->name ?? 'Unknown Guest' }}</h5>
                            <div class="text-secondary small">{{ $booking->user->email ?? '' }}</div>
                            <div class="text-secondary small">Total Guests: {{ $booking->adults + $booking->children }}</div>
                        </div>
                        
                        <!-- Stay Period -->
                        <div class="col-md-6 text-md-end">
                            <div class="section-title">Stay Period</div>
                            <div class="d-flex justify-content-md-end gap-4">
                                <div class="text-center">
                                    <div class="invoice-label text-secondary">Check In</div>
                                    <div class="fw-bold">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M, Y') }}</div>
                                </div>
                                <div class="text-center">
                                    <div class="invoice-label text-secondary">Check Out</div>
                                    <div class="fw-bold">{{ \Carbon\Carbon::parse($booking->check_out)->format('d M, Y') }}</div>
                                </div>
                            </div>
                            <div class="mt-2 small text-indigo-600 fw-bold uppercase">
                                Stay Duration: {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} Nights
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="section-title">Reservation Details</div>
                    <div class="table-responsive">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th style="width: 50%">Description</th>
                                    <th class="text-center">Duration</th>
                                    <th class="text-end">Base Rate</th>
                                    <th class="text-end">Line Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="fw-bold">
                                            @if($booking->type === 'room')
                                                Luxurious Stay - {{ $booking->room->title ?? 'Room Service' }}
                                            @else
                                                Conference Hall - {{ $booking->conferenceHall->title ?? 'Hall Service' }}
                                            @endif
                                        </div>
                                        <div class="text-secondary x-small">Transaction ID: {{ $booking->transaction_id }}</div>
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} Nights
                                    </td>
                                    <td class="text-end">
                                        TK {{ number_format($booking->room->price ?? ($booking->conferenceHall->price ?? 0)) }}
                                    </td>
                                    <td class="text-end">
                                        TK {{ number_format($booking->total_price - round($booking->total_price * 0.0476, 2)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end text-secondary x-small" style="border: none; padding: 10px;">Service Fee & Taxes (5%)</td>
                                    <td class="text-end text-secondary fw-bold" style="border: none; padding: 10px;">TK {{ number_format(round($booking->total_price * 0.0476, 2)) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary -->
                    <div class="row mt-4">
                        <div class="col-md-7">
                            <div style="font-size: 11px; color: #94a3b8; font-style: italic;">
                                Notes: Thank you for staying at Nice Guest House. We hope to see you again soon.<br>
                                This is a computer-generated invoice and doesn't require a physical signature.
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="summary-box">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary small fw-bold uppercase tracking-wide">Grand Total</span>
                                    <span class="fw-bold">TK {{ number_format($booking->total_price) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span class="text-emerald-600 small fw-bold uppercase tracking-wide">Amount Paid</span>
                                    <span class="fw-bold">TK {{ number_format($booking->amount_paid) }}</span>
                                </div>
                                <hr class="my-2 border-slate-200">
                                <div class="d-flex justify-content-between total-row">
                                    <span class="uppercase tracking-wide" style="font-size: 12px;">Balance Due</span>
                                    <span>TK {{ number_format($booking->total_price - $booking->amount_paid) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-light p-4 text-center text-secondary" style="font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                    Powered by Nice Guest House Management System
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Wait for everything (fonts, images, etc) to be fully loaded
    window.addEventListener('load', function() {
        // Add a small delay for safety before popping up the print menu
        setTimeout(function() {
            window.print();
        }, 1000);
    });
</script>

</body>
</html>
