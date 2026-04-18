@extends('layouts.admin')

@section('header', 'Email Management Hub')

@section('content')
<div class="row g-6">
    <!-- Top Header Card -->
    <div class="col-12">
        <div class="card-premium overflow-hidden border-0 shadow-xl mb-6" style="background: linear-gradient(135deg, #4f46e5 0%, #312e81 100%);">
            <div class="p-8 relative">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="flex items-center gap-6 relative z-10">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md border border-white/30 shadow-lg">
                        <i class="bi bi-envelope-paper-heart-fill text-white fs-2"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-black text-white tracking-tight mb-1">Email Management Hub</h2>
                        <p class="text-white/70 font-bold uppercase tracking-widest text-[10px]">Configure SMTP credentials and customize brand email templates</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="col-12 mb-2">
        <div class="flex gap-4 mb-8 bg-slate-100/50 p-2 rounded-2xl w-fit">
            <button class="px-8 py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all shadow-sm border {{ request()->get('tab') == 'admin-templates' || request()->get('tab') == 'user-templates' ? 'bg-white text-slate-500 border-slate-200' : 'bg-indigo-600 text-white border-indigo-500 shadow-indigo-100' }}" onclick="switchEmailTab('credentials', this)">
                <i class="bi bi-shield-lock-fill me-2"></i>Brevo SMTP Credentials
            </button>
            <button class="px-8 py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all shadow-sm border {{ request()->get('tab') == 'admin-templates' ? 'bg-indigo-600 text-white border-indigo-500 shadow-indigo-100' : 'bg-white text-slate-500 border-slate-200' }}" onclick="switchEmailTab('admin-templates', this)">
                <i class="bi bi-person-badge-fill me-2"></i>Admin Templates
            </button>
            <button class="px-8 py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all shadow-sm border {{ request()->get('tab') == 'user-templates' ? 'bg-indigo-600 text-white border-indigo-500 shadow-indigo-100' : 'bg-white text-slate-500 border-slate-200' }}" onclick="switchEmailTab('user-templates', this)">
                <i class="bi bi-people-fill me-2"></i>User Templates
            </button>
        </div>
    </div>

    <!-- Credentials View -->
    <div id="credentials-view" class="col-12 {{ request()->get('tab') == 'admin-templates' || request()->get('tab') == 'user-templates' ? 'hidden' : '' }} animate-in fade-in slide-in-from-bottom-4 mt-4">
        <div class="row g-6">
            <div class="col-lg-8">
                <div class="card-premium p-0 overflow-hidden shadow-xl border-0">
                    <div class="bg-indigo-600 p-6 text-white flex justify-between items-center">
                        <div>
                            <h4 class="text-lg font-black tracking-tight mb-1">SMTP Server Configuration</h4>
                            <p class="text-white/60 text-[10px] font-bold uppercase tracking-widest italic tracking-wider">Brevo Relay Service</p>
                        </div>
                        <i class="bi bi-server fs-3 opacity-50"></i>
                    </div>
                    
                    <form action="{{ route('admin.email-settings.update-credentials') }}" method="POST" class="p-8 bg-white">
                        @csrf
                        <div class="row g-6">
                            <div class="col-md-8">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">SMTP Host</label>
                                <input type="text" name="mail_host" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10" value="{{ $smtpSettings['mail_host'] ?? '' }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">SMTP Port</label>
                                <input type="text" name="mail_port" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10" value="{{ $smtpSettings['mail_port'] ?? '' }}" required>
                            </div>
                            <div class="col-12">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">SMTP Username</label>
                                <input type="text" name="mail_username" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10" value="{{ $smtpSettings['mail_username'] ?? '' }}" required>
                            </div>
                            <div class="col-12">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">SMTP Password (API Key)</label>
                                <div class="relative">
                                    <input type="password" name="mail_password" id="smtp_password" class="w-full pl-4 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10" value="{{ $smtpSettings['mail_password'] ?? '' }}" required>
                                    <button type="button" onclick="toggleSMTPPassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600">
                                        <i class="bi bi-eye-fill" id="pass_icon"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Sender Email Address</label>
                                <input type="email" name="mail_from_address" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10" value="{{ $smtpSettings['mail_from_address'] ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Sender Display Name</label>
                                <input type="text" name="mail_from_name" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-500/10" value="{{ $smtpSettings['mail_from_name'] ?? 'Nice Guest House' }}" required>
                            </div>
                        </div>
                        <div class="mt-10 flex justify-end">
                            <button type="submit" class="bg-indigo-600 text-white btn-premium px-12 py-4 rounded-2xl font-black text-sm shadow-xl shadow-indigo-100 hover:scale-[1.02] active:scale-[0.98] transition-all">
                                <i class="bi bi-cloud-upload-fill me-2"></i> Update SMTP Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card-premium p-6 bg-white mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-0">Live Status</h4>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-[11px] font-bold text-slate-500">
                            <span>Connection Health</span>
                            <span class="text-emerald-500 uppercase">Active</span>
                        </div>
                        <div class="flex justify-between items-center text-[11px] font-bold text-slate-500">
                            <span>Last Sync</span>
                            <span class="text-slate-700">{{ now()->format('h:i A') }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-premium p-6 bg-slate-900 text-white relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-xl"></div>
                    <div class="relative z-10">
                        <h4 class="text-xs font-black uppercase tracking-widest mb-4 flex items-center gap-2">
                            <i class="bi bi-info-circle-fill text-indigo-400"></i> Setup Guide
                        </h4>
                        <ul class="space-y-4 m-0 p-0 list-none">
                            <li class="text-[11px] text-white/70 flex gap-3">
                                <span class="text-indigo-400 font-black">01.</span>
                                <div>Use <strong>smtp-relay.brevo.com</strong> for the host setting.</div>
                            </li>
                            <li class="text-[11px] text-white/70 flex gap-3">
                                <span class="text-indigo-400 font-black">02.</span>
                                <div>Recommended port is <strong>587</strong> with TLS encryption.</div>
                            </li>
                            <li class="text-[11px] text-white/70 flex gap-3">
                                <span class="text-indigo-400 font-black">03.</span>
                                <div>The password is your Brevo SMTP Master Key.</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Templates View -->
    <div id="admin-templates-view" class="col-12 {{ request()->get('tab') == 'admin-templates' ? '' : 'hidden' }} animate-in fade-in slide-in-from-bottom-4 mt-4">
        <div class="row g-6">
            @foreach($adminTemplates as $template)
                @include('admin.settings.partials.template_card', ['template' => $template])
            @endforeach
        </div>
    </div>

    <!-- User Templates View -->
    <div id="user-templates-view" class="col-12 {{ request()->get('tab') == 'user-templates' ? '' : 'hidden' }} animate-in fade-in slide-in-from-bottom-4 mt-4">
        <div class="row g-6">
            @foreach($userTemplates as $template)
                @include('admin.settings.partials.template_card', ['template' => $template])
            @endforeach
        </div>
    </div>
</div>

<script>
    function toggleSMTPPassword() {
        const passInput = document.getElementById('smtp_password');
        const icon = document.getElementById('pass_icon');
        if (passInput.type === 'password') {
            passInput.type = 'text';
            icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
        } else {
            passInput.type = 'password';
            icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
        }
    }

    function switchEmailTab(tabId, btn) {
        document.getElementById('credentials-view').classList.toggle('hidden', tabId !== 'credentials');
        document.getElementById('admin-templates-view').classList.toggle('hidden', tabId !== 'admin-templates');
        document.getElementById('user-templates-view').classList.toggle('hidden', tabId !== 'user-templates');

        const buttons = btn.parentElement.querySelectorAll('button');
        buttons.forEach(b => {
            b.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-500', 'shadow-indigo-100');
            b.classList.add('bg-white', 'text-slate-500', 'border-slate-200');
        });

        btn.classList.add('bg-indigo-600', 'text-white', 'border-indigo-500', 'shadow-indigo-100');
        btn.classList.remove('bg-white', 'text-slate-500', 'border-slate-200');
        
        const url = new URL(window.location);
        url.searchParams.set('tab', tabId);
        window.history.replaceState({}, '', url);
    }

    function copyTag(text) {
        navigator.clipboard.writeText(text);
    }
</script>
@endsection
