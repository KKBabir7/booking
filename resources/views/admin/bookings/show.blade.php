@extends('layouts.admin')

@section('header', 'Booking Management')

@section('content')
    <div class="row g-6">
        <!-- Left Column: Details & Timeline -->
        <div class="col-lg-8">
            <!-- Main Stats Header -->
            <div class="card-premium p-6 mb-6">
                <div class="flex flex-wrap justify-between items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-indigo-500 text-white flex items-center justify-center shadow-lg shadow-indigo-200">
                            @if($booking->type === 'room') <i class="bi bi-door-open-fill fs-4"></i>
                            @elseif($booking->type === 'restaurant') <i class="bi bi-cup-hot-fill fs-4"></i> @else <i
                            class="bi bi-building-fill fs-4"></i> @endif
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight">Reservation
                                #{{ str_pad($booking->id, 8, '0', STR_PAD_LEFT) }}</h3>
                            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Category:
                                {{ $booking->type }} &bull; Transaction: {{ $booking->transaction_id ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                'confirmed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                'completed' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                'cancelled' => 'bg-rose-100 text-rose-700 border-rose-200',
                            ];
                        @endphp
                        <span
                            class="px-4 py-2 {{ $statusColors[$booking->status] ?? 'bg-slate-100 text-slate-500' }} rounded-xl text-xs font-black uppercase tracking-widest border shadow-sm">
                            {{ $booking->status }}
                        </span>
                        <a href="{{ route('admin.bookings.invoice', $booking) }}" target="_blank"
                            class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm">
                            <i class="bi bi-printer-fill"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row g-6">
                <div class="col-md-6">
                    <!-- Guest Information -->
                    <div class="card-premium h-full p-6 bg-white">
                        <div class="flex items-center gap-2 mb-6">
                            <i class="bi bi-person-badge-fill text-indigo-500 fs-5"></i>
                            <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-0">Guest Information
                            </h4>
                        </div>
                        <div class="flex items-center gap-4 mb-6">
                            <div
                                class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold border border-slate-200 fs-3">
                                {{ substr($booking->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-lg font-black text-slate-800">{{ $booking->user->name }}</div>
                                <div class="text-xs text-indigo-500 font-bold">{{ $booking->user->email }}</div>
                            </div>
                        </div>
                        <div class="space-y-4 pt-4 border-top border-slate-50">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-black text-slate-400 uppercase">Contact Phone</span>
                                <span class="text-sm font-bold text-slate-700">{{ $booking->user->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-black text-slate-400 uppercase">Loyalty Status</span>
                                <span
                                    class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[10px] font-black rounded border border-indigo-100">PLATINUM
                                    GUEST</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Stay & Service Details -->
                    <div class="card-premium h-full p-6 bg-white">
                        <div class="flex items-center gap-2 mb-6">
                            <i class="bi bi-calendar-range-fill text-indigo-500 fs-5"></i>
                            <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-0">Stay & Service</h4>
                        </div>
                        <div class="mb-6">
                            <div class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mb-1">
                                {{ $booking->type }} Selection</div>
                            <div class="text-lg font-black text-slate-800">{{ $booking->title }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                            <div class="row align-items-center g-3">
                                <div class="col-12 pb-2 border-bottom border-slate-200/50">
                                    <div class="text-[10px] text-slate-400 font-bold uppercase mb-1">Schedule</div>
                                    <div class="text-sm font-black text-slate-700 flex items-center gap-2">
                                        <i class="bi bi-clock-fill text-slate-300"></i>
                                        @if($booking->type === 'room')
                                            {{ Carbon\Carbon::parse($booking->check_in)->format('d M') }} &rarr;
                                            {{ Carbon\Carbon::parse($booking->check_out)->format('d M, Y') }}
                                        @else
                                            {{ Carbon\Carbon::parse($booking->date)->format('d M Y') }} &bull;
                                            {{ $booking->time_slot ?? $booking->duration }}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 pt-2">
                                    <div class="text-[10px] text-slate-400 font-bold uppercase mb-1">Guests</div>
                                    <div class="text-sm font-black text-slate-700 flex items-center gap-2">
                                        <i class="bi bi-people-fill text-slate-300"></i>
                                        {{ $booking->guests ?? ($booking->adults + $booking->children) }} People
                                        @if ($booking->type !== 'conference')
                                            <span class="text-[10px] text-slate-400 ml-1">({{ $booking->adults ?? 0 }} Adults,
                                                {{ $booking->children ?? 0 }} Children)</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Invoice Style Billing -->
            <div class="card-premium p-0 overflow-hidden mt-6 shadow-xl border-0">
                <div id="billing-banner"
                    class="p-8 {{ ($booking->amount_paid >= $booking->total_price) ? 'bg-emerald-600' : 'bg-slate-900' }} text-white transition-all duration-700 relative">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>

                    <!-- Title Row -->
                    <div class="flex items-center gap-3 mb-8 border-bottom border-white/10 pb-4">
                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div>
                            <div class="text-[9px] font-black text-white/60 uppercase tracking-widest">Billing Summary Table 
                                <span class="ms-2 badge {{ ($booking->amount_paid >= $booking->total_price) ? 'bg-white text-emerald-600' : 'bg-rose-500 text-white' }} p-1 rounded uppercase" style="font-size: 8px;">
                                    {{ ($booking->amount_paid >= $booking->total_price) ? 'CLEARED' : 'PENDING' }}
                                </span>
                            </div>
                            <div class="text-[10px] font-bold uppercase tracking-tight">
                                {{ ($booking->amount_paid >= $booking->total_price) ? 'Transaction Settled & Verified' : 'Awaiting Full Payment' }}
                            </div>
                        </div>
                    </div>

                    <!-- 3 Column Stats Grid -->
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); text-align: center;">
                        <div class="px-4" style="border-right: 1px solid rgba(255,255,255,0.15);">
                            <div class="text-[10px] font-black text-white/50 uppercase tracking-widest mb-2">Total Amount
                                Bill</div>
                            <div class="text-3xl font-black tracking-tight" id="val-total-price">TK
                                {{ number_format($booking->total_price) }}</div>
                        </div>
                        <div class="px-4" style="border-right: 1px solid rgba(255,255,255,0.15);">
                            <div class="text-[10px] font-black text-white/50 uppercase tracking-widest mb-2">Advance Paid
                                Amount</div>
                            <div class="text-3xl font-black tracking-tight" id="val-paid-amount">TK
                                {{ number_format($booking->amount_paid) }}</div>
                        </div>
                        <div class="px-4">
                            <div class="text-[10px] font-black text-white/50 uppercase tracking-widest mb-2" id="label-due">
                                {{ ($booking->amount_paid >= $booking->total_price) ? 'Final Payment Status' : 'Remaining Due Balance' }}
                            </div>
                            <div class="text-3xl font-black tracking-tight" id="val-due-amount">
                                @if($booking->amount_paid >= $booking->total_price)
                                    <span class="text-emerald-200">CLEARED</span>
                                @else
                                    <span class="text-rose-400">TK
                                        {{ number_format($booking->total_price - $booking->amount_paid) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 border-top border-slate-100">
                    <div
                        class="flex justify-between items-center text-[10px] font-bold text-slate-400 tracking-widest uppercase">
                        <span>Payment Method: {{ strtoupper($booking->payment_method ?? 'SSLCOMMERZ') }}</span>
                        <span
                            id="sub-label-due">{{ ($booking->amount_paid >= $booking->total_price) ? 'Balance Fully Recovered' : 'Balance Payment Collection Required' }}</span>
                    </div>
                </div>
            </div>

            <!-- Booking Journey Timeline -->
            <div class="card-premium p-8 mt-6 bg-white">
                <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-8 flex items-center gap-2">
                    <i class="bi bi-clock-history text-indigo-500"></i> Reservation Journey
                </h4>
                <div class="relative pl-8 border-left border-slate-100">
                    <div class="mb-10 relative">
                        <span
                            class="absolute -left-[41px] top-0 w-4 h-4 rounded-full bg-emerald-500 border-4 border-white shadow-sm"></span>
                        <div class="text-sm font-bold text-slate-800">Booking Initialized</div>
                        <div class="text-[10px] text-slate-400 mt-1">{{ $booking->created_at->format('d M Y, h:i A') }}
                        </div>
                        <p class="text-[11px] text-slate-500 mt-2">The guest requested the reservation from the frontend
                            portal.</p>
                    </div>
                    <div class="mb-10 relative">
                        <span
                            class="absolute -left-[41px] top-0 w-4 h-4 rounded-full {{ $booking->payment_status === 'success' ? 'bg-emerald-500' : 'bg-amber-400' }} border-4 border-white shadow-sm"></span>
                        <div class="text-sm font-bold text-slate-800">Payment Verification</div>
                        <div class="text-[11px] text-slate-500 mt-2">
                            @if($booking->payment_status === 'success')
                                Transaction successful via {{ $booking->payment_method }}. Ref: {{ $booking->transaction_id }}
                            @else
                                Awaiting final payment confirmation from the guest or gateway.
                            @endif
                        </div>
                    </div>
                    <div class="relative">
                        <span
                            class="absolute -left-[41px] top-0 w-4 h-4 rounded-full {{ $booking->status === 'completed' ? 'bg-indigo-500' : 'bg-slate-200' }} border-4 border-white shadow-sm"></span>
                        <div class="text-sm font-bold text-slate-800">Final Outcome</div>
                        <div class="text-[11px] text-slate-500 mt-2">Current Status: <strong
                                class="text-indigo-600 uppercase">{{ $booking->status }}</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Management Console -->
        <div class="col-lg-4">
            <div class="card-premium p-0 overflow-hidden sticky top-8 shadow-xl border-0">
                <div class="bg-indigo-600 p-6 text-white">
                    <h4 class="text-lg font-black tracking-tight mb-1 flex items-center gap-2">
                        <i class="bi bi-lightning-charge-fill"></i> Management
                    </h4>
                    <p class="text-white/60 text-[10px] font-bold uppercase tracking-widest">Administration Console</p>
                </div>

                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="p-6 bg-white">
                    @csrf @method('PUT')
                    
                    @if($errors->any())
                        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl animate-shake">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="bi bi-exclamation-triangle-fill text-rose-500"></i>
                                <span class="text-[10px] font-black text-rose-600 uppercase tracking-widest">Security Conflict</span>
                            </div>
                            <ul class="list-none p-0 m-0">
                                @foreach($errors->all() as $error)
                                    <li class="text-[11px] text-rose-500 font-bold leading-relaxed">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-8">
                        <!-- Stay Management Section -->
                        <div class="management-section">
                            <div
                                class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-indigo-500"></span> Stay Details
                            </div>
                            @if($booking->type === 'room')
                                <div class="grid grid-cols-1 gap-4">
                                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                        <label
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Service
                                            Period</label>
                                        <div class="flex items-center gap-2">
                                            <input type="date" name="check_in"
                                                value="{{ \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d') }}"
                                                class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500">
                                            <span class="text-slate-300">&rarr;</span>
                                            <input type="date" name="check_out"
                                                value="{{ \Carbon\Carbon::parse($booking->check_out)->format('Y-m-d') }}"
                                                class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500">
                                        </div>
                                        <div id="days-indicator"
                                            class="text-[9px] text-indigo-500 font-bold uppercase mt-2 italic">Stay Duration:
                                            {{ Carbon\Carbon::parse($booking->check_in)->diffInDays(Carbon\Carbon::parse($booking->check_out)) }}
                                            Nights</div>
                                    </div>
                                </div>
                            @elseif($booking->type === 'conference')
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Event
                                        Period</label>
                                    <div class="flex items-center gap-2">
                                        <input type="date" name="check_in"
                                            value="{{ $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d') : \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}"
                                            class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500">
                                        <span class="text-slate-300">&rarr;</span>
                                        <input type="date" name="check_out"
                                            value="{{ $booking->check_out ? \Carbon\Carbon::parse($booking->check_out)->format('Y-m-d') : \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}"
                                            class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500">
                                    </div>
                                    <div class="text-[9px] text-indigo-500 font-bold uppercase mt-2 italic">Slot:
                                        {{ $booking->duration }}</div>
                                </div>
                            @elseif($booking->type === 'restaurant')
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Dining Date</label>
                                    <input type="date" name="date"
                                        value="{{ \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}"
                                        class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500">
                                    <div class="text-[9px] text-indigo-500 font-bold uppercase mt-2 italic">Slot:
                                        {{ $booking->time_slot }}</div>
                                </div>
                            @endif
                            <div class="mt-4">
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Core
                                    Status</label>
                                <select name="status" id="booking_status_select"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10">
                                    <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending
                                        Review</option>
                                    <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>
                                        Confirmed Reservation</option>
                                    <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Service
                                        Completed</option>
                                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>
                                        Cancelled/Rejected</option>
                                </select>
                            </div>
                        </div>

                        <!-- Payment & Checkout Section -->
                        <div class="management-section border-top border-slate-50 pt-2" id="payment-input-section">
                            <div
                                class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-indigo-500"></span> Financial Capture
                            </div>

                            @if($booking->type === 'restaurant')
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Food Bill / Additional Amount (TK)</label>
                                <div class="relative mb-4">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">TK</span>
                                    <input type="number" name="food_bill" value="{{ $booking->total_price - 500 }}"
                                        class="w-full pl-10 pr-4 py-3 bg-rose-50 border border-rose-100 rounded-2xl text-sm font-black text-rose-700 transition focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-300" placeholder="Enter amount for food/items">
                                    <div class="text-[9px] text-rose-400 font-bold uppercase mt-2 italic px-1">Note: Total Bill will be 500 (Booking) + this amount</div>
                                </div>
                                <div class="flex items-center gap-2 mb-6 px-1">
                                    <input type="checkbox" name="confirm_full_payment" value="1" id="confirm_full_payment" 
                                        class="w-4 h-4 rounded-lg border-rose-200 text-rose-500 focus:ring-rose-500/20">
                                    <label for="confirm_full_payment" class="text-[10px] font-black text-rose-600 uppercase tracking-widest cursor-pointer hover:text-rose-700 transition">
                                        Confirm Full Payment Received
                                    </label>
                                </div>
                            @endif

                            @if($booking->deposit_amount)
                                <div
                                    class="mb-4 p-3 bg-slate-50 border border-slate-200 rounded-2xl flex justify-between items-center">
                                    <div>
                                        <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Initial
                                            Deposit Record</div>
                                        <div class="text-xs font-black text-indigo-500">TK
                                            {{ number_format($booking->deposit_amount) }}</div>
                                    </div>
                                    @if(auth()->user()->isSuperAdmin())
                                        <button type="button" id="btn-revert-deposit" data-amount="{{ $booking->deposit_amount }}"
                                            class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-[9px] font-black text-slate-500 hover:bg-slate-50 transition shadow-sm">
                                            <i class="bi bi-arrow-counterclockwise"></i> REVERT
                                        </button>
                                    @endif
                                </div>
                            @endif

                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Amount
                                Paid (TK)</label>
                            <div class="relative mb-4">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">TK</span>
                                <input type="number" name="amount_paid" id="amount_paid_input"
                                    value="{{ $booking->amount_paid }}" step="0.01" {{ auth()->user()->isSuperAdmin() ? '' : 'readonly' }}
                                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-black text-indigo-400 {{ auth()->user()->isSuperAdmin() ? '' : 'cursor-not-allowed opacity-80 shadow-inner' }}">
                                <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <i class="bi bi-{{ auth()->user()->isSuperAdmin() ? 'unlock-fill text-emerald-400' : 'shield-lock-fill text-slate-300' }}"
                                        title="{{ auth()->user()->isSuperAdmin() ? 'Super Admin Override Active' : 'Manual edits are locked for security. Use checkbox to finalize.' }}"></i>
                                </div>
                            </div>

                            @if($booking->status !== 'completed' || $booking->payment_status !== 'success' || auth()->user()->isSuperAdmin())
                                <div
                                    class="flex items-center gap-3 bg-emerald-50 px-4 py-3 rounded-2xl border border-emerald-100 mb-4 group cursor-pointer transition-all hover:shadow-md">
                                    <input type="checkbox" id="payment_full_complete"
                                        class="w-5 h-5 rounded border-emerald-200 text-emerald-500 focus:ring-emerald-500 cursor-pointer">
                                    <label for="payment_full_complete"
                                        class="text-[10px] font-black text-emerald-700 uppercase tracking-wide cursor-pointer select-none">Confirm
                                        Full Payment</label>
                                </div>
                            @endif

                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Capture
                                Status</label>
                            <select name="payment_status" id="payment_status_select"
                                class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10">
                                <option value="pending" {{ ($booking->payment_status === 'pending' || $booking->amount_paid < $booking->total_price) ? 'selected' : '' }}>Pending/Unpaid</option>
                                <option value="success" {{ ($booking->payment_status === 'success' && $booking->amount_paid >= $booking->total_price) ? 'selected' : '' }}>Payment Successful</option>
                                <option value="failed" {{ $booking->payment_status === 'failed' ? 'selected' : '' }}>Payment
                                    Failed</option>
                            </select>
                        </div>

                        <!-- Notes Section -->
                        <div class="management-section border-top border-slate-50 pt-8 text-white/50">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Administrative
                                Logs</label>
                            <textarea name="admin_notes" rows="3"
                                placeholder="Log any interactions or stay specifications here..."
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500">{{ $booking->admin_notes }}</textarea>
                        </div>

                        @if($booking->status === 'completed' && $booking->payment_status === 'success' && !auth()->user()->isSuperAdmin())
                            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-center">
                                <div
                                    class="w-10 h-10 bg-emerald-500 text-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg shadow-emerald-200">
                                    <i class="bi bi-check-lg fs-5"></i>
                                </div>
                                <p class="text-[10px] text-emerald-700 font-black uppercase tracking-widest">Reservation
                                    Finalized</p>
                                <p class="text-[9px] text-emerald-600/60 mt-1 font-medium italic">Security lock active: No
                                    further modifications allowed.</p>
                                <input type="hidden" name="status" value="completed">
                                <input type="hidden" name="payment_status" value="success">
                                <input type="hidden" name="amount_paid" value="{{ $booking->amount_paid }}">
                            </div>
                        @else
                            <button type="submit"
                                 class="bg-indigo-600 text-white btn-premium w-full py-4 text-sm font-bold shadow-xl shadow-indigo-200 hover:scale-[1.02] active:scale-[0.98] transition">
                                {{ auth()->user()->isSuperAdmin() && $booking->status === 'completed' ? 'Update & Finalize Correction' : 'Commit All Records' }}
                            </button>
                        @endif

                        <a href="{{ route('admin.bookings.invoice', $booking) }}" target="_blank"
                        
                            class="block w-full text-center py-4 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-black rounded-2xl text-[10px] uppercase tracking-widest transition flex items-center justify-center gap-2 border border-indigo-100 mt-4">
                            <i class="bi bi-printer-fill"></i> Generate Guest Invoice
                        </a>

                        <a href="{{ route('admin.bookings.index') }}"
                            class="block w-full text-center py-3 bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold rounded-xl text-[10px] uppercase tracking-widest transition mt-4">
                            Cancel & Go Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkInInput = document.querySelector('input[name="check_in"]');
            const checkOutInput = document.querySelector('input[name="check_out"]');
            const amountPaidInput = document.getElementById('amount_paid_input');
            const paymentCompleteCheckbox = document.getElementById('payment_full_complete');
            const bookingStatusSelect = document.getElementById('booking_status_select');
            const paymentStatusSelect = document.getElementById('payment_status_select');

            // UI Elements for updates
            const valTotalPrice = document.getElementById('val-total-price');
            const valPaidAmount = document.getElementById('val-paid-amount');
            const valDueAmount = document.getElementById('val-due-amount');
            const labelDue = document.getElementById('label-due');
            const subLabelDue = document.getElementById('sub-label-due');
            const billingBanner = document.getElementById('billing-banner');
            const daysIndicator = document.getElementById('days-indicator');

            const roomPrice = {{ $booking->room->price ?? 0 }};

            // Store Original State for Revert Logic
            const originalAmount = {{ $booking->amount_paid ?? 0 }};
            const originalStatus = '{{ $booking->status }}';
            const originalPaymentStatus = '{{ $booking->payment_status }}';

            // Super Admin Real-time Correction Logic
            if (amountPaidInput) {
                amountPaidInput.addEventListener('input', function () {
                    const currentTotal = parseFloat(valTotalPrice.innerText.replace(/[^0-9]/g, ''));
                    const typedAmount = parseFloat(this.value) || 0;

                    updateDue(currentTotal, typedAmount);

                    // Interaction: If amount becomes less than total, uncheck full payment if it was checked
                    if (typedAmount < currentTotal && paymentCompleteCheckbox && paymentCompleteCheckbox.checked) {
                        paymentCompleteCheckbox.checked = false;
                        paymentCompleteCheckbox.parentElement.classList.remove('bg-emerald-100', 'border-emerald-300');

                        // Also update Capture Status to Pending if it's currently success
                        if (paymentStatusSelect.value === 'success') {
                            paymentStatusSelect.value = 'pending';
                        }
                    }
                });
            }

            function recalculate() {
                if (!checkInInput || !checkOutInput || !roomPrice) return;

                const checkIn = new Date(checkInInput.value);
                const checkOut = new Date(checkOutInput.value);

                if (checkIn && checkOut && checkOut > checkIn) {
                    const diffTime = Math.abs(checkOut - checkIn);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    const subtotal = roomPrice * diffDays;
                    const serviceFee = Math.round(subtotal * 0.05);
                    const newTotal = subtotal + serviceFee;

                    // Update UI
                    valTotalPrice.innerText = 'TK ' + newTotal.toLocaleString();
                    if (daysIndicator) daysIndicator.innerText = 'Stay Duration: ' + diffDays + ' Nights';

                    // If full payment wasn't confirmed yet, update the banner based on current input
                    if (!paymentCompleteCheckbox.checked) {
                        updateDue(newTotal, parseFloat(amountPaidInput.value));
                    } else {
                        // If it was checked, force it to match new total
                        amountPaidInput.value = newTotal;
                        updateDue(newTotal, newTotal);
                    }
                }
            }

            function updateDue(total, paid) {
                const due = total - paid;

                if (due <= 0) {
                    valDueAmount.innerHTML = '<span class="text-emerald-200">CLEARED</span>';
                    labelDue.innerText = 'Status';
                    subLabelDue.innerText = 'Balance Fully Recovered';
                    billingBanner.classList.remove('bg-slate-900');
                    billingBanner.classList.add('bg-emerald-600');
                } else {
                    valDueAmount.innerHTML = '<span class="text-rose-400">TK ' + due.toLocaleString() + '</span>';
                    labelDue.innerText = 'Remaining Due';
                    subLabelDue.innerText = 'Balance Payment Collection Required';
                    billingBanner.classList.add('bg-slate-900');
                    billingBanner.classList.remove('bg-emerald-600');
                }
            }

            if (checkInInput) checkInInput.addEventListener('change', recalculate);
            if (checkOutInput) checkOutInput.addEventListener('change', recalculate);

            // Consistency Logic: Handle status-based automation
            if (bookingStatusSelect) {
                bookingStatusSelect.addEventListener('change', function () {
                    if (this.value === 'cancelled') {
                        if (paymentCompleteCheckbox.checked) {
                            paymentCompleteCheckbox.checked = false;
                            paymentCompleteCheckbox.dispatchEvent(new Event('change'));
                        }
                        paymentStatusSelect.value = 'failed';
                    } else if (this.value === 'completed') {
                        // Automation: If service is completed, assume full payment
                        if (!paymentCompleteCheckbox.checked) {
                            paymentCompleteCheckbox.checked = true;
                            paymentCompleteCheckbox.dispatchEvent(new Event('change'));
                        }
                    } else if (this.value === 'pending' || this.value === 'confirmed') {
                        // Automation: If moved back to pending/confirmed, revert payment if it was checked
                        if (paymentCompleteCheckbox.checked) {
                            paymentCompleteCheckbox.checked = false;
                            paymentCompleteCheckbox.dispatchEvent(new Event('change'));
                        }
                    }
                });
            }

            // Bi-directional Logic: If Capture Status is manually changed
            if (paymentStatusSelect) {
                paymentStatusSelect.addEventListener('change', function () {
                    if (this.value === 'success' && !paymentCompleteCheckbox.checked) {
                        paymentCompleteCheckbox.checked = true;
                        paymentCompleteCheckbox.dispatchEvent(new Event('change'));
                    } else if ((this.value === 'pending' || this.value === 'failed') && paymentCompleteCheckbox.checked) {
                        paymentCompleteCheckbox.checked = false;
                        paymentCompleteCheckbox.dispatchEvent(new Event('change'));
                    }
                });
            }

            // Revertible Toggle Logic
            if (paymentCompleteCheckbox) {
                paymentCompleteCheckbox.addEventListener('change', function () {
                    const totalRaw = parseFloat(valTotalPrice.innerText.replace(/[^0-9]/g, ''));

                    if (this.checked) {
                        // Security Confirmation
                        if (!confirm("Are you sure this user has completed full payment?")) {
                            this.checked = false;
                            return;
                        }

                        // Set to Full Payment State
                        amountPaidInput.value = totalRaw;
                        paymentStatusSelect.value = 'success';
                        updateDue(totalRaw, totalRaw);

                        // Visual feedback
                        this.parentElement.classList.add('bg-emerald-100', 'border-emerald-300');
                    } else {
                        // Revert to Original State
                        amountPaidInput.value = originalAmount;
                        // Only revert status if it's currently completed but shouldn't be
                        // (If the current status is what was set by automation)
                        if (bookingStatusSelect.value === 'completed' && originalStatus !== 'completed') {
                            bookingStatusSelect.value = originalStatus;
                        }

                        // Consistency Intelligence: If status is cancelled, force failed. 
                        // If amount is still partial, keep status as pending.
                        if (bookingStatusSelect.value === 'cancelled') {
                            paymentStatusSelect.value = 'failed';
                        } else {
                            paymentStatusSelect.value = (originalAmount < totalRaw) ? 'pending' : originalPaymentStatus;
                        }

                        updateDue(totalRaw, originalAmount);

                        // Visual feedback removal
                        this.parentElement.classList.remove('bg-emerald-100', 'border-emerald-300');
                    }
                });
            }

            // Revert to Initial Deposit Logic (Super Admin)
            const btnRevertDeposit = document.getElementById('btn-revert-deposit');
            if (btnRevertDeposit) {
                btnRevertDeposit.addEventListener('click', function () {
                    const depositAmount = parseFloat(this.getAttribute('data-amount'));
                    if (confirm('Revert payment to the original deposit of TK ' + depositAmount + '?')) {
                        amountPaidInput.value = depositAmount;
                        // Trigger input event to update card and check consistency
                        amountPaidInput.dispatchEvent(new Event('input'));
                    }
                });
            }

            // Initialize UI on load
            const initialTotal = parseFloat(valTotalPrice.innerText.replace(/[^0-9]/g, ''));
            updateDue(initialTotal, originalAmount);

            // Auto-check if already fully paid on load
            if (originalAmount >= initialTotal && !paymentCompleteCheckbox.checked) {
                paymentCompleteCheckbox.checked = true;
                paymentCompleteCheckbox.parentElement.classList.add('bg-emerald-100', 'border-emerald-300');
            }
        });
    </script>
@endpush