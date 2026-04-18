@extends('layouts.admin')

@section('header', 'Guest Inquiries')

@section('content')
<div class="card-premium p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Contact Messages</h3>
            <p class="text-sm text-slate-500 text-muted">Manage and respond to guest inquiries.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Guest</th>
                    <th class="px-6 py-4 font-semibold">Subject</th>
                    <th class="px-6 py-4 font-semibold">Date</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($messages as $msg)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-slate-800">{{ $msg->name }}</div>
                        <div class="text-xs text-slate-400">{{ $msg->email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-slate-600 truncate max-w-xs">{{ $msg->subject ?? '(No Subject)' }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500">
                        {{ $msg->created_at->format('M d, Y') }}
                        <div class="text-xs text-slate-400">{{ $msg->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($msg->replied_at)
                            <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2.5 py-1 rounded-full">Replied</span>
                        @else
                            <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2.5 py-1 rounded-full">Pending</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.contacts.show', $msg) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="View & Reply">
                                <i class="bi bi-chat-left-text fs-5"></i>
                            </a>
                            <form action="{{ route('admin.contacts.destroy', $msg) }}" method="POST" onsubmit="return confirm('Delete this message permanently?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Delete">
                                    <i class="bi bi-trash fs-5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                        <i class="bi bi-envelope fs-1 mb-3 d-block opacity-20"></i>
                        No inquiries found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $messages->links() }}
    </div>
</div>
@endsection
