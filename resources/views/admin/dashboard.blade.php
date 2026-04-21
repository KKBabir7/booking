@extends('layouts.admin')

@section('header', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Bookings -->
        @if(auth()->user()->hasPermission('view_bookings'))
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 group hover:shadow-md transition-all duration-300">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 border border-indigo-100 shadow-sm">
                        <i class="bi bi-calendar-check-fill text-xl"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-indigo-400 bg-indigo-50/50 px-3 py-1.5 rounded-full">All Time</span>
                </div>
                <div class="space-y-1">
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Total Bookings</p>
                    <h3 class="text-4xl font-black text-slate-800 tracking-tight">{{ $stats['bookings_count'] }}</h3>
                </div>
            </div>
        </div>
        
        <!-- Pending Requests -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 group hover:shadow-md transition-all duration-300">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 border border-amber-100 shadow-sm">
                        <i class="bi bi-hourglass-split text-xl"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-amber-400 bg-amber-50/50 px-3 py-1.5 rounded-full">Action Needed</span>
                </div>
                <div class="space-y-1">
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Pending Requests</p>
                    <h3 class="text-4xl font-black text-slate-800 tracking-tight">{{ $stats['pending_bookings'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 group hover:shadow-md transition-all duration-300">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 border border-emerald-100 shadow-sm">
                        <i class="bi bi-currency-dollar text-xl"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-emerald-400 bg-emerald-50/50 px-3 py-1.5 rounded-full">Net Growth</span>
                </div>
                <div class="space-y-1">
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Total Revenue</p>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tight">
                        <span class="text-lg font-bold text-slate-400 mr-1">TK</span>{{ number_format($stats['revenue']) }}
                    </h3>
                </div>
            </div>
        </div>
        @endif

        <!-- Total Users -->
        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('view_users'))
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 group hover:shadow-md transition-all duration-300">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-600 border border-slate-100 shadow-sm">
                        <i class="bi bi-people-fill text-xl"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 bg-slate-50/50 px-3 py-1.5 rounded-full">Community</span>
                </div>
                <div class="space-y-1">
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Total Users</p>
                    <h3 class="text-4xl font-black text-slate-800 tracking-tight">{{ $stats['users_count'] }}</h3>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Bookings -->
        @if(auth()->user()->hasPermission('view_bookings'))
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 pb-4 flex justify-between items-center">
                <h3 class="text-xl font-black text-slate-800 tracking-tight">Recent Bookings</h3>
                <a href="{{ route('admin.bookings.index') }}" class="text-xs font-black uppercase tracking-widest text-indigo-500 hover:text-indigo-600 transition">View All Bookings &rarr;</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 bg-slate-50/30">
                            <th class="px-8 py-4">Guest</th>
                            <th class="px-8 py-4">Status</th>
                            <th class="px-8 py-4 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentBookings as $booking)
                        <tr class="hover:bg-slate-50/50 transition duration-200">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center font-bold border border-slate-50">
                                        {{ substr($booking->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-700">{{ $booking->user->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-medium">{{ $booking->title }} ({{ $booking->type }})</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'confirmed' => 'bg-emerald-100 text-emerald-700',
                                        'cancelled' => 'bg-rose-100 text-rose-700',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter {{ $statusColors[$booking->status] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right font-black text-slate-800 text-sm">
                                TK {{ number_format($booking->total_price) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-10 text-center text-slate-400 text-sm italic">No recent bookings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="lg:col-span-2 bg-white rounded-3xl p-8 border border-slate-100 flex flex-col items-center justify-center text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                <i class="bi bi-shield-lock text-4xl"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-700 mb-2">Welcome to NGH Admin</h3>
            <p class="text-sm text-slate-400 max-w-xs">You have limited access to the system modules. Please use the sidebar to navigate to your assigned areas.</p>
        </div>
        @endif
        
        <!-- Quick Actions Sidebar -->
        <div class="space-y-6">
            <div class="bg-indigo-600 rounded-3xl p-8 text-white relative overflow-hidden shadow-lg shadow-indigo-100">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                <h3 class="text-lg font-bold mb-4 relative z-10">Quick Actions</h3>
                <div class="grid grid-cols-1 gap-3 relative z-10">
                    @if(auth()->user()->hasPermission('view_rooms'))
                    <a href="{{ route('admin.rooms.create') }}" class="flex items-center gap-3 p-3 bg-white/10 hover:bg-white/20 rounded-2xl transition group">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                            <i class="bi bi-door-open-fill"></i>
                        </div>
                        <span class="text-sm font-bold">Add New Room</span>
                    </a>
                    @endif
                    
                    @if(auth()->user()->hasPermission('view_bookings'))
                    <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 p-3 bg-white/10 hover:bg-white/20 rounded-2xl transition group">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>
                        <span class="text-sm font-bold">Manage Bookings</span>
                    </a>
                    @endif
                </div>
            </div>

            <!-- System Info -->
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">System Health</h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm font-bold text-slate-700">
                        <span>Environment</span>
                        <span class="text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded text-[10px]">Production</span>
                    </div>
                    <div class="flex justify-between items-center text-sm font-bold text-slate-700">
                        <span>Framework</span>
                        <span class="text-slate-400">Laravel v{{ app()->version() }}</span>
                    </div>
                    @if(auth()->user()->isSuperAdmin())
                    <div class="pt-4 border-t border-slate-50">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Server Load</span>
                            <span class="text-[10px] font-bold text-indigo-500">24%</span>
                        </div>
                        <div class="w-full h-1.5 bg-slate-50 rounded-full overflow-hidden">
                            <div class="w-1/4 h-full bg-indigo-500 rounded-full"></div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
