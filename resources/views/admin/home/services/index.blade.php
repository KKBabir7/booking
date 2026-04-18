@extends('layouts.admin')

@section('header', 'Manage Premium Services')

@section('content')
<div class="card-premium p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Premium Services</h3>
            <p class="text-sm text-slate-500">Manage the hospitality and facility services shown on the home page</p>
        </div>
        <a href="{{ route('admin.home_services.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Add New Service
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-y border-slate-100">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Image / Icon</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($services as $service)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            @if($service->image)
                            <div class="w-20 h-14 rounded-lg overflow-hidden border border-slate-200 shadow-sm">
                                <img src="{{ asset($service->image) }}" class="w-full h-full object-cover">
                            </div>
                            @endif
                            @if($service->icon)
                            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-500">
                                <i class="bi {{ $service->icon }} text-xl"></i>
                            </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-slate-700">{{ $service->title }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-xs text-slate-400 max-w-xs break-words">
                            {{ \Illuminate\Support\Str::limit($service->description, 100) }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-3 text-sm">
                            <a href="{{ route('admin.home_services.edit', $service->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.home_services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Delete this service?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition">
                                    <i class="bi bi-trash3"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                        <i class="bi bi-inbox text-4xl mb-3 block"></i>
                        No services found. Click "Add New Service" to get started.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
