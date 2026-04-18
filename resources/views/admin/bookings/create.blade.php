@extends('layouts.admin')

@section('header', 'New Offline Booking')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 48px;
        padding: 10px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px;
    }
    .booking-type-card.active {
        border-color: #6366f1;
        background-color: #f5f3ff;
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.1);
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card-premium p-8">
        <div class="mb-8">
            <h3 class="text-xl font-bold text-slate-800 tracking-tight">Create Manual Reservation</h3>
            <p class="text-sm text-slate-500">Enter guest details and select the required service for offline booking.</p>
        </div>

        <form action="{{ route('admin.bookings.store') }}" method="POST" id="offlineBookingForm">
            @csrf

            <!-- 1. Select Booking Type -->
            <div class="mb-10">
                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4">Service Category</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="booking-type-card relative flex flex-col items-center p-6 border-2 border-slate-100 rounded-3xl cursor-pointer transition-all hover:bg-slate-50">
                        <input type="radio" name="booking_type" value="room" class="absolute inset-0 opacity-0 cursor-pointer" checked>
                        <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-3">
                            <i class="bi bi-door-open-fill fs-4"></i>
                        </div>
                        <span class="text-sm font-black text-slate-700 uppercase tracking-tight">Guest Room</span>
                        <div class="type-indicator absolute top-3 right-3 w-4 h-4 rounded-full border-2 border-indigo-200"></div>
                    </label>

                    <label class="booking-type-card relative flex flex-col items-center p-6 border-2 border-slate-100 rounded-3xl cursor-pointer transition-all hover:bg-slate-50">
                        <input type="radio" name="booking_type" value="conference" class="absolute inset-0 opacity-0 cursor-pointer">
                        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-3">
                            <i class="bi bi-megaphone-fill fs-4"></i>
                        </div>
                        <span class="text-sm font-black text-slate-700 uppercase tracking-tight">Conference</span>
                        <div class="type-indicator absolute top-3 right-3 w-4 h-4 rounded-full border-2 border-slate-200"></div>
                    </label>

                    <label class="booking-type-card relative flex flex-col items-center p-6 border-2 border-slate-100 rounded-3xl cursor-pointer transition-all hover:bg-slate-50">
                        <input type="radio" name="booking_type" value="restaurant" class="absolute inset-0 opacity-0 cursor-pointer">
                        <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center mb-3">
                            <i class="bi bi-egg-fried fs-4"></i>
                        </div>
                        <span class="text-sm font-black text-slate-700 uppercase tracking-tight">Restaurant</span>
                        <div class="type-indicator absolute top-3 right-3 w-4 h-4 rounded-full border-2 border-rose-200"></div>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- 2. Guest Information -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Guest Information</label>
                        <select name="user_id" id="userSelect" class="w-full">
                            <option value="">-- Create New Walk-in Guest --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->phone ?? $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="new_guest_fields" class="space-y-4 pt-4 border-t border-slate-100 mt-4">
                        <div>
                            <input type="text" name="guest_name" placeholder="Guest Full Name" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500">
                        </div>
                        <div>
                            <input type="email" name="guest_email" placeholder="Email Address" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500">
                        </div>
                        <div>
                            <input type="text" name="guest_phone" placeholder="Phone Number" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- 3. Service Details -->
                <div class="space-y-6">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Reservation Details</label>
                    
                    <!-- Room Fields -->
                    <div id="group_room" class="service-group space-y-4">
                        <select name="room_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold focus:outline-none">
                            <option value="">Select Room...</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" 
                                    data-price="{{ $room->price }}"
                                    data-partial-payments='@json($room->partial_payments ?? [50, 70, 100])'>
                                    {{ $room->name }} ({{ $room->room_type }})
                                </option>
                            @endforeach
                        </select>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="date" name="check_in" class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold">
                            <input type="date" name="check_out" class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold">
                        </div>
                    </div>

                    <div id="group_conference" class="service-group space-y-4 hidden">
                        <select name="hall_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold focus:outline-none">
                            <option value="">Select Hall...</option>
                            @foreach($halls as $hall)
                                <option value="{{ $hall->id }}" 
                                    data-price="{{ $hall->price }}"
                                    data-partial-payments='@json($hall->partial_payments ?? [50, 70, 100])'>
                                    {{ $hall->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="date" name="check_in" id="hall_check_in" class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold" disabled>
                            <input type="date" name="check_out" id="hall_check_out" class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold" disabled>
                        </div>
                    </div>

                    <!-- Restaurant Fields -->
                    <div id="group_restaurant" class="service-group space-y-4 hidden">
                        <select name="restaurant_title" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold">
                            <option value="" disabled selected>Select Restaurant...</option>
                            @foreach($restaurants as $res)
                                <option value="{{ $res->name }}" data-advance="{{ $res->advance_amount }}">{{ $res->name }}</option>
                            @endforeach
                        </select>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="date" name="date" class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold">
                            <select name="time_slot" class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold">
                                <option value="Breakfast (8:00 AM - 10:30 AM)">Breakfast</option>
                                <option value="Lunch (12:30 PM - 3:30 PM)" selected>Lunch</option>
                                <option value="Dinner (7:30 PM - 10:30 PM)">Dinner</option>
                                <option value="Snacks & Coffee (4:00 PM - 6:30 PM)">Snacks & Coffee</option>
                            </select>
                        </div>
                    </div>

                    <!-- Financials -->
                    <div class="pt-6 border-t border-slate-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block">Total Bill (TK)</label>
                                <input type="number" name="total_price" id="total_price_input" value="0" 
                                    @if(!auth()->user()->isSuperAdmin()) readonly @endif
                                    class="w-full px-4 py-4 bg-slate-900 border-0 rounded-2xl text-emerald-400 font-bold text-xl shadow-inner {{ !auth()->user()->isSuperAdmin() ? 'opacity-90' : '' }}">
                                <div id="calc-summary" class="text-[10px] text-indigo-500 font-bold mt-2 uppercase italic hidden"></div>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block flex justify-between">
                                    <span>Advance Paid (TK)</span>
                                    <span class="text-indigo-500">Manual Entry OK</span>
                                </label>
                                <input type="number" name="amount_paid" id="amount_paid_input" value="0" class="w-full px-4 py-4 bg-indigo-50 border-0 rounded-2xl text-indigo-600 font-bold text-xl mb-3">
                                
                                <!-- Percentage Quick Picks -->
                                <div id="percentage_buttons" class="flex gap-2">
                                    <!-- Dynamic Buttons will show here -->
                                    <button type="button" onclick="setAdvance(50)" class="flex-1 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black text-slate-500 uppercase hover:bg-indigo-500 hover:text-white transition-all">50%</button>
                                    <button type="button" onclick="setAdvance(70)" class="flex-1 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black text-slate-500 uppercase hover:bg-indigo-500 hover:text-white transition-all">70%</button>
                                    <button type="button" onclick="setAdvance(100)" class="flex-1 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black text-slate-500 uppercase hover:bg-indigo-500 hover:text-white transition-all">100%</button>
                                </div>
                                <div id="restaurant_fee_hint" class="text-[9px] font-black text-rose-500 uppercase tracking-tighter mt-1 hidden">
                                    <i class="bi bi-info-circle-fill me-1"></i> Fixed Advance Fee Apply
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 flex justify-end gap-4">
                <a href="{{ route('admin.bookings.index') }}" class="px-8 py-4 text-sm font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-all">Cancel</a>
                <button type="submit" class="px-10 py-4 bg-indigo-600 text-white text-sm font-black rounded-3xl hover:bg-indigo-700 hover:shadow-2xl hover:shadow-indigo-500/20 transition-all active:scale-95 uppercase tracking-widest">
                    Confirm Offline Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#userSelect').select2();

        // Toggle New Guest Fields
        $('#userSelect').on('change', function() {
            if ($(this).val()) {
                $('#new_guest_fields').slideUp();
            } else {
                $('#new_guest_fields').slideDown();
            }
        });

        // Booking Type Switcher
        const updateType = () => {
            const selectedType = $('input[name="booking_type"]:checked').val();
            
            $('.booking-type-card').removeClass('active');
            $('input[name="booking_type"]:checked').closest('.booking-type-card').addClass('active');

            // Hide all and disable all nested inputs to avoid submission conflicts
            $('.service-group').addClass('hidden').find('input, select').prop('disabled', true);
            
            // Show selected and enable its inputs
            $(`#group_${selectedType}`).removeClass('hidden').find('input, select').prop('disabled', false);

            calculatePrice();
        };

        const calculatePrice = () => {
            const type = $('input[name="booking_type"]:checked').val();
            let total = 0;
            let summaryTxt = "";

            const cin = $('input[name="check_in"]:not(:disabled)').val();
            const cout = $('input[name="check_out"]:not(:disabled)').val();
            let diffDays = 0;

            if (cin && cout) {
                const start = new Date(cin);
                const end = new Date(cout);
                const diffTime = Math.abs(end - start);
                diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            }

            // --- Reset & Render Percentage Buttons ---
            const btnContainer = $('#percentage_buttons');
            const feeHint = $('#restaurant_fee_hint');
            btnContainer.empty();
            feeHint.addClass('hidden');

            if (type === 'room') {
                const roomSelected = $('select[name="room_id"]').find(':selected');
                const pricePerNight = roomSelected.data('price') || 0;
                const percentages = roomSelected.data('partial-payments') || [50, 70, 100];

                if (diffDays > 0 && pricePerNight > 0) {
                    total = pricePerNight * diffDays;
                    summaryTxt = `${pricePerNight} TK x ${diffDays} Night${diffDays > 1 ? 's' : ''}`;
                } else {
                    total = pricePerNight;
                }

                // Render Buttons
                percentages.forEach(p => {
                    btnContainer.append(`<button type="button" onclick="setAdvance(${p})" class="flex-1 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black text-slate-500 uppercase hover:bg-indigo-500 hover:text-white transition-all">${p}%</button>`);
                });

            } else if (type === 'conference') {
                const hallSelected = $('select[name="hall_id"]').find(':selected');
                const pricePerDay = hallSelected.data('price') || 0;
                const percentages = hallSelected.data('partial-payments') || [50, 70, 100];

                if (diffDays > 0 && pricePerDay > 0) {
                    total = pricePerDay * diffDays;
                    summaryTxt = `${pricePerDay} TK x ${diffDays} Day${diffDays > 1 ? 's' : ''}`;
                } else {
                    total = pricePerDay;
                }

                // Render Buttons
                percentages.forEach(p => {
                    btnContainer.append(`<button type="button" onclick="setAdvance(${p})" class="flex-1 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black text-slate-500 uppercase hover:bg-indigo-500 hover:text-white transition-all">${p}%</button>`);
                });

            } else {
                // Restaurant
                const resSelected = $('select[name="restaurant_title"]').find(':selected');
                const advanceFee = resSelected.data('advance') || 500;
                total = advanceFee; 
                summaryTxt = `Fixed Advance Fee for ${resSelected.val()}`;
                feeHint.removeClass('hidden');
                
                // For restaurant, advance is always 100% of the booking fee
                btnContainer.append(`<button type="button" onclick="setAdvance(100)" class="flex-1 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black text-slate-500 uppercase hover:bg-rose-500 hover:text-white transition-all">Pay Advance</button>`);
            }

            $('#total_price_input').val(total);
            if(summaryTxt) {
                $('#calc-summary').text(summaryTxt).removeClass('hidden');
            } else {
                $('#calc-summary').addClass('hidden');
            }
        };

        window.setAdvance = (percent) => {
            const total = parseFloat($('#total_price_input').val()) || 0;
            const amount = Math.round((total * percent) / 100);
            $('#amount_paid_input').val(amount);
        };

        $('input[name="booking_type"]').on('change', updateType);
        $('select[name="room_id"], select[name="hall_id"], select[name="restaurant_title"], input[type="date"]').on('change', calculatePrice);
        
        updateType(); // Initial call
    });
</script>
@endpush
