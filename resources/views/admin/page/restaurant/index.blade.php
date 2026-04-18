@extends('layouts.admin')

@section('header', 'Manage Restaurant Content')

@section('content')
<div class="p-8 max-w-6xl mx-auto">
    <!-- <div class="flex justify-between items-center mb-10 border-b border-slate-200 pb-6">
        <div>
            <h3 class="text-3xl font-black text-slate-800 tracking-tight">Restaurant Experience</h3>
            <p class="text-sm text-slate-500 mt-1">Refine and manage the dynamic content for your dining sections</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-full text-xs font-bold uppercase tracking-widest border border-indigo-100">
                Live on /restaurant
            </div>
        </div>
    </div> -->

    <!-- Restaurant Page Settings -->
    <div class="card-premium p-8 mb-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="text-xl font-bold text-slate-800">Restaurant Page Settings</h3>
                <p class="text-sm text-slate-500">Customize the banner, title, and tagline displayed on the Restaurant page.</p>
            </div>
        </div>

        <form action="{{ route('admin.page.update', 'restaurant') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            <i class="bi bi-type me-2"></i>Hero Tagline
                        </label>
                        <input type="text" name="hero_tagline" value="{{ old('hero_tagline', $settings['hero_tagline'] ?? 'Discover a Taste of Excellence') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            <i class="bi bi-type-h1 me-2"></i>Hero Title (Main Heading)
                        </label>
                        <textarea name="hero_title" rows="2" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">{{ old('hero_title', $settings['hero_title'] ?? 'Fine Dining at<br>Nice Guest House') }}</textarea>
                        <p class="text-[10px] text-slate-400 mt-2 italic">* Use &lt;br&gt; for line breaks</p>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="bi bi-image me-2"></i>Hero Background Media
                    </label>
                    <div class="relative group">
                        <div class="w-full h-48 rounded-xl overflow-hidden border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center relative transition-all hover:border-indigo-400 cursor-pointer" onclick="document.getElementById('heroBgInput').click()">
                            @if(isset($settings['hero_bg']))
                                <img id="heroPreviewImg" src="{{ asset($settings['hero_bg']) }}" class="w-full h-full object-cover">
                            @else
                                <div id="heroPreviewPlaceholder" class="text-slate-400 flex flex-col items-center gap-2">
                                    <i class="bi bi-cloud-arrow-up text-3xl"></i>
                                    <span class="text-xs font-semibold">Click to upload banner image</span>
                                </div>
                                <img id="heroPreviewImg" src="#" class="w-full h-full object-cover hidden">
                            @endif
                        </div>
                        <input type="file" name="hero_bg_file" id="heroBgInput" accept="image/*" class="hidden" onchange="previewHeroImage(this)">
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                    <i class="bi bi-floppy2-fill"></i> Save Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Restaurant Locations Management (Merged Section) -->
    <div class="card-premium p-8 mb-8">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight">Restaurant Management (Locations)</h3>
                <p class="text-sm text-slate-500">Manage outlets and their fixed advance payment requirements.</p>
            </div>
            <a href="{{ route('admin.restaurants.create') }}" class="px-6 py-3 bg-indigo-600 text-white text-sm font-black rounded-2xl hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition-all flex items-center gap-2">
                <i class="bi bi-plus-lg"></i> Add New Restaurant
            </a>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Restaurant Info</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Advance Fee</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($restaurants as $restaurant)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden border border-slate-200">
                                    @if($restaurant->image)
                                        <img src="{{ asset('storage/' . $restaurant->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <i class="bi bi-egg-fried fs-4"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="font-bold text-slate-800 mb-0 leading-none">{{ $restaurant->name }}</h5>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">ID: #{{ $restaurant->id }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs font-black tracking-tight">
                                {{ number_format($restaurant->advance_amount, 2) }} TK
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($restaurant->is_active)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.restaurants.edit', $restaurant) }}" class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-lg transition-colors">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.restaurants.destroy', $restaurant) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this restaurant?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4">
                                    <i class="bi bi-inbox fs-1"></i>
                                </div>
                                <h6 class="font-bold text-slate-500 mb-1">No Restaurants Found</h6>
                                <p class="text-xs text-slate-400">Add your first restaurant outlet to get started.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Advanced Restaurant Modules -->
    <div class="card-premium p-8 mb-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="text-xl font-bold text-slate-800">Advanced Restaurant Modules</h3>
                <p class="text-sm text-slate-500">Manage intros, cuisines, and rooftop modules below</p>
            </div>
        </div>
        
        <form action="{{ route('admin.page.update', 'restaurant') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
            @csrf
            @method('PUT')
        <!-- Intro Section -->
        <div class="bg-white border border-slate-200 p-10 rounded-[2rem] relative shadow-sm transition-all hover:shadow-md">
            <div class="absolute -top-3 left-10 px-4 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-full py-1.5 shadow-lg mb-5">
                Introduction Narrative
            </div>
            <div class="grid grid-cols-1 gap-8" style="margin-top:40px; padding: 20px;">
                <div>
                    <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest font-bold">Headline Title</label>
                    <input type="text" name="intro_title" value="{{ old('intro_title', $settings['intro_title'] ?? 'Unforgettable Dining Experiences') }}" class="w-full px-5 py-3 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-bold text-slate-800 text-xl">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">Main Descriptive Paragraph</label>
                    <textarea name="intro_text" rows="5" class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-medium text-slate-600 leading-relaxed text-base">{{ old('intro_text', $settings['intro_text'] ?? 'Step into a world of flavor without ever leaving the comfort of your stay...') }}</textarea>
                </div>
            </div>
        </div>
