@php use App\Models\PaymentSetting; @endphp
@extends('layouts.admin')

@section('header', 'Payment Settings')

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.payment-settings.update') }}" method="POST">
        @csrf
        
        <!-- 1. SSLCommerz Configuration -->
        <div class="card-premium p-8 mb-8 border-l-4 border-indigo-500">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center shadow-sm">
                        <i class="bi bi-shield-lock-fill fs-4"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">SSLCommerz Gateway</h3>
                        <p class="text-sm text-slate-500">Global payment gateway credentials and environment mode.</p>
                    </div>
                </div>
                <div class="px-4 py-2 bg-indigo-50 rounded-xl">
                    <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Active Provider</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Store ID</label>
                    <input type="text" name="ssl_store_id" value="{{ PaymentSetting::where('key', 'ssl_store_id')->first()->value ?? '' }}" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Store Password</label>
                    <input type="password" name="ssl_store_password" value="{{ PaymentSetting::where('key', 'ssl_store_password')->first()->value ?? '' }}" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                </div>
                
                <div class="md:col-span-2 space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Gateway Mode</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="gateway-mode-label group relative flex items-center p-4 border-2 rounded-2xl cursor-pointer transition-all border-slate-100 hover:bg-slate-50">
                            <input type="radio" name="ssl_mode" value="sandbox" class="absolute opacity-0" 
                                {{ (PaymentSetting::where('key', 'ssl_mode')->first()->value ?? 'sandbox') === 'sandbox' ? 'checked' : '' }}>
                            
                            <!-- Checkmark icon -->
                            <div class="checkmark-icon absolute top-2 right-2 w-5 h-5 bg-indigo-600 text-white rounded-full flex items-center justify-center scale-0 transition-transform">
                                <i class="bi bi-check-lg text-[10px]"></i>
                            </div>

                            <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center mr-4">
                                <i class="bi bi-bug-fill"></i>
                            </div>
                            <div>
                                <span class="block text-sm font-black text-slate-700">Sandbox</span>
                                <span class="block text-[10px] text-slate-400 uppercase font-bold tracking-wider">Test Environment</span>
                            </div>
                        </label>
                        
                        <label class="gateway-mode-label group relative flex items-center p-4 border-2 rounded-2xl cursor-pointer transition-all border-slate-100 hover:bg-slate-50">
                            <input type="radio" name="ssl_mode" value="live" class="absolute opacity-0" 
                                {{ (PaymentSetting::where('key', 'ssl_mode')->first()->value ?? '') === 'live' ? 'checked' : '' }}>
                            
                            <!-- Checkmark icon -->
                            <div class="checkmark-icon absolute top-2 right-2 w-5 h-5 bg-emerald-600 text-white rounded-full flex items-center justify-center scale-0 transition-transform">
                                <i class="bi bi-check-lg text-[10px]"></i>
                            </div>

                            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mr-4">
                                <i class="bi bi-broadcast"></i>
                            </div>
                            <div>
                                <span class="block text-sm font-black text-slate-700">Live</span>
                                <span class="block text-[10px] text-slate-400 uppercase font-bold tracking-wider">Production Environment</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end">
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white text-xs font-black rounded-2xl hover:bg-indigo-700 transition-all uppercase tracking-widest shadow-lg shadow-indigo-200">
                    Update Gateway Credentials
                </button>
            </div>
        </div>
    </form>

    <div class="mb-10 mt-12">
        <h3 class="text-2xl font-black text-slate-800 tracking-tight">Service Payment Rules</h3>
        <p class="text-sm text-slate-500">Manage partial payment percentages and advance fees for each booking type.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-20">
        <!-- 2. Guest Rooms Payments -->
        <div class="card-premium p-8 border-t-4 border-emerald-500">
            <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                <i class="bi bi-door-open-fill fs-3"></i>
            </div>
            <h4 class="text-lg font-black text-slate-800 mb-2">Guest Rooms</h4>
            <p class="text-xs text-slate-500 font-bold leading-relaxed mb-6">Manage dynamic partial payment percentages (e.g. 30%, 50%, 100%) individually for each room listing.</p>
            
            <div class="space-y-3 mb-8">
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Rooms</span>
                    <span class="text-sm font-black text-slate-700">{{ $roomSummary->count() }}</span>
                </div>
                <div class="p-3 bg-emerald-50/50 rounded-xl border border-emerald-100/50">
                    <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest block mb-2 text-center">Active Configurations</span>
                    <div class="flex flex-wrap gap-1 justify-center">
                        @foreach($roomSummary->take(4) as $room)
                            <div class="px-2 py-1 bg-white border border-emerald-100 rounded text-[9px] font-bold text-emerald-700" title="{{ $room->name }}">
                                {{ count($room->partial_payments ?? []) }} Options
                            </div>
                        @endforeach
                        @if($roomSummary->count() > 4)
                            <div class="px-2 py-1 bg-white border border-emerald-100 rounded text-[9px] font-bold text-emerald-400">+{{ $roomSummary->count() - 4 }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.rooms.index') }}" class="flex items-center justify-center w-full py-4 bg-emerald-600 text-white text-[10px] font-black rounded-2xl hover:bg-emerald-700 transition-all uppercase tracking-widest shadow-lg shadow-emerald-100">
                Go to Room Management <i class="bi bi-arrow-right-short fs-5 ms-1"></i>
            </a>
        </div>

        <!-- 3. Conference Hall Payments -->
        <div class="card-premium p-8 border-t-4 border-amber-500">
            <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                <i class="bi bi-megaphone-fill fs-3"></i>
            </div>
            <h4 class="text-lg font-black text-slate-800 mb-2">Conference Hub</h4>
            <p class="text-xs text-slate-500 font-bold leading-relaxed mb-6">Configure partial booking options for event spaces. Each hall can have its own payment policy.</p>
            
            <div class="space-y-3 mb-8">
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Halls</span>
                    <span class="text-sm font-black text-slate-700">{{ $hallSummary->count() }}</span>
                </div>
                <div class="p-3 bg-amber-50/50 rounded-xl border border-amber-100/50">
                    <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest block mb-1">Payment Status</span>
                    <div class="text-[10px] font-bold text-slate-600">All halls currently support up to 3 payment percentage options for online booking.</div>
                </div>
            </div>

            <a href="{{ route('admin.conference.index') }}" class="flex items-center justify-center w-full py-4 bg-amber-600 text-white text-[10px] font-black rounded-2xl hover:bg-amber-700 transition-all uppercase tracking-widest shadow-lg shadow-amber-100">
                Manage Hall Payments <i class="bi bi-arrow-right-short fs-5 ms-1"></i>
            </a>
        </div>

        <!-- 4. Restaurant Outlets Payments -->
        <div class="card-premium p-8 border-t-4 border-rose-500">
            <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                <i class="bi bi-egg-fried fs-3"></i>
            </div>
            <h4 class="text-lg font-black text-slate-800 mb-2">Restaurant Outlets</h4>
            <p class="text-xs text-slate-500 font-bold leading-relaxed mb-6">Manage fixed advance booking fees (TK) for each restaurant outlet. No percentage calculation applied here.</p>
            
            <div class="space-y-3 mb-8">
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Outlets</span>
                    <span class="text-sm font-black text-slate-700">{{ $restaurantSummary->count() }}</span>
                </div>
                <div class="p-3 bg-rose-50/50 rounded-xl border border-rose-100/50">
                    <span class="text-[10px] font-black text-rose-600 uppercase tracking-widest block mb-2">Advance Fees</span>
                    <div class="space-y-2">
                        @foreach($restaurantSummary as $res)
                            <div class="flex justify-between items-center text-[10px]">
                                <span class="font-bold text-slate-500 italic truncate me-2">{{ $res->name }}:</span>
                                <span class="font-black text-rose-700">{{ $res->advance_amount }} TK</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.page.edit', 'restaurant') }}" class="flex items-center justify-center w-full py-4 bg-rose-600 text-white text-[10px] font-black rounded-2xl hover:bg-rose-700 transition-all uppercase tracking-widest shadow-lg shadow-rose-100">
                Setup Advance Fees <i class="bi bi-arrow-right-short fs-5 ms-1"></i>
            </a>
        </div>
    </div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radioLabels = document.querySelectorAll('.gateway-mode-label');
            const radios = document.querySelectorAll('input[name="ssl_mode"]');

            function updateUI() {
                radios.forEach(radio => {
                    const label = radio.closest('.gateway-mode-label');
                    const checkmark = label.querySelector('.checkmark-icon');
                    const isChecked = radio.checked;

                    if (isChecked) {
                        const activeColor = radio.value === 'sandbox' ? 'border-indigo-500 bg-indigo-50/50' : 'border-emerald-500 bg-emerald-50/50';
                        label.className = `gateway-mode-label group relative flex items-center p-4 border-2 rounded-2xl cursor-pointer transition-all ${activeColor}`;
                        checkmark.classList.remove('scale-0');
                        checkmark.classList.add('scale-100');
                    } else {
                        label.className = `gateway-mode-label group relative flex items-center p-4 border-2 rounded-2xl cursor-pointer transition-all border-slate-100 hover:bg-slate-50`;
                        checkmark.classList.add('scale-0');
                        checkmark.classList.remove('scale-100');
                    }
                });
            }

            radios.forEach(radio => {
                radio.addEventListener('change', updateUI);
            });

            // Initial call
            updateUI();
        });
    </script>
@endsection
