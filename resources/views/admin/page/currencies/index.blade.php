@extends('layouts.admin')

@section('header', 'Currency Management')

@section('content')

<!-- Statistics Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="card-premium p-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center">
                <i class="bi bi-currency-exchange fs-4"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Currencies</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $currencies->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="card-premium p-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                <i class="bi bi-check-circle-fill fs-4"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Active</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $currencies->where('is_active', true)->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="card-premium p-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
                <i class="bi bi-star-fill fs-4"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Base Currency</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $currencies->where('is_default', true)->first()->code ?? 'None' }}</h3>
            </div>
        </div>
    </div>
    <div class="card-premium p-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="bi bi-clock-history fs-4"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Last Updated</p>
                <h3 class="text-sm font-bold text-slate-800">{{ $currencies->max('updated_at')?->diffForHumans() ?? 'Never' }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Main Management Card -->
<div class="card-premium p-8">
    <div class="flex flex-col md:flex-row justify-between items-md-center mb-8 gap-4">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Available Currencies</h3>
            <p class="text-sm text-slate-500">Manage exchange rates and global currency visibility.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <form action="{{ route('admin.currencies.refresh-rates') }}" method="POST">
                @csrf
                <button type="submit" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-6 rounded-lg transition-all flex items-center gap-2">
                    <i class="bi bi-arrow-repeat"></i> Refresh Rates
                </button>
            </form>
            <button onclick="openCreateModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                <i class="bi bi-plus-lg"></i> Add New Currency
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-y border-slate-100">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Currency Info</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Symbol</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Rate (vs BDT)</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Default</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($currencies as $currency)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center font-bold text-slate-600">
                                {{ $currency->code }}
                            </div>
                            <div>
                                <span class="block font-bold text-slate-700">{{ $currency->name }}</span>
                                <span class="text-xs text-slate-400">ID: #{{ $currency->id }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg font-bold">{{ $currency->symbol }}</span>
                    </td>
                    <td class="px-6 py-4 font-mono font-bold text-slate-700">
                        {{ number_format($currency->exchange_rate, 4) }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.currencies.toggle-status', $currency) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $currency->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $currency->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($currency->is_default)
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-[10px] font-black uppercase tracking-wider">Base</span>
                        @else
                            <form action="{{ route('admin.currencies.set-default', $currency) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-indigo-600 hover:text-indigo-800 text-xs font-bold">Set Default</button>
                            </form>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-3 text-sm">
                            <button onclick='openEditModal(@json($currency))' class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            @if(!$currency->is_default && $currency->code !== 'BDT')
                            <form action="{{ route('admin.currencies.destroy', $currency) }}" method="POST" onsubmit="return confirm('Delete this currency?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Tailwind Modal Backdrop (Universal) -->
<div id="modalBackdrop" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[9998] hidden transition-opacity duration-300 opacity-0"></div>

<!-- Create Modal -->
<div id="createModal" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-white rounded-2xl shadow-2xl z-[9999] hidden transition-all duration-300 scale-95 opacity-0">
    <div class="p-8">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-slate-800">Add New Currency</h3>
            <button onclick="closeModal('createModal')" class="text-slate-400 hover:text-slate-600"><i class="bi bi-x-lg"></i></button>
        </div>
        <form action="{{ route('admin.currencies.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Code (e.g. USD)</label>
                    <input type="text" name="code" required maxlength="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-300 outline-none uppercase">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Symbol (e.g. $)</label>
                    <input type="text" name="symbol" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-300 outline-none">
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Currency Name</label>
                <input type="text" name="name" required placeholder="e.g. US Dollar" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-300 outline-none">
            </div>
            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Exchange Rate (vs BDT)</label>
                <input type="number" step="0.000001" name="exchange_rate" required placeholder="1 BDT = ?" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-300 outline-none">
                <p class="text-[10px] text-slate-400 mt-1">Example: 1 BDT ≈ 0.0085 USD</p>
            </div>
            <div class="mb-6 flex items-center gap-2">
                <input type="checkbox" name="is_active" id="create_active" checked class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                <label for="create_active" class="text-sm font-semibold text-slate-700">Active by default</label>
            </div>
            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="closeModal('createModal')" class="px-6 py-2.5 font-bold text-slate-500 hover:text-slate-700">Cancel</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-8 rounded-xl transition-all shadow-md">Save Currency</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-white rounded-2xl shadow-2xl z-[9999] hidden transition-all duration-300 scale-95 opacity-0">
    <div class="p-8">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-slate-800">Edit Currency <span id="editCodeHeader" class="text-indigo-600"></span></h3>
            <button onclick="closeModal('editModal')" class="text-slate-400 hover:text-slate-600"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Code</label>
                    <input type="text" name="code" id="edit_code" required maxlength="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-300 outline-none uppercase">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Symbol</label>
                    <input type="text" name="symbol" id="edit_symbol" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-300 outline-none">
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Currency Name</label>
                <input type="text" name="name" id="edit_name" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-300 outline-none">
            </div>
            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Exchange Rate (vs BDT)</label>
                <input type="number" step="0.000001" name="exchange_rate" id="edit_rate" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-300 outline-none">
            </div>
            <div class="mb-6 flex items-center gap-2">
                <input type="checkbox" name="is_active" id="edit_active" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                <label for="edit_active" class="text-sm font-semibold text-slate-700">Active</label>
            </div>
            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="closeModal('editModal')" class="px-6 py-2.5 font-bold text-slate-500 hover:text-slate-700">Cancel</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-8 rounded-xl transition-all shadow-md">Update Currency</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openCreateModal() {
        showModal('createModal');
    }

    function openEditModal(currency) {
        // Populate form
        const form = document.getElementById('editForm');
        form.action = `{{ url('admin/currencies') }}/${currency.id}`;
        
        document.getElementById('editCodeHeader').textContent = `(${currency.code})`;
        document.getElementById('edit_code').value = currency.code;
        document.getElementById('edit_name').value = currency.name;
        document.getElementById('edit_symbol').value = currency.symbol;
        document.getElementById('edit_rate').value = currency.exchange_rate;
        document.getElementById('edit_active').checked = !!currency.is_active;

        showModal('editModal');
    }

    function showModal(id) {
        const modal = document.getElementById(id);
        const backdrop = document.getElementById('modalBackdrop');
        
        modal.classList.remove('hidden');
        backdrop.classList.remove('hidden');
        
        setTimeout(() => {
            modal.classList.add('scale-100', 'opacity-100');
            modal.classList.remove('scale-95', 'opacity-0');
            backdrop.classList.add('opacity-100');
            backdrop.classList.remove('opacity-0');
        }, 10);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        const backdrop = document.getElementById('modalBackdrop');
        
        modal.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('scale-100', 'opacity-100');
        backdrop.classList.add('opacity-0');
        backdrop.classList.remove('opacity-100');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            backdrop.classList.add('hidden');
        }, 300);
    }

    // Close on backdrop click
    document.getElementById('modalBackdrop').addEventListener('click', function() {
        const createModal = document.getElementById('createModal');
        const editModal = document.getElementById('editModal');
        
        if (!createModal.classList.contains('hidden')) closeModal('createModal');
        if (!editModal.classList.contains('hidden')) closeModal('editModal');
    });
</script>
@endpush

@endsection
