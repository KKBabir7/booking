@extends('layouts.admin')

@section('header', isset($room) ? __('Edit Room') : __('Create New Room'))

@section('content')
    <div class="max-w-4xl mx-auto pb-24">
        <div class="mb-6">
            <h3 class="text-3xl font-bold text-slate-800">
                {{ isset($room) ? 'Edit Room Listing' : 'Create New Room Listing' }}</h3>
            <p class="text-sm text-slate-500 mt-2">Configure room details, pricing, and guest capacity</p>
        </div>

        <form action="{{ isset($room) ? route('admin.rooms.update', $room) : route('admin.rooms.store') }}"
            method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if(isset($room)) @method('PUT') @endif

            <!-- 1. Basic Information -->
            <div class="card-premium p-8">
                <h4 class="text-sm uppercase tracking-widest font-black text-slate-400 mb-6">Basic Information</h4>
                
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Room Name *</label>
                        <input type="text" name="name" value="{{ old('name', $room->name ?? '') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-800 font-bold"
                            placeholder="e.g. Deluxe Ocean Suite" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Room Type *</label>
                        <select name="room_type"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700 font-semibold"
                            required>
                            <option value="">Select Room Type</option>
                            <option value="ac-deluxe" {{ old('room_type', $room->room_type ?? '') == 'ac-deluxe' ? 'selected' : '' }}>AC Deluxe</option>
                            <option value="ac-room" {{ old('room_type', $room->room_type ?? '') == 'ac-room' ? 'selected' : '' }}>AC Room</option>
                            <option value="ac-single" {{ old('room_type', $room->room_type ?? '') == 'ac-single' ? 'selected' : '' }}>AC Single</option>
                            <option value="business" {{ old('room_type', $room->room_type ?? '') == 'business' ? 'selected' : '' }}>Business Class</option>
                            <option value="double-deluxe" {{ old('room_type', $room->room_type ?? '') == 'double-deluxe' ? 'selected' : '' }}>Double Deluxe</option>
                            <option value="exec-deluxe" {{ old('room_type', $room->room_type ?? '') == 'exec-deluxe' ? 'selected' : '' }}>Executive Deluxe</option>
                            <option value="exec-suite" {{ old('room_type', $room->room_type ?? '') == 'exec-suite' ? 'selected' : '' }}>Executive Suite</option>
                            <option value="family-deluxe" {{ old('room_type', $room->room_type ?? '') == 'family-deluxe' ? 'selected' : '' }}>Family Deluxe</option>
                            <option value="nonac-luxury" {{ old('room_type', $room->room_type ?? '') == 'nonac-luxury' ? 'selected' : '' }}>Non AC Luxury</option>
                            <option value="nonac-single" {{ old('room_type', $room->room_type ?? '') == 'nonac-single' ? 'selected' : '' }}>Non AC Single</option>
                            <option value="super-deluxe" {{ old('room_type', $room->room_type ?? '') == 'super-deluxe' ? 'selected' : '' }}>Super Deluxe</option>
                            <option value="vip-deluxe" {{ old('room_type', $room->room_type ?? '') == 'vip-deluxe' ? 'selected' : '' }}>VIP Deluxe</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Price per Night *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">TK</span>
                            <input type="number" name="price" value="{{ old('price', $room->price ?? '') }}"
                                class="w-full pl-12 pr-4 py-2.5 bg-indigo-50/50 border border-indigo-100 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-indigo-700 font-black"
                                required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Old Price (Optional)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">TK</span>
                            <input type="number" name="old_price"
                                value="{{ old('old_price', $room->old_price ?? '') }}"
                                class="w-full pl-12 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-500 line-through">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Service Charge (per night)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">TK</span>
                            <input type="number" name="service_charge" value="{{ old('service_charge', $room->service_charge ?? '0') }}"
                                class="w-full pl-12 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-800 font-bold">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tax (per night)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">TK</span>
                            <input type="number" name="tax" value="{{ old('tax', $room->tax ?? '0') }}"
                                class="w-full pl-12 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-800 font-bold">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Configuration -->
            <div class="card-premium p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="bi bi-credit-card-fill fs-5"></i>
                    </div>
                    <div>
                        <h4 class="text-sm uppercase tracking-widest font-black text-slate-400 leading-none mb-1">Payment Configuration</h4>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Set custom partial payment percentages</p>
                    </div>
                </div>
                
                <div class="bg-indigo-50/30 p-6 rounded-2xl border border-indigo-100/50">
                    <div id="payment-options-container" class="space-y-3">
                        @php
                            $partialPayments = old('partial_payments', isset($room) ? ($room->partial_payments ?? []) : [50, 70, 100]);
                            if (empty($partialPayments)) $partialPayments = [50];
                        @endphp
                        @foreach($partialPayments as $index => $percent)
                            <div class="flex gap-3 items-center payment-option-item">
                                <div class="relative flex-1">
                                    <input type="number" name="partial_payments[]" value="{{ $percent }}"
                                        class="w-full pl-4 pr-12 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 font-black text-slate-700"
                                        placeholder="e.g. 50" min="1" max="100">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">%</span>
                                </div>
                                <button type="button" class="text-rose-500 hover:text-rose-700 bg-rose-50 p-2.5 rounded-xl remove-payment-option" {{ count($partialPayments) == 1 ? 'style=display:none;' : '' }}>
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-payment-option" class="mt-4 text-sm text-indigo-600 font-black hover:text-indigo-800 transition-colors flex items-center gap-2">
                        <i class="bi bi-plus-circle-fill"></i> Add Another Percentage Option
                    </button>
                    <p class="mt-4 text-[10px] text-slate-400 font-bold uppercase tracking-tighter">* These options will be shown to users in the booking modal.</p>
                </div>
            </div>

            <!-- 2. Primary Image -->
            <div class="card-premium p-8">
                <h4 class="text-sm uppercase tracking-widest font-black text-slate-400 mb-6">Primary Image</h4>
                <div>
                    <div class="relative group border-2 border-dashed border-slate-200 rounded-2xl p-4 bg-slate-50 hover:bg-white hover:border-indigo-300 transition-all cursor-pointer overflow-hidden"
                        style="min-height: 200px;">
                        <input type="file" name="image_file"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50"
                            data-image-preview="room-preview">
                        <div id="room-preview-container"
                            class="hidden absolute inset-0 w-full h-full bg-white z-40">
                            <img id="room-preview" src="" class="w-full h-full object-cover">
                            <div
                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="text-white font-bold text-xs bg-indigo-600 px-3 py-1 rounded-full">New
                                    Selection</span>
                            </div>
                        </div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <i class="bi bi-image text-4xl text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                            <p class="text-xs text-slate-500 mt-2 font-bold uppercase tracking-wider">Drag & drop or
                                click to upload</p>
                        </div>
                    </div>
                    @if(isset($room) && $room->image)
                        <div class="mt-4 flex items-center gap-4 p-3 bg-white border border-slate-100 rounded-xl shadow-sm">
                            <img src="{{ str_starts_with($room->image, 'http') ? $room->image : asset($room->image) }}"
                                class="h-16 w-24 object-cover rounded-lg shadow-sm border border-slate-100">
                            <div class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Currently Displayed</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 3. Gallery Images (Up to 4 recommended) -->
            <div class="card-premium p-8">
                <h4 class="text-sm uppercase tracking-widest font-black text-slate-400 mb-6">Gallery Images (Up to 4 recommended)</h4>
                
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 mb-4">
                    <input type="file" name="gallery_images[]" multiple accept="image/*"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="mt-2 text-xs text-slate-500">Hold CTRL to select multiple images. These will be added to the room gallery.</p>
                </div>

                @if(isset($room) && !empty($room->gallery_images))
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Manage Current Gallery Images</label>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($room->gallery_images as $index => $img)
                                <div class="relative bg-white border border-slate-200 rounded-xl p-2 shadow-sm text-center">
                                    <img src="{{ asset($img) }}" class="h-24 w-full object-cover rounded shadow-sm mb-2">
                                    <div class="flex items-center justify-center gap-2">
                                        <input type="checkbox" name="delete_gallery_images[]" id="del_img_{{ $index }}"
                                            value="{{ $img }}" class="w-4 h-4 text-red-600 rounded">
                                        <label for="del_img_{{ $index }}"
                                            class="text-xs font-bold text-slate-600 cursor-pointer mb-0">Delete</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-3">
                            <input type="checkbox" name="clear_gallery_images" id="clear_gallery_images" value="1"
                                class="w-4 h-4 text-red-600 rounded">
                            <label for="clear_gallery_images"
                                class="text-xs font-bold text-red-600 cursor-pointer mb-0">Delete ALL existing gallery images</label>
                        </div>
                    </div>
                @endif
            </div>

            <!-- 10. Room Description -->
            <div class="card-premium p-8 mb-8">
                <h4 class="text-sm uppercase tracking-widest font-black text-slate-400 mb-6">Room Description</h4>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Detailed Description</label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700">{{ old('description', $room->description ?? '') }}</textarea>
                </div>
            </div>

            <!-- 4. 360° Viewer -->
            <div class="card-premium p-8">
                <h4 class="text-sm uppercase tracking-widest font-black text-slate-400 mb-6">360° Viewer</h4>
                <div class="bg-indigo-50/50 p-5 rounded-2xl border border-indigo-100">
                    <div class="flex items-center gap-3 mb-4">
                        <input type="checkbox" name="is_360_available" id="is_360_available" value="1"
                            class="w-5 h-5 text-indigo-600 rounded" {{ old('is_360_available', $room->is_360_available ?? false) ? 'checked' : '' }}>
                        <label for="is_360_available" class="font-bold text-indigo-900 cursor-pointer mb-0">Enable 360° Viewer</label>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-indigo-800 mb-2">Panorama Image URL</label>
                        <input type="url" name="panorama_url"
                            value="{{ old('panorama_url', $room->panorama_url ?? '') }}"
                            class="w-full px-4 py-2.5 bg-white border border-indigo-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700"
                            placeholder="https://pannellum.org/images/alma.jpg">
                    </div>
                </div>
            </div>

            <!-- 5. Highlights & Badges -->
            <div class="card-premium p-8">
                <h4 class="text-sm uppercase tracking-widest font-black text-slate-400 mb-6">Highlights & Badges</h4>
                <div class="grid gap-4">
                    <div class="flex items-center gap-3 bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1"
                            class="w-5 h-5 text-indigo-600 rounded" {{ old('is_featured', $room->is_featured ?? false) ? 'checked' : '' }}>
                        <label for="is_featured" class="font-bold text-slate-700 cursor-pointer mb-0">Featured Room</label>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Badge Text</label>
                        <input type="text" name="badge_text"
                            value="{{ old('badge_text', $room->badge_text ?? '') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700"
                            placeholder="e.g. Top Pick">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Initial Rating (0-5)</label>
                        <input type="number" step="0.1" name="rating"
                            value="{{ old('rating', $room->rating ?? '0') }}"
                            class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl focus:ring-0 transition-all text-slate-500 cursor-not-allowed"
                            min="0" max="5" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Review Count</label>
                        <input type="number" name="review_count"
                            value="{{ old('review_count', $room->review_count ?? '0') }}"
                            class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl focus:ring-0 transition-all text-slate-500 cursor-not-allowed" readonly>
                    </div>
                </div>
            </div>

            <!-- 6. Room Rules (e.g. Check-in 12:00 PM) -->
            <div class="card-premium p-8">
                <h4 class="text-sm uppercase tracking-widest font-black text-slate-400 mb-6">Room Rules (e.g. Check-in 12:00 PM)</h4>
                @php
                    $rules = old('rules', isset($room) ? ($room->rules ?? []) : []);
                    if (empty($rules)) $rules = [''];
                @endphp
                <div id="rules-container" class="space-y-3 mb-4">
                    @foreach($rules as $index => $rule)
                        <div class="flex gap-2 items-center rule-item">
                            <input type="text" name="rules[]" value="{{ $rule }}"
                                class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 text-slate-700"
                                placeholder="e.g. Check-in: 12:00 PM">
                            <button type="button" class="text-red-500 hover:text-red-700 px-3 py-2 font-bold remove-rule" {{ count($rules) == 1 ? 'style=display:none;' : '' }}><i class="bi bi-trash"></i></button>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-rule"
                    class="text-sm text-indigo-600 font-bold hover:text-indigo-800"><i
                        class="bi bi-plus-circle me-1"></i> Add Another Rule</button>
            </div>

            <!-- 7. Dynamic Attributes & Capacity -->
            <div class="card-premium p-8">
                <h4 class="text-sm uppercase tracking-widest font-black text-slate-400 mb-6">Dynamic Attributes & Capacity</h4>
                
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div class="flex flex-col">
                        <label class="block text-xs font-black text-slate-800 uppercase tracking-wider mb-1">Max Adults</label>
                        <div class="flex items-center gap-3 bg-white p-2 rounded-xl border border-slate-200">
                            <div class="flex-1">
                                <div class="text-[10px] text-slate-400 font-bold leading-none mb-1">AGES 13+</div>
                                <select name="capacity_adults" class="w-full bg-transparent border-0 p-0 text-sm font-black text-slate-800 focus:ring-0">
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ old('capacity_adults', $room->capacity_adults ?? 2) == $i ? 'selected' : '' }}>{{ $i }} Adult{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <i class="bi bi-people-fill text-indigo-400 text-lg me-1"></i>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <label class="block text-xs font-black text-slate-800 uppercase tracking-wider mb-1">Max Children</label>
                        <div class="flex items-center gap-3 bg-white p-2 rounded-xl border border-slate-200">
                            <div class="flex-1">
                                <div class="text-[10px] text-slate-400 font-bold leading-none mb-1">AGES 2-12</div>
                                <select name="capacity_children" class="w-full bg-transparent border-0 p-0 text-sm font-black text-slate-800 focus:ring-0">
                                    @for($i = 0; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ old('capacity_children', $room->capacity_children ?? 0) == $i ? 'selected' : '' }}>{{ $i }} Child{{ $i > 1 ? 'ren' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <i class="bi bi-person-fill text-emerald-400 text-lg me-1"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-8 border-b border-slate-100 pb-8">
                    <div class="flex flex-col">
                        <label class="block text-xs font-black text-slate-800 uppercase tracking-wider mb-1">Max Infants</label>
                        <div class="flex items-center gap-3 bg-white p-2 rounded-xl border border-slate-200">
                            <div class="flex-1">
                                <div class="text-[10px] text-slate-400 font-bold leading-none mb-1">UNDER 2</div>
                                <select name="capacity_infants" class="w-full bg-transparent border-0 p-0 text-sm font-black text-slate-800 focus:ring-0">
                                    @for($i = 0; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ old('capacity_infants', $room->capacity_infants ?? 5) == $i ? 'selected' : '' }}>{{ $i }} Infant{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <i class="bi bi-egg-fill text-amber-400 text-lg me-1"></i>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <label class="block text-xs font-black text-slate-800 uppercase tracking-wider mb-1">Max Pets</label>
                        <div class="flex items-center gap-3 bg-white p-2 rounded-xl border border-slate-200">
                            <div class="flex-1">
                                <div class="text-[10px] text-slate-400 font-bold leading-none mb-1">SERVICE ALLOWED</div>
                                <select name="capacity_pets" class="w-full bg-transparent border-0 p-0 text-sm font-black text-slate-800 focus:ring-0">
                                    @for($i = 0; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('capacity_pets', $room->capacity_pets ?? 2) == $i ? 'selected' : '' }}>{{ $i }} Pet{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <svg class="text-rose-400 w-6 h-6 me-1" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.5 6.5C8.5 5.12 7.38 4 6 4S3.5 5.12 3.5 6.5C3.5 7.88 4.62 9 6 9S8.5 7.88 8.5 6.5M12 8C13.66 8 15 6.66 15 5S13.66 2 12 2S9 3.34 9 5C9 6.66 10.34 8 12 8M18 4C16.62 4 15.5 5.12 15.5 6.5C15.5 7.88 16.62 9 18 9S20.5 7.88 20.5 6.5C20.5 5.12 19.38 4 18 4M19.46 11.2C18.42 10.5 17.5 10 16 10H14V9.5C14 8.67 13.33 8 12.5 8H11.5C10.67 8 10 8.67 10 9.5V10H8C6.5 10 5.58 10.5 4.54 11.2C3.12 12.16 2.5 13.78 2.5 15.5V19C2.5 20.1 3.4 21 4.5 21H19.5C20.6 21 21.5 20.1 21.5 19V15.5C21.5 13.78 20.88 12.16 19.46 11.2Z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <p class="text-xs text-slate-500 mb-4 pt-2">Add other custom attributes like "Bed Type", "View", etc.</p>

                @php
                    $attributes = old('attributes', isset($room) ? ($room->attributes ?? []) : []);
                    if (empty($attributes)) {
                        $attributes = [
                            ['key' => 'Bed Type', 'value' => '1 King Bed'],
                            ['key' => 'Room Size', 'value' => '80 sqm / 860 sqft'],
                            ['key' => 'View', 'value' => 'Ocean View']
                        ];
                    }
                @endphp

                <div id="attributes-container" class="space-y-3 mb-4">
                    @foreach($attributes as $index => $attr)
                        <div class="flex gap-4 items-start attribute-item p-3 bg-slate-50 border border-slate-200 rounded-xl">
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-slate-500 mb-1">Attribute Name (e.g. Capacity)</label>
                                <input type="text" name="attributes[{{ $index }}][key]" value="{{ $attr['key'] ?? '' }}"
                                    class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700">
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-slate-500 mb-1">Value (e.g. 2 Adults)</label>
                                <input type="text" name="attributes[{{ $index }}][value]"
                                    value="{{ $attr['value'] ?? '' }}"
                                    class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700">
                            </div>
                            <button type="button" class="mt-6 text-red-500 hover:text-red-700 px-3 py-2 font-bold remove-attribute" {{ count($attributes) == 1 ? 'style=display:none;' : '' }}><i class="bi bi-trash"></i></button>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-attribute" class="text-sm text-indigo-600 font-bold hover:text-indigo-800"><i class="bi bi-plus-circle me-1"></i> Add Another Attribute</button>
            </div>

            <!-- 8. Amenities with Icons -->
            <div class="card-premium p-8">
                <h4 class="text-sm uppercase tracking-widest font-black text-slate-400 mb-6">Amenities with Icons</h4>
                @php
                    $amenities = old('amenities', isset($room) ? ($room->amenities ?? []) : []);
                    if (empty($amenities)) $amenities = [['icon' => 'bi-wifi', 'text' => 'Free Wi-Fi']];
                @endphp
                <div id="amenities-container" class="space-y-3 mb-4">
                    @foreach($amenities as $index => $amenity)
                        @php $currentIcon = is_array($amenity) ? ($amenity['icon'] ?? '') : 'bi-star'; @endphp
                        <div class="flex gap-4 items-center amenity-item p-3 bg-slate-50 border border-slate-200 rounded-xl">
                            <div class="w-1/3">
                                <label class="block text-xs font-bold text-slate-500 mb-1">Icon <a href="https://icons.getbootstrap.com/" target="_blank" class="text-indigo-500 hover:text-indigo-700">(Bootstrap)</a></label>
                                <select name="amenities[{{ $index }}][icon]" class="icon-select w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700" data-selected="{{ $currentIcon }}">
                                </select>
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-slate-500 mb-1">Amenity Name</label>
                                <input type="text" name="amenities[{{ $index }}][text]"
                                    value="{{ is_array($amenity) ? ($amenity['text'] ?? '') : $amenity }}"
                                    class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700"
                                    placeholder="e.g. Free Wi-Fi">
                            </div>
                            <button type="button" class="mt-5 text-red-500 hover:text-red-700 px-3 py-2 font-bold remove-amenity" {{ count($amenities) == 1 ? 'style=display:none;' : '' }}><i class="bi bi-trash"></i></button>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-amenity" class="text-sm text-indigo-600 font-bold hover:text-indigo-800"><i class="bi bi-plus-circle me-1"></i> Add Another Amenity</button>
            </div>

            <!-- 9. Frequently Asked Questions (FAQs) -->
            <div class="card-premium p-8">
                <h4 class="text-sm uppercase tracking-widest font-black text-slate-400 mb-6">Frequently Asked Questions (FAQs)</h4>
                @php
                    $faqs = old('faqs', isset($room) ? ($room->faqs ?? []) : []);
                    if (empty($faqs)) $faqs = [['question' => '', 'answer' => '']];
                @endphp
                <div id="faqs-container" class="space-y-4 mb-4">
                    @foreach($faqs as $index => $faq)
                        <div class="faq-item bg-slate-50 p-4 rounded-xl border border-slate-200 relative">
                            <button type="button" class="absolute top-4 right-4 text-red-500 hover:text-red-700 font-bold remove-faq" {{ count($faqs) == 1 ? 'style=display:none;' : '' }}><i class="bi bi-trash"></i></button>
                            <div class="grid grid-cols-1 gap-3 pr-8">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Question</label>
                                    <input type="text" name="faqs[{{ $index }}][question]" value="{{ $faq['question'] ?? '' }}"
                                        class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700"
                                        placeholder="e.g. Is breakfast included?">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Answer</label>
                                    <textarea name="faqs[{{ $index }}][answer]" rows="2"
                                        class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700"
                                        placeholder="e.g. Yes, free breakfast is included.">{{ $faq['answer'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-faq" class="text-sm text-indigo-600 font-bold hover:text-indigo-800"><i class="bi bi-plus-circle me-1"></i> Add Another FAQ</button>
            </div>

            <!-- Submit Section -->
            <div class="card-premium p-8 flex items-center justify-end gap-6 bg-slate-50">
                <a href="{{ route('admin.rooms.index') }}" class="text-slate-500 hover:text-slate-800 font-bold text-sm">Cancel Operation</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-12 rounded-2xl transition-all shadow-indigo-100 shadow-xl transform active:scale-95 flex items-center gap-2">
                    <i class="bi bi-cloud-check-fill"></i>
                    {{ isset($room) ? 'Update Room Details' : 'Create Room Listing' }}
                </button>
            </div>

        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Rules dynamic add/remove
            const rulesContainer = document.getElementById('rules-container');
            const addRuleBtn = document.getElementById('add-rule');
            if (addRuleBtn && rulesContainer) {
                addRuleBtn.addEventListener('click', () => {
                    const item = document.createElement('div');
                    item.className = 'flex gap-2 items-center rule-item';
                    item.innerHTML = `
                    <input type="text" name="rules[]" class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 text-slate-700" placeholder="e.g. Check-in: 12:00 PM">
                    <button type="button" class="text-red-500 hover:text-red-700 px-3 py-2 font-bold remove-rule"><i class="bi bi-trash"></i></button>
                    `;
                    rulesContainer.appendChild(item);
                    updateRemoveButtons(rulesContainer, '.remove-rule');
                });
                rulesContainer.addEventListener('click', (e) => {
                    if (e.target.closest('.remove-rule')) {
                        e.target.closest('.rule-item').remove();
                        updateRemoveButtons(rulesContainer, '.remove-rule');
                    }
                });
            }

            // FAQs dynamic add/remove
            const faqsContainer = document.getElementById('faqs-container');
            const addFaqBtn = document.getElementById('add-faq');
            if(faqsContainer && addFaqBtn) {
                let faqIndex = {{ isset($room) && is_array($room->faqs) ? count($room->faqs) : 1 }};
                addFaqBtn.addEventListener('click', () => {
                    const item = document.createElement('div');
                    item.className = 'faq-item bg-slate-50 p-4 rounded-xl border border-slate-200 relative';
                    item.innerHTML = `
                    <button type="button" class="absolute top-4 right-4 text-red-500 hover:text-red-700 font-bold remove-faq"><i class="bi bi-trash"></i></button>
                    <div class="grid grid-cols-1 gap-3 pr-8">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Question</label>
                            <input type="text" name="faqs[${faqIndex}][question]" class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700" placeholder="e.g. Is breakfast included?">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Answer</label>
                            <textarea name="faqs[${faqIndex}][answer]" rows="2" class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700" placeholder="e.g. Yes, free breakfast is included."></textarea>
                        </div>
                    </div>
                    `;
                    faqsContainer.appendChild(item);
                    faqIndex++;
                    updateRemoveButtons(faqsContainer, '.remove-faq');
                });
                faqsContainer.addEventListener('click', (e) => {
                    if (e.target.closest('.remove-faq')) {
                        e.target.closest('.faq-item').remove();
                        updateRemoveButtons(faqsContainer, '.remove-faq');
                    }
                });
            }

            // Amenities dynamic add/remove
            const amenitiesContainer = document.getElementById('amenities-container');
            const addAmenityBtn = document.getElementById('add-amenity');
            if(amenitiesContainer && addAmenityBtn) {
                let amenityIndex = {{ isset($room) && is_array($room->amenities) ? count($room->amenities) : 1 }};
                addAmenityBtn.addEventListener('click', () => {
                    const item = document.createElement('div');
                    item.className = 'flex gap-4 items-center amenity-item p-3 bg-slate-50 border border-slate-200 rounded-xl';
                    item.innerHTML = `
                    <div class="w-1/3">
                        <label class="block text-xs font-bold text-slate-500 mb-1">Icon</label>
                        <select name="amenities[${amenityIndex}][icon]" class="icon-select w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700" data-selected="bi-star">
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-slate-500 mb-1">Amenity Name</label>
                        <input type="text" name="amenities[${amenityIndex}][text]" class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700" placeholder="e.g. Free Wi-Fi">
                    </div>
                    <button type="button" class="mt-5 text-red-500 hover:text-red-700 px-3 py-2 font-bold remove-amenity"><i class="bi bi-trash"></i></button>
                    `;
                    amenitiesContainer.appendChild(item);
                    if (typeof window.initIconSelect === 'function') {
                        window.initIconSelect($(item).find('.icon-select')[0]);
                    }
                    amenityIndex++;
                    updateRemoveButtons(amenitiesContainer, '.remove-amenity');
                });
                amenitiesContainer.addEventListener('click', (e) => {
                    if (e.target.closest('.remove-amenity')) {
                        e.target.closest('.amenity-item').remove();
                        updateRemoveButtons(amenitiesContainer, '.remove-amenity');
                    }
                });
            }

            // Attributes dynamic add/remove
            const attributesContainer = document.getElementById('attributes-container');
            const addAttributeBtn = document.getElementById('add-attribute');
            if(attributesContainer && addAttributeBtn) {
                let attributeIndex = {{ isset($room) && is_array($room->attributes) ? count($room->attributes) : 4 }};
                addAttributeBtn.addEventListener('click', () => {
                    const item = document.createElement('div');
                    item.className = 'flex gap-4 items-start attribute-item p-3 bg-slate-50 border border-slate-200 rounded-xl';
                    item.innerHTML = `
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-slate-500 mb-1">Attribute Name</label>
                        <input type="text" name="attributes[${attributeIndex}][key]" class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-slate-500 mb-1">Value</label>
                        <input type="text" name="attributes[${attributeIndex}][value]" class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700">
                    </div>
                    <button type="button" class="mt-6 text-red-500 hover:text-red-700 px-3 py-2 font-bold remove-attribute"><i class="bi bi-trash"></i></button>
                    `;
                    attributesContainer.appendChild(item);
                    attributeIndex++;
                    updateRemoveButtons(attributesContainer, '.remove-attribute');
                });
                attributesContainer.addEventListener('click', (e) => {
                    if (e.target.closest('.remove-attribute')) {
                        e.target.closest('.attribute-item').remove();
                        updateRemoveButtons(attributesContainer, '.remove-attribute');
                    }
                });
            }

            function updateRemoveButtons(container, selector) {
                if(!container) return;
                const buttons = container.querySelectorAll(selector);
                buttons.forEach(btn => {
                    btn.style.display = buttons.length > 1 ? 'block' : 'none';
                });
            }

            // Payment Options dynamic add/remove
            const paymentOptionsContainer = document.getElementById('payment-options-container');
            const addPaymentOptionBtn = document.getElementById('add-payment-option');
            if (addPaymentOptionBtn && paymentOptionsContainer) {
                addPaymentOptionBtn.addEventListener('click', () => {
                    const items = paymentOptionsContainer.querySelectorAll('.payment-option-item');
                    if (items.length >= 3) {
                        alert('Maximum 3 payment options allowed.');
                        return;
                    }
                    const item = document.createElement('div');
                    item.className = 'flex gap-3 items-center payment-option-item';
                    item.innerHTML = `
                    <div class="relative flex-1">
                        <input type="number" name="partial_payments[]" class="w-full pl-4 pr-12 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 font-black text-slate-700" placeholder="e.g. 50" min="1" max="100">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">%</span>
                    </div>
                    <button type="button" class="text-rose-500 hover:text-rose-700 bg-rose-50 p-2.5 rounded-xl remove-payment-option"><i class="bi bi-trash-fill"></i></button>
                    `;
                    paymentOptionsContainer.appendChild(item);
                    updateRemoveButtons(paymentOptionsContainer, '.remove-payment-option');
                });
                paymentOptionsContainer.addEventListener('click', (e) => {
                    if (e.target.closest('.remove-payment-option')) {
                        e.target.closest('.payment-option-item').remove();
                        updateRemoveButtons(paymentOptionsContainer, '.remove-payment-option');
                    }
                });
            }
        });
    </script>
@endsection