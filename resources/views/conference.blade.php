@extends('layouts.main')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/conference.css') }}" />
  <style>
    /* Fixed size for static Flatpickr so it doesn't stretch */
    .flatpickr-calendar.static {
        /* width: 320px !important; */
        min-width: 335px !important;
        margin-top: -15px !important; /* Move up to touch field */
        left: 0 !important; /* Fix clipping on left side */
        transform: none !important;
        border: 1px solid #eee !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05) !important;
    }
    
    /* Make Flatpickr arrows visible */
    .flatpickr-prev-month svg, .flatpickr-next-month svg {
        fill: #f76156 !important;
    }
    
    /* Ensure disabled dates look faded */
    .flatpickr-day.flatpickr-disabled, .flatpickr-day.flatpickr-disabled:hover {
        color: rgba(0,0,0,0.1) !important;
    }

    /* Booked dates list styling */
    .booked-dates-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    .booked-date-item {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        padding: 10px 15px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .booked-date-item i {
        color: #f76156;
    }
  </style>
@endpush

@section('content')
  <!-- Premium Hero Section -->
  <header class="conference-hero" style="{{ isset($settings['hero_bg']) ? 'background-image: url(' . asset($settings['hero_bg']) . ')' : '' }}">
    <div class="conference-hero-content container">
      <span class="conference-hero-tagline" data-aos="fade-up">{{ $settings['hero_tagline'] ?? 'Elite Corporate Venues' }}</span>
      <h1 class="conference-hero-title" data-aos="fade-up" data-aos-delay="100">{!! $settings['hero_title'] ?? 'Nice Guest House &<br>Training Hall' !!}</h1>
    </div>
  </header>

  <main>
    <!-- Hall Overview Cards -->
    <div class="container hall-grid">
      <div class="row g-4 justify-content-center">
        @foreach($halls as $hall)
        <div class="col-xl-4 col-md-6">
          <div class="hall-card-premium">
            <div class="hall-image-wrapper" {{ $hall->panorama_url ? "onclick=open3DViewer('{$hall->panorama_url}','".addslashes($hall->name)."')" : '' }}>
              <img src="{{ $hall->image ? asset($hall->image) : 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $hall->name }}" class="hall-card-img">
              <button class="wishlist-btn" onclick="event.stopPropagation(); toggleWishlist(this)">
                <i class="bi bi-heart"></i>
              </button>
              @if($hall->panorama_url)
              <div class="orbit-360-container">
                <div class="orbit-360-outer"></div>
                <div class="orbit-360-system">
                  <div class="orbit-ring one"></div>
                  <div class="orbit-ring two"></div>
                </div>
                <div class="orbit-label">360°</div>
              </div>
              <div class="view-360-overlay"></div>
              @endif
            </div>
            <div class="hall-card-content">
              <h3>{{ $hall->name }}</h3>
              <div class="hall-meta">
                <span class="hall-pax"><i class="bi bi-people-fill me-2"></i>Up to {{ $hall->capacity ?? 'N/A' }} Persons</span>
                @if($hall->badge_text)
                <span class="badge bg-light text-dark rounded-pill px-3">{{ $hall->badge_text }}</span>
                @endif
              </div>
              @if($hall->price)
              <div class="hall-price-row d-flex align-items-center gap-2 mt-2 mb-1">
                <i class="bi bi-tag-fill text-primary"></i>
                <span class="fw-black text-primary fs-5">{{ $currencyService->format($hall->price) }}</span>
                <span class="text-muted extra-small">/session</span>
              </div>
              @endif
              <p class="hall-desc-premium">{{ $hall->description }}</p>
              
              <div class="d-flex gap-2 mt-auto">
                <a href="#conferenceBookingForm" class="btn btn-outline-primary rounded-pill flex-grow-1 hall-btn" data-hall-id="{{ $hall->id }}">Book This Hall</a>
                @if($hall->bookings->count() > 0)
                <button type="button" class="btn btn-light rounded-circle text-muted view-booked-btn" data-hall-id="{{ $hall->id }}" data-hall-name="{{ $hall->name }}" title="View Unavailable Dates">
                    <i class="bi bi-calendar-x"></i>
                </button>
                @endif
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <!-- Suitability Section -->
    <section class="suitability-section py-header bg-white">
      <div class="container">
        <div class="row align-items-center g-5 flex-row-reverse">
          <div class="col-lg-6">
            <div class="modern-section-header mt-4">
              <span class="section-label">{{ $settings['suitability_label'] ?? 'Versatility' }}</span>
              <h2 class="modern-section-title">{!! $settings['suitability_title'] ?? 'Designed for Every Significant Moment.' !!}</h2>
              <p class="text-muted mt-3">{{ $settings['suitability_desc'] ?? 'From high-level corporate strategies to celebration of milestones, our halls adapt to your vision with seamless precision.' }}</p>
            </div>
            <div class="premium-icon-grid">
              @php
                  $suitabilityItems = json_decode($settings['suitability_items'] ?? '[]', true) ?: [
                      ['icon' => 'bi-briefcase', 'title' => 'Board Meetings'],
                      ['icon' => 'bi-globe', 'title' => 'Conferences'],
                      ['icon' => 'bi-people', 'title' => 'Retreats'],
                      ['icon' => 'bi-award', 'title' => 'Trainings'],
                      ['icon' => 'bi-calendar-heart', 'title' => 'Weddings'],
                      ['icon' => 'bi-megaphone', 'title' => 'Exhibitions']
                  ];
              @endphp
              @foreach($suitabilityItems as $item)
              <div class="icon-item-modern">
                <div class="icon-circle-modern"><i class="bi {{ str_replace('bi ', '', $item['icon'] ?? 'bi-star') }}"></i></div>
                <span class="icon-text-modern">{{ $item['title'] }}</span>
              </div>
              @endforeach
            </div>
          </div>
          <div class="col-lg-6">
            <div class="image-showcase-container">
              <img src="{{ isset($settings['suitability_image']) ? asset($settings['suitability_image']) : 'https://images.unsplash.com/photo-1431540015161-0bf868a2d407?auto=format&fit=crop&w=1200&q=80' }}" alt="Venue Layout" class="img-fluid">
              <div class="image-overlay-card d-none d-md-flex">
                <span>Theater Style Arrangement</span>
                <i class="bi bi-arrow-right-circle fs-3 text-primary"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Facilities & Booking Section -->
    <section class="facilities-section py-5 mb-5 bg-white">
      <div class="container">
        <div class="row g-5">
          <!-- Left: Facilities Grid -->
          <div class="col-lg-8">
            <div class="modern-section-header">
              <span class="section-label">{{ $settings['facilities_label'] ?? 'Infrastructure' }}</span>
              <h2 class="modern-section-title">{!! $settings['facilities_title'] ?? 'World-Class Excellence<br>Included as Standard.' !!}</h2>
            </div>
            
            <div class="row row-cols-md-2 row-cols-1 g-4">
              @php
                  $facilityItems = json_decode($settings['facilities_items'] ?? '[]', true) ?: [
                      ['icon' => 'bi-display', 'title' => 'Advanced A/V', 'desc' => '4K LCD Displays & HDR Projectors'],
                      ['icon' => 'bi-wifi', 'title' => 'Gigabit Connectivity', 'desc' => 'Dedicated high-speed enterprise WiFi'],
                      ['icon' => 'bi-volume-up', 'title' => 'Stereo Sound', 'desc' => 'Integrated ceiling-mounted audio system'],
                      ['icon' => 'bi-cup-hot', 'title' => 'Catering Ready', 'desc' => 'On-site gourmet refreshments available']
                  ];
              @endphp
              @foreach($facilityItems as $item)
              <div class="col">
                <div class="icon-item-modern p-4">
                  <div class="icon-circle-modern bg-primary-subtle border-0"><i class="bi {{ str_replace('bi ', '', $item['icon'] ?? 'bi-star') }}"></i></div>
                  <div class="ms-1">
                    <h6 class="fw-bold mb-1">{{ $item['title'] }}</h6>
                    <p class="extra-small text-muted mb-0">{{ $item['desc'] }}</p>
                  </div>
                </div>
              </div>
              @endforeach
            </div>

            <div class="image-showcase-container mt-5">
              <img src="{{ isset($settings['facilities_image']) ? asset($settings['facilities_image']) : 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?auto=format&fit=crop&w=1200&q=80' }}" alt="Conference Layout" class="img-fluid">
            </div>
          </div>

          <!-- Right: Professional Booking Card -->
          <div class="col-lg-4">
            <div class="booking-card-modern sticky-top" style="top: 120px;">
              <div class="booking-header-modern mb-4">
                <h4>Plan Your Event</h4>
                <p class="small text-muted">Receive a tailored proposal from our experts.</p>
              </div>
              
              <form action="{{ route('bookings.store') }}" method="POST" id="conferenceBookingForm" novalidate>
                @csrf
                <input type="hidden" name="type" value="conference">
                <input type="hidden" name="payment_percentage" id="payment_percentage_input" value="100">
                <input type="hidden" name="amount_to_pay" id="amount_to_pay_input" value="0">
                <div class="mb-4">
                  <label class="form-label small fw-bold text-uppercase letter-spacing-1">Select Hall</label>
                  <select name="hall_id" class="form-select border-0 bg-light rounded-4 py-3 px-4 shadow-none" id="hallSelect" required>
                    <option selected disabled value="">Choose a hall...</option>
                    @foreach($halls as $hall)
                        <option value="{{ $hall->id }}" data-price="{{ $hall->price }}" data-capacity="{{ $hall->capacity }}">{{ $hall->name }}</option>
                    @endforeach
                  </select>
                </div>
                
                <div class="mb-4">
                  <label class="form-label small fw-bold text-uppercase letter-spacing-1">Date of Event</label>
                  <input type="text" name="date" id="conf-date" class="form-control border-0 bg-light rounded-4 py-3 px-4 shadow-none" placeholder="Select date..." autocomplete="off" required>
                </div>

                <div class="mb-4">
                  <label class="form-label small fw-bold text-uppercase letter-spacing-1">Booking Duration</label>
                  <select name="duration" class="form-select border-0 bg-light rounded-4 py-3 px-4 shadow-none" id="durationSelect" required>
                    <option value="Full Day (8 AM - 8 PM)">Full Day (8 AM - 8 PM)</option>
                  </select>
                </div>

                <div class="mb-4">
                  <label class="form-label small fw-bold text-uppercase letter-spacing-1">Expected Guests</label>
                  <input type="number" name="guests" class="form-control border-0 bg-light rounded-4 py-3 px-4 shadow-none" placeholder="Enter count" min="1" required>
                </div>

                {{-- Dynamic Price Summary --}}
                <div id="hallPriceSummary" class="rounded-4 bg-light p-4 mb-4" style="display:none;">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="small text-muted fw-bold text-uppercase" style="letter-spacing:.05em;">Selected Hall</span>
                    <span class="fw-bold text-dark small" id="summaryHallName">—</span>
                  </div>
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="small text-muted fw-bold text-uppercase" style="letter-spacing:.05em;">Capacity</span>
                    <span class="fw-bold text-dark small" id="summaryCapacity">—</span>
                  </div>
                  <hr class="my-2">
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-black text-uppercase" style="letter-spacing:.05em;">Price</span>
                    <span class="fw-black text-primary fs-5" id="summaryPrice">—</span>
                  </div>
                </div>

                <button type="submit" class="booking-btn-premium w-100 mb-4">
                  Reserve Conference Booking
                </button>
                
                <div class="text-center">
                  <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 extra-small">
                    <i class="bi bi-shield-check me-1"></i> Swift 2-Hour Response Time
                  </span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  </main>

@endsection

<!-- Booked Dates Modal -->
<div class="modal fade" id="bookedDatesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-5 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-black text-indigo-900" id="bookedModalTitle">Unavailable Dates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-4" id="bookedModalHallName"></p>
                <div class="booked-dates-list" id="bookedDatesList">
                    <!-- Dates will be injected here -->
                </div>
                <div class="mt-4 p-3 bg-indigo-50 rounded-4 text-indigo-700 extra-small">
                    <i class="bi bi-info-circle-fill me-2"></i> These dates are currently reserved for corporate events and are not available for selection.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Validation Toast/Alert for Unavailable Dates -->
<div class="modal fade" id="unavailableAlertModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded-5 border-0 shadow-lg">
            <div class="modal-body p-4 text-center">
                <div class="w-16 h-16 bg-rose-100 text-rose-500 rounded-circle flex items-center justify-center mx-auto mb-3">
                    <i class="bi bi-calendar-x-fill fs-3"></i>
                </div>
                <h5 class="fw-black text-slate-800 mb-2">Unavailable Date</h5>
                <p class="text-muted small mb-4">The selected date is already booked for this hall. Please check the unavailable dates list or try another slot.</p>
                <button type="button" class="btn btn-slate-900 w-100 rounded-pill py-2 font-bold" data-bs-dismiss="modal">Got it</button>
            </div>
        </div>
    </div>
</div>

<!-- Backend Error Modal (For Overlaps & Validation) -->
@if($errors->any())
<div class="modal fade" id="bookingErrorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-5 border-0 shadow-lg payment-security-modal">
            <div class="modal-body p-5 text-center">
                <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-circle flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                </div>
                <h4 class="fw-black text-slate-900 mb-2 uppercase tracking-tight">Booking Update Failed</h4>
                <div class="bg-rose-50 border border-rose-100 rounded-3xl p-4 mb-4">
                    @foreach($errors->all() as $error)
                        <p class="text-rose-600 font-bold small mb-1"><i class="bi bi-dot"></i> {{ $error }}</p>
                    @endforeach
                </div>
                <p class="text-slate-500 small mb-5">Please verify the availability and try a different date or time slot.</p>
                <button type="button" class="btn btn-slate-900 w-100 rounded-pill py-3 font-black uppercase tracking-widest hover-shadow transition-all" data-bs-dismiss="modal">Review My Request</button>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
  <script>
    window.exchangeRate = {{ $activeCurrency->exchange_rate }};
    window.currencySymbol = '{{ $activeCurrency->symbol }}';
    
    // Store booked dates for each hall
    window.hallBookings = {
        @foreach($halls as $hall)
            "{{ $hall->id }}": {
                "name": "{{ $hall->name }}",
                "price": {{ $hall->price ?? 0 }},
                "partial_payments": @json($hall->partial_payments ?? [50, 70, 100]),
                "items": [
                    @foreach($hall->bookings as $b)
                        {
                            "date": "{{ $b->date }}",
                            "check_in": "{{ $b->check_in }}",
                            "check_out": "{{ $b->check_out }}"
                        },
                    @endforeach
                ]
            },
        @endforeach
    };

    // Helper to get all dates between two dates
    function getDatesInRange(startDate, endDate) {
        const dates = [];
        let currDate = new Date(startDate);
        const lastDate = new Date(endDate);
        while (currDate <= lastDate) {
            dates.push(new Date(currDate).toISOString().split('T')[0]);
            currDate.setDate(currDate.getDate() + 1);
        }
        return dates;
    }
  </script>
  <script>
    // Track selected hall capacity
    let selectedHallCapacity = null;
    let selectedHallName = '';

    $(document).ready(function() {

      // Select2: Hall
      $('#hallSelect').select2({
        minimumResultsForSearch: Infinity,
        placeholder: "Choose a hall..."
      });

      // Select2: Duration
      $('#durationSelect').select2({
        minimumResultsForSearch: Infinity
      });

      // Hall change: update price summary + store capacity
      $('#hallSelect').on('change', function() {
        const selected = $(this).find('option:selected');
        const price    = selected.data('price');
        const capacity = selected.data('capacity');
        const name     = selected.text();

        selectedHallCapacity = capacity ? parseInt(capacity) : null;
        selectedHallName = name;

        // Update Flatpickr disabled dates for the selected hall
        if (hallId && window.hallBookings[hallId]) {
            let allDisabledDates = [];
            window.hallBookings[hallId].items.forEach(item => {
                if (item.check_in && item.check_out) {
                    allDisabledDates = allDisabledDates.concat(getDatesInRange(item.check_in, item.check_out));
                } else if (item.date) {
                    allDisabledDates.push(item.date);
                }
            });
            window.datePicker.set('disable', [...new Set(allDisabledDates)]);
        } else {
            window.datePicker.set('disable', []);
        }

        if (price) {
          $('#summaryHallName').text(name);
          $('#summaryCapacity').text(capacity ? 'Up to ' + capacity + ' persons' : 'N/A');
          const rate = window.exchangeRate || 1;
          const symbol = window.currencySymbol || 'TK';
          const formattedPrice = Math.round(parseInt(price) * rate).toLocaleString();
          $('#summaryPrice').text(symbol + ' ' + formattedPrice + ' /session');
          $('#hallPriceSummary').slideDown(200);
        } else {
          $('#hallPriceSummary').slideUp(200);
        }
      });

      // 'Book This Hall' card button: pre-selects hall and scrolls to form
      document.querySelectorAll('.hall-btn[data-hall-id]').forEach(function(btn) {
        btn.addEventListener('click', function() {
          const hallId = this.dataset.hallId;
          $('#hallSelect').val(hallId).trigger('change');
          setTimeout(() => {
            document.getElementById('conferenceBookingForm').scrollIntoView({ behavior: 'smooth', block: 'start' });
          }, 150);
        });
      });

      // Form submit validation
      document.getElementById('conferenceBookingForm').addEventListener('submit', function(e) {
        const hallId = $('#hallSelect').val();
        const dateVal = document.getElementById('conf-date').value;
        const guestsVal = parseInt(document.querySelector('[name="guests"]').value);
        
        const vModalEl = document.getElementById('validationModal');
        const vModal = vModalEl ? new bootstrap.Modal(vModalEl) : null;
        const vTitle = document.getElementById('validationModalTitle');
        const vMsg = document.getElementById('validationModalMessage');

        // Check Hall
        if (!hallId) {
          e.preventDefault();
          if (vModal) {
            vTitle.textContent = 'Hall Selection Required';
            vMsg.textContent = 'Please choose a conference hall before proceeding with your booking.';
            vModal.show();
          } else { alert('Please select a hall.'); }
          return;
        }

        // Check Date
        if (!dateVal) {
          e.preventDefault();
          if (vModal) {
            vTitle.textContent = 'Date Required';
            vMsg.textContent = 'Please select a valid date for your event.';
            vModal.show();
          } else { alert('Please select a date.'); }
          return;
        }

        // Check Guests
        if (!guestsVal || guestsVal <= 0) {
          e.preventDefault();
          if (vModal) {
            vTitle.textContent = 'Invalid Guest Count';
            vMsg.textContent = 'Please enter a valid number of expected guests.';
            vModal.show();
          } else { alert('Please enter expected guests.'); }
          return;
        }

        // Check Capacity
        if (selectedHallCapacity && guestsVal > selectedHallCapacity) {
          e.preventDefault();
          if (vModal) {
            vTitle.textContent = 'Capacity Exceeded';
            vMsg.textContent = '"' + selectedHallName + '" has a maximum capacity of ' + selectedHallCapacity + ' persons. You entered ' + guestsVal + '. Please reduce your guest count.';
            vModal.show();
          } else {
             alert('Capacity exceeded.');
          }
          return;
        }

        // --- NEW: Payment Modal Logic ---
        e.preventDefault();

        const paymentModalEl = document.getElementById('paymentModal');
        const paymentModal = paymentModalEl ? new bootstrap.Modal(paymentModalEl) : null;
        
        if (paymentModal) {
            const hallId = $('#hallSelect').val();
            const hallData = window.hallBookings[hallId];
            const basePrice = hallData ? hallData.price : 0;
            const rate = window.exchangeRate || 1;
            const totalInCurrency = Math.round(basePrice * rate);
            const partialPayments = hallData ? hallData.partial_payments : [50, 70, 100];
            
            const container = document.getElementById('paymentPercentageContainer');
            const percentageLabel = paymentModalEl.querySelector('label[style*="font-size: 10px;"]');

            if (container) {
                container.style.display = 'flex';
                container.innerHTML = '';
                partialPayments.forEach((percent, index) => {
                    const col = document.createElement('div');
                    col.className = 'col-4';
                    col.innerHTML = `
                        <input type="radio" class="btn-check" name="payment_percent" id="pay${percent}" value="${percent}" autocomplete="off" ${index === partialPayments.length - 1 ? 'checked' : ''}>
                        <label class="btn btn-outline-indigo w-100 py-3 rounded-4 fw-bold" for="pay${percent}">${percent}%</label>
                    `;
                    container.appendChild(col);
                });
            }
            if (percentageLabel) percentageLabel.style.display = 'block';

            document.getElementById('modalTotalAmount').textContent = totalInCurrency.toLocaleString() + ' ' + (window.currencySymbol || 'TK');
            document.getElementById('modalStayNights').textContent = 'Conference Hall Reservation';
            
            const updatePayable = (percent) => {
                const payable = Math.round((totalInCurrency * percent) / 100);
                document.getElementById('modalPayableAmount').textContent = payable.toLocaleString() + ' ' + (window.currencySymbol || 'TK');
                document.getElementById('payment_percentage_input').value = percent;
                document.getElementById('amount_to_pay_input').value = payable;
            };

            // Set Initial Amount
            const defaultPercent = partialPayments[partialPayments.length - 1];
            updatePayable(defaultPercent);
            paymentModal.show();

            // Re-attach listeners
            if (container) {
                container.querySelectorAll('input[name="payment_percent"]').forEach(r => {
                    r.onclick = function() { updatePayable(this.value); };
                });
            }

            const initiateBtn = document.getElementById('initiatePaymentBtn');
            if (initiateBtn) {
                initiateBtn.onclick = function() {
                    this.disabled = true;
                    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
                    document.getElementById('conferenceBookingForm').submit();
                };
            }
        }
      });
    });

    // Flatpickr: Date of Event
    window.datePicker = flatpickr("#conf-date", {
      mode: "single",
      static: true,
      minDate: "today",
      dateFormat: "Y-m-d",
      altInput: true,
      altFormat: "F j, Y",
      monthSelectorType: "dropdown",
      disableMobile: true,
      disable: [], // Initially empty
      onReady: function(selectedDates, dateStr, instance) {
        $(instance.calendarContainer).find('.flatpickr-monthDropdown-months').select2({
          minimumResultsForSearch: Infinity,
          dropdownParent: $(instance.calendarContainer),
          width: '120px'
        });
      },
      onMonthChange: function(selectedDates, dateStr, instance) {
        setTimeout(() => {
          $(instance.calendarContainer).find('.flatpickr-monthDropdown-months').select2({
            minimumResultsForSearch: Infinity,
            dropdownParent: $(instance.calendarContainer),
            width: '120px'
          });
        }, 0);
      }
    });

    // Handle 'View Unavailable Dates' Modal
    $(document).on('click', '.view-booked-btn', function() {
        const hallId = $(this).data('hall-id');
        const hallName = $(this).data('hall-name');
        const bookedData = window.hallBookings[hallId];
        
        const modal = new bootstrap.Modal(document.getElementById('bookedDatesModal'));
        document.getElementById('bookedModalHallName').innerText = 'Reservations for ' + hallName;
        
        const listContainer = document.getElementById('bookedDatesList');
        listContainer.innerHTML = '';
        
        if (bookedData && bookedData.items.length > 0) {
            bookedData.items.forEach(item => {
                let displayDate = '';
                if (item.check_in && item.check_out && item.check_in !== item.check_out) {
                    const start = new Date(item.check_in).toLocaleDateString('en-GB', { day: 'numeric', month: 'short' });
                    const end = new Date(item.check_out).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
                    displayDate = `${start} — ${end}`;
                } else {
                    const date = item.date || item.check_in;
                    displayDate = new Date(date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
                }

                listContainer.innerHTML += `
                    <div class="booked-date-item">
                        <i class="bi bi-calendar-check text-rose-500"></i>
                        ${displayDate}
                    </div>
                `;
            });
        } else {
            listContainer.innerHTML = '<div class="col-12 text-center py-4 text-muted small">No upcoming reservations for this hall.</div>';
        }
        
        modal.show();
    });

    // Add immediate validation if user tries to select a disabled date manually (if altInput fails)
    $('#conf-date').on('change', function() {
        const selectedDate = $(this).val();
        const hallId = $('#hallSelect').val();
        
        if (hallId && selectedDate && window.hallBookings[hallId]) {
            if (window.hallBookings[hallId].dates.includes(selectedDate)) {
                $(this).val('');
                const alertModal = new bootstrap.Modal(document.getElementById('unavailableAlertModal'));
                alertModal.show();
            }
        }
    });

    // Handle Auto-Show Error Modal
    $(document).ready(function() {
        @if($errors->any())
            const errorModal = new bootstrap.Modal(document.getElementById('bookingErrorModal'));
            errorModal.show();
        @endif
    });
  </script>
@endpush
@include('partials.payment-modal')
