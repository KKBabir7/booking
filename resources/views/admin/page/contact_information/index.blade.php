@extends('layouts.admin')

@section('header', 'Contact Information')

@section('content')
<div class="card-premium p-8 max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-10 border-b border-slate-100 pb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-800 tracking-tight">Contact Page Settings</h3>
            <p class="text-sm text-slate-500 mt-1">Manage the hero section and contact detail cards.</p>
        </div>
    </div>

    <!-- Hero Section -->
    <form action="{{ route('admin.page.contact_information.update') }}" method="POST" enctype="multipart/form-data" class="mb-12">
        @csrf @method('PUT')
        <div class="bg-indigo-50/30 border border-indigo-100 p-8 rounded-3xl relative shadow-sm">
            <div class="absolute -top-3 left-8 px-4 bg-indigo-600 text-white text-xs font-bold uppercase tracking-wider rounded-full py-1.5 shadow-md">
                Hero Section
            </div>
            <br>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Banner Title</label>
                        <textarea name="hero_title" rows="2" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 font-bold">{{ $settings['hero_title'] ?? 'Contact Us & Support Team' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tagline / Subtitle</label>
                        <input type="text" name="hero_tagline" value="{{ $settings['hero_tagline'] ?? 'Get In Touch' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3 text-center">Hero Banner Preview</label>
                    <div class="relative border-2 border-dashed border-slate-300 rounded-2xl p-4 bg-white flex flex-col items-center justify-center gap-2">
                        @php $banner = $settings['hero_banner'] ?? 'assets/img/page_banners/contact-default.jpg'; @endphp
                        <img id="hero-preview" src="{{ asset($banner) }}" class="w-full h-32 object-cover rounded-lg">
                        <input type="file" name="hero_banner_file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                    <input type="hidden" name="hero_banner" value="{{ $settings['hero_banner'] ?? '' }}">
                </div>
            </div>
            <div class="mt-6 pt-6 border-t border-indigo-100 flex justify-end">
                <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg flex items-center gap-2">
                    <i class="bi bi-save"></i> Save Hero Content
                </button>
            </div>
        </div>
    </form>

    <!-- Contact Cards -->
    <form action="{{ route('admin.page.contact_information.update') }}" method="POST">
        @csrf @method('PUT')
        <div class="bg-slate-50/50 border border-slate-200 p-8 rounded-3xl relative shadow-sm">
            <div class="absolute -top-3 left-8 px-4 bg-slate-800 text-white text-xs font-bold uppercase tracking-wider rounded-full py-1.5 shadow-md">
                Contact Feature Cards
            </div>
            
            <div id="cards-container" class="space-y-6 pt-6">
                @php
                    $cards = isset($settings['contact_cards']) ? json_decode($settings['contact_cards'], true) : [
                        ['icon' => 'bi bi-geo-alt-fill', 'title' => 'Our Location', 'detail1' => 'Uzzalpur, Maijdee Court, Sadar', 'detail2' => 'Noakhali-3800, Bangladesh.', 'link_text' => 'View on Map', 'link_url' => 'https://maps.google.com'],
                        ['icon' => 'bi bi-telephone-fill', 'title' => 'Contact Support', 'detail1' => '+880-321-61658', 'detail2' => 'Available 24/7', 'link_text' => '', 'link_url' => ''],
                        ['icon' => 'bi bi-envelope-heart', 'title' => 'Official Email', 'detail1' => 'niceguesthouse.th@gmail.com', 'detail2' => '', 'link_text' => 'Send Email', 'link_url' => 'mailto:niceguesthouse.th@gmail.com']
                    ];
                @endphp

                @foreach($cards as $index => $card)
                <div class="contact-card-item bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative group transition-all hover:border-indigo-300">
                    <button type="button" class="remove-card absolute top-4 right-4 bg-rose-500 text-white w-8 h-8 rounded-full flex items-center justify-center group-hover:opacity-100 transition-all hover:scale-110 shadow-lg z-10" style="right:10px;top:10px">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="md:col-span-1 border-r border-slate-50 pr-4">
                            <label class="block text-xs font-black text-slate-400 uppercase mb-2">Card Icon & Header</label>
                            <div class="space-y-3">
                                <select name="contact_cards[{{$index}}][icon]" class="icon-select" data-selected="{{ $card['icon'] ?? 'bi bi-info-circle' }}"></select>
                                <input type="text" name="contact_cards[{{$index}}][title]" value="{{ $card['title'] ?? '' }}" placeholder="Card Title" class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-indigo-400 font-bold text-slate-700">
                            </div>
                        </div>
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase mb-2">Primary Details</label>
                                <input type="text" name="contact_cards[{{$index}}][detail1]" value="{{ $card['detail1'] ?? '' }}" placeholder="Main information line..." class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-indigo-400 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase mb-2">Secondary Details / Status</label>
                                <input type="text" name="contact_cards[{{$index}}][detail2]" value="{{ $card['detail2'] ?? '' }}" placeholder="Secondary info (e.g. Open 24/7)" class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-indigo-400 text-sm">
                            </div>
                        </div>
                        <div class="md:col-span-1 space-y-4">
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase mb-2">Action Link Text</label>
                                <input type="text" name="contact_cards[{{$index}}][link_text]" value="{{ $card['link_text'] ?? '' }}" placeholder="e.g. View on Map" class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-indigo-400 text-xs font-bold">
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase mb-2">Action URL</label>
                                <input type="text" name="contact_cards[{{$index}}][link_url]" value="{{ $card['link_url'] ?? '' }}" placeholder="https://..." class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-indigo-400 text-xs">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8 flex flex-col items-center gap-6">
                <button type="button" id="add-card" class="btn bg-white border-2 border-dashed border-slate-300 text-slate-600 hover:border-indigo-400 hover:text-indigo-600 font-bold py-3 px-12 rounded-2xl transition flex items-center gap-2">
                    <i class="bi bi-plus-circle fs-5"></i> Add New Contact Card
                </button>
                
                <button type="submit" style="padding-left:20px;padding-right:20px" class="px-20 py-4 bg-indigo-600 text-white font-black rounded-2xl hover:bg-slate-900 transition shadow-2xl hover:shadow-indigo-400/30 flex items-center gap-3 text-xl">
                    <i class="bi bi-check-circle-fill"></i> Save Contact Cards
                </button>
            </div>
        </div>
    </form>
