<div class="col-xl-6">
    <div class="card-premium p-0 overflow-hidden shadow-xl border-0 h-100 bg-white">
        <div class="p-6 text-white flex justify-between items-center" style="background-color: {{ $template->primary_color }}">
            <div>
                <h4 class="text-sm font-black uppercase tracking-widest mb-0">{{ $template->name }}</h4>
                <p class="text-white/60 text-[9px] font-bold uppercase tracking-tighter mt-1">Slug: {{ $template->slug }} | Category: {{ ucfirst($template->category) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center shadow-inner">
                <i class="bi bi-pencil-square fs-5"></i>
            </div>
        </div>
        <div class="p-8">
            <form action="{{ route('admin.email-settings.update-template', $template->id) }}" method="POST">
                @csrf
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Subject Line</label>
                <input type="text" name="subject" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 mb-6 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10" value="{{ $template->subject }}" required>
                
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Smart Message Body</label>
                <textarea name="content" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10 mb-2" rows="12" required>{{ $template->content }}</textarea>
                
                <!-- Placeholder Tags -->
                <div class="mb-8 flex flex-wrap gap-2">
                    @php
                        $placeholders = $template->category == 'admin' 
                            ? ['guest_name', 'booking_id', 'item_title', 'check_in', 'check_out', 'total_amount', 'amount_paid', 'guest_email', 'subject', 'message'] 
                            : ['guest_name', 'booking_id', 'item_title', 'check_in', 'check_out', 'total_amount', 'amount_paid', 'status', 'original_message', 'reply_message'];
                    @endphp
                    @foreach($placeholders as $p)
                        <span class="text-[9px] font-black bg-indigo-50 px-2 py-1 rounded-lg border border-indigo-100 text-indigo-500 cursor-help" title="Click to copy tag" onclick="copyTag('[{{ $p }}]')">[{{ $p }}]</span>
                    @endforeach
                </div>

                <div class="row g-4 mb-6">
                    <div class="col-6">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Brand Highlight Color</label>
                        <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-2xl border border-slate-100">
                            <input type="color" name="primary_color" class="w-12 h-10 rounded-xl border-0 cursor-pointer" value="{{ $template->primary_color }}">
                            <span class="text-[10px] font-black text-slate-400 underline">{{ $template->primary_color }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Call-to-Action Link</label>
                        <input type="url" name="site_link" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-[11px] font-bold text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10" value="{{ $template->site_link }}" required>
                    </div>
                </div>

                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Final Footer Note</label>
                <textarea name="footer_text" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-[10px] font-medium text-slate-500 mb-8" rows="2">{{ $template->footer_text }}</textarea>

                <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-slate-100 hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-2">
                    <i class="bi bi-arrow-repeat text-indigo-400"></i> Sync Brand Template
                </button>
            </form>
        </div>
    </div>
</div>
