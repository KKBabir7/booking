@extends('layouts.admin')

@section('header', 'Restaurant Management')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h3 class="text-2xl font-black text-slate-800 tracking-tight">Restaurant Locations</h3>
        <p class="text-sm text-slate-500">Manage outlets and their fixed advance payment requirements.</p>
    </div>
    <a href="{{ route('admin.restaurants.create') }}" class="px-6 py-3 bg-indigo-600 text-white text-sm font-black rounded-2xl hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition-all flex items-center gap-2">
        <i class="bi bi-plus-lg"></i> Add New Restaurant
    </a>
</div>

<div class="card-premium overflow-hidden">
    <div class="overflow-x-auto">
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
@endsection