<br>
        <!-- Dynamic Features Matrix (Why Dine With Us?) -->
        <div class="bg-white border border-slate-200 p-10 rounded-[2rem] relative shadow-sm transition-all hover:shadow-md">
            <div class="absolute -top-3 left-10 px-4 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-full py-1.5 shadow-lg mb-5">
                Premium Feature Highlights
            </div>
            
            <div class="flex items-center justify-between mb-8" style="margin-top:40px; padding: 20px;">
                <div>
                    <h3 class="text-2xl font-black text-slate-800">Why Dine With Us?</h3>
                    <p class="text-slate-500 text-sm mt-1">Define the key value propositions of your dining services</p>
                </div>
            </div>
            
            @php
                $pageFeatures = isset($settings['page_features']) ? json_decode($settings['page_features'], true) : [];
            @endphp

            <div id="page-features-container" class="space-y-4">
                @foreach($pageFeatures as $idx => $pf)
                <div class="page-feature-item flex gap-4 items-center bg-slate-50/50 p-5 rounded-3xl border border-slate-100 transition-all hover:bg-white hover:shadow-md group">
                    <div class="flex-grow grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">Feature Icon</label>
                            <select name="page_features[{{$idx}}][icon]" class="icon-select" data-selected="{{ $pf['icon'] ?? '' }}">
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">Key Point Description</label>
                            <input type="text" name="page_features[{{$idx}}][text]" value="{{ $pf['text'] ?? '' }}" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-700 font-bold placeholder:text-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        </div>
                    </div>
                    <button type="button" class="remove-page-feature bg-rose-50 text-rose-500 p-3 rounded-2xl hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
                @endforeach
            </div>

            <div class="mt-8 mb-8 flex justify-center">
                <button type="button" id="add-page-feature" class="bg-indigo-600 text-white font-black py-4 px-10 rounded-2xl transition-all shadow-xl hover:bg-indigo-700 hover:scale-[1.05] flex items-center gap-3">
                    <i class="bi bi-plus-circle-fill text-xl"></i> Add High-Impact Point
                </button>
                <br>
            </div>
        </div>
