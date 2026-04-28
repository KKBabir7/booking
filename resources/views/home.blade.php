@extends('layouts.main')

@section('content')
@section('content')
  <!-- Hero Section -->
  <section class="hero-section position-relative">
    <!-- Hero Slider -->
    <div class="hero-main-slider" id="hero-main-slider">
      @foreach($banners as $banner)
      <div class="hero-slide-item" style="background-image: url('{{ asset($banner->image) }}');">
        <div class="container h-100">
          <div class="row h-100 align-items-center">
            <div class="col-lg-7 text-start">
              <div class="hero-offer-text">
                <h1 class="hero-title fw-bold mb-3 animate-item-1">{{ $banner->title }}</h1>
                <p class="hero-subtitle mb-4 fw-light animate-item-2">{{ $banner->subtitle }}</p>
                <a href="{{ $banner->button_link }}" class="btn btn-primary rounded-pill px-5 py-3 btn-offer animate-item-3">{{ $banner->button_text }}</a>
              </div>
            </div>
            <div class="col-lg-5 text-end d-none d-lg-block">
              <div class="offer-banner-tag animate-item-1 {{ $banner->style_class }}">
                <div class="limited-time-tag">LIMITED OFFER</div>
                <div class="tag-content">
                  <span class="tag-label">{{ $banner->tag_label }}</span>
                  <span class="tag-value">{{ $banner->tag_value }}</span>
                  <span class="tag-off">{{ $banner->tag_off }}</span>
                </div>
                <div class="orbital-amenities">
                  <div class="amenity-dot" title="Luxury Stay"><i class="bi bi-gem"></i></div>
                  <div class="amenity-dot" title="Relaxing"><i class="bi bi-sun"></i></div>
                  <div class="amenity-dot" title="Spa"><i class="bi bi-water"></i></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Pill-shaped Search Bar Overlayed -->
    <div class="hero-search-wrapper mx-auto position-absolute start-50 translate-middle-x">
      <div class="hero-search-overlay">
        <form action="{{ route('rooms.index') }}" method="GET" class="hero-search-container d-flex align-items-center bg-white shadow-lg rounded-pill p-1 position-relative">
          <button type="button" class="btn btn-close d-none mobile-search-close" id="mobileSearchClose" aria-label="Close"></button>
          <!-- Where Section -->
          <div class="search-item flex-grow-1 text-start px-4 py-2" id="search-where">
            <div class="search-label fw-bold">Select Property</div>
            <input type="text" name="location" class="search-input-field border-0 bg-transparent w-100 p-0" id="location-input" placeholder="Choose Guest House" readonly autocomplete="off">
            <button type="button" class="search-clear-btn d-none" id="clear-where"><i class="bi bi-x"></i></button>

            <!-- Location Suggestions Panel -->
            <div class="search-panel location-panel shadow-lg rounded-4 d-none">
              <div class="panel-header px-4 py-3 border-bottom">
                <span class="text-muted small fw-bold uppercase">Suggested destinations</span>
              </div>
              <div class="panel-body py-2" id="location-results">
                <div class="suggestion-item d-flex align-items-center px-4 py-3" data-location="Main Branch">
                  <div class="suggestion-icon me-3 bg-light rounded-3 p-2"><i class="bi bi-building text-primary"></i></div>
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
            <input type="text" name="dates" id="date-range-picker" style="display: none;">
            <button type="button" class="search-clear-btn d-none" id="clear-when"><i class="bi bi-x"></i></button>
          </div>

          <div class="search-divider"></div>

          <!-- Who Section -->
          <div class="search-item flex-grow-1 text-start px-4 py-2 position-relative" id="search-who">
            <div class="search-label fw-bold">Guests</div>
            <div class="search-subtext text-dark fw-bold" id="guest-display">1 guest</div>
            <button type="button" class="search-clear-btn d-none" id="clear-who"><i class="bi bi-x"></i></button>

            <!-- Guest Counter Panel -->
            <div class="search-panel guest-panel shadow-lg rounded-4 d-none p-4">
              <!-- Adult row -->
              <div class="guest-row d-flex align-items-center justify-content-between mb-4">
                <div>
                  <div class="fw-bold">Adults</div>
                  <div class="text-muted small">Ages 13 or above</div>
                </div>
                <div class="counter-control d-flex align-items-center">
                  <button type="button" class="btn btn-outline-secondary rounded-circle btn-sm counter-btn minus" data-type="adults"><i class="bi bi-dash"></i></button>
                  <span class="mx-3 fw-bold count-val" id="count-adults">1</span>
                  <button type="button" class="btn btn-outline-secondary rounded-circle btn-sm counter-btn plus" data-type="adults"><i class="bi bi-plus"></i></button>
                </div>
              </div>
              <!-- Children row -->
              <div class="guest-row d-flex align-items-center justify-content-between mb-4">
                <div>
                  <div class="fw-bold">Children</div>
                  <div class="text-muted small">Ages 2 – 12</div>
                </div>
                <div class="counter-control d-flex align-items-center">
                  <button type="button" class="btn btn-outline-secondary rounded-circle btn-sm counter-btn minus" data-type="children"><i class="bi bi-dash"></i></button>
                  <span class="mx-3 fw-bold count-val" id="count-children">0</span>
                  <button type="button" class="btn btn-outline-secondary rounded-circle btn-sm counter-btn plus" data-type="children"><i class="bi bi-plus"></i></button>
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
                  <button type="button" class="btn btn-outline-secondary rounded-circle btn-sm counter-btn plus" data-type="pets"><i
                      class="bi bi-plus"></i></button>
                </div>
              </div>
              <!-- Hidden inputs for form submission -->
              <input type="hidden" name="adults" id="form-adults" value="{{ request('adults', 1) }}">
              <input type="hidden" name="children" id="form-children" value="{{ request('children', 0) }}">
            </div>
          </div>

          <button type="submit" class="btn rounded-circle search-submit-btn d-flex align-items-center justify-content-center">
            <i class="bi bi-search"></i>
          </button>
        </form>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sync guest counts to hidden form inputs before submit
            document.querySelectorAll('.counter-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    setTimeout(() => {
                        document.getElementById('form-adults').value = document.getElementById('count-adults').textContent;
                        document.getElementById('form-children').value = document.getElementById('count-children').textContent;
                    }, 50);
                });
            });
            document.getElementById('clear-who').addEventListener('click', () => {
                setTimeout(() => {
                    document.getElementById('form-adults').value = '1';
                    document.getElementById('form-children').value = '0';
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
                    document.getElementById('date-display').textContent = `${start.substring(4)} - ${end.substring(4)}`;
                    document.getElementById('date-display').classList.add('text-dark', 'fw-bold');
                    document.getElementById('date-display').classList.remove('text-muted');
                    document.getElementById('clear-when').classList.remove('d-none');
                }
            }
        });
        </script>
      </div>
    </div>
  </section>

  <!-- Available Offers Section -->
  <section class="available-offers-section py-5 bg-white d-none">
    <div class="container py-md-5">
      <div class="section-header d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">
        <div class="text-center text-md-start mb-3 mb-md-0">
          <h6 class="text-primary fw-bold text-uppercase ls-2 mb-2">Special Promotions</h6>
          <h2 class="display-5 fw-bold mb-0">Available Offers</h2>
        </div>
        <div class="d-none d-md-block">
          <p class="text-muted mb-0 max-w-400">
            Grab our handpicked limited-time deals and experience premium luxury at unbeatable prices.
          </p>
        </div>
      </div>

      <div class="available-offers-slider">
        <!-- Offer 1: Presidential Suite -->
        <div class="px-3">
          <div class="offer-premium-card">
            <img src="https://niceguesthouse.info/wp-content/uploads/2025/06/istockphoto-1453121684-612x612-2-1.jpg#313"
              alt="Executive Deluxe Room" class="destination-img">
            <div class="offer-badge-premium exclusive">Limited Time</div>
            <div class="offer-info-panel">
              <h4>Executive Deluxe</h4>
              <div class="offer-features-list">
                <span><i class="bi bi-door-open"></i> 1 Queen</span>
                <span><i class="bi bi-people"></i> 2A, 1C</span>
                <span><i class="bi bi-tree"></i> Natural</span>
              </div>
              <div class="offer-pricing-panel">
                <span class="offer-price-old">TK 450</span>
                <span class="offer-price-new">TK 320</span>
                <span class="offer-price-label"> / 38SQM</span>
              </div>
            </div>
            <button class="offer-claim-btn">
              Claim Offer <i class="bi bi-chevron-right"></i>
            </button>
          </div>
        </div>
        <!-- Offer 2: Honeymoon Special -->
        <div class="px-3">
          <div class="offer-premium-card">
            <img src="https://niceguesthouse.info/wp-content/uploads/2025/06/ED-300x300.jpeg"
              alt="Double Deluxe Room" class="destination-img">
            <div class="offer-badge-premium top-pick">Best Value</div>
            <div class="offer-info-panel">
              <h4>Double Deluxe</h4>
              <div class="offer-features-list">
                <span><i class="bi bi-door-open"></i> 2 Queen</span>
                <span><i class="bi bi-people"></i> 4 Adults</span>
                <span><i class="bi bi-image"></i> Scenery</span>
              </div>
              <div class="offer-pricing-panel">
                <span class="offer-price-old">TK 380</span>
                <span class="offer-price-new">TK 275</span>
                <span class="offer-price-label"> / 28SQM</span>
              </div>
            </div>
            <button class="offer-claim-btn">
              Claim Offer <i class="bi bi-chevron-right"></i>
            </button>
          </div>
        </div>
        <!-- Offer 3: Weekend Retreat -->
        <div class="px-3">
          <div class="offer-premium-card">
            <img src="https://niceguesthouse.info/wp-content/uploads/2025/06/ACC-300x225-1-300x300.jpeg"
              alt="Royal Class Room" class="destination-img">
            <div class="offer-badge-premium new-listing">Popular</div>
            <div class="offer-info-panel">
              <h4>Royal Class</h4>
              <div class="offer-features-list">
                <span><i class="bi bi-door-open"></i> King Size</span>
                <span><i class="bi bi-people"></i> 2A, 1C</span>
                <span><i class="bi bi-map"></i> Road View</span>
              </div>
              <div class="offer-pricing-panel">
                <span class="offer-price-old">TK 250</span>
                <span class="offer-price-new">TK 199</span>
                <span class="offer-price-label"> / 40SQM</span>
              </div>
            </div>
            <button class="offer-claim-btn">
              Claim Offer <i class="bi bi-chevron-right"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  @if($promoBanner)
  <!-- Special Promo Banner -->
  <section class="promo-banner-section py-5">
    <div class="container">
      <div class="row bg-dark rounded-4 overflow-hidden position-relative mx-0">
        <div class="col-lg-7 p-0 overflow-hidden">
          <img src="{{ asset($promoBanner->image) }}" class="img-fluid w-100 h-100 object-cover" style="min-height: 400px;" alt="{{ $promoBanner->title }}">
        </div>
        <div class="col-lg-5 d-flex align-items-center p-4 p-md-5 text-white">
          <div class="z-1">
            <span class="badge bg-primary mb-3">{{ $promoBanner->badge_text }}</span>
            <h3 class="display-6 fw-bold mb-3 text-white">{{ $promoBanner->title }}</h3>
            <div class="discount-tag display-4 fw-bold text-primary mb-3">{{ $promoBanner->discount_text }}</div>
            <p class="text-white-50 mb-4">{{ $promoBanner->subtitle }}</p>
            @if($promoBanner->link)
              <a href="{{ url($promoBanner->link) }}" class="btn btn-primary rounded-pill px-5 py-3">Claim Now</a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif

  <!-- Banner Offers Section (Bento Grid) -->
  @if($offerBanners->isNotEmpty())
  <section class="banner-offers-section py-4 bg-white mt-5">
    <div class="container pb-md-5 mt-5">
      <div class="bento-grid-offers">
        @foreach($offerBanners as $obanner)
        <div class="bento-item secondary-1">
          <div class="banner-offer-card shadow-sm rounded-4 overflow-hidden h-100" @if($obanner->link) onclick="window.location.href='{{ url($obanner->link) }}'" style="cursor: pointer;" @endif>
            <img src="{{ asset($obanner->image) }}" alt="Offer Banner" class="bento-img">
            <div class="banner-offer-overlay"></div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <!-- Our Services Section -->
  <section class="services-section py-5">
    <div class="container py-md-5">
      <div class="section-header d-flex justify-content-between align-items-end mb-5">
        <div>
          <h6 class="text-primary fw-bold text-uppercase ls-2 mb-2">We Offer</h6>
          <h2 class="display-5 fw-bold mb-0">Premium Services</h2>
        </div>
      </div>
      <div class="row g-4 justify-content-center">
        @foreach($services as $service)
        <div class="col-md-4">
          <div class="service-premium-card">
            <img src="{{ asset($service->image) }}" class="service-bg-img" alt="{{ $service->title }}">
            <div class="service-premium-overlay">
              <div class="service-premium-icon"><i class="bi {{ $service->icon }}"></i></div>
              <div class="service-premium-content">
                <h4>{{ $service->title }}</h4>
                <p>{{ $service->description }}</p>
              </div>
              <a href="{{ $service->link ?? '#' }}" class="service-learn-more">Learn More <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Featured Offers Section -->
  <section class="offers-section py-5 bg-light">
    <div class="container py-md-5">
      <div class="section-header d-flex justify-content-between align-items-end mb-5">
        <div>
          <h6 class="text-primary fw-bold text-uppercase ls-2 mb-2">Available</h6>
          <h2 class="display-5 fw-bold mb-0">Rooms and Suites</h2>
        </div>
        <div class="d-none d-md-block">
          <p class="text-muted mb-0 max-w-400">Discover our handpicked selection of luxury stays at unbeatable prices. Book your dream escape today.</p>
        </div>
      </div>

      <div class="offers-slider">
        @foreach($featuredRooms as $room)
        <div class="px-3">
          <div class="offer-card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white d-flex flex-column">
            <div class="offer-image-wrapper position-relative" @if($room->is_360_available) onclick="open3DViewer('{{ $room->panorama_url }}', '{{ $room->name }}')" @endif>
              <img src="{{ str_starts_with($room->image, 'http') ? $room->image : asset($room->image) }}" alt="{{ $room->name }}" class="offer-img w-100">
              
              @if($room->is_360_available)
              <div class="orbit-360-container">
                <div class="orbit-360-system">
                  <div class="orbit-ring one"></div>
                  <div class="orbit-ring two"></div>
                </div>
                <div class="orbit-label">360°</div>
              </div>
              <div class="view-360-overlay"></div>
              <button class="image-360-btn" onclick="event.stopPropagation(); open3DViewer('{{ $room->panorama_url }}', '{{ $room->name }}')">
                <i class="bi bi-arrow-repeat"></i>
              </button>
              @endif
              
              @auth
              <button class="wishlist-btn" onclick="event.stopPropagation(); toggleFavorite({{ $room->id }}, this)">
                <i class="bi {{ Auth::user()->favorites->contains('room_id', $room->id) ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
              </button>
              @else
              <button class="wishlist-btn" onclick="event.stopPropagation(); window.location.href='{{ route('register') }}'">
                <i class="bi bi-heart"></i>
              </button>
              @endauth
              
              @if($room->badge_text)
              <div class="offer-badge {{ \Illuminate\Support\Str::slug($room->badge_text) }}">{{ $room->badge_text }}</div>
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
                  <div class="mt-auto pt-3 border-top">
                    <!-- Pricing Section (Blue Mark) -->
                    <div class="offer-pricing-area d-flex justify-content-end pb-2">
                        <div class="pricing-flex d-flex align-items-center">
                          @if($nights > 1)
                            <div class="price-current fw-bolder text-dark fs-4 lh-1">{{ $currencyService->format($room->price * $nights) }}</div>
                          @else
                            @if($room->old_price > $room->price)
                              <div class="price-old text-muted extra-small me-2"><del>{{ $currencyService->format($room->old_price) }}</del></div>
                            @endif
                            <div class="price-current fw-bolder text-dark fs-4 lh-1">{{ $currencyService->format($room->price) }}</div>
                          @endif
                        </div>
                    </div>

                    <!-- Actions Section (Red Mark) -->
                    <div class="offer-action-bottom d-flex align-items-center justify-content-between">
                      <div class="left-action">
                        @if($room->bookings && $room->bookings->count() > 0)
                          <a href="#" class="text-danger fw-bold d-flex align-items-center text-decoration-none bg-danger bg-opacity-10 px-2 py-1 rounded-pill d-inline-block text-center" style="font-size: 0.65rem; width: max-content;"
                                  data-bs-toggle="modal" data-bs-target="#unavailableDatesModal"
                                  data-room-name="{{ $room->name }}"
                                  data-dates='{{ $room->bookings->map(function ($b) { return ["start" => \Carbon\Carbon::parse($b->check_in)->format("d M Y"), "end" => \Carbon\Carbon::parse($b->check_out)->format("d M Y")]; })->toJson() }}'
                                  onclick="event.stopPropagation();">
                            <i class="bi bi-calendar-x me-1"></i> Unavailable Dates
                          </a>
                        @else
                          <!-- Invisible placeholder to enforce identical footer heights across all cards, preventing ugly flexbox gaps -->
                          <div class="px-2 py-1 mb-0" style="font-size: 0.65rem; visibility: hidden; pointer-events: none;">
                            <i class="bi bi-calendar-x me-1"></i> Space
                          </div>
                        @endif
                      </div>

                      <div class="right-action">
                        <span class="text-primary fw-bold d-flex align-items-center" style="font-size: 0.9rem;">
                          View deal <i class="bi bi-chevron-right ms-1" style="font-size: 0.8rem;"></i>
                        </span>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <div class="text-center mt-5">
        <a href="{{ route('rooms.index') }}" class="btn btn-primary btn-modern btn-lg px-5 py-3 rounded-3 shadow-sm fw-bold">
          See More Room <i class="bi bi-arrow-right ms-2"></i>
        </a>
      </div>
    </div>
  </section>

  <!-- Restaurant Summarization Section -->
  <section class="dining-summary-section py-5 bg-white ">
    <div class="container py-md-5">
      <div class="row  g-5">
        <div class="col-lg-6">
          <div class="section-header mb-4">
            <h6 class="text-primary fw-bold text-uppercase ls-2 mb-2">{{ $restaurantSettings['restaurant_subtitle'] ?? 'Culinary Excellence' }}</h6>
            <h1 class="display-5 fw-bold mb-4">{!! $restaurantSettings['restaurant_title'] ?? 'Restaurant at <br> Nice Guest House' !!}</h1>
          </div>
          <p class="text-muted lead mb-4">
            {{ $restaurantSettings['restaurant_desc'] ?? "Indulge in a world of flavor with our diverse menu featuring authentic Thai, Chinese, Indian, and local Deshi delicacies. Whether you're seeking a scenic rooftop view or a refined indoor ambiance, our three distinct restaurants offer an unforgettable dining experience." }}
          </p>
          <div class="row g-2 mb-5 row-cols-2 row-cols-md-4">
            @php
                $defaultFeatures = [
                    ['icon' => 'bi bi-egg-fried', 'text' => '3 Restaurants'],
                    ['icon' => 'bi bi-clouds', 'text' => 'Rooftop View'],
                    ['icon' => 'bi bi-shield-check', 'text' => 'Fresh & Hygienic'],
                    ['icon' => 'bi bi-building', 'text' => '7th Floor Dining'],
                    ['icon' => 'bi bi-brightness-high', 'text' => 'Thai Specialties'],
                    ['icon' => 'bi bi-tencent-qq', 'text' => 'Chinese Cuisine'],
                    ['icon' => 'bi bi-fire', 'text' => 'Indian Flavors'],
                    ['icon' => 'bi bi-house-heart', 'text' => 'Local Deshi Food']
                ];
                $features = isset($restaurantSettings['restaurant_features']) ? json_decode($restaurantSettings['restaurant_features'], true) : $defaultFeatures;
            @endphp
            @foreach($features as $feature)
                @if(!empty($feature['text']))
                <div class="col"><div class="conf-feature-card"><i class="{{ $feature['icon'] ?? 'bi bi-star' }}"></i><span class="fw-bold">{{ $feature['text'] }}</span></div></div>
                @endif
            @endforeach
          </div>
          <a href="{{ url($restaurantSettings['restaurant_btn_link'] ?? route('restaurant.index')) }}" class="btn btn-primary btn-modern btn-lg px-5 py-3 rounded-3 shadow-sm">
            {{ $restaurantSettings['restaurant_btn_text'] ?? 'Explore Our Dining' }} <i class="bi bi-arrow-right ms-2"></i>
          </a>
        </div>
        <div class="col-lg-6">
          <div class="overlapping-image-container mt-5">
            <img src="{{ isset($restaurantSettings['restaurant_img_main']) ? asset($restaurantSettings['restaurant_img_main']) : asset('assets/img/restaurant/rest-small.jpg') }}" alt="Restaurant Image" class="main-image">
            <img src="{{ isset($restaurantSettings['restaurant_img_secondary']) ? asset($restaurantSettings['restaurant_img_secondary']) : asset('assets/img/restaurant/rest-big.jpg') }}" alt="Delicious Cuisine Image" class="secondary-image">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Conference Summary Section -->
  <section class="conference-summary-section py-5 bg-white">
    <div class="container py-md-5">
      <div class="row g-5 flex-row-reverse align-items-center">
        <div class="col-lg-6">
          <div class="section-header mb-4">
            <h6 class="text-primary fw-bold text-uppercase ls-2 mb-2">{{ $conferenceSettings['conference_subtitle'] ?? 'Premium Venues' }}</h6>
            <h2 class="display-5 fw-bold mb-4">{!! $conferenceSettings['conference_title'] ?? 'World-Class <br> Conference Facilities' !!}</h2>
          </div>
          <p class="text-muted lead mb-4">
            {{ $conferenceSettings['conference_description'] ?? "Host your next event in our premium conference halls equipped with state-of-the-art technology and flexible layouts. Whether it's a corporate seminar, a private meeting, or a grand social gathering, we provide the perfect ambiance for success." }}
          </p>
          <div class="row g-2 mb-5 row-cols-2 row-cols-md-4">
            @php
                $confFeatures = isset($conferenceSettings['conference_features']) ? json_decode($conferenceSettings['conference_features'], true) : [];
            @endphp
            @forelse($confFeatures as $feature)
            <div class="col">
              <div class="conf-feature-card">
                <i class="{{ $feature['icon'] ?? 'bi bi-check-circle' }}"></i>
                <span class="fw-bold">{{ $feature['text'] ?? '' }}</span>
              </div>
            </div>
            @empty
            @endforelse
          </div>
          <a href="{{ $conferenceSettings['conference_btn_link'] ?? '#' }}" class="btn btn-primary btn-modern btn-lg px-5 py-3 rounded-3 shadow-sm">
            {{ $conferenceSettings['conference_btn_text'] ?? 'Explore Venues' }} <i class="bi bi-arrow-right ms-2"></i>
          </a>
        </div>
        <div class="col-lg-6">
          <div class="overlapping-image-container image-left mt-5">
            @php
                $confImgMain = isset($conferenceSettings['conference_img_main']) ? asset($conferenceSettings['conference_img_main']) : asset('assets/img/conference/conf-big.jpg');
                $confImgSecondary = isset($conferenceSettings['conference_img_secondary']) ? asset($conferenceSettings['conference_img_secondary']) : asset('assets/img/conference/conf-small.jpg');
            @endphp
            <img src="{{ $confImgMain }}" alt="Premium Conference Hall" class="main-image shadow-lg">
            <img src="{{ $confImgSecondary }}" alt="Modern Boardroom" class="secondary-image shadow-lg">
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- Honorable Clients Infinite Marquee Section -->
  <section class="clients-marquee-section py-5">
    <div class="container py-md-0">
      <div class="section-header d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">
        <div class="text-center text-md-start mb-3 mb-md-0">
          <h6 class="text-primary fw-bold text-uppercase ls-2 mb-2">Our Elite Partners</h6>
          <h2 class="display-5 fw-bold mb-0">Our Clients</h2>
        </div>
        <div class="d-none d-md-block text-md-end">
          <p class="text-muted mb-0 max-w-400">
            Trusted by global leaders and national giants, we pride ourselves on delivering excellence since 2007.
          </p>
        </div>
      </div>
    </div>

    <div class="marquee-container">
      <!-- Row 1: Scrolling Left -->
      <div class="marquee-track">
        @foreach($clients as $client)
        <div class="marquee-item">
            <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}">
            <span>{{ $client->name }}</span>
        </div>
        @endforeach
        {{-- Duplicate for Infinite Loop (at least 2x or 3x depending on count) --}}
        @foreach($clients as $client)
        <div class="marquee-item">
            <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}">
            <span>{{ $client->name }}</span>
        </div>
        @endforeach
        @if($clients->count() < 10)
            @foreach($clients as $client)
            <div class="marquee-item">
                <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}">
                <span>{{ $client->name }}</span>
            </div>
            @endforeach
        @endif
      </div>

      <!-- Row 2: Scrolling Right -->
      <div class="marquee-track">
        @foreach($clients->reverse() as $client)
        <div class="marquee-item">
            <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}">
            <span>{{ $client->name }}</span>
        </div>
        @endforeach
        {{-- Duplicate for Infinite Loop --}}
        @foreach($clients->reverse() as $client)
        <div class="marquee-item">
            <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}">
            <span>{{ $client->name }}</span>
        </div>
        @endforeach
        @if($clients->count() < 10)
            @foreach($clients->reverse() as $client)
            <div class="marquee-item">
                <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}">
                <span>{{ $client->name }}</span>
            </div>
            @endforeach
        @endif
      </div>
    </div>

    <div class="text-center mt-5">
      <a href="#" class="btn btn-primary btn-modern btn-lg px-5 py-3 rounded-3 shadow-sm fw-bold">
        View All Partners <i class="bi bi-arrow-right ms-2"></i>
      </a>
    </div>
  </section>


  <!-- Trending Destinations Section -->
  <section class="trending-section py-5">
    <div class="container py-md-5">
      <div class="section-header d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">
        <div class="text-center text-md-start mb-3 mb-md-0">
          <h6 class="text-primary fw-bold text-uppercase ls-2 mb-2">Noakhali Tourism</h6>
          <h2 class="display-5 fw-bold mb-0">Explore Noakhali best travel places</h2>
        </div>
        <div class="d-none d-md-block text-md-end">
          <p class="text-muted mb-0 max-w-400">
            Discover the hidden gems and breathtaking landscapes of Noakhali. From historic sites to serene natural
            beauty, explore the best of our local heritage.
          </p>
        </div>
      </div>

      <!-- Top Row: 2 Large Cards -->
      <div class="row g-4 mb-4">
        <div class="col-md-6">
          <div class="trending-card destination-card-lg">
            <img src="{{ asset('assets/img/place/noa-1.jpg') }}" alt="Nijhum Dwip" class="destination-img">
            <div class="card-gradient-overlay"></div>
            <div class="destination-label">
              <span>Nijhum Dwip</span>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="trending-card destination-card-lg">
            <img src="{{ asset('assets/img/place/noa-2.jpg') }}" alt="Bajra Shahi Mosque" class="destination-img">
            <div class="card-gradient-overlay"></div>
            <div class="destination-label">
              <span>Bajra Shahi Mosque</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom Row: 3 Small Cards -->
      <div class="row g-4">
        <div class="col-md-4">
          <div class="trending-card destination-card-sm">
            <img src="{{ asset('assets/img/place/monpura.jpg') }}" alt="Monpura Dwip" class="destination-img">
            <div class="card-gradient-overlay"></div>
            <div class="destination-label">
              <span>Monpura Dwip</span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="trending-card destination-card-sm">
            <img src="{{ asset('assets/img/place/hatia dwip.jpg') }}" alt="Hatia" class="destination-img">
            <div class="card-gradient-overlay"></div>
            <div class="destination-label">
              <span>Hatia</span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="trending-card destination-card-sm">
            <img src="{{ asset('assets/img/place/noa-5.jpg') }}" alt="Musapur" class="destination-img">
            <div class="card-gradient-overlay"></div>
            <div class="destination-label">
              <span>Musapur</span>
            </div>
          </div>
        </div>
      </div>
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

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const datesModal = document.getElementById('unavailableDatesModal');
      if (datesModal) {
        datesModal.addEventListener('show.bs.modal', function (event) {
          const button = event.relatedTarget;
          const roomName = button.getAttribute('data-room-name');
          const datesJson = button.getAttribute('data-dates');

          document.getElementById('unavailableRoomName').textContent = roomName;
          const list = document.getElementById('unavailableDatesList');
          list.innerHTML = '';

          try {
            const datesArr = JSON.parse(datesJson);
            if (datesArr.length > 0) {
              datesArr.forEach(d => {
                list.innerHTML += `<li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2 border-bottom"><span class="fw-bold text-dark"><i class="bi bi-calendar-event me-2 text-danger"></i>${d.start}</span> <i class="bi bi-arrow-right text-muted small mx-2"></i> <span class="fw-bold text-dark">${d.end}</span></li>`;
              });
            } else {
              list.innerHTML = '<li class="list-group-item text-success border-0 px-0"><i class="bi bi-check-circle me-2"></i>Currently available</li>';
            }
          } catch (e) {
            console.error("Error parsing dates", e);
          }
        });
      }
    });
  </script>
@endsection
