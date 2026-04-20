@extends('layouts.admin')

@section('header', 'User Management')

@section('content')
<div class="card-premium p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800 tracking-tight">User</h3>
            <p class="text-sm text-slate-500">Manage guest accounts and site visitors</p>
        </div>
        <div class="flex gap-3">
            <form action="{{ route('admin.users.index') }}" method="GET" class="relative group">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Search users..." 
                    class="pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all w-64">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
            </form>
            <a href="{{ route('admin.users.create') }}" class="btn-premium px-4 py-2 text-sm flex items-center gap-2">
                <i class="bi bi-person-plus-fill"></i> Add New User
            </a>
        </div>
    </div>



    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">User</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Contact Info</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Location</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Joined</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($users as $user)
                <tr class="group hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-50 to-slate-100 flex items-center justify-center text-indigo-600 font-bold border border-indigo-100">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-800">{{ $user->name }}</div>
                                <div class="text-[11px] text-slate-400 font-medium">ID: #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex flex-col gap-1">
                            <div class="text-sm text-slate-600 flex items-center gap-2">
                                <i class="bi bi-envelope text-slate-300"></i> {{ $user->email }}
                            </div>
                            @if($user->phone)
                            <div class="text-xs text-slate-400 flex items-center gap-2">
                                <i class="bi bi-telephone text-slate-300"></i> {{ $user->phone }}
                            </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="text-sm text-slate-600">
                            @if($user->location)
                                <i class="bi bi-geo-alt text-slate-300 mr-1"></i> {{ $user->location }}
                            @else
                                <span class="text-slate-300 italic">Not set</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[11px] font-bold rounded-full uppercase tracking-tighter text-nowrap">Registered</span>
                    </td>
                    <td class="px-6 py-5 text-center text-sm text-slate-500 font-medium">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.users.show', $user) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="View Details">
                                <i class="bi bi-eye-fill fs-5"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Edit User">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </a>
                            @if(auth()->user()->isSuperAdmin())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete user {{ $user->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Delete User">
                                        <i class="bi bi-trash-fill fs-5"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 text-2xl">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="text-slate-400 font-medium">No users found match your criteria.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $users->appends(request()->query())->links() }}
    </div>
</div>
@endsection
