@extends('layouts.main')

@section('navClass', 'sticky-nav-dark')

@push('styles')
  <!-- PhotoSwipe v5 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/photoswipe@5.4.3/dist/photoswipe.css" />
@endpush

@section('content')
  <!-- Gallery Section -->
  <section class="room-gallery-section pt-5">
    <div class="container-fluid px-md-5 pt-5">
      <div class="d-flex flex-wrap justify-content-between align-items-center align-items-md-end gap-3 mb-3 pt-5">
        <div class="room-title-area">
          <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-primary text-decoration-none">Home</a>
              </li>
              <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}"
                  class="text-primary text-decoration-none">Rooms</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $room->name }}</li>
            </ol>
          </nav>
          <h2 class="fw-bold mb-0">{{ $room->name }}</h2>
          <p class="text-muted small mb-0"><i class="bi bi-geo-alt me-1"></i> Uzzalpur, Maijdee Court</p>
        </div>
        <div class="d-flex gap-2 room-actions">
          <button class="btn btn-outline-dark btn-sm rounded-pill px-3 action-btn"><i class="bi bi-share me-md-1"></i>
            <span class="d-none d-md-inline">Share</span></button>
          <button class="btn btn-outline-dark btn-sm rounded-pill px-3 action-btn"><i class="bi bi-heart me-md-1"></i>
            <span class="d-none d-md-inline">Save</span></button>
        </div>
      </div>

      <div class="gallery-grid rounded-4 overflow-hidden shadow-sm" id="room-gallery">
        <div class="gallery-main">
          <a href="{{ str_starts_with($room->image, 'http') ? $room->image : asset($room->image) }}"
            data-pswp-width="1600" data-pswp-height="1066" target="_blank" class="gallery-link h-100 d-block">
            <img src="{{ str_starts_with($room->image, 'http') ? $room->image : asset($room->image) }}"
              alt="{{ $room->name }}" class="gallery-img active">
          </a>
        </div>
        <div class="gallery-side grid-2x2">
          @php
            $sideImages = is_array($room->gallery_images) && count($room->gallery_images) > 0 ? $room->gallery_images : [
              'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=800&q=80',
              'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=800&q=80',
              'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?auto=format&fit=crop&w=800&q=80',
              'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80'
            ];
          @endphp
          @foreach(array_slice($sideImages, 0, 4) as $index => $img)
            @php $realImg = str_starts_with($img, 'http') ? $img : asset($img); @endphp
            <div class="{{ $index === 3 ? 'position-relative h-100' : '' }}">
              <a href="{{ $realImg }}" data-pswp-width="1600" data-pswp-height="1066" target="_blank"
                class="gallery-link h-100 d-block">
                <img src="{{ $realImg }}" alt="Side {{ $index + 1 }}" class="gallery-img">
              </a>
              @if($index === 3)
                <button class="btn btn-light btn-sm position-absolute bottom-0 end-0 m-3 shadow-sm rounded-3 fw-bold"
                  id="openMainGallery">
                  <i class="bi bi-grid-3x3-gap me-1"></i> Show all photos
                </button>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="room-content-section py-5">
    <div class="container-fluid px-md-5">
      <div class="row g-5 room-content-row">
        <!-- Left Column: Details -->
        <div class="col-lg-8">
          <div class="room-intro  pb-2 mb-0">
            <div class="d-flex justify-content-between align-items-start mb-3">
              <div>
                <h4 class="fw-bold">Experience Luxury in our {{ $room->name }}</h4>
                <div class="d-flex align-items-center gap-3 text-muted small">
                  @if(is_array($room->attributes) && count($room->attributes) > 0)
                    <span>
                      @foreach(array_slice($room->attributes, 0, 3) as $attr)
                        {{ $attr['key'] ?? '' }}: {{ $attr['value'] ?? '' }}@if(!$loop->last) · @endif
                      @endforeach
                    </span>
                  @else
                    <span>Capacity: {{ $room->capacity_adults }} Adults, {{ $room->capacity_children }} Child · Bed:
                      {{ $room->bed_type }} · {{ $room->room_size }} sqm</span>
                  @endif
                </div>
              </div>
              <div class="rating-box d-flex align-items-center flex-column rounded-1">
                <div class="rating-badge  d-flex align-items-center gap-2">
                  <i class="bi bi-star-fill text-warning fs-5"></i>
                  <span class="fw-bold fs-6 mb-0 text-white">{{ number_format($room->rating, 1) }}</span>
                </div>
                <a style="font-size: 10px;" href="#reviews-tab-linkss" class="text-dark text-decoration-underline"
                  id="jumpToReviews">{{ $room->review_count }} Reviews</a>
              </div>
            </div>

            <!-- Maximum Room Capacity Section -->
            <div class="room-capacity-section mt-4 p-3 bg-light rounded-4 border-dashed border-primary-light">
              <div class="d-flex align-items-center mb-3">
                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                <h6 class="fw-bold mb-0 text-dark uppercase tracking-wider small">Maximum Room Capacity</h6>
              </div>
              <div class="row g-3">
                <div class="col-6 col-md-3">
                  <div class="capacity-item d-flex align-items-center gap-2">
                    <div class="capacity-icon-sm bg-white shadow-sm  p-1">
                      <i class="bi bi-people-fill text-indigo-400"></i>
                    </div>
                    <div class="capacity-info">
                      <div class="fw-bold extra-small text-dark">{{ $room->capacity_adults ?? 0 }} Adults</div>
                      <div class="text-muted" style="font-size: 9px;">Ages 13+</div>
                    </div>
                  </div>
                </div>
                <div class="col-6 col-md-3">
                  <div class="capacity-item d-flex align-items-center gap-2">
                    <div class="capacity-icon-sm bg-white shadow-sm  p-1">
                      <i class="bi bi-person-fill text-emerald-400"></i>
                    </div>
                    <div class="capacity-info">
                      <div class="fw-bold extra-small text-dark">{{ $room->capacity_children ?? 0 }} Children</div>
                      <div class="text-muted" style="font-size: 9px;">Ages 2-12</div>
                    </div>
                  </div>
                </div>
                <div class="col-6 col-md-3">
                  <div class="capacity-item d-flex align-items-center gap-2">
                    <div class="capacity-icon-sm bg-white shadow-sm  p-1">
                      <i class="bi bi-egg-fill text-amber-400"></i>
                    </div>
                    <div class="capacity-info">
                      <div class="fw-bold extra-small text-dark">{{ $room->capacity_infants ?? 0 }} Infants</div>
                      <div class="text-muted" style="font-size: 9px;">Under 2</div>
                    </div>
                  </div>
                </div>
                <div class="col-6 col-md-3">
                  <div class="capacity-item d-flex align-items-center gap-2">
                    <div class="capacity-icon-sm bg-white shadow-sm  p-1">
                      <svg style="color: #fb7185;" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M8.5 6.5C8.5 5.12 7.38 4 6 4S3.5 5.12 3.5 6.5C3.5 7.88 4.62 9 6 9S8.5 7.88 8.5 6.5M12 8C13.66 8 15 6.66 15 5S13.66 2 12 2S9 3.34 9 5C9 6.66 10.34 8 12 8M18 4C16.62 4 15.5 5.12 15.5 6.5C15.5 7.88 16.62 9 18 9S20.5 7.88 20.5 6.5C20.5 5.12 19.38 4 18 4M19.46 11.2C18.42 10.5 17.5 10 16 10H14V9.5C14 8.67 13.33 8 12.5 8H11.5C10.67 8 10 8.67 10 9.5V10H8C6.5 10 5.58 10.5 4.54 11.2C3.12 12.16 2.5 13.78 2.5 15.5V19C2.5 20.1 3.4 21 4.5 21H19.5C20.6 21 21.5 20.1 21.5 19V15.5C21.5 13.78 20.88 12.16 19.46 11.2Z" />
                      </svg>
                    </div>
                    <div class="capacity-info">
                      <div class="fw-bold extra-small text-dark">{{ $room->capacity_pets ?? 0 }} Pets</div>
                      <div class="text-muted" style="font-size: 9px;">Service Allowed</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="feature-highlights d-flex flex-wrap gap-4 pt-4 mb-4">
            <div class="highlight-item d-flex align-items-center">
              <div class="highlight-icon me-3 bg-white shadow-sm rounded-3">
                <i class="bi bi-door-open fs-4 text-primary"></i>
              </div>
              <div>
                <div class="fw-bold small">Self check-in</div>
                <div class="text-muted extra-small">Check yourself in with the keypad.</div>
              </div>
            </div>
            <div class="highlight-item d-flex align-items-center">
              <div class="highlight-icon me-3 bg-white shadow-sm rounded-3">
                <i class="bi bi-geo-alt fs-4 text-primary"></i>
              </div>
              <div>
                <div class="fw-bold small">Great location</div>
                <div class="text-muted extra-small">100% of guest rated the location 5-star.</div>
              </div>
            </div>
            <div class="highlight-item d-flex align-items-center">
              <div class="highlight-icon me-3 bg-white shadow-sm rounded-3">
                <i class="bi bi-calendar-check fs-4 text-primary"></i>
              </div>
              <div>
                <div class="fw-bold small">Free cancellation</div>
                <div class="text-muted extra-small">Full refund before 48 hours.</div>
              </div>
            </div>
          </div>

          <!-- Description Tabs -->
          <div class="room-tabs mb-5">
            <ul class="nav nav-pills mb-3 border-bottom pb-2" id="roomTabs" role="tablist">
              <li class="nav-item">
                <button class="nav-link active fw-bold" id="desc-tab" data-bs-toggle="pill" data-bs-target="#desc"
                  type="button">Description</button>
              </li>
              <li class="nav-item">
                <button class="nav-link fw-bold" id="policy-tab" data-bs-toggle="pill" data-bs-target="#policy"
                  type="button">Room Rules</button>
              </li>
              <li class="nav-item">
                <button class="nav-link fw-bold" id="reviews-tab-link" type="button">Reviews
                  ({{ $room->review_count }})</button>
              </li>
              <li class="nav-item">
                <button class="nav-link fw-bold" id="faq-tab" data-bs-toggle="pill" data-bs-target="#faq"
                  type="button">FAQs</button>
              </li>
            </ul>
            <div class="tab-content pt-2" id="roomTabsContent">
              <div class="tab-pane fade show active" id="desc">
                <p class="text-muted">{{ $room->description }}</p>
                <div class="row pt-2 g-3">
                  @if(is_array($room->attributes) && count($room->attributes) > 0)
                    @foreach($room->attributes as $attr)
                      <div class="col-sm-6">
                        <ul class="list-unstyled text-muted small mb-0">
                          <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i> {{ $attr['key'] ?? '' }}:
                            {{ $attr['value'] ?? '' }}
                          </li>
                        </ul>
                      </div>
                    @endforeach
                  @else
                    <div class="col-sm-6">
                      <ul class="list-unstyled text-muted small">
                        <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i> Bed: {{ $room->bed_type }}
                        </li>
                        <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i> Capacity:
                          {{ $room->capacity_adults }} Adults, {{ $room->capacity_children }} Child
                        </li>
                      </ul>
                    </div>
                    <div class="col-sm-6">
                      <ul class="list-unstyled text-muted small">
                        <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i> View: {{ $room->view_type }}
                        </li>
                        <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i> Room Size:
                          {{ $room->room_size }} sqm
                        </li>
                      </ul>
                    </div>
                  @endif
                </div>
              </div>
              <div class="tab-pane fade" id="policy">
                <div class="row">
                  <div class="col-md-12">
                    <h6 class="fw-bold mb-3">House Rules & Policies</h6>
                    <ul class="list-unstyled text-muted small">
                      @if(is_array($room->rules) && count($room->rules) > 0)
                        @foreach($room->rules as $rule)
                          <li class="mb-2"><i class="bi bi-info-circle me-2"></i> {{ $rule }}</li>
                        @endforeach
                      @else
                        <li class="mb-2"><i class="bi bi-clock me-2"></i> Check-in: 12:00 PM</li>
                        <li class="mb-2"><i class="bi bi-clock-history me-2"></i> Check-out: 11:30 AM</li>
                        <li class="mb-2"><i class="bi bi-slash-circle me-2"></i> No smoking inside</li>
                        <li class="mb-2"><i class="bi bi-dash-circle me-2"></i> No pets allowed</li>
                      @endif
                    </ul>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="faq">
                <div class="accordion accordion-flush" id="faqAccordion">
                  @if(is_array($room->faqs) && count($room->faqs) > 0)
                    @foreach($room->faqs as $index => $faq)
                      <div class="accordion-item border-0 bg-transparent">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed bg-transparent px-0 fw-bold border-bottom" type="button"
                            data-bs-toggle="collapse" data-bs-target="#q{{ $index }}">
                            {{ $faq['question'] }}
                          </button>
                        </h2>
                        <div id="q{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                          <div class="accordion-body px-0 text-muted small">
                            {{ $faq['answer'] }}
                          </div>
                        </div>
                      </div>
                    @endforeach
                  @else
                    <p class="text-muted small">No FAQs available for this room.</p>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="amenities-section mb-5">
            <h5 class="fw-bold mb-4">What this place offers</h5>
            <div class="row g-4 amenity-grid">
              @if(is_array($room->amenities) && count($room->amenities) > 0)
                @foreach($room->amenities as $amenity)
                  <div class="col-6 col-md-4">
                    <div class="amenity-item d-flex align-items-center">
                      <i
                        class="{{ is_array($amenity) ? ($amenity['icon'] ?? 'bi bi-star') : 'bi bi-star' }} me-3 fs-5 text-indigo-500"></i>
                      <span class="small">{{ is_array($amenity) ? ($amenity['text'] ?? '') : $amenity }}</span>
                    </div>
                  </div>
                @endforeach
              @else
                <div class="col-12">
                  <p class="text-muted small">No amenities listed.</p>
                </div>
              @endif
            </div>
          </div>

          <!-- Detailed Reviews Section -->
          <div class="reviews-section py-5 border-top" id="reviews-section">
            <div class="d-flex align-items-center gap-2 mb-4">
              <i class="bi bi-star text-warning fs-4 position-relative" style="top: -2px;"></i>
              <h4 class="fw-bold mb-0" id="reviews-tab-linkss">{{ number_format($room->rating, 2) }} ·
                {{ $room->review_count }} Reviews
              </h4>
            </div>

            @php
              $reviews = $room->reviews;
              $avgCleanliness = $reviews->avg('cleanliness_rating') ?? 5;
              $avgCommunication = $reviews->avg('communication_rating') ?? 5;
              $avgCheckin = $reviews->avg('checkin_rating') ?? 5;
              $avgAccuracy = $reviews->avg('accuracy_rating') ?? 5;
              $avgLocation = $reviews->avg('location_rating') ?? 5;
              $avgValue = $reviews->avg('value_rating') ?? 5;
            @endphp

            @if($reviews->count() > 0)
              <div class="row mb-5 g-4 pe-md-5">
                <div class="col-md-6">
                  <!-- Cleanliness -->
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small text-muted">Cleanliness</span>
                    <div class="d-flex align-items-center gap-2 w-50 justify-content-end">
                      <div class="progress flex-grow-1" style="height: 4px;">
                        <div class="progress-bar bg-dark" role="progressbar"
                          style="width: {{ ($avgCleanliness / 5) * 100 }}%"></div>
                      </div>
                      <span class="small fw-bold">{{ number_format($avgCleanliness, 1) }}</span>
                    </div>
                  </div>
                  <!-- Communication -->
                  <div class="d-flex justify-content-between align-items-center mb-1 mt-3">
                    <span class="small text-muted">Communication</span>
                    <div class="d-flex align-items-center gap-2 w-50 justify-content-end">
                      <div class="progress flex-grow-1" style="height: 4px;">
                        <div class="progress-bar bg-dark" role="progressbar"
                          style="width: {{ ($avgCommunication / 5) * 100 }}%"></div>
                      </div>
                      <span class="small fw-bold">{{ number_format($avgCommunication, 1) }}</span>
                    </div>
                  </div>
                  <!-- Check-in -->
                  <div class="d-flex justify-content-between align-items-center mb-1 mt-3">
                    <span class="small text-muted">Check-in</span>
                    <div class="d-flex align-items-center gap-2 w-50 justify-content-end">
                      <div class="progress flex-grow-1" style="height: 4px;">
                        <div class="progress-bar bg-dark" role="progressbar" style="width: {{ ($avgCheckin / 5) * 100 }}%">
                        </div>
                      </div>
                      <span class="small fw-bold">{{ number_format($avgCheckin, 1) }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <!-- Accuracy -->
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small text-muted">Accuracy</span>
                    <div class="d-flex align-items-center gap-2 w-50 justify-content-end">
                      <div class="progress flex-grow-1" style="height: 4px;">
                        <div class="progress-bar bg-dark" role="progressbar" style="width: {{ ($avgAccuracy / 5) * 100 }}%">
                        </div>
                      </div>
                      <span class="small fw-bold">{{ number_format($avgAccuracy, 1) }}</span>
                    </div>
                  </div>
                  <!-- Location -->
                  <div class="d-flex justify-content-between align-items-center mb-1 mt-3">
                    <span class="small text-muted">Location</span>
                    <div class="d-flex align-items-center gap-2 w-50 justify-content-end">
                      <div class="progress flex-grow-1" style="height: 4px;">
                        <div class="progress-bar bg-dark" role="progressbar" style="width: {{ ($avgLocation / 5) * 100 }}%">
                        </div>
                      </div>
                      <span class="small fw-bold">{{ number_format($avgLocation, 1) }}</span>
                    </div>
                  </div>
                  <!-- Value -->
                  <div class="d-flex justify-content-between align-items-center mb-1 mt-3">
                    <span class="small text-muted">Value</span>
                    <div class="d-flex align-items-center gap-2 w-50 justify-content-end">
                      <div class="progress flex-grow-1" style="height: 4px;">
                        <div class="progress-bar bg-dark" role="progressbar" style="width: {{ ($avgValue / 5) * 100 }}%">
                        </div>
                      </div>
                      <span class="small fw-bold">{{ number_format($avgValue, 1) }}</span>
                    </div>
                  </div>
                </div>
              </div>
            @endif

            <!-- Individual Guest Reviews -->
            <div class="row g-5 guest-reviews-list">
              @forelse ($reviews as $review)
                @php
                  $reviewerName = $review->is_fake ? ($review->fake_guest_name ?: 'Verified Guest') : ($review->user->name ?? 'Guest');
                  $reviewerImage = $review->is_fake ? $review->fake_guest_image : null;
                @endphp
                <div class="col-md-6 review-item">
                  <div class="d-flex align-items-center mb-3">
                    @if($reviewerImage)
                      <img src="{{ str_starts_with($reviewerImage, 'http') ? $reviewerImage : asset($reviewerImage) }}"
                        class="rounded-circle me-3" style="width: 48px; height: 48px; object-fit: cover;"
                        alt="{{ $reviewerName }}">
                    @else
                      <div class="rounded-circle me-3 d-flex justify-content-center align-items-center fw-bold"
                        style="width: 48px; height: 48px; font-size: 1.2rem; background: #f3f4f6; color: #374151;">
                        {{ strtoupper(substr($reviewerName, 0, 1)) }}
                      </div>
                    @endif
                    <div>
                      <h6 class="fw-bold mb-0 text-dark d-flex align-items-center flex-wrap gap-2">
                        {{ $reviewerName }}
                        <span
                          class="ms-1 px-2 py-0.5 bg-warning-subtle text-warning rounded-pill extra-small d-flex align-items-center gap-1 border border-warning-subtle">
                          <i class="bi bi-star-fill shadow-none"></i>
                          <span class="fw-black">{{ number_format($review->rating, 1) }}</span>
                        </span>
                      </h6>
                      <div class="text-muted extra-small">{{ $review->created_at->format('F Y') }} · Verified Guest</div>
                    </div>
                  </div>
                  <p class="text-muted small mb-0">{{ $review->comment }}</p>
                </div>
              @empty
                <div class="col-12">
                  <p class="text-muted small">No reviews yet for this room. Be the first to share your experience!</p>
                </div>
              @endforelse
            </div>

            @if($room->reviews->count() > 4)
              <button class="btn btn-outline-dark rounded-pill px-4 mt-5 fw-bold shadow-none" id="showMoreReviews">Show more
                reviews</button>
            @endif

            <!-- Review Submission Form -->
            @auth
              <div class="mt-5 pt-4 border-top">
                <h5 class="fw-bold mb-4">Leave a Review</h5>
                <form action="{{ route('reviews.store') }}" method="POST"
                  class="bg-slate-50 p-4 rounded-4 border border-slate-200">
                  @csrf
                  <input type="hidden" name="room_id" value="{{ $room->id }}">

                  <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                      <label class="form-label small fw-bold text-slate-700">Cleanliness</label>
                      <input type="range" class="form-range" name="cleanliness_rating" min="1" max="5" value="5"
                        oninput="this.nextElementSibling.value = this.value">
                      <output class="fw-bold small text-primary">5</output>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label small fw-bold text-slate-700">Communication</label>
                      <input type="range" class="form-range" name="communication_rating" min="1" max="5" value="5"
                        oninput="this.nextElementSibling.value = this.value">
                      <output class="fw-bold small text-primary">5</output>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label small fw-bold text-slate-700">Check-in</label>
                      <input type="range" class="form-range" name="checkin_rating" min="1" max="5" value="5"
                        oninput="this.nextElementSibling.value = this.value">
                      <output class="fw-bold small text-primary">5</output>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label small fw-bold text-slate-700">Accuracy</label>
                      <input type="range" class="form-range" name="accuracy_rating" min="1" max="5" value="5"
                        oninput="this.nextElementSibling.value = this.value">
                      <output class="fw-bold small text-primary">5</output>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label small fw-bold text-slate-700">Location</label>
                      <input type="range" class="form-range" name="location_rating" min="1" max="5" value="5"
                        oninput="this.nextElementSibling.value = this.value">
                      <output class="fw-bold small text-primary">5</output>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label small fw-bold text-slate-700">Value</label>
                      <input type="range" class="form-range" name="value_rating" min="1" max="5" value="5"
                        oninput="this.nextElementSibling.value = this.value">
                      <output class="fw-bold small text-primary">5</output>
                    </div>
                  </div>

                  <div class="mb-4">
                    <label class="form-label small fw-bold text-slate-700">Your Shared Experience</label>
                    <textarea name="comment" class="form-control shadow-sm border-0 bg-white" rows="4" required
                      placeholder="Tell us exactly how everything went..."></textarea>
                  </div>
                  <button type="submit" class="btn btn-dark rounded-pill px-5 py-2 fw-bold shadow-none">Submit
                    Review</button>
                </form>
              </div>
            @else
              <div class="mt-5 pt-4 border-top">
                <div class="bg-slate-50 p-4 rounded-4 border border-slate-200 text-center">
                  <p class="mb-0 text-muted small">Please <a href="{{ route('login') }}"
                      class="fw-bold text-dark text-decoration-none">log in</a> to leave a review and share your experience.
                  </p>
                </div>
              </div>
            @endauth
          </div>
        </div>

        <!-- Right Column: Sticky Booking Card -->
        <div class="col-lg-4 booking-sidebar-column">
          <div class="booking-card shadow p-4 rounded-4 bg-white sticky-top" style="top: 100px;">
            <div class="d-flex justify-content-between align-items-end mb-4">
              <div>
                <span class="h4 fw-bold mb-0 text-dark">{{ $currencyService->format($room->price) }}</span>
                <span class="text-muted small">/ night</span>
              </div>
            </div>

            <form id="bookingFormSidebar" action="{{ route('bookings.store') }}" method="POST" novalidate>
              @csrf
              <input type="hidden" name="room_id" value="{{ $room->id }}">
              <input type="hidden" name="payment_percentage" id="payment_percentage_input" value="100">
              <input type="hidden" name="amount_to_pay" id="amount_to_pay_input" value="0">
              <div class="booking-inputs border rounded-3 mb-3">
                <div class="row g-0">
                  <div class="col-12 border-bottom p-3">
                    <label class="extra-small fw-bold text-uppercase d-block mb-1">Check-in / Check-out</label>
                    <input type="text" id="booking-dates" name="stay_period"
                      class="form-control border-0 p-0 shadow-none bg-transparent" placeholder="Select dates" required>
                  </div>
                  <div class="col-12 p-3">
                    <label class="extra-small fw-bold text-uppercase d-block mb-1">Guests</label>
                    <div class="dropdown w-100">
                      <button
                        class="btn btn-link w-100 text-start text-dark text-decoration-none p-0 d-flex justify-content-between align-items-center shadow-none"
                        type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"
                        id="guestsDropdown">
                        <span id="guestDisplaySidebar">2 guests</span>
                        <i class="bi bi-chevron-down small"></i>
                      </button>
                      <div class="dropdown-menu w-100 p-4 shadow-lg border-0 rounded-4">
                        <!-- Adult row -->
                        <div class="guest-row d-flex align-items-center justify-content-between mb-4">
                          <div>
                            <div class="fw-bold">Adults</div>
                            <div class="text-muted small">Ages 13 or above</div>
                          </div>
                          <div class="counter-control d-flex align-items-center">
                            <button type="button"
                              class="btn btn-outline-secondary rounded-circle btn-sm counter-btn minus"
                              data-type="adults"><i class="bi bi-dash"></i></button>
                            <span class="mx-3 fw-bold count-val" id="count-adults-sidebar">2</span>
                            <input type="hidden" name="adults" id="adults-count-input" value="2">
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
                            <button type="button"
                              class="btn btn-outline-secondary rounded-circle btn-sm counter-btn minus"
                              data-type="children"><i class="bi bi-dash"></i></button>
                            <span class="mx-3 fw-bold count-val" id="count-children-sidebar">0</span>
                            <input type="hidden" name="children" id="children-count-input" value="0">
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
                            <button type="button"
                              class="btn btn-outline-secondary rounded-circle btn-sm counter-btn minus"
                              data-type="infants"><i class="bi bi-dash"></i></button>
                            <span class="mx-3 fw-bold count-val" id="count-infants-sidebar">0</span>
                            <input type="hidden" name="infants" id="infants-count-input" value="0">
                            <button type="button" class="btn btn-outline-secondary rounded-circle btn-sm counter-btn plus"
                              data-type="infants"><i class="bi bi-plus"></i></button>
                          </div>
                        </div>
                        <!-- Pets row -->
                        <div class="guest-row d-flex align-items-center justify-content-between">
                          <div>
                            <div class="fw-bold">Pets</div>
                          </div>
                          <div class="counter-control d-flex align-items-center">
                            <button type="button"
                              class="btn btn-outline-secondary rounded-circle btn-sm counter-btn minus"
                              data-type="pets"><i class="bi bi-dash"></i></button>
                            <span class="mx-3 fw-bold count-val" id="count-pets-sidebar">0</span>
                            <input type="hidden" name="pets" id="pets-count-input" value="0">
                            <button type="button" class="btn btn-outline-secondary rounded-circle btn-sm counter-btn plus"
                              data-type="pets"><i class="bi bi-plus"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <button type="button" id="reserveBtn" class="btn btn-primary w-100 py-3 rounded-pill fw-bold mb-3 shadow-none">Reserve
                Room</button>
              <p class="text-center text-muted extra-small mb-3">You won't be charged yet</p>

              <div class="price-breakdown mb-0">
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted small">{{ $activeCurrency->symbol }} <span
                      id="basePriceDisplay">{{ number_format($currencyService->convert($room->price), 0) }}</span> x <span
                      id="nightCount">0</span> nights</span>
                  <span class="small">{{ $activeCurrency->symbol }} <span id="subtotalAmount">0</span></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted small">Service Charge</span>
                  <span class="small">{{ $activeCurrency->symbol }} <span id="serviceChargeAmount">0</span></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted small">Tax</span>
                  <span class="small">{{ $activeCurrency->symbol }} <span id="taxAmount">0</span></span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                  <span class="fw-bold">Total</span>
                  <span class="fw-bold">{{ $activeCurrency->symbol }} <span id="totalAmount">0</span></span>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Related Rooms -->
  <section class="related-rooms py-5 border-top overflow-hidden">
    <div class="container-fluid px-md-5">
      <div class="d-flex justify-content-between align-items-center mb-5">
        <h4 class="fw-bold mb-0">Other Rooms You Might Like</h4>
        <div class="slick-arrows-custom d-flex gap-2">
          <button class="btn btn-outline-dark rounded-circle slider-prev p-2 lh-1 shadow-none"><i
              class="bi bi-chevron-left"></i></button>
          <button class="btn btn-outline-dark rounded-circle slider-next p-2 lh-1 shadow-none"><i
              class="bi bi-chevron-right"></i></button>
        </div>
      </div>

      <div class="related-rooms-slider row g-4">
        @foreach($relatedRooms as $related)
          <div class="px-2">
            <div class="offer-card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
              <div class="offer-image-wrapper position-relative" @if($related->is_360_available)
              onclick="open3DViewer('{{ $related->panorama_url }}', '{{ $related->name }}')" @endif>
                <img src="{{ str_starts_with($related->image, 'http') ? $related->image : asset($related->image) }}"
                  alt="{{ $related->name }}" class="offer-img w-100">
                <button class="wishlist-btn" onclick="event.stopPropagation()"><i class="bi bi-heart"></i></button>
                @if($related->badge_text)
                  <div class="offer-badge {{ \Illuminate\Support\Str::slug($related->badge_text) }}">
                    {{ $related->badge_text }}
                  </div>
                @endif
              </div>
              <div class="offer-content p-3" onclick="window.location.href='{{ route('rooms.show', $related->slug) }}'">
                <h5 class="offer-title fw-bold mb-1">{{ $related->name }}</h5>
                <div class="card-review-row">
                  <div class="card-review-stars text-warning">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                      class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                  </div>
                  <div class="card-review-text">({{ number_format($related->rating, 1) }} · {{ $related->review_count }}
                    reviews)</div>
                </div>
                <div class="offer-features d-flex gap-1 text-muted extra-small mb-2">
                  @if(is_array($related->attributes) && count($related->attributes) >= 2)
                    <span><i class="bi bi-door-open me-1"></i> {{ $related->attributes[0]['key'] ?? '' }}:
                      {{ $related->attributes[0]['value'] ?? '' }}</span>
                    <span>·</span>
                    <span><i class="bi bi-people me-1"></i> {{ $related->attributes[1]['key'] ?? '' }}:
                      {{ $related->attributes[1]['value'] ?? '' }}</span>
                  @else
                    <span><i class="bi bi-people me-1"></i> {{ $related->capacity_adults }} Sleeps</span>
                    <span>·</span>
                    <span><i class="bi bi-door-open me-1"></i> {{ $related->bed_type }}</span>
                  @endif
                </div>
                <div class="offer-footer d-flex justify-content-between align-items-end pt-3 border-top">
                  <div class="offer-action-left">
                    <div class="stay-info">
                      <span class="stay-dates">Recommendation</span>
                    </div>
                  </div>
                  <div class="offer-pricing-area d-flex flex-column align-items-end text-end">
                    <div class="pricing-flex">
                      <div class="price-current fw-bold text-dark">{{ $currencyService->format($related->price) }}</div>
                    </div>
                    <a href="{{ route('rooms.show', $related->slug) }}"
                      class="view-deal-link text-decoration-none fw-bold extra-small text-danger">View deal <i
                        class="bi bi-chevron-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- Booking Conflict Warning Modal -->
  <div class="modal fade" id="bookingConflictModal" tabindex="-1" aria-labelledby="bookingConflictModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 rounded-4 shadow-xl">
        <div class="modal-body p-5 text-center">
          <div class="mb-4">
            <i class="bi bi-calendar-x text-danger" style="font-size: 4rem;"></i>
          </div>
          <h4 class="fw-bold mb-3 text-dark">Dates Unavailable</h4>
          <p class="text-muted mb-4">please try another date slot to booking ,this date slot this room is booking.</p>
          <button type="button" class="btn btn-dark rounded-pill px-5 py-2 fw-bold w-100 shadow-none border-0"
            data-bs-dismiss="modal">Select New Dates</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Capacity Warning Modal -->
  <div class="modal fade" id="capacityWarningModal" tabindex="-1" aria-labelledby="capacityWarningModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 rounded-4 shadow-xl">
        <div class="modal-body p-5 text-center">
          <div class="mb-4">
            <i class="bi bi-exclamation-circle text-amber-500" style="font-size: 4rem;"></i>
          </div>
          <h4 class="fw-bold mb-3" id="capacityWarningTitle">Maximum Capacity Reached</h4>
          <p class="text-muted mb-4" id="capacityWarningMessage">This room can accommodate a maximum of
            {{ $room->capacity_adults }} adults and {{ $room->capacity_children }} children.
          </p>
          <button type="button" class="btn btn-dark rounded-pill px-5 py-2 fw-bold w-100 shadow-none border-0"
            data-bs-dismiss="modal">Got it, thanks!</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <!-- PhotoSwipe v5 JS -->
  <script type="module">
    import PhotoSwipeLightbox from 'https://cdn.jsdelivr.net/npm/photoswipe@5.4.3/dist/photoswipe-lightbox.esm.js';
    import PhotoSwipe from 'https://cdn.jsdelivr.net/npm/photoswipe@5.4.3/dist/photoswipe.esm.js';
    window.PhotoSwipeLightbox = PhotoSwipeLightbox;
    window.PhotoSwipe = PhotoSwipe;
  </script>

  <script>
    window.roomPrice = {{ $room->price }};
    window.exchangeRate = {{ $activeCurrency->exchange_rate }};
    window.currencySymbol = '{{ $activeCurrency->symbol }}';
    window.roomMaxAdults = {{ $room->capacity_adults ?? 10 }};
    window.roomMaxChildren = {{ $room->capacity_children ?? 10 }};
    window.roomMaxInfants = {{ $room->capacity_infants ?? 5 }};
    window.roomMaxPets = {{ $room->capacity_pets ?? 2 }};
    window.roomServiceCharge = {{ $room->service_charge ?? 0 }};
    window.roomTax = {{ $room->tax ?? 0 }};
    window.roomPayments = @json($room->partial_payments ?? [50, 70, 100]);
  </script>
  <script src="{{ asset('assets/js/room-details.js') }}"></script>
  @if($errors->has('stay_period'))
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var bookingConflictModal = new bootstrap.Modal(document.getElementById('bookingConflictModal'));
        bookingConflictModal.show();
      });
    </script>
  @endif
@endpush
@include('partials.payment-modal')
