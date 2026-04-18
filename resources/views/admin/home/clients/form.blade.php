@extends('layouts.admin')

@section('header', isset($client) ? 'Edit Client' : 'Add New Client')

@section('content')
<div class="card-premium p-8 max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-8 border-b border-slate-100 pb-5">
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ isset($client) ? 'Edit Client Details' : 'Register New Client' }}</h3>
            <p class="text-sm text-slate-500 mt-1">Logo will be displayed in the home page marquee</p>
        </div>
        <a href="{{ route('admin.home_clients.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
            <i class="bi bi-x-lg text-xl"></i>
        </a>
    </div>

    <form action="{{ isset($client) ? route('admin.home_clients.update', $client->id) : route('admin.home_clients.store') }}" 
          method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($client))
            @method('PUT')
        @endif

        <div class="space-y-2">
            <label class="block text-sm font-bold text-slate-700">Client Name <span class="text-rose-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $client->name ?? '') }}" 
                   class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm"
                   placeholder="e.g. ActionAid Bangladesh" required>
            @error('name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-bold text-slate-700">Client Website / Link</label>
            <input type="url" name="link" value="{{ old('link', $client->link ?? '') }}" 
                   class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm"
                   placeholder="https://example.com">
            @error('link') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-4 pt-2">
            <label class="block text-sm font-bold text-slate-700">Client Logo <span class="text-rose-500">*</span></label>
            <div class="flex flex-col md:flex-row items-center gap-6 p-6 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                <div class="w-32 h-32 rounded-xl overflow-hidden border border-slate-200 bg-white p-4 flex-shrink-0 flex items-center justify-center shadow-inner">
                    <img id="logo-preview" 
                         src="{{ isset($client) ? asset($client->logo) : asset('assets/img/placeholder-logo.png') }}" 
                         class="max-w-full max-h-full object-contain">
                </div>
                <div class="flex-grow">
                    <p class="text-xs text-slate-500 mb-3">Transparent PNG or SVG recommended. Max size 2MB.</p>
                    <input type="file" name="logo" id="logo-input" accept="image/*" 
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition cursor-pointer"
                           {{ isset($client) ? '' : 'required' }}>
                </div>
            </div>
            @error('logo') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-slate-100 mt-8">
            <a href="{{ route('admin.home_clients.index') }}" class="px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg hover:shadow-xl flex items-center gap-2">
                <i class="bi bi-save"></i> {{ isset($client) ? 'Update Client' : 'Add Client' }}
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('logo-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('logo-preview').setAttribute('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
