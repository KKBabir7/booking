@extends('layouts.admin')

@section('header', 'FAQ')

@section('content')
<div class="card-premium p-8 max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-10 border-b border-slate-100 pb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-800 tracking-tight">FAQ Page Settings</h3>
            <p class="text-sm text-slate-500 mt-1">Manage categories, questions, and answers for the help center.</p>
        </div>
    </div>

    <!-- Hero Section -->
    <form action="{{ route('admin.page.faq.update') }}" method="POST" enctype="multipart/form-data" class="mb-12">
        @csrf @method('PUT')
        <div class="bg-blue-50/30 border border-blue-100 p-8 rounded-3xl relative shadow-sm">
            <div class="absolute -top-3 left-8 px-4 bg-blue-600 text-white text-xs font-bold uppercase tracking-wider rounded-full py-1.5 shadow-md">
                Hero Section
            </div>
            <br>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Banner Title</label>
                        <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? 'Frequently Asked Questions' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 font-bold">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tagline / Subtitle</label>
                        <input type="text" name="hero_tagline" value="{{ $settings['hero_tagline'] ?? 'Help Center' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3 text-center">Hero Banner Preview</label>
                    <div class="relative border-2 border-dashed border-slate-300 rounded-2xl p-4 bg-white flex flex-col items-center justify-center gap-2">
                        @php $banner = $settings['hero_banner'] ?? 'assets/img/page_banners/faq-default.jpg'; @endphp
                        <img id="hero-preview" src="{{ asset($banner) }}" class="w-full h-32 object-cover rounded-lg">
                        <input type="file" name="hero_banner_file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <input type="hidden" name="hero_banner" value="{{ $settings['hero_banner'] ?? '' }}">
                </div>
            </div>
            <div class="mt-6 pt-6 border-t border-blue-100 flex justify-end">
                <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg flex items-center gap-2">
                    <i class="bi bi-info-circle"></i> Save Hero Content
                </button>
            </div>
        </div>
    </form>

    <!-- FAQ Items -->
    <form action="{{ route('admin.page.faq.update') }}" method="POST">
        @csrf @method('PUT')
        <div class="bg-slate-50/50 border border-slate-200 p-8 rounded-3xl relative shadow-sm">
            <div class="absolute -top-3 left-8 px-4 bg-slate-800 text-white text-xs font-bold uppercase tracking-wider rounded-full py-1.5 shadow-md">
                FAQ Data & Grouping
            </div>
            
            <div id="faq-container" class="space-y-6 pt-6">
                @php
                    $faqs = isset($settings['faq_items']) ? json_decode($settings['faq_items'], true) : [
                        ['category' => 'General', 'icon' => 'bi bi-info-circle', 'question' => 'Check-in time?', 'answer' => '2 PM']
                    ];
                @endphp

                @foreach($faqs as $index => $faq)
                <div class="faq-item bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative group transition-all hover:border-blue-300">
                    <button type="button" class="remove-faq absolute top-4 right-4 bg-rose-500 text-white w-8 h-8 rounded-full flex items-center justify-center  group-hover:opacity-100 transition-all hover:scale-110 shadow-lg z-10" style="right:10px;top:10px">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Category Group</label>
                                <input type="text" name="faq_items[{{$index}}][category]" value="{{ $faq['category'] ?? '' }}" placeholder="e.g. General" class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-blue-400 font-bold text-blue-600">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Category Icon</label>
                                <select name="faq_items[{{$index}}][icon]" class="icon-select" data-selected="{{ $faq['icon'] ?? 'bi bi-question-circle' }}"></select>
                            </div>
                        </div>
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Question</label>
                                <input type="text" name="faq_items[{{$index}}][question]" value="{{ $faq['question'] ?? '' }}" placeholder="Enter question..." class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-blue-400 font-bold text-slate-700">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Answer</label>
                                <textarea name="faq_items[{{$index}}][answer]" rows="3" class="w-full px-4 py-3 border border-slate-100 rounded-xl focus:ring-1 focus:ring-blue-400 text-sm text-slate-600">{{ $faq['answer'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8 flex flex-col items-center gap-6">
                <button type="button" id="add-faq" class="btn bg-white border-2 border-dashed border-slate-300 text-slate-600 hover:border-blue-400 hover:text-blue-600 font-bold py-3 px-12 rounded-2xl transition flex items-center gap-2">
                    <i class="bi bi-plus-circle fs-5"></i> Add New FAQ Item
                </button>
                
                <button type="submit" style="padding-left: 10px;padding-right:10px" class="px-16 py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-slate-900 transition shadow-2xl hover:shadow-blue-400/30 flex items-center gap-3 text-xl">
                    <i class="bi bi-check-circle-fill"></i> Save All FAQ Data
                </button>
            </div>
            <p class="text-center text-xs text-slate-400 mt-4 italic">Note: Items with the same Category Category will be grouped together automatically on the frontend.</p>
        </div>
    </form>
</div>

<template id="faq-template">
    <div class="faq-item bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative group transition-all hover:border-blue-300">
        <button type="button" class="remove-faq absolute top-4 right-4 bg-rose-500 text-white w-8 h-8 rounded-full flex items-center justify-center transition-all hover:scale-110 shadow-lg z-10" style="right:10px;top:10px">
            <i class="bi bi-trash-fill"></i>
        </button>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Category Group</label>
                    <input type="text" name="faq_items[REPLACE_INDEX][category]" placeholder="e.g. Booking" class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-blue-400 font-bold text-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Category Icon</label>
                    <select name="faq_items[REPLACE_INDEX][icon]" class="icon-select" data-selected="bi bi-info-circle"></select>
                </div>
            </div>
            <div class="md:col-span-2 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Question</label>
                    <input type="text" name="faq_items[REPLACE_INDEX][question]" placeholder="Enter question..." class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-blue-400 font-bold text-slate-700">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Answer</label>
                    <textarea name="faq_items[REPLACE_INDEX][answer]" rows="3" placeholder="Enter answer details..." class="w-full px-4 py-3 border border-slate-100 rounded-xl focus:ring-1 focus:ring-blue-400 text-sm text-slate-600"></textarea>
                </div>
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
$(document).ready(function() {
    let index = {{ count($faqs) }};
    
    $(document).on('click', '#add-faq', function(e) {
        e.preventDefault();
        const template = $('#faq-template').html();
        if (!template) return;

        const newItem = template.replace(/REPLACE_INDEX/g, index);
        const $item = $(newItem);
        $('#faq-container').append($item);
        
        // Re-initialize icon select for the new item
        if (window.initIconSelect) {
            window.initIconSelect($item.find('.icon-select')[0]);
        }
        index++;
    });

    $(document).on('click', '.remove-faq', function(e) {
        e.preventDefault();
        $(this).closest('.faq-item').remove();
    });
});
</script>
@endpush
@endsection
