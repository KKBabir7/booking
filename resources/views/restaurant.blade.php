@extends('layouts.main')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/restaurant.css') }}" />
@endpush

@section('content')
  <!-- Hero Section -->
  <header class="restaurant-hero"
    style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ isset($restaurantSettings['hero_bg']) ? asset($restaurantSettings['hero_bg']) : asset('assets/img/restaurant/restaurant-hero.jpg') }}'); background-size: cover; background-position: center; height: 60vh; display: flex; align-items: center; text-align: center; color: white;">
    <div class="restaurant-hero-content container">
      <span
        class="restaurant-hero-tagline text-uppercase ls-2 fw-bold text-primary shadow-sm">{{ $restaurantSettings['hero_tagline'] ?? 'Discover a Taste of Excellence' }}</span>
      <h1 class="restaurant-hero-title display-3 fw-bold mt-2 shadow-sm">
        {!! $restaurantSettings['hero_title'] ?? 'Fine Dining at<br>Nice Guest House' !!}</h1>
    </div>
  </header>

  <main>
    <div class="container py-5 mt-5">
      <div class="row g-5">
        <!-- Left Column: Content -->
        <div class="col-lg-7">
          <!-- Intro Section -->
          <div class="mb-5">
            <h2 class="fw-bold mb-4">{{ $restaurantSettings['intro_title'] ?? 'Unforgettable Dining Experiences' }}</h2>
            <p class="lead text-muted">
              {{ $restaurantSettings['intro_text'] ?? 'Step into a world of flavor without ever leaving the comfort of your stay. At Nice Guest House, our restaurants offer more than just meals — they deliver unforgettable dining experiences. From aromatic Thai curries and sizzling Chinese stir-fries to classic Indian delicacies, Deshi favorites, and English comfort food — our diverse menu is crafted to satisfy every craving.' }}
            </p>
          </div>

          <!-- Why Dine With Us / Features -->
          <div class="mb-5">
            <h3 class="fw-bold mb-4">{{ $restaurantSettings['features_title'] ?? '✨ Why Dine With Us?' }}</h3>
            <ul class="feature-list list-unstyled">
              @php
                $features = isset($restaurantSettings['page_features']) ? json_decode($restaurantSettings['page_features'], true) : [];
              @endphp
              @forelse ($features as $feature)
                <li class="mb-3 d-flex align-items-start gap-3">
                  <i class="{{ $feature['icon'] ?? 'bi bi-check-circle-fill' }} text-primary fs-4"></i>
                  <span class="text-muted">{{ $feature['text'] ?? '' }}</span>
                </li>
              @empty
                <li class="mb-3 d-flex align-items-start gap-3"><i class="bi bi-layers-fill text-primary fs-4"></i> 3
                  Restaurants spread across 3 floors — including a scenic rooftop view.</li>
                <li class="mb-3 d-flex align-items-start gap-3"><i class="bi bi-check-circle-fill text-primary fs-4"></i>
                  Fresh, hygienic, and made-to-order meals.</li>
                <li class="mb-3 d-flex align-items-start gap-3"><i class="bi bi-people-fill text-primary fs-4"></i> Ideal
                  ambiance for families, business dinners, or casual hangouts.</li>
              @endforelse
            </ul>
          </div>
        </div>

        <!-- Right Column: Sticky Reservation (Simplified) -->
        <div class="col-lg-5">
          <div class="sticky-reservation-sidebar">
            <div class="reservation-card p-4 bg-white shadow-lg border rounded-5">
              <div class="text-center mb-4">
                <h3 class="fw-bold">Reserve Your Table</h3>
                <p class="text-muted small">Secure your spot at our fine dining establishments.</p>
              </div>

              <form action="{{ route('bookings.store') }}" method="POST" id="restaurantBookingForm" novalidate>
                @csrf
                <input type="hidden" name="type" value="restaurant">
                <input type="hidden" name="payment_percentage" value="100">
                <input type="hidden" name="amount_to_pay" value="">
                <div class="row g-3">
                  <div class="col-12">
                    <label class="form-label small fw-bold text-uppercase text-slate-500">Select Restaurant</label>
                    <select name="restaurant_id" id="restaurantSelect"
                      class="form-select border-0 bg-light rounded-4 py-3 px-4 shadow-none" required>
                      <option value="" selected disabled>Choose a restaurant...</option>
                      @foreach($restaurants as $res)
                        <option value="{{ $res->id }}" data-advance="{{ $res->advance_amount }}">{{ $res->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-12">
                    <label class="form-label small fw-bold text-uppercase text-slate-500">Reservation Date</label>
                    <input type="text" name="date" id="reservationDate"
                      class="form-control border-0 bg-light rounded-4 py-3 px-4 shadow-none" placeholder="Select date..."
                      required>
                  </div>
                  <div class="col-12">
                    <label class="form-label small fw-bold text-uppercase text-slate-500">Preferred Time Slot</label>
                    <select name="time_slot" id="timeSlotSelect"
                      class="form-select border-0 bg-light rounded-4 py-3 px-4 shadow-none" required>
                      <option value="Breakfast (8:00 AM - 10:30 AM)">Breakfast (8:00 AM - 10:30 AM)</option>
                      <option value="Lunch (12:30 PM - 3:30 PM)">Lunch (12:30 PM - 3:30 PM)</option>
                      <option value="Dinner (7:30 PM - 10:30 PM)">Dinner (7:30 PM - 10:30 PM)</option>
                      <option value="Snacks & Coffee (4:00 PM - 6:30 PM)">Snacks & Coffee (4:00 PM - 6:30 PM)</option>
                    </select>
                  </div>
                  <div class="col-12">
                    <label class="form-label small fw-bold text-uppercase text-slate-500">Number of Guests</label>
                    <input type="number" name="guests"
                      class="form-control border-0 bg-light rounded-4 py-3 px-4 shadow-none"
                      placeholder="How many people?" min="1" max="50" value="{{ old('guests', 2) }}" required>
                  </div>
                  <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary w-100 border-0 rounded-4 py-3 fw-bold"
                      style="background: #f76156;">Confirm Reservation Inquiry</button>
                    <p class="text-center extra-small text-muted mt-3 mb-0"><i class="bi bi-shield-lock me-1"></i> Your
                      table will be held for 15 minutes past your reservation time.</p>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="cuisine-grid bg-light" id="menu">
      <div class="container">
        <div class="text-center mb-5">
          <h6 class="text-primary fw-bold text-uppercase ls-2">
            {{ $restaurantSettings['menu_subtitle'] ?? 'Indulge in Excellence' }}</h6>
          <h2 class="display-6 fw-bold">{{ $restaurantSettings['menu_title'] ?? 'Explore Our Diverse Menu' }}</h2>
          <div class="title-divider mx-auto bg-primary" style="width: 80px; height: 3px; margin-top: 15px;"></div>
          <p class="text-muted mt-3 max-w-700 mx-auto">
            {{ $restaurantSettings['menu_desc'] ?? 'Crafted to satisfy every palate, from traditional favorites to international delicacies.' }}
          </p>
        </div>

        <div class="row g-4 mt-4">
          @php
            $cuisines = isset($restaurantSettings['cuisines']) ? json_decode($restaurantSettings['cuisines'], true) : [];
          @endphp
          @forelse ($cuisines as $cuisine)
            <div class="col-md-6 col-lg-3">
              <div class="cuisine-card">
                <div class="cuisine-img-wrapper">
                  <img
                    src="{{ isset($cuisine['image']) ? asset($cuisine['image']) : 'https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&w=600&q=80' }}"
                    alt="{{ $cuisine['title'] ?? 'Menu' }}">
                  <div class="cuisine-img-overlay"></div>
                </div>
                <div class="cuisine-card-content">
                  <h4>{{ $cuisine['title'] ?? 'Cuisine' }}</h4>
                  <p class="cuisine-description text-muted small mb-0">{{ $cuisine['desc'] ?? '' }}</p>
                </div>
              </div>
            </div>
          @empty
            <!-- Default Static Placeholders if blank -->
            <div class="col-md-6 col-lg-3">
              <div class="cuisine-card text-center p-4">
                <h4>Chinese</h4>
                <p class='small text-muted'>Bold flavors & stir-fries.</p>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="cuisine-card text-center p-4">
                <h4>Indian</h4>
                <p class='small text-muted'>Aromatic curries.</p>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="cuisine-card text-center p-4">
                <h4>English</h4>
                <p class='small text-muted'>Western comfort food.</p>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="cuisine-card text-center p-4">
                <h4>Deshi</h4>
                <p class='small text-muted'>Local tradition.</p>
              </div>
            </div>
          @endforelse
        </div>
      </div>
    </section>

    <!-- Rooftop Relaxation -->
    <section class="rooftop-section py-5 my-5 position-relative overflow-hidden"
      style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ isset($restaurantSettings['rooftop_bg']) ? asset($restaurantSettings['rooftop_bg']) : asset('assets/img/restaurant/rooftop-bg.jpg') }}'); background-size: cover; background-position: center; border-radius: 2rem; margin: 0 1rem;">
      <div class="container py-5 text-center text-white">
        <div class="row justify-content-center">
          <div class="col-lg-8" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-4">
              <span class="me-2">{{ $restaurantSettings['rooftop_icon'] ?? '☕' }}</span>
              {{ $restaurantSettings['rooftop_title'] ?? 'Rooftop Relaxation' }}
            </h2>
            <p class="lead mb-0 opacity-90 mx-auto" style="max-width: 800px;">
              {{ $restaurantSettings['rooftop_desc'] ?? 'We offer a beautiful rooftop seating arrangement where guests can unwind, enjoy the fresh air, and take in scenic views — the perfect spot to savor a cup of coffee or tea in peace.' }}
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Hospitality Section -->
    <section class="py-5 bg-white">
      <div class="container text-center py-md-5">
        <div class="row g-5">
          @php
            $hospitality = isset($restaurantSettings['hospitality_grid']) ? json_decode($restaurantSettings['hospitality_grid'], true) : [];
          @endphp
          @foreach($hospitality as $item)
            <div class="col-md-4">
              <div class="p-5 border rounded-5 bg-white shadow-sm h-100 hover-shadow transition">
                <i class="{{ $item['icon'] ?? 'bi bi-star' }} fs-1 text-primary mb-3 d-block"></i>
                <h5 class="fw-bold">{{ $item['title'] ?? '' }}</h5>
                <p class="small text-muted mb-0">{{ $item['desc'] ?? '' }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  </main>

  <style>
    .ls-2 {
      letter-spacing: 2px;
    }

    .cuisine-card:hover img {
      transform: scale(1.1);
    }

    .transition {
      transition: all 0.3s ease;
    }

    .hover-shadow:hover {
      box-shadow: 0 1rem 3rem rgba(0, 0, 0, .1) !important;
    }

    /* Select2 customizations to match theme */
    .select2-container--default .select2-selection--single {
      border: none !important;
      background-color: #f8f9fa !important;
      height: 58px !important;
      border-radius: 1rem !important;
      padding: 0 1rem !important;
      display: flex;
      align-items: center;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 58px !important;
      right: 15px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #6c757d !important;
      line-height: normal !important;
      padding-left: 0 !important;
    }

    /* Fixed size for static Flatpickr so it doesn't stretch */
    .flatpickr-calendar.static {
      width: 307px !important;
      margin-top: -15px !important;
      /* Move up to touch field */
      border: 1px solid #eee !important;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05) !important;
    }

    /* Make Flatpickr arrows visible */
    .flatpickr-prev-month svg,
    .flatpickr-next-month svg {
      fill: #f76156 !important;
    }

    /* Ensure disabled dates look faded */
    .flatpickr-day.flatpickr-disabled,
    .flatpickr-day.flatpickr-disabled:hover {
      color: rgba(0, 0, 0, 0.1) !important;
    }
  </style>
@endsection

@push('scripts')
  <script>
    $(document).ready(function () {
      // Initialize Select2
      $('#restaurantSelect, #timeSlotSelect').select2({
        minimumResultsForSearch: Infinity,
        width: '100%'
      });

      // Initialize Flatpickr
      flatpickr("#reservationDate", {
        mode: "single",
        static: true,
        minDate: "today",
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "F j, Y",
        monthSelectorType: "dropdown",
        disableMobile: true,
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

      // Form submit validation
      document.getElementById('restaurantBookingForm').addEventListener('submit', function(e) {
        const restaurantSelect = document.getElementById('restaurantSelect');
        const selectedOption = restaurantSelect.options[restaurantSelect.selectedIndex];
        const restaurantName = restaurantSelect.value;
        const advanceAmount = selectedOption ? selectedOption.getAttribute('data-advance') : 500;
        const date = document.getElementById('reservationDate').value;
        const guests = document.querySelector('[name="guests"]').value;

        const vModalEl = document.getElementById('validationModal');
        const vModal = vModalEl ? new bootstrap.Modal(vModalEl) : null;
        const vTitle = document.getElementById('validationModalTitle');
        const vMsg = document.getElementById('validationModalMessage');

        if (!restaurantName) {
          e.preventDefault();
          if (vModal) {
            vTitle.textContent = 'Restaurant Required';
            vMsg.textContent = 'Please select a dining venue (Floor or Rooftop) before booking.';
            vModal.show();
          } else { alert('Please select a restaurant.'); }
          return;
        }

        if (!date) {
          e.preventDefault();
          if (vModal) {
            vTitle.textContent = 'Date Required';
            vMsg.textContent = 'Please select a valid date for your dining reservation.';
            vModal.show();
          } else { alert('Please select a date.'); }
          return;
        }

        if (!guests || guests <= 0) {
          e.preventDefault();
          if (vModal) {
            vTitle.textContent = 'Guest Count Required';
            vMsg.textContent = 'Please enter the number of guests joining us.';
            vModal.show();
          } else { alert('Please enter guest count.'); }
          return;
        }

        // --- NEW: Payment Modal Logic ---
        e.preventDefault(); // Prevent immediate submission

        const paymentModalEl = document.getElementById('paymentModal');
        const paymentModal = paymentModalEl ? new bootstrap.Modal(paymentModalEl) : null;
        
        if (paymentModal) {
            const formattedAdvance = parseFloat(advanceAmount).toLocaleString();
            // Update Modal UI for Restaurant (Dynamic Advance Fee)
            document.getElementById('modalTotalAmount').textContent = formattedAdvance + ' TK'; 
            document.getElementById('modalStayNights').textContent = 'Advance Booking Fee';
            document.getElementById('modalPayableAmount').textContent = formattedAdvance + ' TK';
            
            // Set hidden inputs for submission
            document.querySelector('#restaurantBookingForm input[name="amount_to_pay"]').value = advanceAmount;
            document.querySelector('#restaurantBookingForm input[name="payment_percentage"]').value = 100;

            // Hide percentage selection for restaurant (it's a flat fee)
            const container = document.getElementById('paymentPercentageContainer');
            const percentageLabel = paymentModalEl.querySelector('label[style*="font-size: 10px;"]'); 
            if (container) container.style.display = 'none';
            if (percentageLabel) percentageLabel.style.display = 'none';
            
            // Show Modal
            paymentModal.show();
            
            // Handle Payment Initiation
            const initiateBtn = document.getElementById('initiatePaymentBtn');
            if (initiateBtn) {
                initiateBtn.onclick = function() {
                    this.disabled = true;
                    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
                    document.getElementById('restaurantBookingForm').submit();
                };
            }
        } else {
            // Fallback
            document.getElementById('restaurantBookingForm').submit();
        }
      });
    });
  </script>
@endpush
@include('partials.payment-modal')