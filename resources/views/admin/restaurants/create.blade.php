@extends('layouts.admin')

@section('header', 'Add New Restaurant')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.page.edit', 'restaurant') }}" class="text-indigo-600 hover:text-indigo-800 font-bold flex items-center gap-2">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

<div class="max-w-2xl">
    <div class="card-premium p-8">
        <form action="{{ route('admin.restaurants.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Restaurant Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-slate-800"
                        placeholder="e.g. Rooftop Cafe">
                </div>

                <!-- Advance Amount -->
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Fixed Advance Amount (TK) *</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">TK</span>
                        <input type="number" step="0.01" name="advance_amount" value="{{ old('advance_amount', 0) }}" required
                            class="w-full pl-12 pr-4 py-3 bg-indigo-50/30 border border-indigo-100 rounded-2xl text-sm font-black text-indigo-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                    </div>
                </div>

                <!-- Image -->
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Representative Image</label>
                    <div class="p-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl text-center">
                        <input type="file" name="image" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all">
                    </div>
                </div>

                <!-- Active Status -->
                <div class="flex items-center gap-3 p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked class="w-5 h-5 text-indigo-600 border-slate-200 rounded focus:ring-indigo-500">
                    <label for="is_active" class="text-sm font-bold text-slate-700 cursor-pointer mb-0">Visible to Public</label>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="px-10 py-4 bg-indigo-600 text-white text-sm font-black rounded-3xl hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition-all active:scale-95 uppercase tracking-widest">
                        Create Restaurant
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
