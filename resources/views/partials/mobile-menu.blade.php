<!-- Off-canvas Menu -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
  <div class="offcanvas-header border-bottom">
    <div class="offcanvas-title" id="offcanvasMenuLabel">
      <img src="{{ asset('assets/img/logo/logo-2.png') }}" alt="Logo" class="offcanvas-logo">
    </div>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body p-0">
    <div class="p-4 border-bottom" id="mobile-auth-section">
      @auth
        <div class="d-flex align-items-center gap-3 py-1">
           <div class="flex-shrink-0">
              <div class="user-avatar-red rounded-circle d-flex align-items-center justify-content-center fw-bold fs-3" style="width: 50px; height: 50px;">
                 {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
              </div>
           </div>
           <div>
              <h6 class="mb-0 fw-bold" style="font-size: 1rem;">{{ Auth::user()->name }}</h6>
              <div class="text-muted mb-2" style="font-size: 0.75rem;">NGH Member</div>
              <a href="{{ route('account.index') }}" class="mobile-dashboard-btn">
                <i class="bi bi-speedometer2"></i> Dashboard
              </a>
           </div>
        </div>
      @else
        <div class="btn-signup d-flex align-items-center gap-0 p-0 overflow-hidden ps-3 pe-3 rounded-pill justify-content-center mx-auto" style="height: 45px; max-width: 250px;">
          <a href="{{ route('register') }}" class="text-white text-decoration-none px-3 py-2 d-flex align-items-center gap-2 fw-bold"><i class="bi bi-person-plus"></i> Sign Up</a>
          <span class="text-white-50 mx-1">|</span>
          <a href="{{ route('login') }}" class="text-white text-decoration-none px-3 py-2 d-flex align-items-center gap-2 fw-bold"><i class="bi bi-box-arrow-in-right"></i> Log In</a>
        </div>
      @endauth
    </div>
    <ul class="nav flex-column menu-list">
      @foreach($navbarItems as $item)
        <li class="nav-item">
          <a class="nav-link {{ Request::is(trim($item->url, '/')) ? 'active' : '' }}" href="{{ url($item->url) }}">
            @if($item->icon)<i class="bi {{ $item->icon }} me-2"></i>@endif
            {{ $item->label }}
          </a>
        </li>
      @endforeach
      
      <li class="nav-item">
        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#mobileLangMenu" role="button" aria-expanded="false">
          <span><i class="bi bi-translate me-2"></i> Language</span>
          <i class="bi bi-chevron-down small"></i>
        </a>
        <div class="collapse" id="mobileLangMenu">
          <ul class="nav flex-column bg-light ps-4">
            <li class="nav-item">
              <a class="nav-link py-2" href="javascript:void(0);" onclick="changeLanguage('en')">
                <img src="https://flagcdn.com/w40/gb.png" alt="English" class="lang-flag me-2"> English
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link py-2" href="javascript:void(0);" onclick="changeLanguage('bn')">
                <img src="https://flagcdn.com/w40/bd.png" alt="Bengali" class="lang-flag me-2"> Bengali
              </a>
            </li>
          </ul>
        </div>
      </li>
      @auth
        <li class="nav-item mt-3">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link text-danger fw-bold border-0 bg-transparent w-100 text-start">
              <i class="bi bi-box-arrow-right me-2"></i> Sign Out
            </button>
          </form>
        </li>
      @endauth
    </ul>
  </div>
</div>
