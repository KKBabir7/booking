@extends('layouts.admin')

@section('header', 'Manage Promo Banners')

@section('content')
<div class="card-premium p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Promo Banners</h3>
            <p class="text-sm text-slate-500">Manage promotional offer sections</p>
        </div>
        <a href="{{ route('admin.home_promo_banners.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Add New Promo
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-y border-slate-100">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Preview</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Details</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Badge</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($banners as $banner)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="w-[300px] h-[200px] rounded-xl overflow-hidden border border-slate-200 shadow-md relative group">
                            <img src="{{ asset($banner->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-slate-700">{{ $banner->title }}</div>
                        <div class="text-xs text-indigo-600 font-bold mt-0.5">{{ $banner->discount_text }}</div>
                        <div class="text-xs text-slate-400 mt-1">{{ \Illuminate\Support\Str::limit($banner->subtitle, 40) }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 text-xs font-bold rounded-lg border border-slate-200 text-slate-600 bg-slate-50">
                            {{ $banner->badge_text }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 text-xs font-bold rounded-full {{ $banner->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $banner->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-3 text-sm">
                            <a href="{{ route('admin.home_promo_banners.edit', $banner->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.home_promo_banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Delete this banner?')">
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
</div>

<div class="card-premium p-8 mt-8 border-t-[8px] border-indigo-500 rounded-t-none">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Offer Banners (Grid)</h3>
            <p class="text-sm text-slate-500">Manage the two smaller grid banners on the home page</p>
        </div>
        <a href="{{ route('admin.home_offer_banners.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Add New Offer Banner
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-y border-slate-100">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Preview</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Link</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($offerBanners as $obanner)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="w-[200px] h-[150px] rounded-xl overflow-hidden border border-slate-200 shadow-md relative group bg-gray-100 flex items-center justify-center">
                            @if($obanner->image)
                                <img src="{{ asset($obanner->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <span class="text-gray-400 text-sm">No Image</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-indigo-600 font-medium">
                            @if($obanner->link)
                                <a href="{{ url($obanner->link) }}" target="_blank" class="hover:underline flex items-center gap-1"><i class="bi bi-link-45deg"></i> {{ $obanner->link }}</a>
                            @else
                                <span class="text-gray-400 italic">No link specified</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 text-xs font-bold rounded-full {{ $obanner->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $obanner->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-3 text-sm">
                            <form action="{{ route('admin.home_offer_banners.destroy', $obanner->id) }}" method="POST" onsubmit="return confirm('Delete this offer banner?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition">
                                    <i class="bi bi-trash3"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($offerBanners->isEmpty())
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-slate-500 bg-slate-50/50">
                        <i class="bi bi-images text-3xl block mb-2 text-slate-400"></i>
                        No offer banners added yet. <a href="{{ route('admin.home_offer_banners.create') }}" class="text-indigo-600 font-semibold hover:underline">Add one now</a>.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
