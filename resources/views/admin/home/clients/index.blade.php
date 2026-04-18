@extends('layouts.admin')

@section('header', 'Honorable Clients')

@section('content')
<div class="card-premium p-8">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 border-b border-slate-100 pb-5">
        <div>
            <h3 class="text-2xl font-bold text-slate-800">Manage Clients</h3>
            <p class="text-sm text-slate-500 mt-1">Add or remove client logos for the home page marquee</p>
        </div>
        <a href="{{ route('admin.home_clients.create') }}" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg hover:shadow-xl flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Add New Client
        </a>
    </div>



    <div class="overflow-x-auto rounded-xl border border-slate-200">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Logo</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Name</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Link</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($clients as $client)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="w-16 h-16 rounded-lg overflow-hidden border border-slate-200 bg-white p-2">
                            <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}" class="w-full h-full object-contain">
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-slate-700">{{ $client->name }}</td>
                    <td class="px-6 py-4 text-slate-500 text-sm">
                        @if($client->link)
                            <a href="{{ $client->link }}" target="_blank" class="text-indigo-600 hover:underline">{{ $client->link }}</a>
                        @else
                            <span class="italic opacity-50">No link</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.home_clients.edit', $client->id) }}" class="w-10 h-10 flex items-center justify-center rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors shadow-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" 
                                    onclick="if(confirm('Are you sure you want to delete this client?')) document.getElementById('delete-client-{{$client->id}}').submit();"
                                    class="w-10 h-10 flex items-center justify-center rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors shadow-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                            <form id="delete-client-{{$client->id}}" action="{{ route('admin.home_clients.destroy', $client->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center opacity-40">
                            <i class="bi bi-person-badge-fill text-5xl mb-3"></i>
                            <p class="text-lg font-medium">No clients found</p>
                            <a href="{{ route('admin.home_clients.create') }}" class="mt-4 text-indigo-600 font-bold hover:underline">Add your first client</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
