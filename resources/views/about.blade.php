@extends('layouts.main')

@push('styles')
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/about.css') }}" />
@endpush

@section('content')
  <!-- About Hero -->
  <header class="about-hero" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset($settings['hero_banner'] ?? 'assets/img/page_banners/about-hero-default.jpg') }}') !important;">
    <div class="container text-center">
      <span class="about-hero-tagline" data-aos="fade-up">{{ $settings['hero_tagline'] ?? 'A Touch of Home & Excellence' }}</span>
      <h1 class="about-hero-title mb-0" data-aos="fade-up" data-aos-delay="100">{{ $settings['hero_title'] ?? 'About Us' }}</h1>
    </div>
  </header>

  <!-- Legacy Stats Transferred -->
  <section class="stats-section">
    <div class="container">
      <div class="row g-4">
        @php
          $stats = isset($settings['stats']) ? json_decode($settings['stats'], true) : [
            ['icon' => 'bi bi-calendar-check', 'number' => '18+ Years', 'label' => 'of Experience since 2007'],
            ['icon' => 'bi bi-people-fill', 'number' => 'Thousands', 'label' => 'of Happy Guests served'],
            ['icon' => 'bi bi-globe-americas', 'number' => 'Global Trust', 'label' => 'by International NGOs']
          ];
        @endphp
        @foreach($stats as $index => $stat)
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="{{ 100 * ($index + 1) }}">
          <div class="stat-card text-center text-dark">
            <div class="stat-icon"><i class="{{ $stat['icon'] }} text-primary"></i></div>
            <div class="stat-number">{{ $stat['number'] }}</div>
            <div class="text-muted fw-medium">{{ $stat['label'] }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Mission & Passion -->
  <section class="py-5 bg-white">
    <div class="container py-5">
      <div class="row g-4 justify-content-center">
        @php
          $values = isset($settings['core_values']) ? json_decode($settings['core_values'], true) : [
            ['icon' => 'bi bi-bullseye', 'title' => 'Our Mission', 'desc' => 'At Nice Guest House, our mission is to provide a welcoming, comfortable, and secure environment for every guest.'],
            ['icon' => 'bi bi-fire', 'title' => 'Passion', 'desc' => 'Passion is the fuel behind creativity, perseverance, and excellence. It turns challenges into opportunities.']
          ];
          $colClass = count($values) <= 2 ? 'col-md-6' : (count($values) == 3 ? 'col-md-4' : 'col-md-4 col-lg-3');
        @endphp
        @foreach($values as $index => $value)
        <div class="{{ $colClass }}" data-aos="fade-up" data-aos-delay="{{ 100 * $index }}">
          <div class="info-card h-100">
            <div class="info-icon-box"><i class="{{ $value['icon'] ?? 'bi bi-star' }}"></i></div>
            <h3 class="fw-bold mb-3">{{ $value['title'] ?? '' }}</h3>
            <p class="text-muted mb-0">{{ $value['desc'] ?? '' }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Journey of Excellence Transferred -->
  <section class="content-block">
    <div class="container text-dark">
      <div class="row align-items-center g-5">
        <div class="col-lg-6" data-aos="fade-right">
          <h2 class="fw-bold mb-4"><i class="bi bi-award-fill text-success me-2"></i> {{ $settings['journey_title'] ?? 'Since 2007: A Journey of Excellence' }}</h2>
          <p class="text-muted mb-4 lead">{{ $settings['journey_subtitle'] ?? 'Nice Guest House has proudly served thousands of guests, becoming a trusted name in hospitality. Our long-standing reputation reflects our commitment to quality, reliability, and professional service.' }}</p>
          <div class="service-highlight p-4">
            <div class="service-highlight-pattern"></div>
            <h4 class="fw-bold mb-3"><i class="bi bi-stars me-2"></i> {{ $settings['journey_highlight_title'] ?? 'Continuously Improving' }}</h4>
            <p class="mb-0 opacity-90">{{ $settings['journey_highlight_text'] ?? 'From upgraded rooms and modern conference halls to multi-cuisine restaurants and rooftop experiences — we’re always enhancing our services to exceed expectations.' }}</p>
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <div class="rounded-4 overflow-hidden shadow-lg border-24">
            <img src="{{ isset($settings['journey_image']) ? asset($settings['journey_image']) : 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80' }}" alt="Hospitality" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Chairman Section -->
  <section class="chairman-section">
    <div class="container text-dark">
      <div class="chairman-card" data-aos="fade-up">
        <i class="bi bi-quote chairman-quote-icon"></i>
        <div class="row align-items-center g-5">
          <div class="col-lg-5">
            <div class="chairman-img-wrapper">
              <img src="{{ isset($settings['chairman_image']) ? asset($settings['chairman_image']) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $settings['chairman_name'] ?? 'Chairman' }}" class="img-fluid">
            </div>
          </div>
          <div class="col-lg-7">
            <h6 class="text-primary fw-bold text-uppercase ls-2 mb-3">Chairman's Message</h6>
            <h2 class="fw-bold mb-4">{{ $settings['chairman_greeting'] ?? 'Greetings from Nice Guest House & Training Hall' }}</h2>
            <div class="text-muted">
              @if(isset($settings['chairman_message']))
                  @foreach(explode("\n", str_replace("\r", "", $settings['chairman_message'])) as $para)
                      @if(trim($para))
                        <p>{{ $para }}</p>
                      @endif
                  @endforeach
              @else
                <p>In December 2007, we started the journey of an institution called “Nice Guest House” with a vow of service ensuring international standard accommodation and hygienic food for the guests arriving in Noakhali.</p>
                <p>Nice Guest House is the best guest house in Noakhali, Maijdee Town. We are committed to ensuring international quality service for living and eating. From the beginning till today, we have been providing quality services uninterruptedly by the grace of Allah.</p>
                <p>Luxury, relaxation & tranquility are what you will find at Nice Guest House with the arrangement of Training facilities. The warmth of our hospitality will ensure that you leave with memories of a stay that has both relaxed and rejuvenated your spirit.</p>
              @endif
            </div>
            <div class="mt-5">
              <span class="chairman-signature">{{ $settings['chairman_name'] ?? 'Md. Shawkat Ali' }}</span>
              <p class="mb-0 text-dark fw-bold">Chairman</p>
              <p class="text-muted small">{{ $settings['chairman_phone'] ?? '+880 1821159478' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 1000, once: true });
  </script>
@endpush
