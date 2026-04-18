@extends('layouts.main')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />
@endpush

@section('content')
  <!-- Hero Section -->
  <header class="conference-hero contact-hero-sync" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset($settings['hero_banner'] ?? 'assets/img/page_banners/contact-default.jpg') }}')">
      <div class="conference-hero-content container">
          <span class="conference-hero-tagline" data-aos="fade-up">{{ $settings['hero_tagline'] ?? 'Get In Touch' }}</span>
          <h1 class="conference-hero-title" data-aos="fade-up" data-aos-delay="100">{!! nl2br(e($settings['hero_title'] ?? "Contact Us &\nSupport Team")) !!}</h1>
      </div>
  </header>

  <!-- Contact Section -->
  <section id="contact" class="contact-section pb-5 bg-white">
      <div class="container contact-grid-overlap">
              <!-- Contact Info Cards -->
              <div class="col-lg-12 mb-5">
                  <div class="row g-4 justify-content-center">
                    @php
                        $cards = isset($settings['contact_cards']) ? json_decode($settings['contact_cards'], true) : [];
                    @endphp
                    @forelse($cards as $index => $card)
                        <div class="col-md-6 col-lg-4">
                            <div class="contact-feature-card shadow-sm h-100 p-4 rounded-4 text-center border {{ $index === 1 ? 'active-card' : '' }}">
                                <div class="icon-box mx-auto">
                                    <i class="{{ $card['icon'] ?? 'bi bi-info-circle' }}"></i>
                                </div>
                                <h5 class="fw-bold mb-3">{{ $card['title'] ?? '' }}</h5>
                                <p class="text-muted small mb-0">{{ $card['detail1'] ?? '' }}</p>
                                @if(!empty($card['detail2']))
                                    <p class="{{ str_contains(strtolower($card['detail2']), 'available') ? 'text-primary' : 'text-muted' }} small fw-bold mt-2 mb-0">{{ $card['detail2'] }}</p>
                                @endif
                                @if(!empty($card['link_text']) && !empty($card['link_url']))
                                    <a href="{{ $card['link_url'] }}" target="_blank" class="btn btn-link text-primary mt-3 p-0 fw-bold small text-decoration-none">{{ $card['link_text'] }} <i class="bi bi-arrow-right ms-1"></i></a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No contact information available.</p>
                    @endforelse
                  </div>
              </div>

              <!-- Contact Form Redesigned -->
              <div class="col-lg-8 mx-auto mt-4">
                  <div class="contact-form-premium shadow p-4 p-md-5 rounded-4 bg-white border-top border-5">
                      <div class="text-center mb-5">
                          <h3 class="fw-bold mb-2">Send us a message</h3>
                          <p class="text-muted">Fill out the form below and we'll get back to you shortly.</p>
                      </div>

                      @if(session('success'))
                          <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4 p-3 d-flex align-items-center gap-3">
                              <i class="bi bi-check-circle-fill fs-4"></i>
                              <div>{{ session('success') }}</div>
                          </div>
                      @endif

                      @if($errors->any())
                          <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4 p-3">
                              <ul class="mb-0 small">
                                  @foreach($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif

                      <form action="{{ route('contact.send') }}" method="POST">
                          @csrf
                          <div class="row g-4">
                              <div class="col-md-6">
                                  <div class="form-floating mb-3">
                                      <input type="text" name="name" class="form-control" id="contactName" placeholder="John Doe" required>
                                      <label for="contactName">Your Name</label>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-floating mb-3">
                                      <input type="email" name="email" class="form-control" id="contactEmail" placeholder="john@example.com" required>
                                      <label for="contactEmail">Email Address</label>
                                  </div>
                              </div>
                              <div class="col-12">
                                  <div class="form-floating mb-3">
                                      <input type="text" name="subject" class="form-control" id="contactSubject" placeholder="Inquiry">
                                      <label for="contactSubject">Subject</label>
                                  </div>
                              </div>
                              <div class="col-12">
                                  <div class="form-floating mb-3">
                                      <textarea name="message" class="form-control" id="contactMessage" placeholder="Message" style="height: 150px" required></textarea>
                                      <label for="contactMessage">Your Message</label>
                                  </div>
                              </div>
                              <div class="col-12 text-center pt-2">
                                  <button type="submit" class="btn btn-primary btn-cta-premium rounded-pill px-5 py-3 fw-bold">
                                      Submit Inquiry <i class="bi bi-arrow-right ms-2 transition-transform"></i>
                                  </button>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </section>

  <!-- Map Section -->
  <section class="map-section">
      <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3183.6448475657526!2d91.09366391010211!3d22.848709622709144!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3754a53e012d7b89%3A0x3ec0fd442b458cd3!2sNice%20Guest%20House%2C%20Training%20Hall%20%26%20Dolna%20Food%20Heaven%20(Hotel%20in%20Noakhali)!5e1!3m2!1sen!2sbd!4v1749283641246!5m2!1sen!2sbd"
          allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
          style="width: 100%; height: 450px; border:0;"></iframe>
  </section>
@endsection