<br>
        <!-- Rooftop Relaxation Section -->
        <div class="bg-white border border-slate-200 p-10 rounded-[2rem] relative shadow-sm transition-all hover:shadow-md overflow-hidden">
            <div class="absolute -top-3 left-10 px-4 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-full py-1.5 shadow-lg mb-5">
                Rooftop Promo Section
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 relative z-10" style="margin-top:40px; padding: 20px;padding-bottom: 100px !important;">
                <div class="space-y-6">
                    <h3 class="text-2xl font-black text-slate-800">Experience Rooftop Serenity</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">Accent Icon/Emoji</label>
                            <input type="text" name="rooftop_icon" value="{{ old('rooftop_icon', $settings['rooftop_icon'] ?? '☕') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 text-slate-800 font-bold focus:ring-2 focus:ring-amber-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">Section Heading</label>
                            <input type="text" name="rooftop_title" value="{{ old('rooftop_title', $settings['rooftop_title'] ?? 'Rooftop Relaxation') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 text-slate-800 font-bold focus:ring-2 focus:ring-amber-500 outline-none transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">Detailed Narrative</label>
                        <textarea name="rooftop_desc" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-700 font-medium focus:ring-2 focus:ring-amber-500 outline-none leading-relaxed transition-all">{{ old('rooftop_desc', $settings['rooftop_desc'] ?? 'We offer a beautiful rooftop seating arrangement where guests can unwind...') }}</textarea>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest text-center">Promo Background Image</label>
                    <div class="flex-grow group relative">
                        <div class="w-full h-full min-h-[220px] rounded-[2rem] overflow-hidden border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center transition-all group-hover:border-amber-300">
                            @if(isset($settings['rooftop_bg']))
                                <img src="{{ asset($settings['rooftop_bg']) }}" class="w-40 h-40 ">
                            @else
                                <div class="text-slate-300 flex flex-col items-center">
                                    <i class="bi bi-image-alt text-5xl"></i>
                                    <span class="text-[10px] font-black uppercase tracking-widest mt-2">No Media</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-amber-600/0 group-hover:bg-amber-600/10 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <span class="bg-white text-amber-600 px-5 py-2.5 rounded-full text-xs font-black shadow-xl">Update Background</span>
                            </div>
                        </div>
                        <input type="file" name="rooftop_bg_file" class="mt-4 block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-amber-50 file:text-amber-600 hover:file:bg-amber-100 transition-all cursor-pointer">
                        
                    </div>
                </div>
            </div>
        </div>
