@extends('layouts.admin')

@section('header', __('Manage Reviews'))

@section('content')
<div class="max-w-7xl mx-auto pb-24">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Room Reviews</h2>
            <p class="text-slate-500 text-sm mt-1">Manage all guest reviews for your rooms.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.reviews.create') }}" class="flex-1 md:flex-none text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-indigo-600/20 text-sm">
                <i class="bi bi-plus-lg me-1"></i> Add Review
            </a>
        </div>
    </div>



    @forelse ($roomsWithReviews as $room)
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-slate-800">{{ $room->name }} <span class="text-sm font-normal text-slate-500">({{ $room->reviews->count() }} Reviews, Avg: {{ number_format($room->rating, 2) }})</span></h3>
            <a href="{{ route('admin.reviews.create', ['room_id' => $room->id, 'is_fake' => 1]) }}" class="text-sm bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-1.5 px-4 rounded-lg transition-colors">
                <i class="bi bi-plus-lg me-1"></i> Add Fake Review
            </a>
        </div>
        
        <div class="card-premium p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100">
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Guest</th>
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Rating</th>
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Comment</th>
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Type</th>
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($room->reviews as $review)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="py-4 px-6 text-sm">
                                <span class="font-bold text-slate-700">
                                    {{ $review->is_fake ? ($review->fake_guest_name ?: 'Fake Guest') : ($review->user->name ?? 'Deleted User') }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center justify-center bg-amber-50 text-amber-600 font-black px-2.5 py-1 rounded-lg text-xs">
                                    <i class="bi bi-star-fill me-1"></i> {{ number_format($review->rating, 2) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-500">
                                {{ Str::limit($review->comment, 60) }}
                            </td>
                            <td class="py-4 px-6">
                                @if($review->is_fake)
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 pb-1.5 rounded-full text-xs font-bold uppercase tracking-widest">Fake</span>
                                @else
                                    <span class="bg-emerald-100 text-emerald-700 px-3 py-1 pb-1.5 rounded-full text-xs font-bold uppercase tracking-widest">Real</span>
                                @endif
                                @if($review->is_featured)
                                    <span class="bg-indigo-100 text-indigo-700 px-3 py-1 pb-1.5 rounded-full text-xs font-bold uppercase tracking-widest ml-1">Featured</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.reviews.edit', $review) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit Review">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Delete Review">
                                            <i class="bi bi-trash"></i>
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
    </div>
    @empty
    <div class="card-premium p-12 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-4">
            <i class="bi bi-star text-2xl text-slate-400"></i>
        </div>
        <h3 class="text-base font-bold text-slate-700 mb-1">No Reviews Found</h3>
        <p class="text-sm text-slate-500 max-w-sm mx-auto">None of your rooms have received any reviews yet.</p>
    </div>
    @endforelse
</div>
@endsection
