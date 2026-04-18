<footer class="site-footer">
  <div class="container">
    <div class="row g-5 pb-5">
      <!-- Branding column -->
      <div class="col-lg-4">
        <a href="{{ url('/') }}" class="footer-logo">NICE<span>GUESTHOUSE</span></a>
        <p class="text-white-50 mb-4 pe-lg-4">
          Committed to serving you with our expert team members. Experience a touch of home and excellence in the
          heart of Noakhali since 2007.
        </p>
        <div class="social-links">
          <a href="https://www.facebook.com/NGHNOAKHALI" class="social-link" target="_blank"><i class="fa fa-facebook"></i></a>
          <a href="https://www.youtube.com/watch?v=2fpsh9s6ebM" class="social-link" target="_blank"><i class="fa fa-youtube-play"></i></a>
          <a href="https://www.tripadvisor.com/..." class="social-link" target="_blank"><i class="fa fa-tripadvisor"></i></a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="col-6 col-md-3 col-lg-2">
        <h5 class="footer-heading">Navigate</h5>
        <ul class="footer-links">
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ route('about') }}">About Us</a></li>
          <li><a href="{{ route('rooms.index') }}">Rooms & Suites</a></li>
          <li><a href="{{ route('restaurant.index') }}">Restaurants</a></li>
          <li><a href="{{ route('conference.index') }}">Conference</a></li>
        </ul>
      </div>

      <!-- Useful Links -->
      <div class="col-6 col-md-3 col-lg-2">
        <h5 class="footer-heading">Useful Info</h5>
        <ul class="footer-links">
          <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
          <li><a href="{{ route('terms-of-service') }}">Terms of Service</a></li>
          <li><a href="{{ route('gallery') }}">Gallery</a></li>
          <li><a href="{{ route('our-clients') }}">Our Clients</a></li>
          <li><a href="{{ route('contact') }}">Contact</a></li>
          <li><a href="{{ route('faq') }}">FAQ</a></li>
        </ul>
      </div>

      <!-- Contact Summary -->
      <div class="col-md-6 col-lg-4">
        <h5 class="footer-heading">Stay Connected</h5>
        <p class="text-white-50 mb-4">Subscribe to our newsletter for latest offers and news.</p>
        <div class="input-group">
          <input type="email" class="form-control bg-dark border-0 text-white" placeholder="Enter email" style="padding: 12px 20px;">
          <button class="btn btn-primary px-4" type="button">Join</button>
        </div>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
          &copy; {{ date('Y') }} Nice Guest House & Training Hall. All rights reserved.
        </div>
        <div class="col-md-6 text-center text-md-end">
          Designed for Excellence | Powered by <a href="#" class="text-white-50 text-decoration-none">NGH Team</a>
        </div>
      </div>
    </div>
  </div>
</footer>

<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