</div>

<template id="card-template">
    <div class="contact-card-item bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative group transition-all hover:border-indigo-300">
        <button type="button" class="remove-card absolute top-4 right-4 bg-rose-500 text-white w-8 h-8 rounded-full flex items-center justify-center transition-all hover:scale-110 shadow-lg z-10" style="right:10px;top:10px">
            <i class="bi bi-trash-fill"></i>
        </button>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="md:col-span-1 border-r border-slate-50 pr-4">
                <label class="block text-xs font-black text-slate-400 uppercase mb-2">Card Icon & Header</label>
                <div class="space-y-3">
                    <select name="contact_cards[REPLACE_INDEX][icon]" class="icon-select" data-selected="bi bi-info-circle"></select>
                    <input type="text" name="contact_cards[REPLACE_INDEX][title]" placeholder="Card Title" class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-indigo-400 font-bold text-slate-700">
                </div>
            </div>
            <div class="md:col-span-2 space-y-4">
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase mb-2">Primary Details</label>
                    <input type="text" name="contact_cards[REPLACE_INDEX][detail1]" placeholder="Main information line..." class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-indigo-400 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase mb-2">Secondary Details / Status</label>
                    <input type="text" name="contact_cards[REPLACE_INDEX][detail2]" placeholder="Secondary info (e.g. Open 24/7)" class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-indigo-400 text-sm">
                </div>
            </div>
            <div class="md:col-span-1 space-y-4">
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase mb-2">Action Link Text</label>
                    <input type="text" name="contact_cards[REPLACE_INDEX][link_text]" placeholder="e.g. View on Map" class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-indigo-400 text-xs font-bold">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase mb-2">Action URL</label>
                    <input type="text" name="contact_cards[REPLACE_INDEX][link_url]" placeholder="https://..." class="w-full px-4 py-2 border border-slate-100 rounded-xl focus:ring-1 focus:ring-indigo-400 text-xs">
                </div>
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
$(document).ready(function() {
    let index = {{ count($cards) }};
    
    $(document).on('click', '#add-card', function(e) {
        e.preventDefault();
        const template = $('#card-template').html();
        if (!template) return;

        const newItem = template.replace(/REPLACE_INDEX/g, index);
        const $item = $(newItem);
        $('#cards-container').append($item);
        
        if (window.initIconSelect) {
            window.initIconSelect($item.find('.icon-select')[0]);
        }
        index++;
    });

    $(document).on('click', '.remove-card', function(e) {
        e.preventDefault();
        $(this).closest('.contact-card-item').remove();
    });
});
</script>
@endpush
@endsection
