@extends('layouts.admin')

@section('header', 'Booking Management')

@section('content')
<div class="card-premium p-8">
    <div class="flex flex-col md:flex-row justify-between items-md-center mb-8 gap-4">
        <div>
            <h3 class="text-xl font-bold text-slate-800 tracking-tight">Reservations</h3>
            <p class="text-sm text-slate-500">View and manage all guest bookings</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex flex-wrap gap-3">
                <select name="type" onchange="this.form.submit()" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all font-semibold text-slate-600">
                    <option value="">All Types</option>
                    <option value="room" {{ request('type') == 'room' ? 'selected' : '' }}>Rooms</option>
                    <option value="restaurant" {{ request('type') == 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                    <option value="conference" {{ request('type') == 'conference' ? 'selected' : '' }}>Conference</option>
                </select>

                <select name="status" onchange="this.form.submit()" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all font-semibold text-slate-600">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <div class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search guest or email..." 
                        class="pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all w-64">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                </div>
            </form>

            <a href="{{ route('admin.bookings.create') }}" class="px-5 py-2 bg-indigo-600 text-white text-sm font-black rounded-xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/20 transition-all flex items-center gap-2">
                <i class="bi bi-plus-lg"></i> Create Offline Booking
            </a>
        </div>
    </div>



    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Guest</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Type</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Product/Service</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Schedule</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Amount</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($bookings as $booking)
                <tr class="group hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold border border-indigo-100">
                                {{ substr($booking->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-800">{{ $booking->user->name }}</div>
                                <div class="text-[11px] text-slate-400 font-medium">{{ $booking->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="px-2 py-1 bg-slate-100 text-slate-500 text-[10px] font-black rounded uppercase tracking-widest">
                            {{ $booking->type }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="text-sm font-bold text-slate-700">{{ $booking->title }}</div>
                        <div class="text-[11px] text-slate-400 font-medium">Ref: #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="text-sm text-slate-600">
                            @if($booking->type === 'room' || ($booking->type === 'conference' && $booking->check_in && $booking->check_out))
                                <div class="flex items-center gap-1"><i class="bi bi-calendar-event text-slate-300"></i> 
                                    {{ Carbon\Carbon::parse($booking->check_in ?? $booking->date)->format('d M') }} 
                                    @if($booking->check_out && $booking->check_in !== $booking->check_out)
                                        - {{ Carbon\Carbon::parse($booking->check_out)->format('d M, Y') }}
                                    @else
                                        , {{ Carbon\Carbon::parse($booking->check_in ?? $booking->date)->format('Y') }}
                                    @endif
                                </div>
                            @else
                                <div class="flex items-center gap-1"><i class="bi bi-calendar-check text-slate-300"></i> {{ Carbon\Carbon::parse($booking->date)->format('d M, Y') }}</div>
                            @endif
                            @if($booking->type !== 'room')
                                <div class="text-[11px] text-slate-400 font-medium"><i class="bi bi-clock text-slate-200"></i> {{ $booking->time_slot ?? $booking->duration }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @php
                            $statusMap = [
                                'pending' => ['bg-amber-100 text-amber-700', 'Pending Review'],
                                'confirmed' => ['bg-emerald-100 text-emerald-700', 'Confirmed'],
                                'completed' => ['bg-indigo-100 text-indigo-700', 'Completed'],
                                'cancelled' => ['bg-rose-100 text-rose-700', 'Cancelled'],
                            ];
                            $currentStatus = $statusMap[$booking->status] ?? ['bg-slate-100 text-slate-500', $booking->status];
                        @endphp
                        <span style="    white-space: nowrap;" class="px-3 py-1 {{ $currentStatus[0] }} text-[10px] font-black rounded-full uppercase tracking-tighter">
                            {{ $currentStatus[1] }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-right">
                        <div class="flex flex-col items-end gap-1">
                            <div class="text-xs font-black text-slate-800">TK {{ number_format($booking->total_price) }}</div>
                            
                            @php
                                $isFullySettled = ($booking->amount_paid >= $booking->total_price && $booking->type !== 'restaurant') || 
                                                 ($booking->type === 'restaurant' && $booking->status === 'completed' && $booking->payment_status === 'success');
                            @endphp

                            @if($isFullySettled && $booking->status !== 'cancelled')
                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[9px] font-black rounded border border-emerald-100 uppercase tracking-tighter">Settled</span>
                            @elseif($booking->amount_paid > 0 && $booking->status !== 'cancelled')
                                <span class="px-2 py-0.5 {{ $booking->type === 'restaurant' ? 'bg-indigo-50 text-indigo-600 border-indigo-100' : 'bg-emerald-50 text-emerald-600 border-emerald-100' }} text-[9px] font-black rounded border uppercase tracking-tighter">
                                    {{ $booking->type === 'restaurant' && !$isFullySettled ? 'Advance Pay' : ($booking->payment_percentage . '% Paid') }}
                                </span>
                                <div class="text-[9px] text-slate-400 font-medium">TK {{ number_format($booking->amount_paid) }}</div>
                            @endif

                            @php
                                $payStatusClasses = [
                                    'success' => 'bg-emerald-500',
                                    'pending' => 'bg-amber-400',
                                    'failed' => 'bg-rose-500',
                                ];
                                $payStatusColor = $payStatusClasses[$booking->payment_status] ?? 'bg-slate-400';
                            @endphp
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="w-1 h-1 rounded-full {{ $payStatusColor }}"></span>
                                <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ $booking->payment_status ?? 'Unpaid' }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="View Details">
                                <i class="bi bi-eye-fill fs-5"></i>
                            </a>
                            @if(auth()->user()->isSuperAdmin())
                                <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Delete reservation #{{ $booking->id }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Delete">
                                        <i class="bi bi-trash-fill fs-5"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                        <i class="bi bi-database-exclamation text-4xl mb-3 d-block"></i>
                        No reservations found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $bookings->appends(request()->query())->links() }}
    </div>
</div>
@endsection
