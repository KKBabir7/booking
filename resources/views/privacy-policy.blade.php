@extends('layouts.main')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/about.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
@endpush

@section('content')
  <!-- Hero Section -->
  <header class="about-hero" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset($settings['hero_banner'] ?? 'assets/img/page_banners/privacy-default.jpg') }}') center/cover no-repeat !important;">
    <div class="container text-center">
      <span class="about-hero-tagline" data-aos="fade-up">{{ $settings['hero_tagline'] ?? 'Your Privacy Matters' }}</span>
      <h1 class="about-hero-title mb-0" data-aos="fade-up" data-aos-delay="100">{{ $settings['hero_title'] ?? 'Privacy Policy' }}</h1>
    </div>
  </header>

  <!-- Policy Content -->
  <section class="legal-content-section bg-white">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10" data-aos="fade-up">
          <div class="legal-card">
            @php
                $sections = isset($settings['content_sections']) ? json_decode($settings['content_sections'], true) : [];
            @endphp
            
            @if(count($sections) > 0)
                @foreach($sections as $section)
                <h4 class="legal-section-title">{{ $section['title'] ?? '' }}</h4>
                <div class="legal-text mb-5">
                    {!! $section['content'] ?? '' !!}
                </div>
                @endforeach
            @else
                <div class="text-center py-5">
                    <h5 class="text-muted italic">Privacy policy is being updated. Please check back soon.</h5>
                </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
