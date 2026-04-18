@extends('layouts.main')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/about.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/legal.css') }}" />
@endpush

@section('content')
  <!-- Hero Section -->
  <header class="about-hero" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset($settings['hero_banner'] ?? 'assets/img/page_banners/faq-default.jpg') }}') center/cover no-repeat !important;">
    <div class="container text-center">
      <span class="about-hero-tagline" data-aos="fade-up">{{ $settings['hero_tagline'] ?? 'Help Center' }}</span>
      <h1 class="about-hero-title mb-0" data-aos="fade-up" data-aos-delay="100">{{ $settings['hero_title'] ?? 'Frequently Asked Questions' }}</h1>
    </div>
  </header>

  <!-- FAQ Search -->
  <div class="container" data-aos="fade-up" data-aos-delay="200">
    <div class="faq-search-wrapper">
      <input type="text" class="form-control faq-search-input" placeholder="Search for answers...">
      <button class="btn btn-primary faq-search-btn">Search</button>
    </div>
  </div>

  <!-- FAQ Content -->
  <section class="legal-content-section bg-white pt-0">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="accordion faq-accordion" id="faqAccordion">
            
            @php
                $faqList = isset($settings['faq_items']) ? json_decode($settings['faq_items'], true) : [];
                $groupedFaqs = collect($faqList)->groupBy('category');
            @endphp

            @if($groupedFaqs->count() > 0)
                @foreach($groupedFaqs as $category => $items)
                <div class="mb-5" data-aos="fade-up">
                  <h4 class="fw-bold mb-4 text-primary">
                    <i class="{{ $items->first()['icon'] ?? 'bi bi-info-circle' }} me-2"></i> {{ $category }}
                  </h4>
                  @foreach($items as $idx => $item)
                  @php $faqId = 'faq_' . Str::slug($category) . '_' . $idx; @endphp
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $faqId }}">
                        {{ $item['question'] ?? '' }}
                      </button>
                    </h2>
                    <div id="{{ $faqId }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                      <div class="accordion-body">
                        {!! $item['answer'] ?? '' !!}
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
                @endforeach
            @else
                <div class="text-center py-5">
                    <i class="bi bi-patch-question text-muted fs-1 mb-3 d-block"></i>
                    <h5 class="text-muted">No questions added yet. Please check back later.</h5>
                </div>
            @endif

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script>
    // FAQ Search functionality
    $(document).ready(function() {
      $('.faq-search-input').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('.accordion-item').filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>
@endpush
