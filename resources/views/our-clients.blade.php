@extends('layouts.main')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/clients.css') }}" />
@endpush

@section('content')
  <!-- Premium Hero Section -->
  <header class="clients-hero">
    <div class="clients-hero-content container">
      <span class="clients-hero-tagline" data-aos="fade-up">A Legacy of Trust</span>
      <h1 class="clients-hero-title mb-0" data-aos="fade-up" data-aos-delay="100">Our Honorable<br>Partners</h1>
    </div>
  </header>

  <!-- Category Section -->
  <section class="category-section">
    <div class="container clients-grid-overlap">

      <div class="row g-4">
        <!-- Category 1 -->
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
          <div class="client-category-card">
            <div class="category-icon-box"><i class="bi bi-globe"></i></div>
            <h4 class="fw-bold">UN Agencies</h4>
            <p class="text-muted small">Global leaders who trust our security and comfort for their highest-level operations.</p>
            <div class="client-list-tags">
              <span class="client-tag"><img src="{{ asset('assets/img/client/wfp-logo.jpg.jpeg') }}" alt="WFP" class="client-logo-inline" onerror="this.parentElement.style.display='none'"></span>
              <span class="client-tag"><img src="{{ asset('assets/img/client/usaid-logo.png') }}" alt="USAID" class="client-logo-inline" onerror="this.parentElement.style.display='none'"></span>
            </div>
          </div>
        </div>
        <!-- Category 2 -->
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
          <div class="client-category-card">
            <div class="category-icon-box"><i class="bi bi-shield-check"></i></div>
            <h4 class="fw-bold">International NGOs</h4>
            <p class="text-muted small">Collaborating for development and humanitarian aid across various national projects.</p>
            <div class="client-list-tags">
              <span class="client-tag"><img src="{{ asset('assets/img/client/stc-logo.jpg.jpeg') }}" alt="Save the Children" class="client-logo-inline" onerror="this.parentElement.style.display='none'"></span>
              <span class="client-tag"><img src="{{ asset('assets/img/client/actionaid-logo.png') }}" alt="ActionAid" class="client-logo-inline" onerror="this.parentElement.style.display='none'"></span>
              <span class="client-tag"><img src="{{ asset('assets/img/client/jica-logo.png') }}" alt="JICA" class="client-logo-inline" onerror="this.parentElement.style.display='none'"></span>
            </div>
          </div>
        </div>
        <!-- Category 3 -->
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
          <div class="client-category-card">
            <div class="category-icon-box"><i class="bi bi-capsule"></i></div>
            <h4 class="fw-bold">Pharmaceuticals</h4>
            <p class="text-muted small">The giants of the medicine industry who frequently choose us for their corporate events.</p>
            <div class="client-list-tags">
              <span class="client-tag"><img src="{{ asset('assets/img/client/square-logo.jpg.jpeg') }}" alt="Square" class="client-logo-inline" onerror="this.parentElement.style.display='none'"></span>
              <span class="client-tag"><img src="{{ asset('assets/img/client/renata-logo.png') }}" alt="Renata" class="client-logo-inline" onerror="this.parentElement.style.display='none'"></span>
            </div>
          </div>
        </div>
        <!-- Category 4 -->
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
          <div class="client-category-card">
            <div class="category-icon-box"><i class="bi bi-briefcase"></i></div>
            <h4 class="fw-bold">Industry Leaders</h4>
            <p class="text-muted small">Corporate partners for high-end business stays, providing luxury and efficiency.</p>
            <div class="client-list-tags">
              <span class="client-tag"><img src="{{ asset('assets/img/client/grameenphone-logo.jpg.jpeg') }}" alt="Grameenphone" class="client-logo-inline" onerror="this.parentElement.style.display='none'"></span>
              <span class="client-tag"><img src="{{ asset('assets/img/client/robi-logo.jpg.jpeg') }}" alt="Robi" class="client-logo-inline" onerror="this.parentElement.style.display='none'"></span>
              <span class="client-tag"><img src="{{ asset('assets/img/client/walton-logo.jpg.jpeg') }}" alt="Walton" class="client-logo-inline" onerror="this.parentElement.style.display='none'"></span>
            </div>
          </div>
        </div>
        <!-- Category 5 -->
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
          <div class="client-category-card">
            <div class="category-icon-box"><i class="bi bi-diagram-3"></i></div>
            <h4 class="fw-bold">Development Partners</h4>
            <p class="text-muted small">National NGOs and agencies relying on our facilities for training and residential stays.</p>
            <div class="client-list-tags">
              <span class="client-tag"><img src="{{ asset('assets/img/client/drc_logo.jpg.jpeg') }}" alt="DRC" class="client-logo-inline" onerror="this.parentElement.style.display='none'"></span>
              <span class="client-tag"><img src="{{ asset('assets/img/client/wec-logo.jpeg') }}" alt="IWM" class="client-logo-inline" onerror="this.parentElement.style.display='none'"></span>
            </div>
          </div>
        </div>
        <!-- CTA Card -->
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="600">
          <div class="client-category-card bg-primary text-white border-0 shadow-lg">
            <div class="category-icon-box bg-white text-primary"><i class="bi bi-chat-heart"></i></div>
            <h4 class="fw-bold">Join Our Legacy</h4>
            <p class="text-white-50">Experience the hospitality trusted by global leaders and industry giants.</p>
            <a href="{{ route('contact') }}" class="btn btn-light rounded-pill mt-auto px-4 fw-bold py-2 shadow-sm">Contact Us</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Partner Showcase Slider Section -->
  <section class="partner-showcase-section py-5">
    <div class="container py-5">
      <div class="text-center mb-5 position-relative">
        <h6 class="text-primary fw-bold text-uppercase ls-2">Our Elite Partners</h6>
        <h2 class="display-6 fw-bold">Industry Leaders</h2>
        <div class="title-divider mx-auto"></div>
      </div>

      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4" data-aos="fade-up">
        @foreach($clients as $client)
        <div class="col">
          <div class="partner-card">
            <div class="partner-logo-box">
              <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}">
              <span>{{ $client->name }}</span>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
@endsection
