@extends('layouts.main')

@push('styles')
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.3/photoswipe.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/gallery.css') }}" />
@endpush

@section('content')
  <!-- Gallery Hero -->
  <header class="gallery-hero">
    <div class="container gallery-hero-content">
      <span class="gallery-hero-tagline" data-aos="fade-up">Visual Excellence</span>
      <h1 class="gallery-hero-title mb-0" data-aos="fade-up" data-aos-delay="100">Our Gallery</h1>
    </div>
  </header>

  <!-- Video Showcase Section -->
  <section class="video-showcase-section">
    <div class="container">
      <div class="text-center mb-5" data-aos="fade-up">
        <h6 class="text-primary fw-bold text-uppercase ls-2">Cinematic Experience</h6>
        <h2 class="display-6 fw-bold">A Glimpse of NGH Hospitality</h2>
        <div class="title-divider mx-auto"></div>
      </div>

      <div class="video-container" data-aos="zoom-in" data-aos-delay="200">
        <div class="video-wrapper">
          <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ?si=7kC4jC0v9X1T9s-q" title="NGH Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </section>

  <!-- Story Section -->
  <section class="gallery-story-section">
    <div class="container text-center">
      <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-lg-8">
          <h2 class="display-6 fw-bold">NGH is the best guest house of Noakhali.</h2>
          <p class="text-muted mb-4">
            The warmth of our hospitality, combined with good food, comfortable surroundings, and friendly, helpful service, along with the convenience of high-speed internet access, will ensure that you leave with memories of a stay that has both relaxed and rejuvenated your spirit.
          </p>
          <div class="title-divider mx-auto"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- Elite Gallery Showcase -->
  <section class="gallery-showcase-section py-5">
    <div class="container">
      <!-- Filter Buttons -->
      <div class="gallery-filters mb-5 p-2" data-aos="fade-up">
        <button class="filter-btn active" data-filter="all">All Showcase</button>
        <button class="filter-btn" data-filter="rooms">Our Rooms</button>
        <button class="filter-btn" data-filter="dining">Dining & Food</button>
        <button class="filter-btn" data-filter="events">Events & Halls</button>
        <button class="filter-btn" data-filter="amenities">Amenities</button>
      </div>

      <!-- Gallery Grid -->
      <div id="elite-gallery" class="gallery-grid-v2" data-aos="fade-up">
        <!-- Item 1: Room -->
        <div class="gallery-item-wrapper" data-category="rooms">
          <a href="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1600&q=80" 
             data-pswp-width="1600" data-pswp-height="1067" target="_blank">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=800&q=80" alt="Executive Suite">
              <div class="card-content">
                <span class="category-tag">Rooms</span>
                <h4 class="card-title">Executive Suite</h4>
              </div>
            </div>
          </a>
        </div>

        <!-- Item 2: Dining -->
        <div class="gallery-item-wrapper" data-category="dining">
          <a href="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1600&q=80" 
             data-pswp-width="1600" data-pswp-height="1067" target="_blank">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=800&q=80" alt="Fine Dining">
              <div class="card-content">
                <span class="category-tag">Dining</span>
                <h4 class="card-title">The Royal Platter</h4>
              </div>
            </div>
          </a>
        </div>

        <!-- Item 3: Events -->
        <div class="gallery-item-wrapper" data-category="events">
          <a href="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=1600&q=80" 
             data-pswp-width="1600" data-pswp-height="1067" target="_blank">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=800&q=80" alt="Grand Hall">
              <div class="card-content">
                <span class="category-tag">Events</span>
                <h4 class="card-title">NGH Grand Ballroom</h4>
              </div>
            </div>
          </a>
        </div>

        <!-- Item 4: Amenities -->
        <div class="gallery-item-wrapper" data-category="amenities">
          <a href="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1600&q=80" 
             data-pswp-width="1600" data-pswp-height="1067" target="_blank">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=800&q=80" alt="Rooftop Pool">
              <div class="card-content">
                <span class="category-tag">Amenities</span>
                <h4 class="card-title">Serenity Pool</h4>
              </div>
            </div>
          </a>
        </div>

        <!-- Item 5: Room -->
        <div class="gallery-item-wrapper" data-category="rooms">
          <a href="https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=1600&q=80" 
             data-pswp-width="1600" data-pswp-height="1067" target="_blank">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=800&q=80" alt="Deluxe Room">
              <div class="card-content">
                <span class="category-tag">Rooms</span>
                <h4 class="card-title">Deluxe Experience</h4>
              </div>
            </div>
          </a>
        </div>

        <!-- Item 6: Dining -->
        <div class="gallery-item-wrapper" data-category="dining">
          <a href="https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&w=1600&q=80" 
             data-pswp-width="1600" data-pswp-height="1067" target="_blank">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&w=800&q=80" alt="Breakfast">
              <div class="card-content">
                <span class="category-tag">Dining</span>
                <h4 class="card-title">Morning Feast</h4>
              </div>
            </div>
          </a>
        </div>

        <!-- Item 7: Events -->
        <div class="gallery-item-wrapper" data-category="events">
          <a href="https://images.unsplash.com/photo-1505373633519-c2900720ded4?auto=format&fit=crop&w=1600&q=80" 
             data-pswp-width="1600" data-pswp-height="1067" target="_blank">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1505373633519-c2900720ded4?auto=format&fit=crop&w=800&q=80" alt="Meeting Room">
              <div class="card-content">
                <span class="category-tag">Events</span>
                <h4 class="card-title">Business Conference</h4>
              </div>
            </div>
          </a>
        </div>

        <!-- Item 8: Amenities -->
        <div class="gallery-item-wrapper" data-category="amenities">
          <a href="https://images.unsplash.com/photo-1540555700478-4be28aefcf1?auto=format&fit=crop&w=1600&q=80" 
             data-pswp-width="1600" data-pswp-height="1067" target="_blank">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1540555700478-4be28aefcf1?auto=format&fit=crop&w=800&q=80" alt="Spa">
              <div class="card-content">
                <span class="category-tag">Amenities</span>
                <h4 class="card-title">Wellness Spa</h4>
              </div>
            </div>
          </a>
        </div>

        <!-- Item 9: Rooms -->
        <div class="gallery-item-wrapper" data-category="rooms">
          <a href="https://images.unsplash.com/photo-1590490359683-658d3d23f972?auto=format&fit=crop&w=1600&q=80" 
             data-pswp-width="1600" data-pswp-height="1067" target="_blank">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1590490359683-658d3d23f972?auto=format&fit=crop&w=800&q=80" alt="Double Room">
              <div class="card-content">
                <span class="category-tag">Rooms</span>
                <h4 class="card-title">Comfort Double</h4>
              </div>
            </div>
          </a>
        </div>

        <!-- Item 10: Dining -->
        <div class="gallery-item-wrapper" data-category="dining">
          <a href="https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&w=1600&q=80" 
             data-pswp-width="1600" data-pswp-height="1067" target="_blank">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&w=800&q=80" alt="Local Food">
              <div class="card-content">
                <span class="category-tag">Dining</span>
                <h4 class="card-title">Traditional Flavors</h4>
              </div>
            </div>
          </a>
        </div>

        <!-- Item 11: Events -->
        <div class="gallery-item-wrapper" data-category="events">
          <a href="https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1600&q=80" 
             data-pswp-width="1600" data-pswp-height="1067" target="_blank">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=800&q=80" alt="Wedding">
              <div class="card-content">
                <span class="category-tag">Events</span>
                <h4 class="card-title">Celebration Moments</h4>
              </div>
            </div>
          </a>
        </div>

        <!-- Item 12: Amenities -->
        <div class="gallery-item-wrapper" data-category="amenities">
          <a href="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80" 
             data-pswp-width="1600" data-pswp-height="1067" target="_blank">
            <div class="gallery-card">
              <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=800&q=80" alt="Gym">
              <div class="card-content">
                <span class="category-tag">Amenities</span>
                <h4 class="card-title">Fitness Center</h4>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <!-- PhotoSwipe Module -->
  <script type="module">
    import PhotoSwipeLightbox from 'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.3/photoswipe-lightbox.esm.min.js';
    const lightbox = new PhotoSwipeLightbox({
      gallery: '#elite-gallery',
      children: 'a',
      pswpModule: () => import('https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.3/photoswipe.esm.min.js')
    });
    lightbox.init();
  </script>

  <script>
    AOS.init({ duration: 1000, once: true });

    $(document).ready(function() {
      // Gallery Filtering Logic
      $('.filter-btn').on('click', function() {
        const filter = $(this).data('filter');
        
        // Update active button
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');

        // Filter items
        if (filter === 'all') {
          $('.gallery-item-wrapper').removeClass('hide').addClass('show');
        } else {
          $('.gallery-item-wrapper').each(function() {
            if ($(this).data('category') === filter) {
              $(this).removeClass('hide').addClass('show');
            } else {
              $(this).removeClass('show').addClass('hide');
            }
          });
        }
      });
    });
  </script>
@endpush
