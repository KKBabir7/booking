@extends('layouts.admin')

@section('header', 'Payment Settings')

@section('content')
<div class="card-premium p-0 overflow-hidden">
    <!-- Tabs Header -->
    <div class="bg-slate-50 border-b border-slate-100 p-2 flex gap-2">
        <button onclick="switchTab('gateway')" id="tab-btn-gateway" class="tab-btn px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all active">
            <i class="bi bi-shield-lock-fill me-2"></i> Gateway Configuration
        </button>
        <button onclick="switchTab('rooms')" id="tab-btn-rooms" class="tab-btn px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
            <i class="bi bi-door-open-fill me-2"></i> Room Partial Payment
        </button>
        <button onclick="switchTab('conference')" id="tab-btn-conference" class="tab-btn px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
            <i class="bi bi-megaphone-fill me-2"></i> Conference Partial
        </button>
        <button onclick="switchTab('restaurant')" id="tab-btn-restaurant" class="tab-btn px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
            <i class="bi bi-egg-fried me-2"></i> Restaurant Advance
        </button>
    </div>

    <div class="p-8">
        <!-- 1. Gateway Tab -->
        <div id="tab-gateway" class="tab-content">
            <div class="max-w-2xl">
                <h4 class="text-lg font-bold text-slate-800 mb-2">SSLCommerz Configuration</h4>
                <p class="text-sm text-slate-500 mb-8">Manage your payment gateway credentials and environments here.</p>

                <form action="{{ route('admin.payment-settings.gateway.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Store ID</label>
                        <input type="text" name="sslcz_store_id" value="{{ $settings['sslcz_store_id'] ?? '' }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Store Password</label>
                        <input type="password" name="sslcz_store_password" value="{{ $settings['sslcz_store_password'] ?? '' }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Working Mode</label>
                        <div class="flex gap-4">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="sslcz_mode" value="sandbox" class="peer hidden" {{ ($settings['sslcz_mode'] ?? 'sandbox') === 'sandbox' ? 'checked' : '' }}>
                                <div class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-center text-sm font-bold text-slate-500 peer-checked:bg-amber-50 peer-checked:border-amber-500 peer-checked:text-amber-700 transition-all">
                                    Sandbox (Testing)
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="sslcz_mode" value="live" class="peer hidden" {{ ($settings['sslcz_mode'] ?? '') === 'live' ? 'checked' : '' }}>
                                <div class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-center text-sm font-bold text-slate-500 peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 transition-all">
                                    Live (Production)
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="px-8 py-4 bg-indigo-600 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-500/20 transition-all">
                            Save Gateway Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 2. Rooms Tab -->
        <div id="tab-rooms" class="tab-content hidden">
            <h4 class="text-lg font-bold text-slate-800 mb-2">Room Partial Payment Policies</h4>
            <p class="text-sm text-slate-500 mb-8">Set up to 3 percentage variants (e.g., 30, 50, 100) per room.</p>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Room Name</th>
                            <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Type</th>
                            <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Current Price</th>
                            <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Payment Options (%)</th>
                            <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($rooms as $room)
                        <tr>
                            <td class="px-6 py-4 font-bold text-slate-700 text-sm">{{ $room->name }}</td>
                            <td class="px-6 py-4 text-xs font-medium text-slate-400 uppercase">{{ $room->room_type }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-indigo-600">{{ $room->price }} TK</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.payment-settings.partial-payment.update') }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="type" value="room">
                                    <input type="hidden" name="id" value="{{ $room->id }}">
                                    <input type="text" name="options" value="{{ $room->partial_payment_options ?? '50, 70, 100' }}" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold focus:ring-2 focus:ring-indigo-500 outline-none w-48">
                                    <button type="submit" class="p-2 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-600 hover:text-white transition-all">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-[10px] text-slate-400 italic">Auto Sync Active</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. Conference Tab -->
        <div id="tab-conference" class="tab-content hidden">
            <h4 class="text-lg font-bold text-slate-800 mb-2">Conference Hall Payment Policies</h4>
            <p class="text-sm text-slate-500 mb-8">Set dynamic installment options for conference hall bookings.</p>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Hall Name</th>
                            <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Base Price</th>
                            <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Allowed Options (%)</th>
                            <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($halls as $hall)
                        <tr>
                            <td class="px-6 py-4 font-bold text-slate-700 text-sm">{{ $hall->name }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-indigo-600">{{ $hall->price }} TK</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.payment-settings.partial-payment.update') }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="type" value="conference">
                                    <input type="hidden" name="id" value="{{ $hall->id }}">
                                    <input type="text" name="options" value="{{ $hall->partial_payment_options ?? '50, 70, 100' }}" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold focus:ring-2 focus:ring-indigo-500 outline-none w-48">
                                    <button type="submit" class="p-2 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-600 hover:text-white transition-all">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-right text-xs text-slate-400">
                                Max 3 values allowed
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 4. Restaurant Tab -->
        <div id="tab-restaurant" class="tab-content hidden">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h4 class="text-lg font-bold text-slate-800 mb-2">Restaurant Advance Settings</h4>
                    <p class="text-sm text-slate-500">Manage dining venues and their fixed reservation deposits.</p>
                </div>
                <button onclick="showRestaurantModal()" class="px-6 py-3 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:shadow-lg transition-all">
                    Add New Venue
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($restaurants as $restaurant)
                <div class="p-6 border border-slate-100 rounded-3xl bg-slate-50/50 hover:bg-white hover:border-indigo-200 transition-all group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center">
                            <i class="bi bi-egg-fried text-xl"></i>
                        </div>
                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-all">
                            <button onclick="editRestaurant({{ $restaurant->id }}, '{{ $restaurant->name }}', {{ $restaurant->advance_amount }})" class="p-2 text-slate-400 hover:text-indigo-600"><i class="bi bi-pencil-square"></i></button>
                            <form action="{{ route('admin.restaurants.destroy', $restaurant->id) }}" method="POST" onsubmit="return confirm('Delete this venue?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600"><i class="bi bi-trash3-fill"></i></button>
                            </form>
                        </div>
                    </div>
                    <h5 class="font-black text-slate-700 uppercase tracking-tight mb-1">{{ $restaurant->name }}</h5>
                    <div class="text-2xl font-black text-indigo-600">{{ $restaurant->advance_amount }} <span class="text-xs text-slate-400">TK Advance</span></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Restaurant Modal -->
<div id="restModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="p-8">
            <h5 id="restModalTitle" class="text-xl font-bold text-slate-800 mb-6">Add New Venue</h5>
            <form id="restForm" action="{{ route('admin.restaurants.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" id="restMethod" value="POST">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Venue Name</label>
                    <input type="text" name="name" id="restName" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Advance Amount (TK)</label>
                    <input type="number" name="advance_amount" id="restAmount" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-sm">
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="hideRestaurantModal()" class="flex-1 py-3 text-xs font-black uppercase text-slate-400 tracking-widest">Cancel</button>
                    <button type="submit" class="flex-1 py-3 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-600/20">Save Venue</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<style>
    .tab-btn.active {
        background: white;
        color: #4f46e5;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .tab-btn:not(.active) {
        color: #94a3b8;
    }
    .tab-btn:not(.active):hover {
        color: #64748b;
        background: rgba(255,255,255,0.5);
    }
</style>

<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
        
        document.getElementById('tab-' + tabId).classList.remove('hidden');
        document.getElementById('tab-btn-' + tabId).classList.add('active');
        localStorage.setItem('payment_setting_active_tab', tabId);
    }

    // Restore last active tab
    const lastTab = localStorage.getItem('payment_setting_active_tab');
    if(lastTab) switchTab(lastTab);

    function showRestaurantModal() {
        document.getElementById('restForm').action = "{{ route('admin.restaurants.store') }}";
        document.getElementById('restMethod').value = "POST";
        document.getElementById('restModalTitle').innerText = "Add New Venue";
        document.getElementById('restName').value = "";
        document.getElementById('restAmount').value = "";
        document.getElementById('restModal').classList.remove('hidden');
    }

    function hideRestaurantModal() {
        document.getElementById('restModal').classList.add('hidden');
    }

    function editRestaurant(id, name, amount) {
        document.getElementById('restForm').action = "/admin/restaurants/" + id;
        document.getElementById('restMethod').value = "PUT";
        document.getElementById('restModalTitle').innerText = "Edit Venue";
        document.getElementById('restName').value = name;
        document.getElementById('restAmount').value = amount;
        document.getElementById('restModal').classList.remove('hidden');
    }
</script>
@endpush
@endsection
