@extends('layouts.admin')

@section('header', 'Manage Navbar Items')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Logo Management -->
        <div class="lg:col-span-1">
            <div class="card-premium p-6 h-full">
                <h3 class="text-xl font-bold text-slate-800 mb-2">Navbar Logo</h3>
                <p class="text-sm text-slate-500 mb-6">Update the logo displayed in the main navigation</p>

                @php
                    $logo = \App\Models\PageSetting::where('page', 'navbar')->where('key', 'navbar_logo')->first();
                @endphp

                <div class="flex flex-col items-center">
                    <div
                        class="w-full h-40 rounded-xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden mb-6 group relative">
                        @if($logo && $logo->value)
                            <img src="{{ asset($logo->value) }}"
                                class="max-h-32 object-contain group-hover:opacity-50 transition">
                        @else
                            <img src="{{ asset('assets/img/logo/logo-2.png') }}"
                                class="max-h-32 object-contain group-hover:opacity-50 transition">
                        @endif
                        <div
                            class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <i class="bi bi-camera text-3xl text-slate-600"></i>
                        </div>
                    </div>

                    <form action="{{ route('admin.navbar.update-logo') }}" method="POST" enctype="multipart/form-data"
                        class="w-full">
                        @csrf
                        <div class="mb-4">
                            <input type="file" name="navbar_logo"
                                class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition"
                                required>
                        </div>
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 rounded-lg transition shadow-md">
                            Update Logo
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Stats or Info (Optional) -->
        <div class="lg:col-span-2">
            <div class="card-premium p-6 h-full flex flex-col justify-center bg-slate-50 border border-slate-100">
                <h3 class="text-2xl font-black text-slate-800 mb-4 tracking-tight">Navigation Settings</h3>
                <p class="text-slate-500 mb-8 leading-relaxed font-medium">
                    Management of your website's navigation structure and branding. Changes to links and the logo are
                    reflected instantly across all pages.
                </p>
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                        <div class="text-3xl font-black text-slate-800 mb-1 tracking-tighter">{{ $items->count() }}</div>
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Links</div>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                        <div class="text-3xl font-black text-slate-800 mb-1 tracking-tighter">
                            {{ $items->where('is_active', true)->count() }}</div>
                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Active Links</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-premium p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="text-xl font-bold text-slate-800">Navbar Links</h3>
                <p class="text-sm text-slate-500">Manage the main navigation menu of your website</p>
            </div>
            <a href="{{ route('admin.navbar.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                <i class="bi bi-plus-lg"></i> Add New Link
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-y border-slate-100">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Label</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">URL</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Order
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Position
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($items as $item)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($item->icon)
                                        <div class="w-8 h-8 bg-slate-100 rounded flex items-center justify-center text-slate-500">
                                            <i class="bi {{ $item->icon }}"></i>
                                        </div>
                                    @endif
                                    <span class="font-semibold text-slate-700">{{ $item->label }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-mono text-sm">{{ $item->url }}</td>
                            <td class="px-6 py-4 text-center text-slate-600">{{ $item->order_column }}</td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="px-3 py-1 text-xs font-medium rounded-full {{ $item->position == 'top' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ ucfirst($item->position) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="px-3 py-1 text-xs font-bold rounded-full {{ $item->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $item->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-3 text-sm">
                                    <a href="{{ route('admin.navbar.edit', $item->id) }}"
                                        class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Edit">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.navbar.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this link?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                            title="Delete">
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
@endsection