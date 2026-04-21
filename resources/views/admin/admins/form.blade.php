@extends('layouts.admin')

@section('header', isset($admin) ? 'Edit Admin Member' : 'Add New Admin Member')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card-premium p-8">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.admin-user.index') }}" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ isset($admin) ? 'Update Member' : 'Create Member' }}</h3>
                <p class="text-sm text-slate-500">Configure access level and identity</p>
            </div>
        </div>

        <form action="{{ isset($admin) ? route('admin.admin-user.update', $admin) : route('admin.admin-user.store') }}" method="POST">
            @csrf
            @if(isset($admin))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Full Name</label>
                    <div class="relative">
                        <i class="bi bi-person absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="name" value="{{ old('name', $admin->name ?? '') }}" 
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border-slate-100 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all" style="padding-left: 40px;" 
                               placeholder="e.g. John Doe" required>
                    </div>
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Email Address</label>
                    <div class="relative">
                        <i class="bi bi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="email" name="email" value="{{ old('email', $admin->email ?? '') }}" 
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border-slate-100 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all" style="padding-left: 40px;" 
                               placeholder="name@example.com" required>
                    </div>
                </div>

                <!-- Role -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Assigned Role</label>
                    <div class="relative">
                        <i class="bi bi-shield-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <select name="role_id" class="w-full pl-11 pr-4 py-3 bg-slate-50 border-slate-100 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all appearance-none" style="padding-left: 37px;" required>
                            <option value="">Select a Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" 
                                    {{ (old('role_id', $userRoleId ?? '') == $role->id) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Password (Optional for Edit) -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">
                        Password {{ isset($admin) ? '(Leave blank to keep current)' : '' }}
                    </label>
                    <div class="relative">
                        <i class="bi bi-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="password" name="password" 
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border-slate-100 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all" style="padding-left: 40px;"
                               placeholder="********" {{ isset($admin) ? '' : 'required' }}>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Confirm Password</label>
                    <div class="relative">
                        <i class="bi bi-lock-fill absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="password" name="password_confirmation" 
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border-slate-100 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all"  style="padding-left: 40px;"
                               placeholder="********" {{ isset($admin) ? '' : 'required' }}>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('admin.admin-user.index') }}" class="px-6 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all">
                    Cancel
                </a>
                <button type="submit" class="btn-premium px-8 py-3 rounded-xl text-sm font-bold text-gray shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all">
                    {{ isset($admin) ? 'Save Changes' : 'Create Member' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
