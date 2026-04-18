@extends('layouts.admin')

@section('header', 'SEO Management')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Favicon Management Card -->
    <div class="card-premium p-8 mb-10 overflow-hidden relative border-l-4 border-indigo-600">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative z-10">
            <div class="flex-grow">
                <h3 class="text-2xl font-black text-slate-800 mb-2 flex items-center gap-3">
                    <i class="bi bi-star-fill text-amber-400"></i> Favicon Management
                </h3>
                <p class="text-slate-500 font-medium leading-relaxed max-w-2xl">
                    Upload your website's global favicon (.ico or .png). This icon appears in browser tabs and bookmarks.
                </p>
                @if($favicon && $favicon->site_favicon)
                    <div class="mt-6 flex items-center gap-4">
                        <form action="{{ route('admin.seo.favicon.delete') }}" method="POST" onsubmit="return confirm('Remove favicon?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold py-2 px-4 rounded-lg transition border border-rose-100 flex items-center gap-2">
                                <i class="bi bi-trash3-fill"></i> Remove Current
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="flex flex-col items-center justify-center p-6 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 min-w-[200px] group transition-all hover:border-indigo-300">
                <div class="w-16 h-16 bg-white rounded-xl shadow-md border border-slate-100 flex items-center justify-center p-2 mb-4 group-hover:scale-110 transition-transform">
                    @if($favicon && $favicon->site_favicon)
                        <img src="{{ asset($favicon->site_favicon) }}" class="max-w-full max-h-full object-contain">
                    @else
                        <i class="bi bi-image text-3xl text-slate-300"></i>
                    @endif
                </div>
                
                <form action="{{ route('admin.seo.favicon.update') }}" method="POST" enctype="multipart/form-data" id="faviconForm" class="text-center">
                    @csrf
                    <input type="file" name="site_favicon" id="site_favicon" class="hidden" onchange="document.getElementById('faviconForm').submit()" accept=".ico,.png,.jpg,.jpeg">
                    <label for="site_favicon" class="cursor-pointer bg-slate-800 hover:bg-black text-white text-xs font-bold py-2.5 px-6 rounded-full transition shadow-lg">
                        {{ ($favicon && $favicon->site_favicon) ? 'Replace Favicon' : 'Upload Favicon' }}
                    </label>
                </form>
            </div>
        </div>
        <!-- Decorative Background Icon -->
        <i class="bi bi-gear-wide-connected absolute -bottom-10 -right-10 text-slate-100/50" style="font-size: 15rem;"></i>
    </div>

    <!-- SEO Page Wise Management -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Page-wise SEO</h2>
            <p class="text-slate-500 font-medium">Create and customize meta tags for every page independently.</p>
        </div>
        <button onclick="toggleModal('seoModal')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all hover:shadow-indigo-200 flex items-center gap-2">
            <i class="bi bi-plus-circle-fill"></i> Add New Page SEO
        </button>
    </div>

    @if($seoMetas->isEmpty())
        <div class="card-premium p-16 text-center bg-slate-50 border-2 border-dashed border-slate-200">
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-100">
                <i class="bi bi-search text-4xl text-slate-300"></i>
            </div>
            <h4 class="text-xl font-bold text-slate-800 mb-2">No SEO Records Found</h4>
            <p class="text-slate-500 max-w-sm mx-auto">Start optimizing your website search visibility by adding your first page SEO configuration.</p>
        </div>
    @else
        <div class="space-y-6 mb-12">
            @foreach($seoMetas as $sm)
                <div class="card-premium overflow-hidden border-l-4 border-slate-800 hover:border-indigo-600 transition-all duration-300">
                    <!-- Card Header / Toggle -->
                    <div class="p-5 flex justify-between items-center cursor-pointer bg-white group" onclick="toggleAccordion('seo-{{ $sm->id }}')">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-600 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition">
                                <i class="bi bi-file-earmark-code"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-slate-800 group-hover:text-indigo-600 transition">{{ $sm->page_name }}</h4>
                                <span class="text-[10px] uppercase tracking-widest font-bold text-slate-400">Slug: <span class="text-slate-600 lowercase font-medium">{{ '/' . $sm->slug }}</span></span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="bi bi-chevron-down text-slate-400 transition-transform duration-300" id="icon-seo-{{ $sm->id }}"></i>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div id="seo-{{ $sm->id }}" class="hidden border-t border-slate-50 bg-slate-50/30 p-8 pt-6">
                        <form action="{{ route('admin.seo.update', $sm->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                                <!-- Basic SEO -->
                                <div class="space-y-6">
                                    <h5 class="text-xs font-black uppercase tracking-widest text-indigo-600 border-b border-indigo-100 pb-2">Basic Metadata</h5>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="col-span-1">
                                            <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Page Name</label>
                                            <input type="text" name="page_name" value="{{ $sm->page_name }}" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-600 text-sm font-bold shadow-sm">
                                        </div>
                                        <div class="col-span-1">
                                            <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Slug (Unique Path)</label>
                                            <input type="text" name="slug" value="{{ $sm->slug }}" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-600 text-sm font-bold shadow-sm bg-slate-50">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Meta Title</label>
                                        <input type="text" name="meta_title" value="{{ $sm->meta_title }}" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-600 text-sm font-bold shadow-sm" maxlength="60">
                                        <p class="text-[10px] text-slate-400 mt-1">Recommended: 50-60 characters</p>
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Meta Description</label>
                                        <textarea name="meta_description" rows="3" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-600 text-sm font-medium shadow-sm" maxlength="160">{{ $sm->meta_description }}</textarea>
                                        <p class="text-[10px] text-slate-400 mt-1">Recommended: 150-160 characters</p>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Robots Index</label>
                                            <select name="robots_index" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-600 text-sm font-bold shadow-sm">
                                                <option value="index" {{ $sm->robots_index == 'index' ? 'selected' : '' }}>Index</option>
                                                <option value="noindex" {{ $sm->robots_index == 'noindex' ? 'selected' : '' }}>Noindex</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Robots Follow</label>
                                            <select name="robots_follow" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-600 text-sm font-bold shadow-sm">
                                                <option value="follow" {{ $sm->robots_follow == 'follow' ? 'selected' : '' }}>Follow</option>
                                                <option value="nofollow" {{ $sm->robots_follow == 'nofollow' ? 'selected' : '' }}>Nofollow</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Social Meta / OG -->
                                <div class="space-y-6">
                                    <h5 class="text-xs font-black uppercase tracking-widest text-rose-600 border-b border-rose-100 pb-2">Social Sharing (OG Tag)</h5>
                                    
                                    <div>
                                        <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">OG Title (Facebook/WhatsApp)</label>
                                        <input type="text" name="og_title" value="{{ $sm->og_title }}" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:ring-2 focus:ring-rose-400 text-sm font-bold shadow-sm">
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">OG Image</label>
                                        <div class="flex items-start gap-4">
                                            @if($sm->og_image)
                                                <img src="{{ asset($sm->og_image) }}" class="w-20 h-20 rounded-lg object-cover border border-slate-200">
                                            @else
                                                <div class="w-20 h-20 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-300">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                            <input type="file" name="og_image" class="block w-full text-[10px] text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-[10px] file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 transition">
                                        </div>
                                    </div>

                                    <h5 class="text-xs font-black uppercase tracking-widest text-sky-600 border-b border-sky-100 pb-2 mt-8 luxury-separator">Twitter Settings</h5>
                                    
                                    <div>
                                        <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Twitter Title</label>
                                        <input type="text" name="twitter_title" value="{{ $sm->twitter_title }}" class="w-full px-4 py-2.5 rounded-xl border-slate-200 focus:ring-2 focus:ring-sky-400 text-sm font-bold shadow-sm">
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Twitter Image</label>
                                        <div class="flex items-start gap-4">
                                            @if($sm->twitter_image)
                                                <img src="{{ asset($sm->twitter_image) }}" class="w-20 h-20 rounded-lg object-cover border border-slate-200">
                                            @else
                                                <div class="w-20 h-20 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-300">
                                                    <i class="bi bi-image text-xl"></i>
                                                </div>
                                            @endif
                                            <input type="file" name="twitter_image" class="block w-full text-[10px] text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-[10px] file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 transition">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-10 pt-6 border-t border-slate-100 flex justify-between items-center">
                                <button type="button" onclick="confirmDelete('{{ $sm->id }}')" class="text-rose-500 hover:text-rose-700 text-xs font-bold transition flex items-center gap-2">
                                    <i class="bi bi-trash3"></i> Delete This Configuration
                                </button>
                                <div class="flex gap-4">
                                    <button type="button" onclick="toggleAccordion('seo-{{ $sm->id }}')" class="px-6 py-2.5 rounded-xl font-bold text-sm text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition">Cancel</button>
                                    <button type="submit" class="px-8 py-2.5 rounded-xl font-bold text-sm text-white bg-indigo-600 hover:bg-indigo-700 shadow-md transition">Update Changes</button>
                                </div>
                            </div>
                        </form>

                        <form id="delete-form-{{ $sm->id }}" action="{{ route('admin.seo.destroy', $sm->id) }}" method="POST" class="hidden">
                            @csrf @method('DELETE')
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Add SEO Modal -->
<div id="seoModal" class="fixed inset-0 z-50 hidden overflow-y-auto px-4 py-8">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('seoModal')"></div>
    <div class="relative max-w-2xl mx-auto bg-white rounded-3xl shadow-2xl p-8 animate-in fade-in zoom-in duration-300">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">New Page SEO Configuration</h3>
            <button onclick="toggleModal('seoModal')" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form action="{{ route('admin.seo.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Select Page</label>
                        <select name="page_name" id="new_page_name" required class="w-full px-4 py-3 rounded-xl border-slate-200 font-bold" onchange="handlePageSelect(this)">
                            <option value="">-- Select a Page --</option>
                            <option value="Home" data-slug="home">Home Page</option>
                            <option value="Rooms" data-slug="rooms">Rooms Listing</option>
                            <option value="Conference" data-slug="conference">Conference Hall</option>
                            <option value="Restaurant" data-slug="restaurant">Restaurant Page</option>
                            <option value="About" data-slug="about">About Us</option>
                            <option value="Gallery" data-slug="gallery">Gallery</option>
                            <option value="FAQ" data-slug="faq">FAQ</option>
                            <option value="Contact" data-slug="contact">Contact Information</option>
                            <option value="Privacy Policy" data-slug="privacy-policy">Privacy Policy</option>
                            <option value="Terms of Service" data-slug="terms-of-service">Terms of Service</option>
                            <option value="Custom">Custom Page...</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Slug (URL Path)</label>
                        <input type="text" name="slug" id="new_slug" required placeholder="e.g., blog" class="w-full px-4 py-3 rounded-xl border-slate-200 font-bold bg-slate-50">
                    </div>
                </div>

                <div id="custom-name-wrapper" class="hidden animate-in fade-in slide-in-from-top-2 duration-300">
                    <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Custom Page Name</label>
                    <input type="text" id="custom_page_name" placeholder="e.g., Blog Post #1" class="w-full px-4 py-3 rounded-xl border-slate-200 font-bold">
                </div>

                <div>
                    <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Meta Title</label>
                    <input type="text" name="meta_title" placeholder="Catchy title for Google" class="w-full px-4 py-3 rounded-xl border-slate-200 font-bold">
                </div>

                <div>
                    <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Meta Description</label>
                    <textarea name="meta_description" rows="3" placeholder="Brief summary of the page content" class="w-full px-4 py-3 rounded-xl border-slate-200 font-medium"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Robots Index</label>
                        <select name="robots_index" class="w-full px-4 py-3 rounded-xl border-slate-200 font-bold">
                            <option value="index">Index</option>
                            <option value="noindex">Noindex</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Robots Follow</label>
                        <select name="robots_follow" class="w-full px-4 py-3 rounded-xl border-slate-200 font-bold">
                            <option value="follow">Follow</option>
                            <option value="nofollow">Nofollow</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="button" onclick="toggleModal('seoModal')" class="flex-1 py-3.5 rounded-xl font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">Discard</button>
                <button type="submit" class="flex-grow py-3.5 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-xl transition-all">Enable SEO for This Page</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function toggleAccordion(id) {
        const accordionBody = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        
        if (accordionBody.classList.contains('hidden')) {
            accordionBody.classList.remove('hidden');
            icon.style.transform = 'rotate(180deg)';
        } else {
            accordionBody.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
        }
    }

    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
        if (!modal.classList.contains('hidden')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
    }

    function handlePageSelect(select) {
    const slugInput = document.getElementById('new_slug');
    const customWrapper = document.getElementById('custom-name-wrapper');
    const customInput = document.getElementById('custom_page_name');
    const selectedOption = select.options[select.selectedIndex];
    const slug = selectedOption.getAttribute('data-slug');

    if (select.value === 'Custom') {
        customWrapper.classList.remove('hidden');
        slugInput.value = '';
        slugInput.readOnly = false;
        slugInput.classList.remove('bg-slate-50');
    } else {
        customWrapper.classList.add('hidden');
        if (slug) {
            slugInput.value = slug;
            slugInput.readOnly = true;
            slugInput.classList.add('bg-slate-50');
        } else {
            slugInput.value = '';
            slugInput.readOnly = false;
            slugInput.classList.remove('bg-slate-50');
        }
    }
}

// Intercept form submission to handle custom page name
document.querySelector('#seoModal form').addEventListener('submit', function(e) {
    const select = document.getElementById('new_page_name');
    const customInput = document.getElementById('custom_page_name');
    
    if (select.value === 'Custom' && customInput.value.trim() !== '') {
        // We create a temporary hidden input so the server gets the custom name
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'page_name';
        hiddenInput.value = customInput.value;
        this.appendChild(hiddenInput);
        
        // Remove name attribute from select so it doesn't conflict
        select.removeAttribute('name');
    }
});

function generateSlug(sourceId, targetId) {
    const source = document.getElementById(sourceId);
    const target = document.getElementById(targetId);
    
    if (target.readOnly) return; // Don't auto-generate if locked to a standard page

    let text = source.value.toLowerCase()
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-');
    target.value = text;
}

    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this SEO configuration?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
@endsection
