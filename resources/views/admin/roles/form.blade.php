@extends('layouts.admin')

@section('header', $title)

@section('content')
<div class="max-w-5xl mx-auto">
    <form action="{{ $action }}" method="POST" class="space-y-8">
        @csrf
        @if($method === 'PUT') @method('PUT') @endif

        <!-- Card: Basic Info -->
        <div class="card-premium p-8">
            <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
                <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                    <i class="bi bi-shield-check fs-4"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-800">Role Information</h3>
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mt-0.5">Primary identification level</p>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-black text-slate-700 mb-2">Role Display Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required 
                        placeholder="e.g. Booking Manager, Frontend Editor"
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold text-slate-800">
                    <p class="text-[11px] text-slate-400 mt-2 italic font-medium px-1">This name will appear in dropdowns across the system</p>
                </div>
            </div>
        </div>

        <!-- Card: Permissions Grid -->
        <div class="card-premium p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-12 -mt-6 -mr-6 opacity-5 pointer-events-none">
                <i class="bi bi-key-fill text-9xl"></i>
            </div>

            <div class="flex items-center justify-between mb-10 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500 flex items-center justify-center text-white shadow-lg shadow-amber-200">
                        <i class="bi bi-key fs-4"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800">Configure Permissions</h3>
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mt-0.5">Define what this role can and cannot do</p>
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <button type="button" onclick="toggleAll(true)" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-all">Select All</button>
                    <button type="button" onclick="toggleAll(false)" class="px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-400 rounded-xl text-xs font-bold transition-all border border-slate-100">Deselect All</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                @foreach($permissionsByModule as $module => $permissions)
                <div class="bg-slate-50/50 rounded-3xl p-6 border border-slate-100">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-2 h-6 bg-indigo-500 rounded-full"></div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">{{ $module }}</h4>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($permissions as $permission)
                        <label class="flex items-center group cursor-pointer">
                            <div class="relative flex items-center">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                    class="peer h-6 w-6 rounded-lg border-2 border-slate-200 text-indigo-600 focus:ring-4 focus:ring-indigo-100 transition-all cursor-pointer"
                                    {{ (isset($rolePermissions) && in_array($permission->id, $rolePermissions)) ? 'checked' : '' }}>
                                <div class="absolute inset-0 pointer-events-none opacity-0 peer-checked:opacity-100 flex items-center justify-center transition-opacity">
                                    <i class="bi bi-check-lg text-indigo-600 font-black"></i>
                                </div>
                            </div>
                            <div class="ml-4 transition-all group-hover:translate-x-1">
                                <span class="block text-sm font-bold text-slate-700 leading-none mb-1">{{ $permission->name }}</span>
                                <span class="block text-[10px] text-slate-400 font-medium uppercase tracking-tighter">{{ $permission->slug }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-between pb-12 pt-4">
            <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-2 text-slate-400 hover:text-slate-800 font-bold transition-all">
                <i class="bi bi-arrow-left"></i> Cancel and go back
            </a>
            
            <button type="submit" class="btn-premium px-12 py-4 rounded-2xl text-lg font-black flex items-center gap-3">
                <i class="bi bi-check2-circle"></i> {{ $method === 'PUT' ? 'Apply changes' : 'Create role' }}
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function toggleAll(status) {
        document.querySelectorAll('input[type="checkbox"][name="permissions[]"]').forEach(cb => {
            cb.checked = status;
        });
    }
</script>
@endpush
@endsection
