@extends('layouts.admin')

@section('header', 'User Profile Details')

@section('content')
<div class="row g-8">
    <div class="col-lg-4">
        <div class="card-premium p-8 sticky top-8 text-center">
            <div class="mx-auto w-32 h-32 rounded-3xl bg-gradient-to-br from-indigo-50 to-slate-100 flex items-center justify-center text-indigo-600 font-bold border border-indigo-100 shadow-sm fs-1 mb-6">
                {{ substr($user->name, 0, 1) }}
            </div>
            <h3 class="text-2xl font-black text-slate-800 tracking-tight mb-1">{{ $user->name }}</h3>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6 px-4 py-1.5 bg-slate-50 rounded-full inline-block">ID: #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</p>

            <div class="space-y-6 text-left border-y border-slate-100 py-6 my-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center text-slate-400">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Email Address</p>
                        <p class="text-sm font-bold text-slate-700">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center text-slate-400">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Phone Number</p>
                        <p class="text-sm font-bold text-slate-700">{{ $user->phone ?? 'Not provided' }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center text-slate-400">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Location</p>
                        <p class="text-sm font-bold text-slate-700">{{ $user->location ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="block w-full py-3 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-bold rounded-2xl text-[11px] uppercase tracking-widest transition text-center">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card-premium p-8 mb-8">
            <h4 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-2">
                <i class="bi bi-calendar3 text-indigo-500"></i> Reservation History
            </h4>

            <div class="space-y-8">
                @forelse(['room' => 'Rooms & Suites', 'restaurant' => 'Dining Reservations', 'conference' => 'Meeting Halls'] as $type => $title)
                    @php $typeBookings = $allBookings->where('type', $type); @endphp
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <h5 class="text-sm font-black text-slate-400 uppercase tracking-widest">{{ $title }}</h5>
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[10px] font-bold rounded-full">{{ $typeBookings->count() }}</span>
                        </div>
                        
                        @if($typeBookings->isNotEmpty())
                        <div class="overflow-x-auto bg-slate-50 rounded-3xl border border-slate-100 px-4">
                            <table class="w-full text-left">
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($typeBookings as $booking)
                                    <tr class="group hover:bg-white transition-colors">
                                        <td class="py-4">
                                            <div class="text-sm font-bold text-slate-700">{{ $booking->title }}</div>
                                            <div class="text-[10px] text-slate-400 font-medium">Ref #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div>
                                        </td>
                                        <td class="py-4 text-sm font-medium text-slate-500">
                                            @if($type === 'room')
                                                {{ Carbon\Carbon::parse($booking->check_in)->format('d M') }} - {{ Carbon\Carbon::parse($booking->check_out)->format('d M') }}
                                            @else
                                                {{ Carbon\Carbon::parse($booking->date)->format('d M Y') }}
                                            @endif
                                        </td>
                                        <td class="py-4">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-amber-100 text-amber-700',
                                                    'confirmed' => 'bg-emerald-100 text-emerald-700',
                                                    'cancelled' => 'bg-rose-100 text-rose-700',
                                                ];
                                            @endphp
                                            <span class="px-2 py-0.5 {{ $statusColors[$booking->status] ?? 'bg-slate-100 text-slate-500' }} text-[9px] font-black rounded-full uppercase tracking-tighter">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td class="py-4 text-right">
                                            <a href="{{ route('admin.bookings.show', $booking) }}" class="p-2 text-slate-300 hover:text-indigo-600 transition-colors">
                                                <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <div class="py-6 text-center text-slate-400 text-xs italic bg-slate-50 rounded-3xl border border-slate-100 border-dashed">No {{ strtolower($title) }} found.</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
