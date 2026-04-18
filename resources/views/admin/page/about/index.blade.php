@extends('layouts.admin')

@section('header', 'About Us')

@section('content')
<div class="card-premium p-8 max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-10 border-b border-slate-100 pb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-800 tracking-tight">About Page Settings</h3>
            <p class="text-sm text-slate-500 mt-1">Manage each section of the About Us page independently.</p>
        </div>
    </div>

    <div class="space-y-12 pb-20">
        <!-- Hero Section -->
        <form action="{{ route('admin.page.about.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="bg-slate-50 border border-slate-100 p-8 rounded-3xl relative shadow-sm">
            <div class="absolute -top-3 left-8 px-4 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full py-1.5 border border-indigo-200">
                Hero Content
            </div>
            <br>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Main Hero Title</label>
                            <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? 'About Us' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-lg font-medium">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Hero Tagline</label>
                            <input type="text" name="hero_tagline" value="{{ $settings['hero_tagline'] ?? 'A Touch of Home & Excellence' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-600">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Hero Banner Image</label>
                        <div class="relative group cursor-pointer overflow-hidden rounded-2xl border-4 border-white shadow-lg aspect-[21/9] bg-slate-100 mb-2">
                             @php
                                $heroBanner = $settings['hero_banner'] ?? 'assets/img/page_banners/about-hero-default.jpg';
                             @endphp
                            <img id="hero-banner-preview" src="{{ asset($heroBanner) }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <i class="bi bi-camera-fill text-white fs-2"></i>
                            </div>
                            <input type="file" name="hero_banner_file" class="absolute inset-0 opacity-0 cursor-pointer" data-image-preview="hero-banner-preview">
                        </div>
                        <input type="hidden" name="hero_banner" value="{{ $settings['hero_banner'] ?? '' }}">
                        <p class="text-[10px] text-slate-400 italic">Recommended: 1920x600px | High Quality JPG/WebP</p>
                    </div>
                </div>
                <div class="mt-6 pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg flex items-center gap-2">
                        <i class="bi bi-save"></i> Save Hero Content
                    </button>
                </div>
            </div>
        </form>

        <!-- Combined Form for Other Sections -->
        <form action="{{ route('admin.page.about.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="space-y-12">
                <!-- Experience Statistics -->
                <div class="bg-indigo-50/40 border border-indigo-100 p-8 rounded-3xl relative shadow-sm">
                    <div class="absolute -top-3 left-8 px-4 bg-indigo-600 text-white text-xs font-bold uppercase tracking-wider rounded-full py-1.5 shadow-md">
                        Experience Statistics
                    </div>
                    <br>
                    @php
                        $stats = isset($settings['stats']) ? json_decode($settings['stats'], true) : [
                            ['icon' => 'bi bi-calendar-check', 'number' => '18+ Years', 'label' => 'of Experience since 2007'],
                            ['icon' => 'bi bi-people-fill', 'number' => 'Thousands', 'label' => 'of Happy Guests served']
                        ];
                    @endphp
                    <div id="stats-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-6">
                        @foreach($stats as $index => $stat)
                        <div class="stat-item bg-white p-6 rounded-2xl border border-indigo-100 shadow-sm relative group transition-all hover:shadow-md">
                            <button type="button" class="remove-stat absolute -top-2 -right-2 bg-rose-500 text-white w-8 h-8 rounded-full flex items-center justify-center transition-all hover:scale-110 shadow-lg z-20 opacity-1 group-hover:opacity-100" style="right: 10px;top:10px">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                            <div class="text-xs font-bold text-indigo-700 uppercase mb-4 tracking-tight">Stat Card</div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Icon</label>
                                    <select name="stats[{{$index}}][icon]" class="icon-select" data-selected="{{ $stat['icon'] ?? 'bi bi-star' }}"></select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Heading / Number</label>
                                    <input type="text" name="stats[{{$index}}][number]" value="{{ $stat['number'] ?? '' }}" placeholder="e.g. 15+" class="w-full px-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 font-bold">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Description Label</label>
                                    <input type="text" name="stats[{{$index}}][label]" value="{{ $stat['label'] ?? '' }}" placeholder="e.g. Years of Service" class="w-full px-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-8 flex justify-center">
                        <button type="button" id="add-stat" class="btn bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-2xl transition shadow-lg flex items-center gap-2">
                            <i class="bi bi-plus-circle-dotted fs-5"></i> Add New Stat Card
                        </button>
                    </div>
                </div>

                <!-- Mission & Passion (Core Values) -->
                <div class="bg-amber-50/40 border border-amber-100 p-8 rounded-3xl relative shadow-sm">
                    <div class="absolute -top-3 left-8 px-4 bg-amber-500 text-white text-xs font-bold uppercase tracking-wider rounded-full py-1.5 shadow-md">
                        Mission & Passion Cards
                    </div>
                    @php
                        $values = isset($settings['core_values']) ? json_decode($settings['core_values'], true) : [
                            ['icon' => 'bi bi-bullseye', 'title' => 'Our Mission', 'desc' => 'Our mission is to provide a welcoming environment.'],
                            ['icon' => 'bi bi-fire', 'title' => 'Passion', 'desc' => 'Passion is the fuel behind creativity.']
                        ];
                    @endphp
                    <div id="values-container" class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6">
                        @foreach($values as $index => $value)
                        <div class="value-item bg-white p-6 rounded-2xl border border-amber-100 shadow-sm relative group transition-all hover:shadow-md">
                            <button type="button" class="remove-value absolute -top-2 -right-2 bg-rose-500 text-white w-8 h-8 rounded-full flex items-center justify-center transition-all hover:scale-110 shadow-lg z-20 opacity-0 group-hover:opacity-100">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                            <div class="text-xs font-bold text-amber-700 uppercase mb-4 tracking-tight">Core Value Card</div>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1">Icon</label>
                                        <select name="core_values[{{$index}}][icon]" class="icon-select" data-selected="{{ $value['icon'] ?? 'bi bi-heart' }}"></select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1">Card Title</label>
                                        <input type="text" name="core_values[{{$index}}][title]" value="{{ $value['title'] ?? '' }}" placeholder="e.g. Integrity" class="w-full px-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 font-bold">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Description</label>
                                    <textarea name="core_values[{{$index}}][desc]" rows="3" class="w-full px-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500">{{ $value['desc'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-8 flex justify-center">
                        <button type="button" id="add-value" class="btn bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded-2xl transition shadow-lg flex items-center gap-2">
                            <i class="bi bi-plus-circle-dotted fs-5"></i> Add Core Value
                        </button>
                    </div>
                </div>

                <!-- Story & Journey -->
                <div class="bg-emerald-50/40 border border-emerald-100 p-8 rounded-3xl relative shadow-sm">
                    <div class="absolute -top-3 left-8 px-4 bg-emerald-600 text-white text-xs font-bold uppercase tracking-wider rounded-full py-1.5 shadow-md">
                        Our Journey & Media
                    </div>
                    <br>
                    <div class="row g-5 pt-6 ">
                        <div class="col-lg-7 space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Since 2007: Journey Title</label>
                                <input type="text" name="journey_title" value="{{ $settings['journey_title'] ?? 'Our Journey of Excellence' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 font-bold">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Lead Paragraph</label>
                                <textarea name="journey_subtitle" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500">{{ $settings['journey_subtitle'] ?? '' }}</textarea>
                            </div>
                            <div class="bg-white p-5 rounded-2xl border border-emerald-100 shadow-sm border-l-4 border-l-emerald-500">
                                <label class="block text-xs font-bold text-emerald-600 uppercase mb-3 tracking-wider">Highlight Sidebar Box</label>
                                <input type="text" name="journey_highlight_title" value="{{ $settings['journey_highlight_title'] ?? 'Continuously Improving' }}" placeholder="Box Title" class="w-full px-4 py-2 border border-slate-200 rounded-xl mb-3 font-bold text-slate-700">
                                <textarea name="journey_highlight_text" rows="2" placeholder="Short text..." class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm">{{ $settings['journey_highlight_text'] ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <label class="block text-sm font-bold text-slate-700 mb-3 text-center">Journey Image Preview</label>
                            <div class="relative group cursor-pointer overflow-hidden rounded-3xl border-4 border-white shadow-xl aspect-video bg-slate-100 flex items-center justify-center">
                                <img id="journey-preview" src="{{ asset($settings['journey_image'] ?? 'assets/img/page_banners/default-journey.jpg') }}" class="w-full h-full object-cover transition-transform group-hover:scale-110">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <i class="bi bi-camera-fill text-white fs-1"></i>
                                </div>
                                <input type="file" name="journey_image_file" class="absolute inset-0 opacity-0 cursor-pointer" data-image-preview="journey-preview">
                            </div>
                            <p class="text-xs text-slate-400 mt-4 text-center">Recommended size: 800x600px | Aspect Ratio 4:3</p>
                        </div>
                    </div>
                </div>

                <!-- Chairman Message -->
                <div class="bg-rose-50/40 border border-rose-100 p-8 rounded-3xl relative shadow-sm">
                    <div class="absolute -top-3 left-8 px-4 bg-rose-600 text-white text-xs font-bold uppercase tracking-wider rounded-full py-1.5 shadow-md">
                        Chairman's Visionary Message
                    </div>
                    <div class="row g-5 pt-8 align-items-center">
                        <div class="col-lg-4 text-center">
                            <div class="relative inline-block group cursor-pointer mb-6">
                                <div class="w-64 h-80 rounded-3xl overflow-hidden border-4 border-white shadow-2xl relative">
                                    <img id="chairman-preview" src="{{ asset($settings['chairman_image'] ?? 'assets/img/page_banners/default-chairman.jpg') }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <i class="bi bi-pencil-square text-white fs-1"></i>
                                    </div>
                                    <input type="file" name="chairman_image_file" class="absolute inset-0 opacity-0 cursor-pointer" data-image-preview="chairman-preview">
                                </div>
                            </div>
                            <input type="text" name="chairman_name" value="{{ $settings['chairman_name'] ?? 'Md. Shawkat Ali' }}" placeholder="Full Name" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-center font-bold text-slate-800 mb-2">
                            <input type="text" name="chairman_phone" value="{{ $settings['chairman_phone'] ?? 'Chairman' }}" placeholder="Role or Phone" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-center text-sm text-slate-500">
                        </div>
                        <div class="col-lg-8">
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Greeting Title</label>
                                <input type="text" name="chairman_greeting" value="{{ $settings['chairman_greeting'] ?? 'Greetings from Nice Guest House' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-rose-500 font-bold">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Full Message Markdown/Text</label>
                                <textarea name="chairman_message" rows="12" class="w-full px-4 py-4 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-rose-500 text-slate-600 leading-relaxed">{{ $settings['chairman_message'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Single Save Button for all Other Sections -->
                <div class="flex justify-center pt-8 pb-10">
                    <button type="submit" class="px-12 py-4  text-white font-bold rounded-2xl hover:bg-slate-900 transition shadow-2xl hover:shadow-slate-500/50 flex items-center gap-3 text-xl bg-indigo-600">
                        <i class="bi bi-check-circle-fill"></i> Save All About 
                    </button>
                </div>
            </div>
        </form>
    </div>

<!-- Repeater Templates -->
<template id="stat-template">
    <div class="stat-item bg-white p-6 rounded-2xl border border-indigo-100 shadow-sm relative group transition-all hover:shadow-md">
        <button type="button" class="remove-stat absolute -top-2 -right-2 bg-rose-500 text-white w-8 h-8 rounded-full flex items-center justify-center transition-all hover:scale-110 shadow-lg z-20">
            <i class="bi bi-trash-fill"></i>
        </button>
        <div class="text-xs font-bold text-indigo-700 uppercase mb-4 tracking-tight">New Stat Card</div>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">Icon</label>
                <select name="stats[REPLACE_INDEX][icon]" class="icon-select" data-selected="bi bi-star"></select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">Heading / Number</label>
                <input type="text" name="stats[REPLACE_INDEX][number]" placeholder="e.g. 15+" class="w-full px-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 font-bold">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">Description Label</label>
                <input type="text" name="stats[REPLACE_INDEX][label]" placeholder="e.g. Years of Service" class="w-full px-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>
    </div>
</template>

<template id="value-template">
    <div class="value-item bg-white p-6 rounded-2xl border border-amber-100 shadow-sm relative group transition-all hover:shadow-md">
        <button type="button" class="remove-value absolute -top-2 -right-2 bg-rose-500 text-white w-8 h-8 rounded-full flex items-center justify-center transition-all hover:scale-110 shadow-lg z-20">
            <i class="bi bi-trash-fill"></i>
        </button>
        <div class="text-xs font-bold text-amber-700 uppercase mb-4 tracking-tight">New Core Value</div>
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Icon</label>
                    <select name="core_values[REPLACE_INDEX][icon]" class="icon-select" data-selected="bi bi-bookmark-star"></select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Card Title</label>
                    <input type="text" name="core_values[REPLACE_INDEX][title]" placeholder="e.g. Mission" class="w-full px-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 font-bold">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">Description</label>
                <textarea name="core_values[REPLACE_INDEX][desc]" rows="3" class="w-full px-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500"></textarea>
            </div>
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Stats Repeater
    const statsContainer = document.getElementById('stats-container');
    const addStatBtn = document.getElementById('add-stat');
    const statTemplate = document.getElementById('stat-template').innerHTML;
    let statIndex = {{ count($stats) }};

    addStatBtn.addEventListener('click', function() {
        const newItem = statTemplate.replace(/REPLACE_INDEX/g, statIndex);
        const div = document.createElement('div');
        div.innerHTML = newItem;
        const item = div.firstElementChild;
        statsContainer.appendChild(item);
        if (window.initIconSelect) window.initIconSelect(item.querySelector('.icon-select'));
        statIndex++;
    });

    statsContainer.addEventListener('click', (e) => {
        if (e.target.closest('.remove-stat')) e.target.closest('.stat-item').remove();
    });

    // Values Repeater
    const valuesContainer = document.getElementById('values-container');
    const addValueBtn = document.getElementById('add-value');
    const valueTemplate = document.getElementById('value-template').innerHTML;
    let valueIndex = {{ count($values) }};

    addValueBtn.addEventListener('click', function() {
        const newItem = valueTemplate.replace(/REPLACE_INDEX/g, valueIndex);
        const div = document.createElement('div');
        div.innerHTML = newItem;
        const item = div.firstElementChild;
        valuesContainer.appendChild(item);
        if (window.initIconSelect) window.initIconSelect(item.querySelector('.icon-select'));
        valueIndex++;
    });

    valuesContainer.addEventListener('click', (e) => {
        if (e.target.closest('.remove-value')) e.target.closest('.value-item').remove();
    });
});
</script>
@endsection
