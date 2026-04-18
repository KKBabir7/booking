@extends('layouts.admin')

@section('header', isset($review) ? __('Edit Review') : __('Create New Review'))

@section('content')
<div class="max-w-3xl mx-auto pb-24">
    <div class="card-premium p-8">
        <div class="mb-8">
            <h3 class="text-xl font-bold text-slate-800">{{ isset($review) ? 'Edit Review' : 'Create New Review' }}</h3>
            <p class="text-sm text-slate-500">Add or edit guest review details.</p>
        </div>

        <form action="{{ isset($review) ? route('admin.reviews.update', $review) : route('admin.reviews.store') }}" method="POST" class="space-y-8">
            @csrf
            @if(isset($review)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-b border-slate-100 pb-8">
                <div class="space-y-6">
                    <h4 class="text-sm uppercase tracking-widest font-black text-slate-400">Review Information</h4>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Room *</label>
                        <select name="room_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700 font-semibold" required>
                            <option value="">Select Room</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id', $review->room_id ?? request('room_id')) == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-3 bg-amber-50 p-4 rounded-xl border border-amber-200">
                        <input type="hidden" name="is_fake" value="0">
                        <input type="checkbox" name="is_fake" id="is_fake" value="1" onchange="toggleFakeFields()" class="w-5 h-5 text-amber-600 rounded" {{ old('is_fake', $review->is_fake ?? request('is_fake', false)) ? 'checked' : '' }}>
                        <label for="is_fake" class="font-bold text-amber-800 cursor-pointer mb-0">This is a Fake/Manual Review</label>
                    </div>

                    <div id="real_user_field" style="display: {{ old('is_fake', $review->is_fake ?? request('is_fake', false)) ? 'none' : 'block' }}">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Guest/User *</label>
                        <select name="user_id" id="user_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700 font-semibold">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $review->user_id ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="fake_user_fields" style="display: {{ old('is_fake', $review->is_fake ?? request('is_fake', false)) ? 'block' : 'none' }}" class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Fake Guest Name *</label>
                            <input type="text" name="fake_guest_name" id="fake_guest_name" value="{{ old('fake_guest_name', $review->fake_guest_name ?? '') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Fake Guest Email</label>
                            <input type="email" name="fake_guest_email" id="fake_guest_email" value="{{ old('fake_guest_email', $review->fake_guest_email ?? '') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700">
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <h4 class="text-sm uppercase tracking-widest font-black text-slate-400 mt-0">Detailed Ratings (1-5) *</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Cleanliness</label>
                            <input type="number" min="1" max="5" name="cleanliness_rating" value="{{ old('cleanliness_rating', $review->cleanliness_rating ?? '5') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Communication</label>
                            <input type="number" min="1" max="5" name="communication_rating" value="{{ old('communication_rating', $review->communication_rating ?? '5') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Check-in</label>
                            <input type="number" min="1" max="5" name="checkin_rating" value="{{ old('checkin_rating', $review->checkin_rating ?? '5') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Accuracy</label>
                            <input type="number" min="1" max="5" name="accuracy_rating" value="{{ old('accuracy_rating', $review->accuracy_rating ?? '5') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Location</label>
                            <input type="number" min="1" max="5" name="location_rating" value="{{ old('location_rating', $review->location_rating ?? '5') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Value</label>
                            <input type="number" min="1" max="5" name="value_rating" value="{{ old('value_rating', $review->value_rating ?? '5') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg" required>
                        </div>
                    </div>

                    <h4 class="text-sm uppercase tracking-widest font-black text-slate-400 mt-6">Review Content</h4>
                    
                    <div class="flex items-center gap-3 bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" class="w-5 h-5 text-indigo-600 rounded" {{ old('is_featured', $review->is_featured ?? false) ? 'checked' : '' }}>
                        <label for="is_featured" class="font-bold text-slate-700 cursor-pointer mb-0">Feature on Room Page</label>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Comment *</label>
                        <textarea name="comment" rows="4" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-slate-700" required>{{ old('comment', $review->comment ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-6">
                <a href="{{ route('admin.reviews.index') }}" class="text-slate-500 hover:text-slate-800 font-bold text-sm">Cancel</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-2xl transition-all shadow-indigo-100 shadow-xl transform active:scale-95 flex items-center gap-2">
                    <i class="bi bi-save-fill"></i>
                    {{ isset($review) ? 'Update Review' : 'Save Review' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleFakeFields() {
        const isFake = document.getElementById('is_fake').checked;
        const realField = document.getElementById('real_user_field');
        const fakeFields = document.getElementById('fake_user_fields');
        const userIdInput = document.getElementById('user_id');
        const fakeNameInput = document.getElementById('fake_guest_name');

        if (isFake) {
            realField.style.display = 'none';
            fakeFields.style.display = 'block';
            userIdInput.removeAttribute('required');
            fakeNameInput.setAttribute('required', 'required');
        } else {
            realField.style.display = 'block';
            fakeFields.style.display = 'none';
            userIdInput.setAttribute('required', 'required');
            fakeNameInput.removeAttribute('required');
        }
    }
    document.addEventListener('DOMContentLoaded', toggleFakeFields);
</script>
@endpush
