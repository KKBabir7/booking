@extends('layouts.main')

@section('content')
  <!-- Hero Section -->
  @php
    $bannerTitle = $pageSettings['banner_title'] ?? 'Explore Our Rooms';
    $bannerSubtitle = $pageSettings['banner_subtitle'] ?? 'Discover our handpicked luxury rooms & suites.';
    $storedBanner = $pageSettings['banner_image'] ?? '';
    $cleanBanner = $storedBanner ? preg_replace('#^storage/#', '', $storedBanner) : '';
    $bannerImage = $storedBanner
      ? asset($storedBanner)
      : asset('assets/img/cover/room.jpeg');
    $searchPh = $pageSettings['search_placeholder'] ?? 'Search rooms, amenities...';
  @endphp
  <section class="hero-rooms"
    style="background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url('{{ $bannerImage }}') center/cover no-repeat;">
    <div class="container text-center">
      <h1 class="display-3 fw-bold mb-3">{{ $bannerTitle }}</h1>
      <p class="lead text-white-50 mb-0">{{ $bannerSubtitle }}</p>
    </div>
  </section>

  <!-- Availability Bar (Home Style) -->
  <section class="hero-search-section hero-search-section-room">
    <div class="container relative-trigger-container">
      <div class="hero-search-wrapper mx-auto mt-4 position-relative ">
        <div class="hero-search-overlay">
          <form action="{{ route('rooms.index') }}" method="GET"
            class="hero-search-container d-flex align-items-center bg-white shadow-lg rounded-pill p-1 position-relative">
            <!-- Mobile Close Button -->
            <button type="button" class="btn btn-close d-none mobile-search-close" id="mobileSearchCloseRooms"
              aria-label="Close" style="position: absolute; right: 20px; top: 20px; z-index: 1051;"></button>
            <!-- Where Section -->
            <div class="search-item flex-grow-1 text-start px-4 py-2" id="search-where">
              <div class="search-label fw-bold">Select Property</div>
              <input type="text" name="location" value="{{ request('location') }}"
                class="search-input-field border-0 bg-transparent w-100 p-0" id="location-input"
                placeholder="{{ $searchPh }}" readonly autocomplete="off">
              <button type="button" class="search-clear-btn d-none" id="clear-where">
                <i class="bi bi-x"></i>
              </button>

              <!-- Location Suggestions Panel -->
              <div class="search-panel location-panel shadow-lg rounded-4 d-none">
                <div class="panel-header px-4 py-3 border-bottom">
                  <span class="text-muted small fw-bold uppercase">Suggested destinations</span>
                </div>
                <div class="panel-body py-2" id="location-results">
                  <!-- Property 1 -->
                  <div class="suggestion-item d-flex align-items-center px-4 py-3" data-location="Main Branch">
                    <div class="suggestion-icon me-3 bg-light rounded-3 p-2">
                      <i class="bi bi-building text-primary"></i>
                    </div>
                    <div>
                      <div class="suggestion-title fw-bold">Nice Guest House</div>
                      <div class="suggestion-subtitle text-muted small">Uzzalpur, Maijdee Court</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="search-divider"></div>

            <!-- When Section -->
            <div class="search-item flex-grow-1 text-start px-4 py-2" id="search-when">
              <div class="search-label fw-bold">Stay Period</div>
              <div class="search-subtext text-muted small" id="date-display">Add dates</div>
              <input type="text" name="dates" value="{{ request('dates') }}" id="date-range-picker"
                style="display: none;">
              <button type="button" class="search-clear-btn d-none" id="clear-when">
                <i class="bi bi-x"></i>
              </button>
            </div>

            <div class="search-divider"></div>

            <!-- Who Section -->
            <div class="search-item flex-grow-1 text-start px-4 py-2 position-relative" id="search-who">
              <div class="search-label fw-bold">Guests</div>
              <div class="search-subtext text-dark fw-bold" id="guest-display">1 guest</div>
              <button type="button" class="search-clear-btn d-none" id="clear-who">
                <i class="bi bi-x"></i>
              </button>

              <!-- Guest Counter Panel -->
              <div class="search-panel guest-panel shadow-lg rounded-4 d-none p-4">
                <!-- Adult row -->
                <div class="guest-row d-flex align-items-center justify-content-between mb-4">
                  <div>
                    <div class="fw-bold">Adults</div>
                    <div class="text-muted small">Ages 13 or above</div>
                  </div>
                  <div class="counter-control d-flex align-items-center">
                    <button type="button" class="btn btn-outline-secondary rounded-circle btn-sm counter-btn minus"
                      data-type="adults"><i class="bi bi-dash"></i></button>
                    <span class="mx-3 fw-bold count-val" id="count-adults">1</span>
                    <button type="button" class="btn btn-outline-secondary rounded-circle btn-sm counter-btn plus"
                      data-type="adults"><i class="bi bi-plus"></i></button>
                  </div>
                </div>
                <!-- Children row -->
                <div class="guest-row d-flex align-items-center justify-content-between mb-4">
                  <div>
                    <div class="fw-bold">Children</div>
                    <div class="text-muted small">Ages 2 – 12</div>
                  </div>
                  <div class="counter-control d-flex align-items-center">
                    <button type="button" class="btn btn-outline-secondary rounded-circle btn-sm counter-btn minus"
                      data-type="children"><i class="bi bi-dash"></i></button>
                    <span class="mx-3 fw-bold count-val" id="count-children">0</span>
                    <button type="button" class="btn btn-outline-secondary rounded-circle btn-sm counter-btn plus"
                      data-type="children"><i class="bi bi-plus"></i></button>
                  </div>
                </div>
                <!-- Infants row -->
                <div class="guest-row d-flex align-items-center justify-content-between mb-4">
                  <div>
                    <div class="fw-bold">Infants</div>
                    <div class="text-muted small">Under 2</div>
                  </div>
                  <div class="counter-control d-flex align-items-center">
                    <button type="button" class="btn btn-outline-secondary rounded-circle btn-sm counter-btn minus"
                      data-type="infants"><i class="bi bi-dash"></i></button>
                    <span class="mx-3 fw-bold count-val" id="count-infants">0</span>
                    <button type="button" class="btn btn-outline-secondary rounded-circle btn-sm counter-btn plus"
                      data-type="infants"><i class="bi bi-plus"></i></button>
                  </div>
                </div>
                <!-- Pets row -->
                <div class="guest-row d-flex align-items-center justify-content-between">
                  <div>
                    <div class="fw-bold">Pets</div>
                    <div class="text-muted small"><a href="#" class="text-decoration-underline text-muted">Bringing a
                        service animal?</a></div>
                  </div>
                  <div class="counter-control d-flex align-items-center">
                    <button type="button" class="btn btn-outline-secondary rounded-circle btn-sm counter-btn minus"
                      data-type="pets"><i class="bi bi-dash"></i></button>
                    <span class="mx-3 fw-bold count-val" id="count-pets">0</span>
                    <button type="button" class="btn btn-outline-secondary rounded-circle btn-sm counter-btn plus"
                      data-type="pets"><i class="bi bi-plus"></i></button>
                  </div>
                </div>
                <!-- Hidden inputs for form submission -->
                <input type="hidden" name="adults" id="form-adults-rooms" value="{{ request('adults', 1) }}">
                <input type="hidden" name="children" id="form-children-rooms" value="{{ request('children', 0) }}">
              </div>
            </div>

            <button type="submit"
              class="btn  rounded-circle search-submit-btn d-flex align-items-center justify-content-center">
              <i class="bi bi-search"></i>
            </button>
          </form>

          <script>
            document.addEventListener('DOMContentLoaded', function () {
              // Sync guest counts to hidden form inputs before submit
              document.querySelectorAll('.counter-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                  setTimeout(() => {
                    document.getElementById('form-adults-rooms').value = document.getElementById('count-adults').textContent;
                    document.getElementById('form-children-rooms').value = document.getElementById('count-children').textContent;
                  }, 50);
                });
              });
              document.getElementById('clear-who').addEventListener('click', () => {
                setTimeout(() => {
                  document.getElementById('form-adults-rooms').value = '1';
                  document.getElementById('form-children-rooms').value = '0';
                }, 50);
              });

              // Pre-fill initial guest display based on URL
              const reqAdults = parseInt('{{ request("adults", 0) }}');
              const reqChildren = parseInt('{{ request("children", 0) }}');
              if (reqAdults > 0 || reqChildren > 0) {
                document.getElementById('count-adults').textContent = reqAdults;
                document.getElementById('count-children').textContent = reqChildren;
                const total = reqAdults + reqChildren;
                document.getElementById('guest-display').textContent = `${total} guest${total > 1 ? 's' : ''}`;
                document.getElementById('guest-display').classList.add('text-dark', 'fw-bold');
                document.getElementById('guest-display').classList.remove('text-muted');
                document.getElementById('clear-who').classList.remove('d-none');
              } else {
                // Set default display if nothing in URL
                document.getElementById('count-adults').textContent = '1';
                document.getElementById('guest-display').textContent = '1 guest';
                document.getElementById('guest-display').classList.add('text-dark', 'fw-bold');
              }

              // Pre-fill dates text based on URL
              const dates = '{{ request("dates") }}';
              if (dates) {
                const [start, end] = dates.split(' to ');
                if (start && end) {
                  document.getElementById('date-display').textContent = `${start.substring(4)} - ${end.substring(4)}`; // Basic formatting fallback if picker doesn't format
                  document.getElementById('date-display').classList.add('text-dark', 'fw-bold');
                  document.getElementById('date-display').classList.remove('text-muted');
                  document.getElementById('clear-when').classList.remove('d-none');
                }
              }
            });
          </script>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="container py-3 py-md-5">
    <div class="row">
      <!-- Sidebar Filters -->
      <aside class="col-lg-3">
        <div class="filter-header-actions d-lg-none d-flex gap-2">
          <button class="btn btn-primary w-100 rounded-3 py-0 fw-bold shadow-sm" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#filterOffcanvas" style="height: 40px;">
            <i class="bi bi-filter-left me-2"></i> Filters
          </button>
          <button class="btn btn-primary rounded-3 btn-mobile-search shadow d-flex d-md-none"
            id="mobileSearchTriggerRooms"
            style="width: 50px; height: 40px; flex-shrink: 0; align-items: center; justify-content: center;">
            <i class="bi bi-search text-white"></i>
          </button>
        </div>

        <!-- Desktop Sidebar -->
        <div class="filter-sidebar d-none d-lg-block">
          <div class="d-flex justify-content-between align-items-center mb-4 px-1">
            <h5 class="mb-0 fw-bold">Filters</h5>
            @php
              $rawMax = $rooms->max('price') ?: 1000;
              // Conversion can sometimes result in numbers like 20.3 - we ceil it to the next 10 and add a buffer
              $convertedMax = $currencyService->convert($rawMax);
              $maxFilteredPrice = (ceil($convertedMax / 10) * 10) + 10; 
              $isBdt = $activeCurrency->code === 'BDT';
              $filterStep = $isBdt ? 50 : 1;
            @endphp
            <button class="btn btn-link text-primary text-decoration-none p-0 small fw-bold" id="resetAllFilters"
              data-max="{{ $maxFilteredPrice }}">
              <i class="bi bi-arrow-counterclockwise me-1"></i> Reset All
            </button>
          </div>
          <div class="filter-section">
            <h5 class="filter-title">Price Range</h5>
            <div class="dual-range-container">
              <div class="range-inputs">
                <div class="range-input-box">
                  <label>Min</label>
                  <div class="price-input-wrapper">
                    <span class="currency-prefix">{{ $activeCurrency->symbol }}&nbsp;</span>
                    <input type="number" id="minPriceInput" value="0" min="0" max="{{ $maxFilteredPrice }}" step="{{ $filterStep }}">
                  </div>
                </div>
                <div class="range-divider">-</div>
                <div class="range-input-box">
                  <label>Max</label>
                  <div class="price-input-wrapper">
                    <span class="currency-prefix">{{ $activeCurrency->symbol }}&nbsp;</span>
                    <input type="number" id="maxPriceInput" value="{{ $maxFilteredPrice }}" min="0"
                      max="{{ $maxFilteredPrice }}" step="{{ $filterStep }}">
                  </div>
                </div>
              </div>
              <div class="slider-container">
                <div class="slider-track"></div>
                <input type="range" id="minPriceRange" min="0" max="{{ $maxFilteredPrice }}" value="0" step="{{ $filterStep }}">
                <input type="range" id="maxPriceRange" min="0" max="{{ $maxFilteredPrice }}"
                  value="{{ $maxFilteredPrice }}" step="{{ $filterStep }}">
              </div>
            </div>
          </div>

          <hr>

          <div class="filter-section">
            <h5 class="filter-title">Special Offers</h5>
            <div class="filter-list">
              <div class="filter-item">
                <input type="checkbox" id="offer-discount">
                <label for="offer-discount">Discount Items</label>
                <span class="count">0</span>
              </div>
            </div>
          </div>

          <hr>

          <div class="filter-section">
            <h5 class="filter-title">Room Exclusives</h5>
            <div class="filter-list">
              <div class="filter-item">
                <input type="checkbox" id="badge-genius">
                <label for="badge-genius">Genius Exclusive</label>
                <span class="count">0</span>
              </div>
              <div class="filter-item">
                <input type="checkbox" id="badge-top">
                <label for="badge-top">Top Pick</label>
                <span class="count">0</span>
              </div>
              <div class="filter-item">
                <input type="checkbox" id="badge-new">
                <label for="badge-new">New Luxury</label>
                <span class="count">0</span>
              </div>
              <div class="filter-item">
                <input type="checkbox" id="badge-limited">
                <label for="badge-limited">Limited Time</label>
                <span class="count">0</span>
              </div>
            </div>
          </div>

          <hr>

          <div class="filter-section">
            <h5 class="filter-title">Room Types</h5>
            <div class="filter-list">
              <div class="filter-item">
                <input type="checkbox" id="type-ac-deluxe">
                <label for="type-ac-deluxe">AC Deluxe</label>
                <span class="count">0</span>
              </div>
              <div class="filter-item">
                <input type="checkbox" id="type-ac-room">
                <label for="type-ac-room">AC Room</label>
                <span class="count">0</span>
              </div>
              <div class="filter-item">
                <input type="checkbox" id="type-ac-single">
                <label for="type-ac-single">AC Single</label>
                <span class="count">0</span>
              </div>
              <div class="filter-item">
                <input type="checkbox" id="type-business">
                <label for="type-business">Business Class</label>
                <span class="count">0</span>
              </div>
              <div class="filter-item">
                <input type="checkbox" id="type-exec-suite">
                <label for="type-exec-suite">Executive Suite</label>
                <span class="count">0</span>
              </div>
              <div class="filter-item">
                <input type="checkbox" id="type-family-deluxe">
                <label for="type-family-deluxe">Family Deluxe</label>
                <span class="count">0</span>
              </div>
              <div class="filter-item">
                <input type="checkbox" id="type-nonac-luxury">
                <label for="type-nonac-luxury">Non AC Luxury</label>
                <span class="count">0</span>
              </div>
              <div class="filter-item">
                <input type="checkbox" id="type-super-deluxe">
                <label for="type-super-deluxe">Super Deluxe</label>
                <span class="count">0</span>
              </div>
            </div>
          </div>

          <hr>

          <div class="filter-section">
            <h5 class="filter-title">Review Score</h5>
            <div class="filter-list rating-filter-list">
              @for($i = 5; $i >= 1; $i--)
                <div class="filter-item rating-filter-item" data-rating="{{ $i }}">
                  <input type="checkbox" id="review-{{ $i }}">
                  <label for="review-{{ $i }}" class="d-flex align-items-center justify-content-between w-100">
                    <span class="stars text-warning me-2">
                      @for($j = 1; $j <= 5; $j++)
                        <i class="bi bi-star{{ $j <= $i ? '-fill' : '' }}"></i>
                      @endfor
                    </span>
                    <span class="count">0</span>
                  </label>
                </div>
              @endfor
            </div>
          </div>
        </div>
      </aside>

      <!-- Room Grid -->
      <main class="col-lg-9 mt-0 mt-lg-0">
        <div class="results-header d-flex justify-content-between align-items-center mb-3">
          <p class="mb-0 text-muted showing-text-mobile">Showing <strong>{{ $rooms->count() }}</strong> results</p>
          <div class="d-flex align-items-center gap-2 gap-md-3">
            <span class="small text-muted d-none d-md-inline">Sort By:</span>
            <select class="sort-select" id="sortRooms">
              <option value="newest">Newest First</option>
              <option value="price-low">Price: Low to High</option>
              <option value="price-high">Price: High to Low</option>
              <option value="rating">Top Rated</option>
            </select>
          </div>
        </div>

        <div class="row g-4 rooms-grid">
          @foreach($rooms as $room)
            <div class="col-lg-4 col-md-6" data-room-type="{{ $room->room_type }}" data-price="{{ $room->price }}">
              <div class="offer-card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white d-flex flex-column">
                <div class="offer-image-wrapper position-relative" @if($room->is_360_available)
                onclick="open3DViewer('{{ $room->panorama_url }}', '{{ $room->name }}')" @endif>
                  <img src="{{ str_starts_with($room->image, 'http') ? $room->image : asset($room->image) }}"
                    alt="{{ $room->name }}" class="offer-img w-100">

                  @if($room->is_360_available)
                    <div class="orbit-360-container">
                      <div class="orbit-360-system">
                        <div class="orbit-ring one"></div>
                        <div class="orbit-ring two"></div>
                      </div>
                      <div class="orbit-label">360°</div>
                    </div>
                    <div class="view-360-overlay"></div>
                    <button class="image-360-btn"
                      onclick="event.stopPropagation(); open3DViewer('{{ $room->panorama_url }}', '{{ $room->name }}')">
                      <i class="bi bi-arrow-repeat"></i>
                    </button>
                  @endif

                  @auth
                    <button class="wishlist-btn" onclick="event.stopPropagation(); toggleFavorite({{ $room->id }}, this)">
                      <i
                        class="bi {{ Auth::user()->favorites->contains('room_id', $room->id) ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                    </button>
                  @else
                    <button class="wishlist-btn"
                      onclick="event.stopPropagation(); window.location.href='{{ route('register') }}'">
                      <i class="bi bi-heart"></i>
                    </button>
                  @endauth

                  @if($room->badge_text)
                    <div class="offer-badge {{ \Illuminate\Support\Str::slug($room->badge_text) }}">{{ $room->badge_text }}
                    </div>
                  @endif
                </div>
                <div class="offer-content p-4 d-flex flex-column flex-grow-1" onclick="window.location.href='{{ route('rooms.show', $room->slug) }}'" style="cursor: pointer;">
                  
                  <!-- Title & Rating -->
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="offer-title fw-bold mb-0 text-dark fs-5 text-truncate pe-2">{{ $room->name }}</h5>
                    <div class="d-flex align-items-center bg-light px-2 py-1 rounded">
                      <i class="bi bi-star-fill text-warning" style="font-size: 0.8rem;"></i>
                      <span class="fw-bold ms-1 text-dark" style="font-size: 0.55rem;">{{ number_format($room->rating, 2) }}({{ $room->review_count }})</span>
                    </div>
                  </div>

                  <!-- Features -->
                  <div class="d-flex align-items-center flex-nowrap gap-2 text-muted fw-medium mb-1" style="font-size: 0.7rem;">
                    @if(is_array($room->attributes) && count($room->attributes) >= 2)
                      <span class="d-flex align-items-center text-truncate">
                        <i class="bi bi-door-open text-primary opacity-75 me-1"></i> {{ mb_strimwidth($room->attributes[0]['value'] ?? '', 0, 18, '...') }}
                      </span>
                      <span class="text-muted opacity-50">•</span>
                      <span class="d-flex align-items-center text-truncate">
                        <i class="bi bi-people text-primary opacity-75 me-1"></i> {{ mb_strimwidth($room->attributes[1]['value'] ?? '', 0, 18, '...') }}
                      </span>
                    @else
                      <span class="d-flex align-items-center text-truncate">
                        <i class="bi bi-door-open text-primary opacity-75 me-1"></i> {{ mb_strimwidth($room->bed_type, 0, 18, '...') }}
                      </span>
                      <span class="text-muted opacity-50">•</span>
                      <span class="d-flex align-items-center text-truncate">
                        <i class="bi bi-people text-primary opacity-75 me-1"></i> {{ $room->capacity_adults + $room->capacity_children }} Guests
                      </span>
                    @endif
                  </div>

                  <!-- Nights & Adults (Single Line above footer) -->
                  @php
                    $dates = request('dates');
                    $adults = request('adults');
                    if ($adults === null || $adults == 0) {
                        $adults = $room->capacity_adults ?? 1;
                    }
                    $nights = 1;
                    $isSearchActive = false;

                    if ($dates) {
                      $isSearchActive = true;
                      $parts = explode(' to ', $dates);
                      if (count($parts) == 2) {
                        $start = \Carbon\Carbon::parse($parts[0]);
                        $end = \Carbon\Carbon::parse($parts[1]);
                        $nights = max(1, $start->diffInDays($end));
                        $dateText = $start->format('M d') . ' - ' . $end->format('M d');
                      } else {
                        $dateText = \Carbon\Carbon::parse($dates)->format('M d');
                      }
                    }
                  @endphp

                  <div class="text-muted mb-2 d-flex align-items-center flex-wrap" style="font-size: 0.75rem;">
                    @if($isSearchActive)
                      <span class="fw-bold text-dark me-1">{{ $dateText }}</span>
                      <span class="text-muted opacity-50 me-1">•</span>
                      <span>{{ $nights }} {{ Str::plural('night', $nights) }}, {{ $adults }} {{ Str::plural('adult', $adults) }}</span>
                    @else
                      <span class="fw-bold text-dark me-1">1 Night</span>
                      <span class="text-muted opacity-50 me-1">•</span>
                      <span>{{ $adults }} {{ Str::plural('adult', $adults) }}</span>
                    @endif
                  </div>

                  <!-- Footer: Pricing -->
                  <div class="d-flex justify-content-between align-items-end mt-auto pt-3 border-top">
                    
                    <div class="offer-action-left d-flex flex-column">

                      @if($room->bookings && $room->bookings->count() > 0)
                        <a href="#" class="text-danger fw-bold d-flex align-items-center text-decoration-none bg-danger bg-opacity-10 px-2 py-1 rounded-pill mt-2 d-inline-block text-center" style="font-size: 0.65rem; width: max-content;"
                                data-bs-toggle="modal" data-bs-target="#unavailableDatesModal"
                                data-room-name="{{ $room->name }}"
                                data-dates='{{ $room->bookings->map(function ($b) { return ["start" => \Carbon\Carbon::parse($b->check_in)->format("d M Y"), "end" => \Carbon\Carbon::parse($b->check_out)->format("d M Y")]; })->toJson() }}'
                                onclick="event.stopPropagation();">
                          <i class="bi bi-calendar-x me-1"></i> Unavailable Dates
                        </a>
                      @else
                        <!-- Invisible placeholder to enforce identical footer heights across all cards, preventing ugly flexbox gaps -->
                        <div class="px-2 py-1 mt-2 mb-0" style="font-size: 0.65rem; visibility: hidden; pointer-events: none;">
                          <i class="bi bi-calendar-x me-1"></i> Space
                        </div>
                      @endif
                    </div>

                    <div class="offer-pricing-area d-flex flex-column align-items-end text-end pb-1">
                      <div class="pricing-flex d-flex align-items-center justify-content-end mb-1">
                        @if($nights > 1)
                          <div class="price-current fw-bolder text-dark fs-4 lh-1">{{ $currencyService->format($room->price * $nights) }}</div>
                        @else
                          @if($room->old_price > $room->price)
                            <div class="price-old text-muted extra-small me-2"><del>{{ $currencyService->format($room->old_price) }}</del></div>
                          @endif
                          <div class="price-current fw-bolder text-dark fs-4 lh-1">{{ $currencyService->format($room->price) }}</div>
                        @endif
                      </div>
                      
                      <span class="text-primary fw-bold mt-1 d-flex align-items-center" style="font-size: 0.9rem;">
                        View deal <i class="bi bi-chevron-right ms-1" style="font-size: 0.8rem;"></i>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Pagination -->
        <nav class="mt-5">
          <ul class="pagination justify-content-center" id="rooms-pagination">
            <!-- Dynamically populated by rooms.js -->
          </ul>
        </nav>
      </main>
    </div>
  </section>

  <!-- Unavailable Dates Modal -->
  <div class="modal fade" id="unavailableDatesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 border-0 shadow-lg">
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title fw-bold" id="unavailableModalTitle"><i
              class="bi bi-calendar-x text-danger me-2"></i>Unavailable Dates</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pt-3">
          <p class="text-muted small mb-3">The following dates are currently booked for <strong
              id="unavailableRoomName">this room</strong>. Please select different dates.</p>
          <ul class="list-group list-group-flush" id="unavailableDatesList">
            <!-- Dynamically populated via JS -->
          </ul>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-secondary rounded-pill fw-bold" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter Offcanvas (Mobile) -->
  <div class="offcanvas offcanvas-start h-100 rounded-top-4" tabindex="-1" id="filterOffcanvas"
    aria-labelledby="filterOffcanvasLabel">
    <div class="offcanvas-header border-bottom px-4">
      <h5 class="offcanvas-title fw-bold" id="filterOffcanvasLabel">Filters</h5>
      <div class="d-flex align-items-center justify-content-end w-100 gap-3">
        <button class="btn btn-link text-primary text-decoration-none p-0 small fw-bold" id="resetAllFiltersMobile"
          data-max="{{ $maxFilteredPrice }}"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset All</button>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
    </div>
    <div class="offcanvas-body p-1">
      <div id="offcanvasFilterContent">
        <!-- Content will be moved here via JS -->
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    window.exchangeRate = {{ $activeCurrency->exchange_rate }};
    window.currencySymbol = '{{ $activeCurrency->symbol }}';
  </script>
  <script src="{{ asset('assets/js/rooms.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const unavailableModal = document.getElementById('unavailableDatesModal');
      if (unavailableModal) {
        unavailableModal.addEventListener('show.bs.modal', function (event) {
          const button = event.relatedTarget;
          const roomName = button.getAttribute('data-room-name');
          const dates = JSON.parse(button.getAttribute('data-dates'));

          document.getElementById('unavailableRoomName').textContent = roomName;

          const listContainer = document.getElementById('unavailableDatesList');
          listContainer.innerHTML = '';

          if (dates && dates.length > 0) {
            dates.forEach(function (dateParam) {
              const li = document.createElement('li');
              li.className = 'list-group-item d-flex align-items-center px-0 border-light';
              li.innerHTML = `<i class="bi bi-calendar-event text-danger me-3"></i> <span class="fw-bold">${dateParam.start}</span> <span class="text-muted mx-2">to</span> <span class="fw-bold">${dateParam.end}</span>`;
              listContainer.appendChild(li);
            });
          } else {
            listContainer.innerHTML = '<li class="list-group-item text-muted px-0 text-center border-0">No unavailable dates found.</li>';
          }
        });
      }
    });
  </script>
@endpush