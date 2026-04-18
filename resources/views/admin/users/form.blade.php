@extends('layouts.admin')

@section('header', $title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card-premium p-8">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.users.index') }}" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight">{{ $title }}</h3>
                <p class="text-sm text-slate-500">Manage visitor account details and credentials</p>
            </div>
        </div>

        @if($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-600 rounded-2xl">
            <ul class="list-disc list-inside text-sm font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ $action }}" method="POST">
            @csrf
            @if($method === 'PUT')
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Full Name</label>
                    <div class="relative">
                        <i class="bi bi-person absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border-slate-100 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm " style="padding-left: 40px;" 
                               placeholder="e.g. John Doe" required>
                    </div>
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Email Address</label>
                    <div class="relative">
                        <i class="bi bi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border-slate-100 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm" style="padding-left: 40px;" 
                               placeholder="name@example.com" required>
                    </div>
                </div>

                <!-- Phone -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Phone Number</label>
                    <div class="relative">
                        <i class="bi bi-telephone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border-slate-100 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm"  style="padding-left: 40px;" 
                               placeholder="+1 234 567 890">
                    </div>
                </div>

                <!-- Location -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Location</label>
                    <div class="relative">
                        <i class="bi bi-geo-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="location" value="{{ old('location', $user->location) }}" 
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border-slate-100 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm"  style="padding-left: 40px;" 
                               placeholder="City, Country">
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">
                        Password {{ $method === 'PUT' ? '(Leave blank to keep current)' : '' }}
                    </label>
                    <div class="relative">
                        <i class="bi bi-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="password" name="password" 
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border-slate-100 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm" style="padding-left: 40px;" 
                               placeholder="********" {{ $method === 'POST' ? 'required' : '' }}>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Confirm Password</label>
                    <div class="relative">
                        <i class="bi bi-lock-fill absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="password" name="password_confirmation" 
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border-slate-100 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm" style="padding-left: 40px;" 
                               placeholder="********" {{ $method === 'POST' ? 'required' : '' }}>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all text-decoration-none">
                    Cancel
                </a>
                <button type="submit" class="btn-premium px-8 py-3 rounded-xl text-sm font-bold text-gray shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all">
                    {{ $method === 'POST' ? 'Create User' : 'Save Changes' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
