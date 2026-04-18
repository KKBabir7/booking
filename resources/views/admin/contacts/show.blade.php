@extends('layouts.admin')

@section('header', 'Inquiry Details')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-premium p-6 mb-4">
            <div class="flex justify-between items-start mb-6 border-b border-slate-50 pb-4">
                <div>
                    <h5 class="text-xl font-bold text-slate-800">{{ $message->subject ?? '(No Subject)' }}</h5>
                    <p class="text-sm text-slate-500">From: <span class="font-bold text-slate-700">{{ $message->name }}</span> ({{ $message->email }})</p>
                </div>
                <div class="text-right">
                    <span class="text-xs text-slate-400 block mb-1">Received on:</span>
                    <span class="text-sm font-medium text-slate-600">{{ $message->created_at->format('M d, Y \a\t H:i') }}</span>
                </div>
            </div>

            <div class="bg-slate-50 rounded-2xl p-6 text-slate-700 leading-relaxed mb-6">
                {{ $message->message }}
            </div>

            @if($message->replied_at)
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <div class="flex items-center gap-2 mb-4 text-emerald-600">
                        <i class="bi bi-check-circle-fill"></i>
                        <span class="font-bold uppercase tracking-wider text-xs">Replied on {{ $message->replied_at->format('M d, Y') }}</span>
                    </div>
                    <div class="bg-emerald-50/50 rounded-2xl p-6 border border-emerald-100">
                        <p class="text-emerald-800 mb-0 italic">"{{ $message->reply_message }}"</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="card-premium p-6">
            <h5 class="text-lg font-bold text-slate-800 mb-4">Send Reply</h5>
            <form action="{{ route('admin.contacts.reply', $message) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="reply_message" class="form-label text-sm font-bold text-slate-600 mb-2">Message Content</label>
                    <textarea name="reply_message" id="reply_message" class="form-control border-slate-200 rounded-xl focus:ring-indigo-500" rows="6" placeholder="Type your professional reply here..." required></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.contacts.index') }}" class="btn px-4 py-2 border-slate-200 text-slate-600 hover:bg-slate-50 rounded-xl transition">Cancel</a>
                    <button type="submit" class="btn btn-primary px-6 py-2 bg-indigo-600 text-white rounded-xl shadow-lg hover:bg-indigo-700 transition flex items-center gap-2">
                        <i class="bi bi-send-fill text-xs"></i> Send Reply
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-premium p-6">
            <h5 class="text-base font-bold text-slate-800 mb-4 border-b border-slate-50 pb-2">Guest Meta</h5>
            <div class="flex flex-col gap-4">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 flex-shrink-0">
                        <i class="bi bi-geo-alt fs-5"></i>
                    </div>
                    <div>
                        <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">IP Address</div>
                        <div class="text-sm text-slate-700 font-medium">{{ $message->ip_address ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 flex-shrink-0">
                        <i class="bi bi-clock fs-5"></i>
                    </div>
                    <div>
                        <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">Waiting For</div>
                        <div class="text-sm text-slate-700 font-medium">{{ $message->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-50">
                    <p class="text-xs text-slate-400 leading-relaxed italic">
                        Replying will send a professional HTML email to the guest at <strong>{{ $message->email }}</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
