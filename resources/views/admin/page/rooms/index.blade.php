@extends('layouts.admin')

@section('header', 'Manage Rooms')

@section('content')


<!-- Rooms Page Settings Card -->
<div class="card-premium p-8 mb-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Rooms Page Settings</h3>
            <p class="text-sm text-slate-500">Customize the banner, title, and subtitle displayed on the Rooms listing page.</p>
        </div>
    </div>

    <form action="{{ route('admin.page.update', 'room') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- Banner Title --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                <i class="bi bi-type-h1 me-2"></i>Banner Title
            </label>
            <input type="text" name="banner_title"
                value="{{ $settings['banner_title'] ?? 'Find Your Perfect Room' }}"
                class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
                placeholder="e.g. Find Your Perfect Room">
        </div>

        {{-- Banner Subtitle --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                <i class="bi bi-type me-2"></i>Banner Subtitle
            </label>
            <input type="text" name="banner_subtitle"
                value="{{ $settings['banner_subtitle'] ?? 'Explore our collection of luxury rooms and suites.' }}"
                class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
                placeholder="e.g. Explore our collection of luxury rooms and suites.">
        </div>

        {{-- Banner Image --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                <i class="bi bi-image me-2"></i>Banner Background Image
            </label>

            @php
                $storedBannerPath = $settings['banner_image'] ?? '';
                $bannerUrl = $storedBannerPath ? asset($storedBannerPath) : '';
            @endphp

            {{-- Current / Preview image --}}
            <div id="bannerPreviewContainer" class="{{ empty($storedBannerPath) ? 'hidden' : '' }} mb-3">
                <p class="text-xs text-slate-500 mb-1 font-semibold" id="bannerPreviewLabel">
                    {{ $storedBannerPath ? 'Current Banner' : 'Upload Preview' }}
                </p>
                <div class="rounded-xl overflow-hidden border border-slate-200 shadow-sm" style="max-height:220px;">
                    <img id="bannerPreviewImg"
                        src="{{ $bannerUrl ?: '#' }}"
                        alt="Banner Preview"
                        class="w-full object-cover"
                        style="max-height:220px; object-fit:cover; display:block;">
                </div>
            </div>

            {{-- Upload input --}}
            <label class="flex items-center gap-3 cursor-pointer border-2 border-dashed border-slate-300 hover:border-indigo-400 rounded-xl px-5 py-5 transition-all" id="bannerDropZone">
                <i class="bi bi-cloud-arrow-up text-2xl text-slate-400"></i>
                <div>
                    <span class="block font-semibold text-slate-600 text-sm">Click to upload banner image</span>
                    <span class="text-xs text-slate-400">Recommended: 1920 × 600px. JPG, PNG, WebP.</span>
                </div>
                <input type="file" name="banner_image_file" accept="image/*" id="bannerImageInput" class="hidden">
            </label>
        </div>

        {{-- Search Placeholder --}}
        <div class="mb-8">
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                <i class="bi bi-search me-2"></i>Search Placeholder Text
            </label>
            <input type="text" name="search_placeholder"
                value="{{ $settings['search_placeholder'] ?? 'Search rooms, amenities...' }}"
                class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
                placeholder="e.g. Search rooms, amenities...">
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                <i class="bi bi-floppy2-fill"></i> Save Settings
            </button>
        </div>
    </form>
</div>

<!-- Rooms Management Card -->
<div class="card-premium p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Rooms Management</h3>
            <p class="text-sm text-slate-500">Manage your hotel listings and pricing</p>
        </div>
        <a href="{{ route('admin.rooms.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Add New Room
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-y border-slate-100">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Preview</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Room Details</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Capacity</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Price per Night</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($rooms as $room)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="w-24 h-16 rounded-lg overflow-hidden border border-slate-200">
                            <img src="{{ str_starts_with($room->image, 'http') ? $room->image : asset($room->image) }}" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-semibold text-slate-700">{{ $room->name }}</span>
                            @if($room->is_featured)
                                <span class="px-2 py-0.5 bg-amber-100 text-amber-700 font-bold text-[10px] rounded-full uppercase tracking-wider flex-shrink-0">Featured</span>
                            @endif
                            @if($room->badge_text)
                                <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 font-bold text-[10px] rounded-full uppercase tracking-wider flex-shrink-0">{{ $room->badge_text }}</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 text-xs text-slate-400 mt-0.5">
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 font-bold rounded-lg uppercase tracking-wider">{{ str_replace('-', ' ', $room->room_type) ?? 'N/A' }}</span>
                            @if($room->bed_type) <span class="truncate">&bull; {{ $room->bed_type }}</span> @endif
                            @if($room->is_360_available) <span title="360 View Available" class="text-indigo-500"><i class="bi bi-badge-3d-fill fs-6"></i></span> @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center flex-nowrap gap-x-3 gap-y-1 text-slate-600 max-w-[140px] mx-auto">
                            <span title="Adults" class="flex items-center gap-1.5"><i class="bi bi-people-fill text-indigo-400"></i> {{ $room->capacity_adults ?? 0 }}</span>
                            <span title="Children" class="flex items-center gap-1.5"><i class="bi bi-person-fill text-emerald-400"></i> {{ $room->capacity_children ?? 0 }}</span>
                            <span title="Infants" class="flex items-center gap-1.5"><i class="bi bi-egg-fill text-amber-400"></i> {{ $room->capacity_infants ?? 0 }}</span>
                            <span title="Pets" class="flex items-center gap-1.5">
                                <svg class="text-rose-400 w-4 h-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.5 6.5C8.5 5.12 7.38 4 6 4S3.5 5.12 3.5 6.5C3.5 7.88 4.62 9 6 9S8.5 7.88 8.5 6.5M12 8C13.66 8 15 6.66 15 5S13.66 2 12 2S9 3.34 9 5C9 6.66 10.34 8 12 8M18 4C16.62 4 15.5 5.12 15.5 6.5C15.5 7.88 16.62 9 18 9S20.5 7.88 20.5 6.5C20.5 5.12 19.38 4 18 4M19.46 11.2C18.42 10.5 17.5 10 16 10H14V9.5C14 8.67 13.33 8 12.5 8H11.5C10.67 8 10 8.67 10 9.5V10H8C6.5 10 5.58 10.5 4.54 11.2C3.12 12.16 2.5 13.78 2.5 15.5V19C2.5 20.1 3.4 21 4.5 21H19.5C20.6 21 21.5 20.1 21.5 19V15.5C21.5 13.78 20.88 12.16 19.46 11.2Z" />
                                </svg> 
                                {{ $room->capacity_pets ?? 0 }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-indigo-600">TK {{ number_format($room->price, 0) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-3 text-sm">
                            <a href="{{ route('admin.rooms.edit', $room) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" onsubmit="return confirm('Delete this room?')">
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
    
    @if($rooms->hasPages())
    <div class="mt-8 px-6">
        {{ $rooms->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
document.getElementById('bannerImageInput').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById('bannerPreviewImg');
        const container = document.getElementById('bannerPreviewContainer');
        img.src = e.target.result;
        container.classList.remove('hidden');
        // Update label
        container.querySelector('p').textContent = 'Upload Preview';
    };
    reader.readAsDataURL(file);
});
</script>
@endpush

@endsection
