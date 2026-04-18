@extends('layouts.admin')

@section('header', 'Admin User Management')

@section('content')
<div class="card-premium p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800 tracking-tight">Company Members</h3>
            <p class="text-sm text-slate-500">Manage administrative roles and permissions</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.admin-user.create') }}" class="btn-premium px-6 py-3 rounded-xl flex items-center gap-2 text-sm font-bold text-gray shadow-lg">
                <i class="bi bi-person-plus-fill"></i>
                Add Member
            </a>
        </div>
    </div>



    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 border-y border-slate-100">
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Member</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Role</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Joined</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($admins as $admin)
                <tr class="hover:bg-slate-50/30 transition-colors duration-200">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shadow-sm" 
                                 style="background: {{ $admin->role === 'super_admin' ? 'linear-gradient(135deg, #4f46e5, #7c3aed)' : 'linear-gradient(135deg, #6366f1, #818cf8)' }}; color: white">
                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-bold text-slate-800">{{ $admin->name }}</div>
                                <div class="text-xs text-slate-500">{{ $admin->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @php
                            $roleClasses = [
                                'super_admin' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                'admin' => 'bg-blue-50 text-blue-600 border-blue-100',
                                'manager' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'editor' => 'bg-amber-50 text-amber-600 border-amber-100',
                                'staff' => 'bg-slate-100 text-slate-500 border-slate-200'
                            ];
                            $roleLabel = [
                                'super_admin' => 'Super Admin',
                                'admin' => 'Admin',
                                'manager' => 'Manager',
                                'editor' => 'Editor',
                                'staff' => 'Staff'
                            ];
                        @endphp
                        <span class="px-3 py-1 text-[10px] font-black rounded-full uppercase tracking-tighter border {{ $roleClasses[$admin->role] ?? 'bg-slate-100 text-slate-500' }}">
                            {{ $roleLabel[$admin->role] ?? $admin->role }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center text-sm text-slate-500 font-medium">
                        {{ $admin->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.admin-user.edit', $admin) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Edit Permissions">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </a>
                            
                            @if($admin->id !== auth()->id() && $admin->email !== 'admin@example.com')
                            <form action="{{ route('admin.admin-user.destroy', $admin) }}" method="POST" class="inline" onsubmit="return confirm('Permanently remove {{ $admin->name }} from organization?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Remove Member">
                                    <i class="bi bi-trash3-fill fs-5"></i>
                                </button>
                            </form>
                            @else
                            <span class="text-[11px] font-bold text-slate-300 italic tracking-tight p-2">Protected</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $admins->links() }}
    </div>
</div>
@endsection
