@extends('layouts.main')

@section('title', 'Payment Successful')

@section('navClass', 'sticky-nav-dark')

@section('content')
    <div class="py-5"
        style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); min-height: 80vh; display: flex; align-items: center;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <!-- Premium Glassmorphic Card -->
                    <div class="card border-0 rounded-5 shadow-2xl overflow-hidden animate__animated animate__fadeInUp"
                        style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.3) !important;">
                        <div class="card-body p-0">
                            <!-- Header with Success Animation -->
                            <div class="text-center p-5 text-white"
                                style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                <div class="success-checkmark-wrapper mb-4">
                                    <div class="check-icon">
                                        <i class="bi bi-check-circle-fill" style="font-size: 5rem;"></i>
                                    </div>
                                </div>
                                <h2 class="fw-black mb-1 tracking-tight" style="font-family: 'Poppins', sans-serif;">Payment
                                    Successful!</h2>
                                <p class="opacity-75 mb-0">Your reservation has been received and is awaiting confirmation.
                                </p>
                            </div>

                            <div class="p-5">
                                <!-- Summary Details -->
                                <div class="row g-4 mb-5">
                                    <div class="col-6">
                                        <label
                                            class="text-slate-400 small uppercase font-black tracking-widest d-block mb-1"
                                            style="font-size: 10px;">Booking ID</label>
                                        <p class="fw-bold text-slate-800 mb-0">#{{ $booking->id }}</p>
                                    </div>
                                    <div class="col-6 text-end">
                                        <label
                                            class="text-slate-400 small uppercase font-black tracking-widest d-block mb-1"
                                            style="font-size: 10px;">Amount Paid</label>
                                        <!-- <p class="fw-bold text-success mb-0">{{ number_format($booking->amount_paid, 2) }}
                                                {{ $booking->currency_code }}</p> -->
                                        <p class="fw-bold text-success mb-0">TK
                                            {{ number_format($booking->amount_paid, 2) }}</p>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-3 rounded-4" style="background: #f1f5f9; border: 1px dashed #cbd5e1;">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-slate-500 small">Transaction ID</span>
                                                <span
                                                    class="fw-medium small text-slate-700">{{ $booking->transaction_id }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-slate-500 small">Room / Service</span>
                                                <span class="fw-medium small text-slate-700">{{ $booking->title }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Next Steps Info -->
                                <div class="alert alert-info border-0 rounded-4 p-4 mb-5 d-flex align-items-start"
                                    style="background: #eff6ff; color: #1e40af;">
                                    <i class="bi bi-info-circle-fill me-3 mt-1 fs-5"></i>
                                    <div class="small">
                                        <strong>What's next?</strong> Our reservations team will review your booking and
                                        send a confirmation email within 24 hours. You can track your status in your
                                        dashboard.
                                    </div>
                                </div>

                                <!-- Dashboard Button -->
                                <div class="d-grid gap-3">
                                    <a href="{{ route('account.index') }}?tab=bookings&type={{ $booking->type }}"
                                        class="btn btn-indigo-premium rounded-pill py-3 fw-bold shadow-lg transition-all text-center text-white text-decoration-none">
                                        <i class="bi bi-speedometer2 me-2"></i> Go to Dashboard
                                    </a>
                                    <a href="{{ route('home') }}"
                                        class="btn btn-link text-slate-400 small text-decoration-none fw-medium text-center">Back
                                        to Home Page</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Promotional Footer -->
                    <div class="text-center mt-5 text-slate-400 small">
                        <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved. <br> Need help? <a
                                href="{{ route('contact') }}" class="text-indigo-600 text-decoration-none fw-bold">Contact
                                Support</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .shadow-2xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .text-slate-400 {
            color: #94a3b8;
        }

        .text-slate-500 {
            color: #64748b;
        }

        .text-slate-700 {
            color: #334155;
        }

        .text-slate-800 {
            color: #1e293b;
        }

        .text-indigo-600 {
            color: #4f46e5;
        }

        .fw-black {
            font-weight: 900;
        }

        .btn-indigo-premium {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            border: none;
        }

        .btn-indigo-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(79, 70, 229, 0.4);
            opacity: 0.9;
        }

        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .check-icon {
            animation: scaleUp 0.5s ease-out forwards;
        }

        @keyframes scaleUp {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            60% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate__fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection