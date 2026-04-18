<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Name --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Hall Name <span class="text-rose-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $hall->name ?? '') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300" placeholder="e.g. Ground Floor Executive Hall" required>
        </div>

        {{-- Capacity --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Max Capacity (Persons)</label>
            <input type="number" name="capacity" value="{{ old('capacity', $hall->capacity ?? '') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300" placeholder="e.g. 50">
        </div>

        {{-- Price --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Price Amount (TK)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $hall->price ?? '') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300" placeholder="e.g. 5000">
        </div>

        {{-- Badge Text --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Badge Highlight</label>
            <input type="text" name="badge_text" value="{{ old('badge_text', $hall->badge_text ?? '') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300" placeholder="e.g. VIP Suite">
        </div>

        {{-- Panorama URL --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">360&deg; Panorama Image URL</label>
            <input type="url" name="panorama_url" value="{{ old('panorama_url', $hall->panorama_url ?? '') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300" placeholder="e.g. https://pannellum.org/images/jfk.jpg">
        </div>
    </div>

    {{-- Payment Configuration --}}
    <div class="bg-indigo-50/30 p-6 rounded-2xl border border-indigo-100/50">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                <i class="bi bi-credit-card-fill"></i>
            </div>
            <div>
                <h4 class="text-sm font-black text-slate-700 leading-none">Payment Configuration</h4>
                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mt-1">Specify deposit percentages</p>
            </div>
        </div>
        
        <div id="payment-options-container" class="space-y-3">
            @php
                $partialPayments = old('partial_payments', isset($hall) ? ($hall->partial_payments ?? []) : [100]);
                if (empty($partialPayments)) $partialPayments = [100];
            @endphp
            @foreach($partialPayments as $index => $percent)
                <div class="flex gap-3 items-center payment-option-item">
                    <div class="relative flex-1">
                        <input type="number" name="partial_payments[]" value="{{ $percent }}"
                            class="w-full pl-4 pr-12 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-700"
                            placeholder="e.g. 50" min="1" max="100">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">%</span>
                    </div>
                    <button type="button" class="text-rose-500 hover:text-rose-700 bg-rose-50 p-2.5 rounded-xl remove-payment-option" {{ count($partialPayments) == 1 ? 'style=display:none;' : '' }}>
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </div>
            @endforeach
        </div>
        <button type="button" id="add-payment-option" class="mt-4 text-xs text-indigo-600 font-black hover:text-indigo-800 transition-colors flex items-center gap-2">
            <i class="bi bi-plus-circle-fill"></i> Add Option
        </button>
    </div>

    {{-- Description --}}
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Venue Description</label>
        <textarea name="description" rows="4" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300" placeholder="An elegant, accessible space designed for board meetings...">{{ old('description', $hall->description ?? '') }}</textarea>
    </div>

    {{-- Main Image --}}
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Main Display Image</label>
        
        @if(isset($hall) && $hall->image)
        <div class="mb-3">
            <p class="text-xs text-slate-500 mb-1 font-semibold">Current Image</p>
            <img src="{{ asset($hall->image) }}" class="h-32 object-cover rounded-lg border border-slate-200">
        </div>
        @endif
        
        <input type="file" name="image_file" accept="image/*" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
        <p class="text-xs text-slate-400 mt-2">Recommended size: 800x533px (JPG, PNG, WebP)</p>
    </div>

    {{-- Status Toggle --}}
    @php
        $currentStatus = old('status', isset($hall) ? (int)$hall->status : 1);
    @endphp
    <div class="pt-4 border-t border-slate-100">
        <label class="block text-sm font-semibold text-slate-700 mb-3">Hall Visibility Status</label>
        <div class="flex items-center gap-3">
            {{-- Hidden input ensures a value is always submitted --}}
            <input type="hidden" name="status" value="0">

            <div class="inline-flex rounded-xl border border-slate-200 overflow-hidden shadow-sm" role="group">
                {{-- Active Button --}}
                <label id="status-active-label"
                       class="relative flex items-center gap-2 px-5 py-2.5 cursor-pointer text-sm font-bold transition-all
                              {{ $currentStatus == 1 ? 'bg-emerald-500 text-white shadow-inner' : 'bg-white text-slate-500 hover:bg-slate-50' }}">
                    <input type="radio" name="status" value="1" class="sr-only"
                           {{ $currentStatus == 1 ? 'checked' : '' }}
                           onchange="updateStatusUI(1)">
                    <i class="bi bi-check-circle-fill"></i>
                    Active
                </label>

                <div class="w-px bg-slate-200"></div>

                {{-- Inactive Button --}}
                <label id="status-inactive-label"
                       class="relative flex items-center gap-2 px-5 py-2.5 cursor-pointer text-sm font-bold transition-all
                              {{ $currentStatus == 0 ? 'bg-slate-500 text-white shadow-inner' : 'bg-white text-slate-500 hover:bg-slate-50' }}">
                    <input type="radio" name="status" value="0" class="sr-only"
                           {{ $currentStatus == 0 ? 'checked' : '' }}
                           onchange="updateStatusUI(0)">
                    <i class="bi bi-dash-circle-fill"></i>
                    Inactive
                </label>
            </div>

            {{-- Status description text --}}
            <span id="status-description" class="text-xs {{ $currentStatus == 1 ? 'text-emerald-600' : 'text-slate-400' }} font-medium">
                {{ $currentStatus == 1 ? 'This hall is publicly visible on the conference page.' : 'This hall is hidden from the public.' }}
            </span>
        </div>
    </div>

    <script>
    function updateStatusUI(value) {
        const activeLabel   = document.getElementById('status-active-label');
        const inactiveLabel = document.getElementById('status-inactive-label');
        const description   = document.getElementById('status-description');

        if (value == 1) {
            activeLabel.className   = activeLabel.className.replace(/bg-white text-slate-500 hover:bg-slate-50/, 'bg-emerald-500 text-white shadow-inner');
            inactiveLabel.className = inactiveLabel.className.replace(/bg-slate-500 text-white shadow-inner/, 'bg-white text-slate-500 hover:bg-slate-50');
            description.textContent = 'This hall is publicly visible on the conference page.';
            description.className   = 'text-xs text-emerald-600 font-medium';
        } else {
            inactiveLabel.className = inactiveLabel.className.replace(/bg-white text-slate-500 hover:bg-slate-50/, 'bg-slate-500 text-white shadow-inner');
            activeLabel.className   = activeLabel.className.replace(/bg-emerald-500 text-white shadow-inner/, 'bg-white text-slate-500 hover:bg-slate-50');
            description.textContent = 'This hall is hidden from the public.';
            description.className   = 'text-xs text-slate-400 font-medium';
        }
    }

    // Payment Options dynamic add/remove
    const paymentOptionsContainer = document.getElementById('payment-options-container');
    const addPaymentOptionBtn = document.getElementById('add-payment-option');
    
    function updateRemoveButtons() {
        if(!paymentOptionsContainer) return;
        const buttons = paymentOptionsContainer.querySelectorAll('.remove-payment-option');
        buttons.forEach(btn => {
            btn.style.display = buttons.length > 1 ? 'block' : 'none';
        });
    }

    if (addPaymentOptionBtn && paymentOptionsContainer) {
        addPaymentOptionBtn.addEventListener('click', () => {
            const items = paymentOptionsContainer.querySelectorAll('.payment-option-item');
            if (items.length >= 3) {
                alert('Maximum 3 payment options allowed.');
                return;
            }
            const item = document.createElement('div');
            item.className = 'flex gap-3 items-center payment-option-item';
            item.innerHTML = `
            <div class="relative flex-1">
                <input type="number" name="partial_payments[]" class="w-full pl-4 pr-12 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-700" placeholder="e.g. 50" min="1" max="100">
                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">%</span>
            </div>
            <button type="button" class="text-rose-500 hover:text-rose-700 bg-rose-50 p-2.5 rounded-xl remove-payment-option"><i class="bi bi-trash-fill"></i></button>
            `;
            paymentOptionsContainer.appendChild(item);
            updateRemoveButtons();
        });
        
        paymentOptionsContainer.addEventListener('click', (e) => {
            if (e.target.closest('.remove-payment-option')) {
                e.target.closest('.payment-option-item').remove();
                updateRemoveButtons();
            }
        });
    }
    </script>

    <div class="flex justify-end pt-6">
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-10 rounded-xl transition-all shadow-md hover:shadow-lg flex items-center gap-2">
            <i class="bi bi-floppy2-fill"></i> {{ isset($hall) ? 'Update' : 'Save' }} Conference Hall
        </button>
    </div>
</div>
