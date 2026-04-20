@extends('layouts.admin')

@section('header', 'Room Exclusives Settings')

@section('content')
<div class="card-premium p-8 mb-8 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Room Exclusives Page Settings</h3>
            <p class="text-sm text-slate-500">Customize the banner and content for the Room Exclusives page.</p>
        </div>
    </div>

    <form action="{{ route('admin.page.update', 'room_exclusives') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Banner Title</label>
            <input type="text" name="banner_title" value="{{ $settings['banner_title'] ?? 'Exclusive Room Features' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-300">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Banner Subtitle</label>
            <input type="text" name="banner_subtitle" value="{{ $settings['banner_subtitle'] ?? 'Discover the unique features of our premium rooms.' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-300">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Banner Image</label>
            <div class="relative group">
                <div class="w-full h-48 rounded-xl overflow-hidden border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center relative cursor-pointer" onclick="this.nextElementSibling.click()">
                    @if(isset($settings['banner_image']))
                        <img id="previewImg" src="{{ asset($settings['banner_image']) }}" class="w-full h-full object-cover">
                    @else
                        <div id="previewPlaceholder" class="text-slate-400 flex flex-col items-center gap-2">
                            <i class="bi bi-cloud-arrow-up text-3xl"></i>
                            <span class="text-xs font-semibold">Click to upload</span>
                        </div>
                        <img id="previewImg" src="#" class="w-full h-full object-cover hidden">
                    @endif
                </div>
                <input type="file" name="banner_image_file" class="hidden" onchange="previewImage(this)">
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-md flex items-center gap-2">
                <i class="bi bi-floppy2-fill"></i> Save Settings
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('previewImg');
            const placeholder = document.getElementById('previewPlaceholder');
            img.src = e.target.result;
            img.classList.remove('hidden');
            if(placeholder) placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
