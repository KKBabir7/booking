@extends('layouts.admin')

@section('header', isset($banner) ? 'Edit Promo Banner' : 'Create Promo Banner')

@section('content')
<div class="max-w-4xl mx-auto pb-24">
    <div class="card-premium p-8">
        <div class="mb-8">
            <h3 class="text-xl font-bold text-slate-800">{{ isset($banner) ? 'Edit Promo Banner' : 'Create New Promo Banner' }}</h3>
            <p class="text-sm text-slate-500">Configure promotional offers and deal sections</p>
        </div>

        <form action="{{ isset($banner) ? route('admin.home_promo_banners.update', $banner->id) : route('admin.home_promo_banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @if(isset($banner)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Promo Title *</label>
                        <input type="text" name="title" value="{{ $banner->title ?? '' }}" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-800 font-bold" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Subtitle / Description</label>
                        <textarea name="subtitle" rows="3" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700">{{ $banner->subtitle ?? '' }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Redirect Link (URL)</label>
                        <input type="text" name="link" value="{{ $banner->link ?? '' }}" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700 font-mono text-sm" 
                            placeholder="e.g. /rooms, /gallery">
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Display Image *</label>
                        <div class="relative group border-2 border-dashed border-slate-200 rounded-2xl p-4 bg-slate-50 hover:bg-white hover:border-indigo-300 transition-all cursor-pointer overflow-hidden">
                            <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50" data-image-preview="promo-preview" {{ isset($banner) ? '' : 'required' }}>
                            <div id="promo-preview-container" class="hidden absolute inset-0 w-full h-full bg-white z-40">
                                <img id="promo-preview" src="" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="text-white font-bold text-xs bg-indigo-600 px-3 py-1 rounded-full">New Selection</span>
                                </div>
                            </div>
                            <div class="text-center py-4 pointer-events-none">
                                <i class="bi bi-image text-4xl text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                                <p class="text-xs text-slate-500 mt-2 font-bold uppercase tracking-wider">Drag & drop or click to upload</p>
                            </div>
                        </div>
                        @if(isset($banner))
                            <div class="mt-4 flex items-center gap-4 p-3 bg-white border border-slate-100 rounded-xl shadow-sm">
                                <img src="{{ asset($banner->image) }}" class="h-16 w-24 object-cover rounded-lg">
                                <div class="text-xs text-slate-500 font-bold uppercase tracking-tighter">Current Image</div>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Discount Text</label>
                            <input type="text" name="discount_text" value="{{ $banner->discount_text ?? '' }}" 
                                class="w-full px-4 py-2.5 bg-indigo-50 border border-indigo-100 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-indigo-700 font-bold" 
                                placeholder="e.g. 35% OFF">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Badge Text</label>
                            <input type="text" name="badge_text" value="{{ $banner->badge_text ?? '' }}" 
                                class="w-full px-4 py-2.5 bg-amber-50 border border-amber-100 rounded-xl focus:ring-2 focus:ring-amber-500 transition-all text-amber-700 font-bold" 
                                placeholder="e.g. LIMITED DEAL">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Publication Status</label>
                        <div class="flex gap-4">
                            <label class="flex-grow">
                                <input type="radio" name="is_active" value="1" class="hidden peer" {{ (!isset($banner) || $banner->is_active) ? 'checked' : '' }}>
                                <div class="text-center p-3 rounded-xl border border-slate-200 bg-slate-50 peer-checked:bg-indigo-50 peer-checked:border-indigo-500 peer-checked:text-indigo-700 cursor-pointer transition-all font-bold text-sm">
                                    <i class="bi bi-check-circle-fill mr-1"></i> Active
                                </div>
                            </label>
                            <label class="flex-grow">
                                <input type="radio" name="is_active" value="0" class="hidden peer" {{ (isset($banner) && !$banner->is_active) ? 'checked' : '' }}>
                                <div class="text-center p-3 rounded-xl border border-slate-200 bg-slate-50 peer-checked:bg-rose-50 peer-checked:border-rose-500 peer-checked:text-rose-700 cursor-pointer transition-all font-bold text-sm">
                                    <i class="bi bi-x-circle-fill mr-1"></i> Inactive
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-6">
                <a href="{{ route('admin.home_promo_banners.index') }}" class="text-slate-500 hover:text-slate-800 font-bold text-sm">Cancel</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-12 rounded-2xl transition-all shadow-indigo-200 shadow-xl transform active:scale-95">
                    {{ isset($banner) ? 'Update Promotion' : 'Create Promotion' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
