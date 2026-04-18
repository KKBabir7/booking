@extends('layouts.admin')

@section('header', 'Edit Offer Banner')

@section('content')
<div class="card-premium p-8 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8 border-b border-slate-100 pb-5">
        <div>
            <h3 class="text-2xl font-bold text-slate-800">Edit Offer Banner</h3>
            <p class="text-sm text-slate-500 mt-1">Update grid image or link</p>
        </div>
        <a href="{{ route('admin.home_promo_banners.index') }}" class="text-slate-500 hover:text-indigo-600 font-medium transition flex items-center gap-2 bg-slate-50 hover:bg-indigo-50 px-4 py-2 rounded-lg">
            <i class="bi bi-arrow-left"></i> Back to Banners
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg mb-6">
            <div class="flex items-center mb-2">
                <i class="bi bi-exclamation-circle text-rose-500 text-lg mr-2"></i>
                <h3 class="text-rose-800 font-bold">Please fix the following errors:</h3>
            </div>
            <ul class="list-disc list-inside text-sm text-rose-700 ml-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.home_offer_banners.update', $offerBanner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column: Image Upload -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Banner Image <span class="text-slate-400 font-normal">(Leave blank to keep current)</span></label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-solid border-2 border-indigo-200 rounded-xl hover:bg-slate-50 transition relative overflow-hidden group min-h-[250px]" id="dropZone">
                        <div class="space-y-2 text-center relative z-10 hidden" id="uploadPrompt">
                            <i class="bi bi-cloud-arrow-up text-4xl text-indigo-400 group-hover:text-indigo-500 transition"></i>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 px-2 py-1">
                                    <span>Upload a new file</span>
                                    <input id="file-upload" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(event)">
                                </label>
                            </div>
                            <p class="text-xs text-slate-500">PNG, JPG, WEBP up to 2MB</p>
                        </div>
                        <img id="imagePreview" src="{{ asset($offerBanner->image) }}" class="absolute inset-0 w-full h-full object-cover rounded-xl z-20" />
                        <button type="button" id="removeImageBtn" class="absolute top-2 right-2 bg-rose-500 text-white rounded-full w-8 h-8 flex items-center justify-center z-30 hover:bg-rose-600 shadow-md" onclick="removeImage()">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings -->
            <div class="space-y-6 bg-slate-50/50 p-6 rounded-xl border border-slate-100">
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Target Link URL <span class="text-slate-400 font-normal">(Optional)</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-link text-slate-400"></i>
                        </div>
                        <input type="text" name="link" value="{{ old('link', $offerBanner->link) }}" class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm" placeholder="e.g. /rooms/executive-suite">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-200">
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="is_active" class="sr-only" {{ $offerBanner->is_active ? 'checked' : '' }}>
                            <div class="block bg-slate-300 w-12 h-7 rounded-full transition-colors duration-300 group-hover:bg-slate-400 toggle-bg"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-5 h-5 rounded-full transition-transform duration-300 shadow-sm"></div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-bold text-slate-800">Active Status</div>
                            <p class="text-xs text-slate-500">Banner will be visible on the home page</p>
                        </div>
                    </label>
                </div>

            </div>
        </div>

        <div class="flex justify-end pt-6 border-t border-slate-100 gap-4">
            <a href="{{ route('admin.home_promo_banners.index') }}" class="px-6 py-2.5 bg-white border border-slate-300 text-slate-700 font-bold rounded-lg hover:bg-slate-50 transition shadow-sm">Cancel</a>
            <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition shadow-md hover:shadow-lg flex items-center gap-2">
                <i class="bi bi-save"></i> Save Changes
            </button>
        </div>
    </form>
</div>

<style>
    /* Custom Toggle Switch Styles */
    input:checked ~ .dot {
        transform: translateX(100%);
    }
    input:checked ~ .toggle-bg {
        background-color: #4f46e5; /* indigo-600 */
    }
</style>

<script>
    function previewImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                const dropZone = document.getElementById('dropZone');
                const uploadPrompt = document.getElementById('uploadPrompt');
                const removeBtn = document.getElementById('removeImageBtn');
                
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                uploadPrompt.classList.add('hidden');
                removeBtn.innerHTML = '<i class="bi bi-x-lg"></i>';
                removeBtn.onclick = removeImage;
                dropZone.classList.remove('border-dashed', 'border-slate-300', 'p-6');
                dropZone.classList.add('border-solid', 'border-indigo-200');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        const input = document.getElementById('file-upload');
        const preview = document.getElementById('imagePreview');
        const dropZone = document.getElementById('dropZone');
        const uploadPrompt = document.getElementById('uploadPrompt');
        const removeBtn = document.getElementById('removeImageBtn');
        
        input.value = '';
        preview.classList.add('hidden');
        uploadPrompt.classList.remove('hidden');
        removeBtn.classList.add('hidden');
        dropZone.classList.add('border-dashed', 'border-slate-300', 'p-6');
        dropZone.classList.remove('border-solid', 'border-indigo-200');
    }
</script>
@endsection
