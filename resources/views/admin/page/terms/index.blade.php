@extends('layouts.admin')

@section('header', 'Terms of Service')

@section('content')
<div class="card-premium p-8 max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-10 border-b border-slate-100 pb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-800 tracking-tight">Terms of Service Settings</h3>
            <p class="text-sm text-slate-500 mt-1">Manage the standard guidelines and hero section for the terms of service.</p>
        </div>
    </div>

    <!-- Hero Section -->
    <form action="{{ route('admin.page.terms.update') }}" method="POST" enctype="multipart/form-data" class="mb-12">
        @csrf @method('PUT')
        <div class="bg-amber-50/30 border border-amber-100 p-8 rounded-3xl relative shadow-sm">
            <div class="absolute -top-3 left-8 px-4 bg-amber-600 text-white text-xs font-bold uppercase tracking-wider rounded-full py-1.5 shadow-md">
                Hero Section
            </div>
            <br>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Banner Title</label>
                        <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? 'Terms of Service' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 font-bold">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tagline / Subtitle</label>
                        <input type="text" name="hero_tagline" value="{{ $settings['hero_tagline'] ?? 'Standard Guidelines' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3 text-center">Hero Banner</label>
                    <div class="border-2 border-dashed border-slate-300 rounded-2xl p-4 bg-white">
                        @php $banner = $settings['hero_banner'] ?? 'assets/img/page_banners/terms-default.jpg'; @endphp
                        <img id="hero-preview" src="{{ asset($banner) }}" class="w-full h-32 object-cover rounded-lg mb-3">
                        <input type="file" name="hero_banner_file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                    </div>
                    <input type="hidden" name="hero_banner" value="{{ $settings['hero_banner'] ?? '' }}">
                </div>
            </div>
            <div class="mt-6 pt-6 border-t border-amber-100 flex justify-end">
                <button type="submit" class="px-8 py-2.5 bg-amber-600 text-white font-bold rounded-xl hover:bg-amber-700 transition shadow-lg flex items-center gap-2">
                    <i class="bi bi-file-earmark-check"></i> Save Hero Content
                </button>
            </div>
        </div>
    </form>

    <!-- Terms Content Clauses -->
    <form action="{{ route('admin.page.terms.update') }}" method="POST">
        @csrf @method('PUT')
        <div class="bg-slate-50/50 border border-slate-200 p-8 rounded-3xl relative shadow-sm">
            <div class="absolute -top-3 left-8 px-4 bg-slate-800 text-white text-xs font-bold uppercase tracking-wider rounded-full py-1.5 shadow-md">
                Terms & Conditions Clauses
            </div>
            
            <div id="sections-container" class="space-y-6 pt-6">
                @php
                    $sections = isset($settings['content_sections']) ? json_decode($settings['content_sections'], true) : [
                        ['title' => '1. Acceptance of Terms', 'content' => 'By accessing and using Nice Guest House\'s services...']
                    ];
                @endphp

                @foreach($sections as $index => $section)
                <div class="section-item bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative group transition-all hover:border-amber-300">
                    <button type="button" class="remove-section absolute top-4 right-4 bg-rose-500 text-white w-8 h-8 rounded-full flex items-center justify-center  group-hover:opacity-100 transition-all hover:scale-110 shadow-lg z-10" style="right:10px;top:10px">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Clause Heading</label>
                            <input type="text" name="content_sections[{{$index}}][title]" value="{{ $section['title'] ?? '' }}" placeholder="e.g. 1. Terms of Use" class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-amber-400 font-bold text-slate-700">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Clause Content (Supports HTML)</label>
                            <textarea name="content_sections[{{$index}}][content]" rows="4" class="w-full px-4 py-3 border border-slate-100 rounded-xl focus:ring-1 focus:ring-amber-400 text-sm text-slate-600">{{ $section['content'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8 flex flex-col items-center gap-6">
                <button type="button" id="add-section" class="btn bg-white border-2 border-dashed border-slate-300 text-slate-600 hover:border-amber-400 hover:text-amber-600 font-bold py-3 px-12 rounded-2xl transition flex items-center gap-2">
                    <i class="bi bi-plus-circle fs-5"></i> Add New Terms Clause
                </button>
                
                <button type="submit" style="padding-left: 10px;padding-right:10px" class="px-16 py-4 bg-amber-600 text-white font-bold rounded-2xl hover:bg-slate-900 transition shadow-2xl hover:shadow-amber-400/30 flex items-center gap-3 text-xl">
                    <i class="bi bi-check-circle-fill"></i> Save All Terms Sections
                </button>
            </div>
        </div>
    </form>
</div>

<template id="section-template">
    <div class="section-item bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative group transition-all hover:border-amber-300">
        <button type="button" class="remove-section absolute top-4 right-4 bg-rose-500 text-white w-8 h-8 rounded-full flex items-center justify-center transition-all hover:scale-110 shadow-lg z-10" style="right:10px;top:10px">
            <i class="bi bi-trash-fill"></i>
        </button>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Clause Heading</label>
                <input type="text" name="content_sections[REPLACE_INDEX][title]" placeholder="New Section Heading" class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-amber-400 font-bold text-slate-700">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Clause Content</label>
                <textarea name="content_sections[REPLACE_INDEX][content]" rows="4" placeholder="Enter details here..." class="w-full px-4 py-3 border border-slate-100 rounded-xl focus:ring-1 focus:ring-amber-400 text-sm text-slate-600"></textarea>
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
$(document).ready(function() {
    let index = {{ count($sections) }};
    
    $(document).on('click', '#add-section', function(e) {
        e.preventDefault();
        const template = $('#section-template').html();
        if (!template) return;

        const newItem = template.replace(/REPLACE_INDEX/g, index);
        $('#sections-container').append(newItem);
        index++;
    });

    $(document).on('click', '.remove-section', function(e) {
        e.preventDefault();
        $(this).closest('.section-item').remove();
    });
});
</script>
@endpush
@endsection