<br>
        <!-- Cuisine Grid -->
        <div class="bg-white border border-slate-200 p-10 rounded-[2rem] relative shadow-sm transition-all hover:shadow-md">
            <div class="absolute -top-3 left-10 px-4 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-full py-1.5 shadow-lg mb-5">
                Cuisine & Menu Categories
            </div>

            <div class="flex items-center justify-between mb-8" style="margin-top:40px; padding: 20px;">
                <div>
                    <h3 class="text-2xl font-black text-slate-800">Menu Category Highlights</h3>
                    <p class="text-slate-500 text-sm mt-1">Showcase the diverse culinary offerings available</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 px-5">
                <div>
                    <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">Menu Subtitle</label>
                    <input type="text" name="menu_subtitle" value="{{ old('menu_subtitle', $settings['menu_subtitle'] ?? 'Indulge in Excellence') }}" class="w-full px-5 py-3 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-medium text-slate-700">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">Menu Main Title</label>
                    <input type="text" name="menu_title" value="{{ old('menu_title', $settings['menu_title'] ?? 'Explore Our Diverse Menu') }}" class="w-full px-5 py-3 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-bold text-slate-800">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">Menu Description</label>
                    <input type="text" name="menu_desc" value="{{ old('menu_desc', $settings['menu_desc'] ?? 'Crafted to satisfy every palate, from traditional favorites to international delicacies.') }}" class="w-full px-5 py-3 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none font-medium text-slate-600">
                </div>
            </div>

            @php
                $cuisines = isset($settings['cuisines']) ? json_decode($settings['cuisines'], true) : [];
            @endphp

            <div id="cuisines-container" class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
                @foreach($cuisines as $cidx => $cuisine)
                <div class="cuisine-item bg-slate-50/50 p-8 rounded-3xl border border-slate-100 shadow-sm relative group hover:bg-white hover:shadow-lg transition-all">
                    <button type="button" class="remove-cuisine absolute top-3 right-3 bg-rose-500 text-white w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110 shadow-xl z-20" style="top: 10px; right: 10px;">
                        <i class="bi bi-x-lg text-lg"></i>
                    </button>
                    <div class="space-y-6">
                        <div class="flex flex-col gap-4">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Category Media</label>
                            <div class="flex items-end gap-6">
                                <div class="w-24 h-24 rounded-2xl overflow-hidden bg-white flex-shrink-0 border border-slate-100 shadow-sm group/thumb relative">
                                    @if(isset($cuisine['image']))
                                        <img src="{{ asset($cuisine['image']) }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <input type="file" name="cuisines_file[{{$cidx}}][image]" class="text-[10px] w-full text-slate-500 file:bg-emerald-50 file:text-emerald-700 file:border-0 file:rounded-lg file:px-3 file:py-1 file:font-black hover:file:bg-emerald-100 transition-all">
                                    <input type="hidden" name="cuisines[{{$cidx}}][image]" value="{{ $cuisine['image'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 mb-1 uppercase tracking-widest">Title</label>
                                <input type="text" name="cuisines[{{$cidx}}][title]" value="{{ $cuisine['title'] ?? '' }}" placeholder="e.g. Authentic Bengali" class="w-full px-5 py-3 bg-white border border-slate-200 rounded-xl font-black text-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 mb-1 uppercase tracking-widest">Brief Narrative</label>
                                <textarea name="cuisines[{{$cidx}}][desc]" placeholder="Small flavor description..." rows="2" class="w-full px-5 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-600 focus:ring-2 focus:ring-emerald-500 outline-none transition-all">{{ $cuisine['desc'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
         <br>
            <div class="mt-12 flex justify-center">
                <button type="button" id="add-cuisine" class="bg-emerald-600 hover:bg-emerald-500 text-white font-black py-4 px-10 rounded-2xl transition-all shadow-xl hover:scale-[1.05] flex items-center gap-3 border border-white/20">
                    <i class="bi bi-plus-square-dotted text-xl"></i> Add New Menu Category
                </button>
            </div>
            <br>
        </div>
<br>
        <!-- Hospitality Grid (Experience Section) -->
        <div class="bg-white border border-slate-200 p-10 rounded-[2rem] relative shadow-sm transition-all hover:shadow-md">
            <div class="absolute -top-3 left-10 px-4 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-full py-1.5 shadow-lg mb-5">
                Service & Experience Pillars
            </div>
            
            <div class="flex justify-between items-center mb-10" style="margin-top:40px; padding: 20px;">
                <div>
                    <h3 class="text-2xl font-black text-slate-800">Hospitality Experience</h3>
                    <p class="text-slate-500 text-sm mt-1">Manage the highlighted feature cards at the page footer</p>
                </div>
            </div>
            
            @php
                $hospitality = isset($settings['hospitality_grid']) ? json_decode($settings['hospitality_grid'], true) : [];
            @endphp

            <div id="hospitality-container" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($hospitality as $hidx => $h)
                <div class="hospitality-item bg-slate-50/50 p-8 rounded-3xl border border-slate-100 relative transition-all hover:bg-white hover:shadow-lg group/card">
                    <button type="button" class="remove-hospitality absolute -top-3 -right-3 bg-rose-500 text-white w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110 shadow-xl z-30 pointer-events-auto" style="top: 10px; right: 10px;">
                        <i class="bi bi-trash-fill text-lg"></i>
                    </button>
                    <div class="mb-8">
                        <label class="block text-[10px] font-black text-slate-400 mb-3 uppercase tracking-widest">Identify Icon</label>
                        <select name="hospitality_grid[{{$hidx}}][icon]" class="icon-select" data-selected="{{ $h['icon'] ?? '' }}">
                        </select>
                    </div>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 mb-1 uppercase tracking-widest">Card Heading</label>
                            <input type="text" name="hospitality_grid[{{$hidx}}][title]" value="{{ $h['title'] ?? '' }}" placeholder="e.g. World-Class Chefs" class="w-full px-5 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 font-black placeholder:text-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 mb-1 uppercase tracking-widest">Description</label>
                            <textarea name="hospitality_grid[{{$hidx}}][desc]" placeholder="Brief point description..." rows="3" class="w-full px-5 py-3 bg-white border border-slate-200 rounded-xl text-sm text-slate-600 font-medium placeholder:text-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">{{ $h['desc'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12 pb-12 pt-5 flex justify-center">
                <button type="button" id="add-hospitality" class="bg-slate-900 hover:bg-slate-800 text-white font-black py-4 px-10 rounded-2xl transition-all shadow-xl hover:scale-[1.05] flex items-center gap-3">
                    <i class="bi bi-plus-circle-fill text-xl"></i> Add Experience Card
                </button>
                <br>
            </div>
        </div>

        <div class="flex mt-12 justify-end pt-12 border-t border-slate-100 gap-4">
            <button type="submit" class="px-16 mt-12 py-5 bg-indigo-600 text-white font-black rounded-3xl hover:bg-indigo-700 transition-all shadow-2xl hover:scale-[1.02] flex items-center gap-4 text-xl relative overflow-hidden group" style="margin-top: 50px;padding: 20px;">
                <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                <i class="bi bi-rocket-takeoff-fill"></i> Update Global Restaurant Page
            </button>
        </div>
    </form>
</div>

<!-- Templates for dynamic adding -->
<template id="pf-template">
    <div class="page-feature-item flex gap-4 items-center bg-slate-50/50 p-5 rounded-3xl border border-slate-100 transition-all hover:bg-white hover:shadow-md group">
        <div class="flex-grow grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">Feature Icon</label>
                <select name="page_features[IDX][icon]" class="icon-select" data-selected="bi bi-check-circle-fill"></select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">Key Point Description</label>
                <input type="text" name="page_features[IDX][text]" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-700 font-bold outline-none">
            </div>
        </div>
        <button type="button" class="remove-page-feature bg-rose-50 text-rose-500 p-3 rounded-2xl hover:bg-rose-500 hover:text-white transition-all shadow-sm">
            <i class="bi bi-trash3-fill"></i>
        </button>
    </div>
</template>

<template id="cuisine-template">
    <div class="cuisine-item bg-slate-50/50 p-8 rounded-3xl border border-slate-100 shadow-sm relative group hover:bg-white hover:shadow-lg transition-all">
        <button type="button" class="remove-cuisine absolute -top-3 -right-3 bg-rose-500 text-white w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110 shadow-xl z-20">
            <i class="bi bi-x-lg text-lg"></i>
        </button>
        <div class="space-y-6">
            <div class="flex flex-col gap-4">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Category Media</label>
                <div class="flex items-end gap-6">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden bg-white flex-shrink-0 border border-slate-100 shadow-sm flex items-center justify-center text-slate-300"><i class="bi bi-image"></i></div>
                    <div class="flex-grow">
                        <input type="file" name="cuisines_file[IDX][image]" class="text-[10px] w-full text-slate-500 file:bg-emerald-50 file:text-emerald-700 file:border-0 file:rounded-lg file:px-3 file:py-1 file:font-black">
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <input type="text" name="cuisines[IDX][title]" placeholder="Cuisine Category Title" class="w-full px-5 py-3 bg-white border border-slate-200 rounded-xl font-black text-slate-800 outline-none">
                <textarea name="cuisines[IDX][desc]" placeholder="Small flavor description..." rows="2" class="w-full px-5 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-600 outline-none"></textarea>
            </div>
        </div>
    </div>
</template>

<template id="hospitality-template">
    <div class="hospitality-item bg-slate-50/50 p-8 rounded-3xl border border-slate-100 relative transition-all hover:bg-white hover:shadow-lg group/card">
        <button type="button" class="remove-hospitality absolute -top-3 -right-3 bg-rose-500 text-white w-10 h-10 rounded-full flex items-center justify-center transition-all hover:scale-110 shadow-xl z-30 pointer-events-auto">
            <i class="bi bi-trash-fill text-lg"></i>
        </button>
        <div class="mb-8">
            <label class="block text-[10px] font-black text-slate-400 mb-3 uppercase tracking-widest">Identify Icon</label>
            <select name="hospitality_grid[IDX][icon]" class="icon-select" data-selected="bi bi-check-circle-fill">
            </select>
        </div>
        <div class="space-y-5">
            <input type="text" name="hospitality_grid[IDX][title]" placeholder="Experience Pillar Title" class="w-full px-5 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 font-black outline-none">
            <textarea name="hospitality_grid[IDX][desc]" placeholder="Brief narrative..." rows="3" class="w-full px-5 py-3 bg-white border border-slate-200 rounded-xl text-sm text-slate-600 font-medium outline-none"></textarea>
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Shared initialization function
    function initDynamicItem(item) {
        if (window.initIconSelect) {
            const select = item.querySelector('.icon-select');
            if (select) window.initIconSelect(select);
        }
    }

    // Feature Points logic
    const pfContainer = document.getElementById('page-features-container');
    const addPfBtn = document.getElementById('add-page-feature');
    const pfTemplate = document.getElementById('pf-template').innerHTML;
    let pfIdx = Date.now();

    addPfBtn.addEventListener('click', function() {
        const html = pfTemplate.replace(/IDX/g, pfIdx);
        const div = document.createElement('div');
        div.innerHTML = html;
        const item = div.firstElementChild;
        pfContainer.appendChild(item);
        initDynamicItem(item);
        pfIdx++;
    });

    // Cuisine logic
    const cuisineContainer = document.getElementById('cuisines-container');
    const addCuisineBtn = document.getElementById('add-cuisine');
    const cuisineTemplate = document.getElementById('cuisine-template').innerHTML;
    let cIdx = Date.now() + 1000;

    addCuisineBtn.addEventListener('click', function() {
        const html = cuisineTemplate.replace(/IDX/g, cIdx);
        const div = document.createElement('div');
        div.innerHTML = html;
        const item = div.firstElementChild;
        cuisineContainer.appendChild(item);
        cIdx++;
    });

    // Hospitality logic
    const hospContainer = document.getElementById('hospitality-container');
    const addHospBtn = document.getElementById('add-hospitality');
    const hospTemplate = document.getElementById('hospitality-template').innerHTML;
    let hIdx = Date.now() + 2000;

    addHospBtn.addEventListener('click', function() {
        const html = hospTemplate.replace(/IDX/g, hIdx);
        const div = document.createElement('div');
        div.innerHTML = html;
        const item = div.firstElementChild;
        hospContainer.appendChild(item);
        initDynamicItem(item);
        hIdx++;
    });

    // Unified removal
    document.addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.remove-page-feature, .remove-cuisine, .remove-hospitality');
        if (removeBtn) {
            const item = removeBtn.closest('.page-feature-item, .cuisine-item, .hospitality-item');
            if (item) {
                item.style.opacity = '0';
                item.style.transform = 'scale(0.95)';
                setTimeout(() => item.remove(), 250);
            }
        }
    });
});

function previewHeroImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('heroPreviewImg');
            var placeholder = document.getElementById('heroPreviewPlaceholder');
            img.src = e.target.result;
            img.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
