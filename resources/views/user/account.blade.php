@extends('layouts.main')

@section('navClass', 'sticky-nav-dark')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/account.css') }}" />
@endpush

@section('content')
  <section class="account-section" style="margin-top: 0px; padding-bottom: 80px;">
    <div class="container">
      <!-- Page Header -->
      <div class="mb-5">
        <h2 class="fw-bold mb-1">My Account</h2>
        <p class="text-muted mb-0">Manage your profile, bookings & preferences</p>
      </div>

      <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3">
          <div class="account-sidebar shadow-sm p-4 rounded-4 bg-white">
            <div class="user-profile-summary text-center mb-4">
              <div
                class="user-avatar-lg mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold text-white fs-3"
                style="width: 80px; height: 80px; background: linear-gradient(135deg, #f76156, #ff8e86); border-radius: 20px;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
              </div>
              <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
              <p class="text-muted small">NGH Member</p>
            </div>
            <nav class="nav flex-column account-nav gap-2">
              <button class="nav-link active text-start py-2 px-3 rounded-3" data-tab="profile"><i
                  class="bi bi-person me-2"></i> My Profile</button>
              <button class="nav-link text-start py-2 px-3 rounded-3" data-tab="bookings"><i
                  class="bi bi-calendar-check me-2"></i> My Bookings <span
                  class="badge bg-danger ms-auto">{{ $bookings->count() }}</span></button>
              <button class="nav-link text-start py-2 px-3 rounded-3" data-tab="favorites"><i
                  class="bi bi-heart me-2"></i> Favorites <span
                  class="badge bg-danger ms-auto">{{ $favorites->count() }}</span></button>
              <button class="nav-link text-start py-2 px-3 rounded-3" data-tab="settings"><i class="bi bi-gear me-2"></i>
                Settings</button>
              <hr class="my-2">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                  class="nav-link text-danger text-start py-2 px-3 rounded-3 w-100 border-0 bg-transparent"><i
                    class="bi bi-box-arrow-right me-2"></i> Sign Out</button>
              </form>
            </nav>
          </div>
        </div>

        <!-- Content -->
        <div class="col-lg-9">
          <!-- Success Alert -->
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4 border-0" role="alert">
              <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <!-- Profile Tab -->
          <div id="tab-profile" class="tab-section">
            <div class="account-card p-4 p-md-5 bg-white shadow-sm rounded-4">
              <h5 class="fw-bold mb-4"><i class="bi bi-person-badge me-2 text-danger"></i> Personal Information</h5>
              <form action="{{ route('account.profile.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="row g-4">
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-muted small uppercase">Full Name</label>
                    <input type="text" name="name" class="form-control rounded-3 py-2"
                      value="{{ old('name', $user->name) }}" required>
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-muted small uppercase">Email Address</label>
                    <input type="email" name="email" class="form-control rounded-3 py-2"
                      value="{{ old('email', $user->email) }}" required>
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-muted small uppercase">Phone Number</label>
                    <input type="tel" name="phone" class="form-control rounded-3 py-2"
                      value="{{ old('phone', $user->phone) }}" required>
                    <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-muted small uppercase">Location / Address</label>
                    <input type="text" name="location" class="form-control rounded-3 py-2"
                      value="{{ old('location', $user->location) }}">
                    <x-input-error :messages="$errors->get('location')" class="mt-1" />
                  </div>
                  <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-bold"
                      style="background:#f76156; border:none;">Save Changes</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <!-- Bookings Tab -->
          <div id="tab-bookings" class="tab-section d-none">
            <div class="account-card p-4 p-md-5 bg-white shadow-sm rounded-4">
              <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-calendar-check me-2 text-danger"></i> My Bookings</h5>

                <!-- Booking Sub-Tabs -->
                <div class="booking-filter-tabs d-flex p-1 bg-light rounded-pill">
                  <a href="{{ route('account.index', ['tab' => 'bookings']) }}"
                    class="btn btn-sm rounded-pill px-3 {{ !$type ? 'bg-white shadow-sm fw-bold border-0 text-danger' : 'text-muted border-0' }}">All</a>
                  <a href="{{ route('account.index', ['tab' => 'bookings', 'type' => 'room']) }}"
                    class="btn btn-sm rounded-pill px-3 {{ $type === 'room' ? 'bg-white shadow-sm fw-bold border-0 text-danger' : 'text-muted border-0' }}">Room</a>
                  <a href="{{ route('account.index', ['tab' => 'bookings', 'type' => 'restaurant']) }}"
                    class="btn btn-sm rounded-pill px-3 {{ $type === 'restaurant' ? 'bg-white shadow-sm fw-bold border-0 text-danger' : 'text-muted border-0' }}">Restaurant</a>
                  <a href="{{ route('account.index', ['tab' => 'bookings', 'type' => 'conference']) }}"
                    class="btn btn-sm rounded-pill px-3 {{ $type === 'conference' ? 'bg-white shadow-sm fw-bold border-0 text-danger' : 'text-muted border-0' }}">Conference</a>
                </div>
              </div>

              @if($bookings->isEmpty())
                <div class="text-center py-5">
                  <div class="mb-4">
                    <i class="bi bi-calendar-x display-4 text-muted opacity-50"></i>
                  </div>
                  <h5 class="fw-bold text-muted">No {{ $type ?? '' }} bookings found</h5>
                  <p class="text-muted small mb-4">Start your journey by exploring our premium services.</p>
                  <a href="{{ route('rooms.index') }}" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm"
                    style="background: #f76156; border: none;">Explore Now</a>
                </div>
              @else
                <div class="row row-cols-1 g-4">
                  @foreach($bookings as $booking)
                    <div class="col">
                      <div
                        class="booking-card-modern border rounded-4 p-4 hover-shadow transition-all bg-white overflow-hidden position-relative">
                        <div class="row items-center g-4">
                          <!-- Date Column -->
                          <div class="col-auto">
                            <div class="date-badge-modern text-center p-3 rounded-4 d-flex flex-column justify-content-center"
                              style="background: #f8f9fa; min-width: 90px; height: 90px; border: 1px solid #eee;">
                              @if($booking->type === 'room')
                                <span
                                  class="d-block fw-black text-dark fs-4 lh-1">{{ Carbon\Carbon::parse($booking->check_in)->format('d') }}</span>
                                <span
                                  class="text-muted small fw-bold text-uppercase">{{ Carbon\Carbon::parse($booking->check_in)->format('M') }}</span>
                              @else
                                <span
                                  class="d-block fw-black text-dark fs-4 lh-1">{{ Carbon\Carbon::parse($booking->check_in ?? $booking->date)->format('d') }}</span>
                                <span
                                  class="text-muted small fw-bold text-uppercase">{{ Carbon\Carbon::parse($booking->check_in ?? $booking->date)->format('M') }}</span>
                              @endif
                            </div>
                          </div>

                          <!-- Details Column -->
                          <div class="col">
                            <div class="mb-2">
                              <h5 class="fw-bold mb-1 text-dark">{{ $booking->title }}</h5>
                              <div class="d-flex flex-wrap gap-3 mt-1">
                                @if($booking->type === 'room')
                                  <span class="text-muted small"><i class="bi bi-calendar-range me-1 text-danger"></i>
                                    {{ Carbon\Carbon::parse($booking->check_in)->format('d M') }} -
                                    {{ Carbon\Carbon::parse($booking->check_out)->format('d M, Y') }}</span>
                                @elseif($booking->type === 'restaurant')
                                  <span class="text-muted small"><i class="bi bi-calendar-check me-1 text-danger"></i>
                                    {{ Carbon\Carbon::parse($booking->date)->format('d M, Y') }}</span>
                                  <span class="text-muted small"><i class="bi bi-clock me-1 text-danger"></i>
                                    {{ $booking->time_slot }}</span>
                                @elseif($booking->type === 'conference')
                                  <span class="text-muted small"><i class="bi bi-calendar-event me-1 text-danger"></i>
                                    @if($booking->check_in && $booking->check_out)
                                      {{ Carbon\Carbon::parse($booking->check_in)->format('d M') }} —
                                      {{ Carbon\Carbon::parse($booking->check_out)->format('d M, Y') }}
                                    @else
                                      {{ Carbon\Carbon::parse($booking->date)->format('d M, Y') }}
                                    @endif
                                  </span>
                                  <span class="text-muted small"><i class="bi bi-hourglass-split me-1 text-danger"></i>
                                    {{ $booking->duration }}</span>
                                @endif
                                <span class="text-muted small"><i class="bi bi-people me-1 text-danger"></i>
                                  {{ $booking->guests ?? ($booking->adults + $booking->children) }} Guests</span>
                              </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                              @php
                                $statusColors = [
                                  'pending' => 'bg-warning text-dark',
                                  'confirmed' => 'bg-primary text-white',
                                  'completed' => 'bg-success text-white',
                                  'cancelled' => 'bg-danger text-white'
                                ];
                              @endphp
                              <span
                                class="badge {{ $statusColors[$booking->status] ?? 'bg-secondary' }} rounded-pill px-3 py-1 text-uppercase fw-bold"
                                style="font-size: 9px; @if($booking->status === 'confirmed') background-color: #4f46e5 !important; @endif">
                                <i class="bi bi-dot me-1"></i>{{ $booking->status }}
                              </span>
                              <span class="text-muted extra-small">Booked on
                                {{ $booking->created_at->format('d M, Y') }}</span>
                            </div>
                          </div>

                          <!-- Price & Actions Column -->
                          <div class="col-md-auto text-md-end pt-3 border-top border-md-0 mt-3 mt-md-0">
                            <div class="mb-3">
                              <span
                                class="badge rounded-pill px-3 py-1 text-uppercase letter-spacing-1 font-black mb-2 d-inline-block"
                                style="font-size: 8px; background: rgba(247,97,86,0.1); color: #f76156;">
                                {{ $booking->type }}
                              </span>

                              @if($booking->type !== 'restaurant')
                                @if($booking->payment_percentage && $booking->payment_percentage < 100)
                                  <!-- Partial Payment Display -->
                                  <h4 class="fw-black text-danger mb-0">{{ $currencyService->format($booking->amount_paid) }}</h4>
                                  <div class="d-flex flex-column align-items-md-end">
                                    <small class="text-muted fw-bold text-uppercase" style="font-size: 9px;">Amount Paid
                                      ({{ $booking->payment_percentage }}%)</small>
                                    <div class="mt-1">
                                      <span class="badge bg-light text-dark border small fw-medium" style="font-size: 10px;">
                                        Total: {{ $currencyService->format($booking->total_price) }}
                                      </span>
                                      <span class="badge bg-danger-subtle text-danger border border-danger-subtle small fw-medium"
                                        style="font-size: 10px;">
                                        Due: {{ $currencyService->format($booking->total_price - $booking->amount_paid) }}
                                      </span>
                                    </div>
                                  </div>
                                @else
                                  <!-- Full Payment or Quote Display -->
                                  <h4 class="fw-black text-danger mb-0">{{ $currencyService->format($booking->total_price) }}</h4>
                                  @if($booking->total_price > 0)
                                    <small class="text-muted fw-bold text-uppercase"
                                      style="font-size: 9px;">{{ $booking->type === 'conference' ? 'Hall Price / Session' : 'Total Amount' }}</small>
                                  @else
                                    <small class="text-success fw-bold text-uppercase"
                                      style="font-size: 9px;">{{ $booking->type === 'conference' ? 'Pending Quote' : 'Reservation Only' }}</small>
                                  @endif
                                @endif
                              @else
                                <!-- Restaurant Dynamic Pricing Display -->
                                <h4 class="fw-black text-danger mb-0">{{ $currencyService->format($booking->total_price) }}</h4>
                                <div class="d-flex flex-column align-items-md-end">
                                  <small class="text-muted fw-bold text-uppercase mt-1" style="font-size: 8px;">Advance paid:
                                    {{ $currencyService->format(500) }}</small>
                                  <small class="text-muted fw-bold text-uppercase" style="font-size: 9px;">Total Bill
                                    ({{ $booking->amount_paid >= $booking->total_price ? 'Cleared' : 'Pending' }})</small>
                                </div>
                              @endif
                            </div>

                            <div class="d-flex justify-content-md-end gap-2">
                              @if($booking->status === 'pending' && $booking->amount_paid <= 0)
                                <form action="{{ route('bookings.cancel', $booking) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                  @csrf @method('PATCH')
                                  <button type="submit"
                                    class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">Cancel</button>
                                </form>
                              @endif

                              @php
                                $detailsUrl = '#';
                                if ($booking->type === 'room' && $booking->room) {
                                  $detailsUrl = route('rooms.show', $booking->room->slug);
                                } elseif ($booking->type === 'conference') {
                                  $detailsUrl = route('conference.index');
                                } elseif ($booking->type === 'restaurant') {
                                  $detailsUrl = route('restaurant.index');
                                }
                              @endphp
                              <a href="{{ $detailsUrl }}"
                                class="btn btn-sm btn-dark rounded-pill px-3 fw-bold shadow-sm">Details</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endif
            </div>
          </div>

          <!-- Favorites Tab -->
          <div id="tab-favorites" class="tab-section d-none">
            <div class="account-card p-4 p-md-5 bg-white shadow-sm rounded-4">
              <h5 class="fw-bold mb-4"><i class="bi bi-heart-fill text-danger me-2"></i> My Wishlist</h5>

              @if($favorites->isEmpty())
                <div class="text-center py-5">
                  <i class="bi bi-suit-heart text-muted display-1 mb-3"></i>
                  <p class="text-muted">You haven't added any properties to your wishlist yet.</p>
                  <a href="{{ route('rooms.index') }}" class="btn btn-outline-danger btn-sm rounded-pill px-4 mt-2">Explore
                    Properties</a>
                </div>
              @else
                <div class="row g-4">
                  @foreach($favorites as $favorite)
                    <div class="col-md-6 mb-4">
                      <!-- Standard Room Card (Reused Design) -->
                      <div class="hotel-card shadow-sm h-100 rounded-4 overflow-hidden position-relative">
                        <a href="{{ route('rooms.show', $favorite->room->slug) }}"
                          class="text-decoration-none text-dark d-block h-100 position-relative">
                          <div class="position-relative">
                            <img
                              src="{{ str_starts_with($favorite->room->image, 'http') ? $favorite->room->image : asset($favorite->room->image) }}"
                              class="img-fluid w-100" style="height: 220px; object-fit: cover;"
                              alt="{{ $favorite->room->name }}">

                            <button class="wishlist-btn bg-white shadow-sm"
                              onclick="event.preventDefault(); event.stopPropagation(); removeFavorite({{ $favorite->room->id }}, this)"
                              style="border: 1px solid #dee2e6; color: #dc3545;" title="Remove from Favorites">
                              <i class="bi bi-trash"></i>
                            </button>

                            @if($favorite->room->badge_text)
                              <div class="offer-badge {{ \Illuminate\Support\Str::slug($favorite->room->badge_text) }}">
                                {{ $favorite->room->badge_text }}
                              </div>
                            @endif
                          </div>
                          <div class="p-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                              <div class="text-muted small"><i class="bi bi-geo-alt-fill text-danger me-1"></i>Dhaka</div>
                              <div class="rating-badge small fw-bold">
                                <i class="bi bi-star-fill text-warning"></i> {{ $favorite->room->rating ?? '4.8' }}
                                <span class="text-muted fw-normal">({{ $favorite->room->review_count ?? '120' }})</span>
                              </div>
                            </div>
                            <h5 class="fw-bold mb-2">{{ $favorite->room->name }}</h5>
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                              <div>
                                <span
                                  class="fs-5 fw-bold text-danger">{{ $currencyService->format($favorite->room->price) }}</span>
                                <span class="text-muted small">/Night</span>
                              </div>
                              <!-- Keep the standard check icon to match original UI styling requirements -->
                              <div
                                class="btn btn-sm btn-outline-danger rounded-circle d-flex align-items-center justify-content-center"
                                style="width:32px; height:32px;"><i class="bi bi-arrow-right"></i></div>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endif
            </div>
          </div>

          <!-- Settings Tab -->
          <div id="tab-settings" class="tab-section d-none">
            <div class="account-card p-4 p-md-5 bg-white shadow-sm rounded-4">
              <h5 class="fw-bold mb-4"><i class="bi bi-gear me-2 text-danger"></i> Security Settings</h5>
              <form action="{{ route('password.update') }}" method="POST">
                @csrf @method('put')
                <div class="row g-4">
                  <div class="col-md-12">
                    <label class="form-label fw-bold text-muted small uppercase">Current Password</label>
                    <input type="password" name="current_password" class="form-control rounded-3 py-2"
                      placeholder="Enter current password">
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-muted small uppercase">New Password</label>
                    <input type="password" name="password" class="form-control rounded-3 py-2"
                      placeholder="Enter new password">
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-muted small uppercase">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control rounded-3 py-2"
                      placeholder="Repeat new password">
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
                  </div>
                  <div class="col-12 mt-4 text-start">
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-bold"
                      style="background:#f76156; border:none;">Update Password</button>
                    @if (session('status') === 'password-updated')
                      <p class="text-success small mt-2"><i class="bi bi-check-circle"></i> Password updated successfully.
                      </p>
                    @endif
                  </div>
                </div>
              </form>
              <hr class="my-5">
              <div class="p-4 rounded-4 bg-danger bg-opacity-10 border border-danger border-opacity-20">
                <h6 class="fw-bold text-danger mb-2">Danger Zone</h6>
                <p class="text-muted small mb-3">Permanently delete your account and all associated data. This action
                  cannot be undone.</p>
                <form method="post" action="{{ route('profile.destroy') }}">
                  @csrf @method('delete')
                  <input type="password" name="password" class="form-control mb-3 rounded-3"
                    placeholder="Enter password to confirm" style="max-width:300px;">
                  <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4">Delete Account</button>
                </form>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script>
    $(document).ready(function () {
      // Tab switching
      $('.account-nav .nav-link').on('click', function () {
        const tabName = $(this).data('tab');

        // UI Update
        $('.account-nav .nav-link').removeClass('active');
        $(this).addClass('active');

        // Tab update
        $('.tab-section').addClass('d-none');
        $('#tab-' + tabName).removeClass('d-none');
      });

      // Initialize from URL param if exists
      const urlParams = new URLSearchParams(window.location.search);
      const activeTab = urlParams.get('tab');
      if (activeTab) {
        $(`.account-nav .nav-link[data-tab="${activeTab}"]`).trigger('click');
      }
    });
  </script>
@endpush