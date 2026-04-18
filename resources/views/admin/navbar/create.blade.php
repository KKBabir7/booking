@extends('layouts.admin')

@section('header', isset($item) ? 'Edit Navbar Link' : 'Add Navbar Link')

@section('content')
<style>
    .selection-card {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    input[type="radio"]:checked + .selection-card {
        background-color: #059669 !important; /* emerald-600 */
        border-color: #059669 !important;
        color: #ffffff !important;
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);
    }
</style>
<div class="max-w-3xl mx-auto">
    <div class="card-premium p-8">
        <div class="mb-8">
            <h3 class="text-xl font-bold text-slate-800">{{ isset($item) ? 'Edit Navbar Link' : 'Add New Navbar Link' }}</h3>
            <p class="text-sm text-slate-500">Configure a navigation link for your website's header</p>
        </div>

        <form action="{{ isset($item) ? route('admin.navbar.update', $item->id) : route('admin.navbar.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($item)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Display Label *</label>
                    <input type="text" name="label" value="{{ $item->label ?? '' }}" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-700 font-medium" 
                        placeholder="e.g. Home, Rooms" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">URL Path *</label>
                    <input type="text" name="url" value="{{ $item->url ?? '' }}" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-700 font-mono text-sm" 
                        placeholder="e.g. /, /rooms" required>
                </div>

                @php
                    $currentIcon = old('icon', $item->icon ?? '');
                @endphp
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Bootstrap Icon Class</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 z-10">
                            <i class="bi bi-fonts"></i>
                        </span>
                        <select name="icon" class="icon-select w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700" data-selected="{{ $currentIcon }}">
                        </select>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1 uppercase font-bold tracking-wider">Example: bi-house, bi-door-open</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Display Order</label>
                    <input type="number" name="order_column" value="{{ $item->order_column ?? 0 }}" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-700">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Display Position</label>
                <div class="flex gap-4">
                    <label class="flex-grow">
                        <input type="radio" name="position" value="top" class="hidden peer" {{ (!isset($item) || $item->position == 'top') ? 'checked' : '' }}>
                        <div class="selection-card text-center p-4 rounded-2xl border-2 border-slate-100 bg-slate-50 cursor-pointer transition-all font-bold text-sm">
                            <i class="bi bi-layout-header mr-1"></i> Top Menu
                        </div>
                    </label>
                    <label class="flex-grow">
                        <input type="radio" name="position" value="dropdown" class="hidden peer" {{ (isset($item) && $item->position == 'dropdown') ? 'checked' : '' }}>
                        <div class="selection-card text-center p-4 rounded-2xl border-2 border-slate-100 bg-slate-50 cursor-pointer transition-all font-bold text-sm">
                            <i class="bi bi-list-ul mr-1"></i> Dropdown
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Menu Status</label>
                <div class="flex gap-4">
                    <label class="flex-grow">
                        <input type="radio" name="is_active" value="1" class="hidden peer" {{ (!isset($item) || $item->is_active) ? 'checked' : '' }}>
                        <div class="selection-card text-center p-4 rounded-2xl border-2 border-slate-100 bg-slate-50 cursor-pointer transition-all font-bold text-sm">
                            <i class="bi bi-check-circle-fill mr-1"></i> Active
                        </div>
                    </label>
                    <label class="flex-grow">
                        <input type="radio" name="is_active" value="0" class="hidden peer" {{ (isset($item) && !$item->is_active) ? 'checked' : '' }}>
                        <div class="selection-card text-center p-4 rounded-2xl border-2 border-slate-100 bg-slate-50 cursor-pointer transition-all font-bold text-sm">
                            <i class="bi bi-x-circle-fill mr-1"></i> Inactive
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-4">
                <a href="{{ route('admin.navbar.index') }}" class="text-slate-500 hover:text-slate-800 font-bold text-sm">Cancel</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-10 rounded-xl transition-all shadow-md hover:shadow-lg transform active:scale-95">
                    {{ isset($item) ? 'Update Changes' : 'Create Link' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
