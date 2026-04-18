@extends('layouts.admin')

@section('header', 'Home Page: Restaurant Section')

@section('content')
<div class="card-premium p-8 max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-8 border-b border-slate-100 pb-5">
        <div>
            <h3 class="text-2xl font-bold text-slate-800">Restaurant Section Settings</h3>
            <p class="text-sm text-slate-500 mt-1">Manage the dining summary section on the home page</p>
        </div>
    </div>



    <form action="{{ route('admin.home_restaurant.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf
        @method('PUT')

        <!-- Text Content -->
        <div class="bg-slate-50 border border-slate-100 p-6 rounded-2xl relative">
            <div class="absolute -top-3 left-6 px-3 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full py-1">
                Text Content
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Subtitle</label>
                    <input type="text" name="restaurant_subtitle" value="{{ old('restaurant_subtitle', $settings['restaurant_subtitle'] ?? 'Culinary Excellence') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Title <span class="text-xs text-slate-400 font-normal">(Use &lt;br&gt; for line breaks)</span></label>
                    <input type="text" name="restaurant_title" value="{{ old('restaurant_title', $settings['restaurant_title'] ?? 'Restaurant at <br> Nice Guest House') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                    <textarea name="restaurant_desc" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">{{ old('restaurant_desc', $settings['restaurant_desc'] ?? "Indulge in a world of flavor with our diverse menu featuring authentic Thai, Chinese, Indian, and local Deshi delicacies. Whether you're seeking a scenic rooftop view or a refined indoor ambiance, our three distinct restaurants offer an unforgettable dining experience.") }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Button Text</label>
                    <input type="text" name="restaurant_btn_text" value="{{ old('restaurant_btn_text', $settings['restaurant_btn_text'] ?? 'Explore Our Dining') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Button Link <span class="text-xs text-slate-400 font-normal">(e.g. # or /menu)</span></label>
                    <input type="text" name="restaurant_btn_link" value="{{ old('restaurant_btn_link', $settings['restaurant_btn_link'] ?? '#') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                </div>
            </div>
        </div>

        <!-- Images -->
        <div class="bg-indigo-50/50 border border-indigo-100 p-6 rounded-2xl relative">
            <div class="absolute -top-3 left-6 px-3 bg-indigo-600 text-white text-xs font-bold uppercase tracking-wider rounded-full py-1">
                Images Grid
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">
                <!-- Main Image -->
                <div style="margin-top:50px">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Main Image (Small overlay)</label>
                    <div class="flex items-center gap-4">
                        <div class="w-24 h-24 rounded-lg overflow-hidden border border-slate-200 bg-white flex-shrink-0">
                            @if(isset($settings['restaurant_img_main']))
                                <img src="{{ asset($settings['restaurant_img_main']) }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('assets/img/restaurant/rest-small.jpg') }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <input type="file" name="restaurant_img_main_file" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                    </div>
                </div>
                <!-- Secondary Image -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Secondary Image (Large background)</label>
                    <div class="flex items-center gap-4">
                        <div class="w-24 h-24 rounded-lg overflow-hidden border border-slate-200 bg-white flex-shrink-0">
                            @if(isset($settings['restaurant_img_secondary']))
                                <img src="{{ asset($settings['restaurant_img_secondary']) }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('assets/img/restaurant/rest-big.jpg') }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <input type="file" name="restaurant_img_secondary_file" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Matrix -->
        <div class="bg-amber-50/50 border border-amber-100 p-6 rounded-2xl relative">
            <div class="absolute -top-3 left-6 px-3 bg-amber-500 text-white text-xs font-bold uppercase tracking-wider rounded-full py-1">
                Restaurant Features
            </div>
            
            @php
                $features = isset($settings['restaurant_features']) ? json_decode($settings['restaurant_features'], true) : [];
            @endphp

            <div id="features-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                @foreach($features as $index => $feature)
                <div class="feature-item bg-white p-4 rounded-lg border border-amber-200 shadow-sm flex flex-col gap-3 relative group">
                    <button type="button" class="remove-feature absolute -top-2 -right-2 bg-rose-500 text-white w-8 h-8 rounded-full flex items-center justify-center transition-all hover:scale-110 shadow-lg z-20" style="top: 10px; right: 10px;">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                    <div class="text-xs font-bold text-amber-800 uppercase">Feature Item</div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Icon</label>
                        <select name="restaurant_features[{{$index}}][icon]" class="icon-select" data-selected="{{ $feature['icon'] ?? '' }}">
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Text Tagline</label>
                        <input type="text" name="restaurant_features[{{$index}}][text]" value="{{ $feature['text'] ?? '' }}" placeholder="e.g. 3 Restaurants" class="w-full px-3 py-1.5 text-sm border border-slate-300 rounded focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-center">
                <button type="button" id="add-feature" class="bg-amber-500 hover:bg-amber-600 text-gray font-bold py-3 px-8 rounded-xl transition shadow-lg hover:shadow-xl flex items-center gap-2">
                    <i class="bi bi-plus-circle"></i> Add More Feature
                </button>
            </div>
            <p class="text-xs text-amber-700 mt-4 text-center"><i class="bi bi-info-circle mr-1"></i> You can add as many features as you need. They will be displayed on the home page matrix.</p>
        </div>

        <template id="feature-template">
            <div class="feature-item bg-white p-4 rounded-lg border border-amber-200 shadow-sm flex flex-col gap-3 relative group">
                <button type="button" class="remove-feature absolute -top-2 -right-2 bg-rose-500 text-white w-8 h-8 rounded-full flex items-center justify-center transition-all hover:scale-110 shadow-lg z-20" style="top: 10px; right: 10px;">
                    <i class="bi bi-trash-fill"></i>
                </button>
                <div class="text-xs font-bold text-amber-800 uppercase">New Feature Item</div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Icon</label>
                    <select name="restaurant_features[REPLACE_INDEX][icon]" class="icon-select" data-selected="bi bi-star">
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Text Tagline</label>
                    <input type="text" name="restaurant_features[REPLACE_INDEX][text]" placeholder="e.g. Rooftop View" class="w-full px-3 py-1.5 text-sm border border-slate-300 rounded focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>
            </div>
        </template>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('features-container');
                const addButton = document.getElementById('add-feature');
                const template = document.getElementById('feature-template').innerHTML;
                let featureIndex = {{ count($features) }};

                addButton.addEventListener('click', function() {
                    const newItem = template.replace(/REPLACE_INDEX/g, featureIndex);
                    const div = document.createElement('div');
                    div.innerHTML = newItem;
                    const item = div.firstElementChild;
                    container.appendChild(item);
                    
                    // Initialize icon select for new item
                    if (window.initIconSelect) {
                        window.initIconSelect(item.querySelector('.icon-select'));
                    }
                    
                    featureIndex++;
                    updateRemoveButtons();
                });

                container.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-feature')) {
                        e.target.closest('.feature-item').remove();
                        updateRemoveButtons();
                    }
                });

                function updateRemoveButtons() {
                    const items = container.querySelectorAll('.feature-item');
                    // Optional: keep at least 1 or hide remove if count is 1
                }
            });
        </script>

        <div class="flex justify-end pt-4 border-t border-slate-100 gap-4">
            <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg hover:shadow-xl flex items-center gap-2 text-lg">
                <i class="bi bi-save"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
