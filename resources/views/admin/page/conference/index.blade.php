@extends('layouts.admin')

@section('header', 'Manage Conference Halls')

@section('content')

<!-- Conference Page Settings -->
<div class="card-premium p-8 mb-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Conference Page Settings</h3>
            <p class="text-sm text-slate-500">Customize the banner, title, and tagline displayed on the Conference page.</p>
        </div>
    </div>

    <form action="{{ route('admin.page.update', 'conference') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="bi bi-type me-2"></i>Hero Tagline
                    </label>
                    <input type="text" name="hero_tagline" value="{{ old('hero_tagline', $settings['hero_tagline'] ?? 'Elite Corporate Venues') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="bi bi-type-h1 me-2"></i>Hero Title (Main Heading)
                    </label>
                    <textarea name="hero_title" rows="2" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">{{ old('hero_title', $settings['hero_title'] ?? 'Nice Guest House &<br>Training Hall') }}</textarea>
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

<!-- Conference Halls Management Card -->
<div class="card-premium p-8 mb-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Conference Halls Management</h3>
            <p class="text-sm text-slate-500">Manage your corporative venues, halls, and training rooms</p>
        </div>
        <a href="{{ route('admin.conference.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Add New Hall
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-y border-slate-100">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Preview</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Hall Details</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Capacity</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Price</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($halls as $hall)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="w-24 h-16 rounded-lg overflow-hidden border border-slate-200">
                            @if($hall->image)
                                <img src="{{ str_starts_with($hall->image, 'http') ? $hall->image : asset($hall->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400"><i class="bi bi-image"></i></div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-semibold text-slate-700">{{ $hall->name }}</span>
                            @if($hall->badge_text)
                                <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 font-bold text-[10px] rounded-full uppercase tracking-wider flex-shrink-0">{{ $hall->badge_text }}</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 text-xs text-slate-400 mt-0.5">
                            @if($hall->panorama_url) <span title="360 View Available" class="text-indigo-500"><i class="bi bi-badge-3d-fill fs-6"></i> 360&deg;</span> @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3 text-slate-600 font-bold">
                            <span title="Capacity"><i class="bi bi-people-fill me-1"></i> {{ $hall->capacity ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center text-indigo-700 font-black">
                            <span title="Price">{{ $hall->price ? 'TK ' . number_format($hall->price, 0) : 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.conference.toggle-status', $hall) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-3 py-1 text-xs font-bold rounded-full transition-all {{ $hall->status ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                {{ $hall->status ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-3 text-sm">
                            <a href="{{ route('admin.conference.edit', $hall) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.conference.destroy', $hall) }}" method="POST" onsubmit="return confirm('Delete this hall?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition">
                                    <i class="bi bi-trash3"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($halls->hasPages())
    <div class="mt-8 px-6">
        {{ $halls->links() }}
    </div>
    @endif
</div>

<!-- Conference Content Management -->
<div class="card-premium p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Conference Content Management</h3>
            <p class="text-sm text-slate-500">Manage the Versatility and Infrastructure section texts and imagery</p>
        </div>
    </div>
    
    <form action="{{ route('admin.page.update', 'conference') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
        @csrf
        @method('PUT')

        <!-- Versatility Section -->
        <div class="bg-white border border-slate-200 p-10 rounded-[2rem] relative shadow-sm transition-all hover:shadow-md">
            <div class="absolute -top-3 left-10 px-4 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-full py-1.5 shadow-lg mb-5">
                Versatility Section
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4" style="margin-top:40px; padding: 20px;">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Section Label</label>
                        <input type="text" name="suitability_label" value="{{ old('suitability_label', $settings['suitability_label'] ?? 'Versatility') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Section Title</label>
                        <input type="text" name="suitability_title" value="{{ old('suitability_title', $settings['suitability_title'] ?? 'Designed for Every Significant Moment.') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Description text</label>
                        <textarea name="suitability_desc" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">{{ old('suitability_desc', $settings['suitability_desc'] ?? 'From high-level corporate strategies to celebration of milestones, our halls adapt to your vision with seamless precision.') }}</textarea>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Section Image</label>
                    <div class="mb-3">
                        @if(isset($settings['suitability_image']))
                            <img src="{{ asset($settings['suitability_image']) }}" class="w-full h-40 object-cover rounded-xl border border-slate-200">
                        @endif
                    </div>
                    <input type="file" name="suitability_image_file" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
                </div>
            </div>
<br><br>
            <div class="mt-8 border-t border-slate-200 pt-6">
                <label class="block   mb-4 bg-indigo-600 text-white px-4 py-2 rounded-full w-fit text-[10px] font-black uppercase tracking-[0.2em]">Grid Items</label>
                @php
                    $suitabilityDefaults = [
                        ['icon' => 'bi-briefcase', 'title' => 'Board Meetings'],
                        ['icon' => 'bi-globe', 'title' => 'Conferences'],
                        ['icon' => 'bi-people', 'title' => 'Retreats'],
                        ['icon' => 'bi-award', 'title' => 'Trainings'],
                        ['icon' => 'bi-calendar-heart', 'title' => 'Weddings'],
                        ['icon' => 'bi-megaphone', 'title' => 'Exhibitions']
                    ];
                    $currentSuitability = json_decode($settings['suitability_items'] ?? '[]', true) ?: $suitabilityDefaults;
                    if (empty($currentSuitability)) $currentSuitability = [];
                @endphp
                <input type="hidden" name="suitability_items" value="">
                <div id="suitability-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($currentSuitability as $i => $item)
                        <div class="suitability-item p-4 bg-slate-50 border border-slate-200 rounded-xl relative pr-10">
                            <button type="button" class="absolute top-2 right-2 text-red-500 hover:text-red-700 p-1 remove-suitability" style="right: 20px;top:2px;background-color: #dc2626;color:white;border-radius: 50%;width: 25px;height: 25px;display: flex;align-items: center;justify-content: center;"><i class="bi bi-trash"></i></button>
                            <div class="mb-3">
                                <label class="text-xs font-bold text-slate-500 mb-1 block">Icon</label>
                                <select name="suitability_items[{{$i}}][icon]" class="icon-select w-full px-3 py-2 bg-white border border-slate-200 rounded text-sm focus:ring-2 focus:ring-indigo-300 outline-none" data-selected="{{ $item['icon'] ?? 'bi-star' }}">
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 mb-1 block">Title</label>
                                <input type="text" name="suitability_items[{{$i}}][title]" value="{{ $item['title'] ?? '' }}" class="w-full px-3 py-2 bg-white border border-slate-200 rounded text-sm focus:ring-2 focus:ring-indigo-300 outline-none">
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-suitability" class="mt-4 text-sm text-indigo-600 font-bold hover:text-indigo-800"><i class="bi bi-plus-circle me-1"></i> Add Grid Item</button>
            </div>
        </div>
<br>
        <!-- Infrastructure Section -->
        <div class="bg-white border border-slate-200 p-10 rounded-[2rem] relative shadow-sm transition-all hover:shadow-md">
            <div class="absolute -top-3 left-10 px-4 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-full py-1.5 shadow-lg mb-5">
                Infrastructure Section
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4" style="margin-top:40px; padding: 20px;">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Section Label</label>
                        <input type="text" name="facilities_label" value="{{ old('facilities_label', $settings['facilities_label'] ?? 'Infrastructure') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Section Title</label>
                        <input type="text" name="facilities_title" value="{{ old('facilities_title', $settings['facilities_title'] ?? 'World-Class Excellence<br>Included as Standard.') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Overview Image</label>
                    <div class="mb-3">
                        @if(isset($settings['facilities_image']))
                            <img src="{{ asset($settings['facilities_image']) }}" class="w-full h-40 object-cover rounded-xl border border-slate-200">
                        @endif
                    </div>
                    <input type="file" name="facilities_image_file" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
                </div>
            </div>

            <div class="mt-8 border-t border-slate-200 pt-6">
                <label class="block   mb-4 bg-indigo-600 text-white px-4 py-2 rounded-full w-fit text-[10px] font-black uppercase tracking-[0.2em]">Facility Cards</label>
                @php
                    $facilityDefaults = [
                        ['icon' => 'bi-display', 'title' => 'Advanced A/V', 'desc' => '4K LCD Displays & HDR Projectors'],
                        ['icon' => 'bi-wifi', 'title' => 'Gigabit Connectivity', 'desc' => 'Dedicated high-speed enterprise WiFi'],
                        ['icon' => 'bi-volume-up', 'title' => 'Stereo Sound', 'desc' => 'Integrated ceiling-mounted audio system'],
                        ['icon' => 'bi-cup-hot', 'title' => 'Catering Ready', 'desc' => 'On-site gourmet refreshments available']
                    ];
                    $currentFacilities = json_decode($settings['facilities_items'] ?? '[]', true) ?: $facilityDefaults;
                    if (empty($currentFacilities)) $currentFacilities = [];
                @endphp
                <input type="hidden" name="facilities_items" value="">
                <div id="facilities-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($currentFacilities as $i => $item)
                        <div class="facility-item p-4 bg-slate-50 border border-slate-200 rounded-xl relative pr-10">
                            <button type="button" class="absolute top-2 right-2 text-red-500 hover:text-red-700 p-1 remove-facility" style="right: 20px;top:2px;background-color: #dc2626;color:white;border-radius: 50%;width: 25px;height: 25px;display: flex;align-items: center;justify-content: center;"><i class="bi bi-trash"></i></button>
                            <div class="grid grid-cols-[1fr_2fr] gap-3 mb-3">
                                <div>
                                    <label class="text-xs font-bold text-slate-500 mb-1 block">Icon</label>
                                    <select name="facilities_items[{{$i}}][icon]" class="icon-select w-full px-3 py-2 bg-white border border-slate-200 rounded text-sm focus:ring-2 focus:ring-indigo-300 outline-none" data-selected="{{ $item['icon'] ?? 'bi-star' }}">
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-500 mb-1 block">Title</label>
                                    <input type="text" name="facilities_items[{{$i}}][title]" value="{{ $item['title'] ?? '' }}" class="w-full px-3 py-2 bg-white border border-slate-200 rounded text-sm focus:ring-2 focus:ring-indigo-300 outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 mb-1 block">Description</label>
                                <input type="text" name="facilities_items[{{$i}}][desc]" value="{{ $item['desc'] ?? '' }}" class="w-full px-3 py-2 bg-white border border-slate-200 rounded text-sm focus:ring-2 focus:ring-indigo-300 outline-none">
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-facility" class="mt-4 text-sm text-indigo-600 font-bold hover:text-indigo-800"><i class="bi bi-plus-circle me-1"></i> Add Facility Card</button>
            </div>
        </div>

        <div class="flex justify-end mt-8">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-12 rounded-xl transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                <i class="bi bi-floppy2-fill"></i> Save Advanced Modules
            </button>
        </div>
    </form>
</div>

<script>
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

document.addEventListener('DOMContentLoaded', function() {
    // Suitability Add/Remove
    const suitabilityContainer = document.getElementById('suitability-container');
    const addSuitabilityBtn = document.getElementById('add-suitability');
    let suitabilityIndex = Date.now();

    addSuitabilityBtn.addEventListener('click', () => {
        const item = document.createElement('div');
        item.className = 'suitability-item p-4 bg-slate-50 border border-slate-200 rounded-xl relative pr-10';
        item.innerHTML = `
            <button type="button" class="absolute top-2 right-2 text-red-500 hover:text-red-700 p-1 remove-suitability" style="right: 20px;top:2px;background-color: #dc2626;color:white;border-radius: 50%;width: 25px;height: 25px;display: flex;align-items: center;justify-content: center;"><i class="bi bi-trash"></i></button>
            <div class="mb-3">
                <label class="text-xs font-bold text-slate-500 mb-1 block">Icon</label>
                <select name="suitability_items[${suitabilityIndex}][icon]" class="icon-select w-full px-3 py-2 bg-white border border-slate-200 rounded text-sm focus:ring-2 focus:ring-indigo-300 outline-none" data-selected="bi-star"></select>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 mb-1 block">Title</label>
                <input type="text" name="suitability_items[${suitabilityIndex}][title]" class="w-full px-3 py-2 bg-white border border-slate-200 rounded text-sm focus:ring-2 focus:ring-indigo-300 outline-none">
            </div>
        `;
        suitabilityContainer.appendChild(item);
        if (typeof window.initIconSelect === 'function') {
            window.initIconSelect($(item).find('.icon-select')[0]);
        }
        suitabilityIndex++;
    });

    suitabilityContainer.addEventListener('click', (e) => {
        if (e.target.closest('.remove-suitability')) {
            e.target.closest('.suitability-item').remove();
        }
    });

    // Facilities Add/Remove
    const facilitiesContainer = document.getElementById('facilities-container');
    const addFacilityBtn = document.getElementById('add-facility');
    let facilityIndex = Date.now() + 5000;

    addFacilityBtn.addEventListener('click', () => {
        const item = document.createElement('div');
        item.className = 'facility-item p-4 bg-slate-50 border border-slate-200 rounded-xl relative pr-10';
        item.innerHTML = `
            <button type="button" class="absolute top-2 right-2 text-red-500 hover:text-red-700 p-1 remove-facility" style="right: 20px;top:2px;background-color: #dc2626;color:white;border-radius: 50%;width: 25px;height: 25px;display: flex;align-items: center;justify-content: center;"><i class="bi bi-trash"></i></button>
            <div class="grid grid-cols-[1fr_2fr] gap-3 mb-3">
                <div>
                    <label class="text-xs font-bold text-slate-500 mb-1 block">Icon</label>
                    <select name="facilities_items[${facilityIndex}][icon]" class="icon-select w-full px-3 py-2 bg-white border border-slate-200 rounded text-sm focus:ring-2 focus:ring-indigo-300 outline-none" data-selected="bi-star"></select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 mb-1 block">Title</label>
                    <input type="text" name="facilities_items[${facilityIndex}][title]" class="w-full px-3 py-2 bg-white border border-slate-200 rounded text-sm focus:ring-2 focus:ring-indigo-300 outline-none">
                </div>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 mb-1 block">Description</label>
                <input type="text" name="facilities_items[${facilityIndex}][desc]" class="w-full px-3 py-2 bg-white border border-slate-200 rounded text-sm focus:ring-2 focus:ring-indigo-300 outline-none">
            </div>
        `;
        facilitiesContainer.appendChild(item);
        if (typeof window.initIconSelect === 'function') {
            window.initIconSelect($(item).find('.icon-select')[0]);
        }
        facilityIndex++;
    });

    facilitiesContainer.addEventListener('click', (e) => {
        if (e.target.closest('.remove-facility')) {
            e.target.closest('.facility-item').remove();
        }
    });
});
</script>

@endsection
