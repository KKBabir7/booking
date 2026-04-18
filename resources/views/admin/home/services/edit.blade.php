@extends('layouts.admin')

@section('header', isset($service) ? 'Edit Service' : 'Create Service')

@section('content')
<div class="max-w-4xl mx-auto pb-24">
    <div class="card-premium p-8">
        <div class="mb-8">
            <h3 class="text-xl font-bold text-slate-800">{{ isset($service) ? 'Edit Premium Service' : 'Create New Premium Service' }}</h3>
            <p class="text-sm text-slate-500">Configure hospitality and facility services for the home page</p>
        </div>

        <form action="{{ isset($service) ? route('admin.home_services.update', $service->id) : route('admin.home_services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @if(isset($service)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Service Title *</label>
                        <input type="text" name="title" value="{{ old('title', $service->title ?? '') }}" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-800 font-bold" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                        <textarea name="description" rows="5" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700">{{ old('description', $service->description ?? '') }}</textarea>
                    </div>

                    @php
                        $currentIcon = old('icon', $service->icon ?? 'bi-star');
                    @endphp
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Icon Class (Bootstrap Icons)</label>
                        <select name="icon" class="icon-select w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 focus:ring-2 focus:ring-indigo-500" data-selected="{{ $currentIcon }}">
                        </select>
                        <p class="text-xs text-slate-500 mt-1">Select an icon to display with this service.</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Service Image *</label>
                        <div class="relative group border-2 border-dashed border-slate-200 rounded-2xl p-4 bg-slate-50 hover:bg-white hover:border-indigo-300 transition-all cursor-pointer overflow-hidden">
                            <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50" data-image-preview="service-preview-edit" {{ isset($service) ? '' : 'required' }}>
                            <div id="service-preview-container" class="hidden absolute inset-0 w-full h-full bg-white z-40">
                                <img id="service-preview-edit" src="" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="text-white font-bold text-xs bg-indigo-600 px-3 py-1 rounded-full">New Selection</span>
                                </div>
                            </div>
                            <div class="text-center py-4 pointer-events-none">
                                <i class="bi bi-cloud-arrow-up text-4xl text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                                <p class="text-xs text-slate-500 mt-2 font-bold uppercase tracking-wider">Click or drag to upload image</p>
                            </div>
                        </div>
                        @if(isset($service) && $service->image)
                            <div class="mt-4 flex items-center gap-4 p-3 bg-white border border-slate-100 rounded-xl shadow-sm">
                                <img src="{{ asset($service->image) }}" class="h-16 w-24 object-cover rounded-lg">
                                <div class="text-xs text-slate-500 font-bold uppercase tracking-tighter">Current Image</div>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Redirect Link (Optional)</label>
                        <input type="text" name="link" value="{{ old('link', $service->link ?? '') }}" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700 font-mono text-sm" 
                            placeholder="e.g. /restaurant">
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-6">
                <a href="{{ route('admin.home_services.index') }}" class="text-slate-500 hover:text-slate-800 font-bold text-sm">Cancel</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-12 rounded-2xl transition-all shadow-indigo-200 shadow-xl transform active:scale-95">
                    {{ isset($service) ? 'Update Service' : 'Create Service' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
