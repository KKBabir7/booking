@extends('layouts.admin')

@section('header', 'Create Hero Banner')

@section('content')
<div class="max-w-4xl mx-auto pb-24">
    <div class="card-premium p-8">
        <div class="mb-8 flex justify-between items-start">
            <div>
                <h3 class="text-2xl font-bold text-slate-800">Create New Hero Banner</h3>
                <p class="text-sm text-slate-500">Configure your home page's main carousel slide</p>
            </div>
            <a href="{{ route('admin.home_banners.index') }}" class="text-slate-400 hover:text-slate-600 transition p-2 hover:bg-slate-50 rounded-lg">
                <i class="bi bi-x-lg text-xl"></i>
            </a>
        </div>

        <form action="{{ route('admin.home_banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Banner Title *</label>
                        <input type="text" name="title" value="{{ old('title') }}" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-800 font-bold" 
                            placeholder="e.g. Luxury Stay Awaits" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Subtitle</label>
                        <textarea name="subtitle" rows="4" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700 font-medium">{{ old('subtitle') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tag Label</label>
                            <input type="text" name="tag_label" value="{{ old('tag_label') }}" 
                                class="w-full px-4 py-2.5 bg-indigo-50/50 border border-indigo-100 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-indigo-700 font-bold" 
                                placeholder="e.g. WELCOME">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tag Value</label>
                            <input type="text" name="tag_value" value="{{ old('tag_value') }}" 
                                class="w-full px-4 py-2.5 bg-indigo-50/50 border border-indigo-100 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-indigo-700 font-bold" 
                                placeholder="e.g. 35%">
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Banner Image *</label>
                        <div class="relative group border-2 border-dashed border-slate-200 rounded-2xl p-4 bg-slate-50 hover:bg-white hover:border-indigo-300 transition-all cursor-pointer overflow-hidden">
                            <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50" data-image-preview="hero-preview" required>
                            <div id="hero-preview-container" class="hidden absolute inset-0 w-full h-full bg-white z-40">
                                <img id="hero-preview" src="" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="text-white font-bold text-xs bg-indigo-600 px-3 py-1 rounded-full">Change Image</span>
                                </div>
                            </div>
                            <div class="text-center py-4 pointer-events-none">
                                <i class="bi bi-cloud-arrow-up text-4xl text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                                <p class="text-xs text-slate-500 mt-2 font-bold uppercase tracking-wider">Click or drag to upload image</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tag Off Text</label>
                            <input type="text" name="tag_off" value="{{ old('tag_off') }}" 
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all" 
                                placeholder="e.g. OFF">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Style Class</label>
                            <input type="text" name="style_class" value="{{ old('style_class') }}" 
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all" 
                                placeholder="style-2, style-3">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Banner Visibility</label>
                        <div class="flex gap-4">
                            <label class="flex-grow">
                                <input type="radio" name="is_active" value="1" class="hidden peer" checked>
                                <div class="text-center p-3 rounded-xl border border-slate-200 bg-slate-50 peer-checked:bg-indigo-50 peer-checked:border-indigo-500 peer-checked:text-indigo-700 cursor-pointer transition-all font-bold text-sm shadow-sm">
                                    <i class="bi bi-check-circle-fill mr-1"></i> Published
                                </div>
                            </label>
                            <label class="flex-grow">
                                <input type="radio" name="is_active" value="0" class="hidden peer">
                                <div class="text-center p-3 rounded-xl border border-slate-200 bg-slate-50 peer-checked:bg-rose-50 peer-checked:border-rose-500 peer-checked:text-rose-700 cursor-pointer transition-all font-bold text-sm shadow-sm">
                                    <i class="bi bi-x-circle-fill mr-1"></i> Hidden
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-10 border-t border-slate-100 flex items-center justify-end gap-6">
                <a href="{{ route('admin.home_banners.index') }}" class="text-slate-500 hover:text-slate-800 font-bold text-sm">Discard Changes</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-14 rounded-2xl transition-all shadow-indigo-200 shadow-2xl transform active:scale-95 flex items-center gap-2">
                    <i class="bi bi-cloud-check-fill"></i>
                    Publish Banner
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
