@extends('layouts.admin')

@section('header', 'Roles & Permissions')

@section('content')
<div class="card-premium p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800 tracking-tight">System Roles</h3>
            <p class="text-sm text-slate-500">Define access levels for your administrative staff</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="btn-premium px-6 py-2.5 text-sm flex items-center gap-2">
            <i class="bi bi-shield-plus"></i> Create New Role
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-separate border-spacing-y-2">
            <thead>
                <tr class="text-slate-400">
                    <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest">Role Name</th>
                    <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest">Slug</th>
                    <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-center">Permissions Count</th>
                    <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="space-y-4">
                @foreach($roles as $role)
                <tr class="bg-white border border-slate-100 rounded-2xl group hover:shadow-lg hover:border-indigo-100 transition-all duration-300">
                    <td class="px-6 py-5 rounded-l-2xl border-y border-l border-slate-100 group-hover:border-indigo-100">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                                <i class="bi bi-shield-lock-fill"></i>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800">{{ $role->name }}</div>
                                @if($role->slug === 'super_admin')
                                    <span class="text-[10px] bg-indigo-600 text-white px-2 py-0.5 rounded-full uppercase font-black tracking-tighter">System Master</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 border-y border-slate-100 group-hover:border-indigo-100 text-sm font-mono text-slate-400">
                        {{ $role->slug }}
                    </td>
                    <td class="px-6 py-5 border-y border-slate-100 group-hover:border-indigo-100 text-center">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-50 text-slate-600 rounded-lg border border-slate-100">
                            <span class="font-black">{{ $role->permissions_count }}</span>
                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-tight">Abilities</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 rounded-r-2xl border-y border-r border-slate-100 group-hover:border-indigo-100 text-right">
                        @if($role->slug !== 'super_admin')
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Edit Role">
                                    <i class="bi bi-pencil-square fs-5"></i>
                                </a>
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('Note: Deleting a role will revoke all its permissions. Confirm?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Delete Role">
                                        <i class="bi bi-trash-fill fs-5"></i>
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="text-xs font-bold text-slate-300 italic px-4">Protected System Role</div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $roles->links() }}
    </div>
</div>
@endsection
