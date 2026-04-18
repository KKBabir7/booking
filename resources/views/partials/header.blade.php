<nav class="navbar navbar-expand-lg fixed-top py-2 py-md-4 transition-all @yield('navClass')" id="main-nav">
  <div class="container-fluid px-md-5">
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
      @php
        $navbarLogo = \App\Models\PageSetting::where('page', 'navbar')->where('key', 'navbar_logo')->first();
      @endphp
      @if($navbarLogo && $navbarLogo->value)
        <img src="{{ asset($navbarLogo->value) }}" alt="Logo" class="navbar-logo">
      @else
        <img src="{{ asset('assets/img/logo/logo-2.png') }}" alt="Logo" class="navbar-logo">
      @endif
    </a>

    <!-- Desktop Horizontal Menu -->
    <div class="d-none d-lg-flex flex-grow-1 justify-content-end align-items-center desktop-menu">
      <ul class="nav">
        @foreach($navbarItems->where('position', 'top') as $item)
          <li class="nav-item">
            <a href="{{ url($item->url) }}" class="nav-link {{ Request::is(trim($item->url, '/')) ? 'active' : '' }}">
              @if($item->icon)<i class="bi {{ $item->icon }} me-1"></i>@endif
              {{ $item->label }}
            </a>
          </li>
        @endforeach
      </ul>

      <!-- Auth Button (Premium Account Dropdown) -->
      <div id="auth-btn-wrapper" class="d-flex align-items-center">
        @auth
          <div class="dropdown auth-dropdown ms-3">
            <button class="btn btn-auth-red rounded-pill d-flex align-items-center gap-2 px-3 py-2 text-white" 
                    type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle fs-6"></i> 
              <span class="fw-medium">{{ Auth::user()->name }}</span>
              <i class="bi bi-chevron-down ms-1" style="font-size:0.75rem;"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2 mt-3" aria-labelledby="userDropdown" style="min-width:210px;">
              <!-- User Info Header -->
              <li class="px-3 pt-2 pb-3 border-bottom mb-1">
                <div class="d-flex align-items-center">
                  <div class="user-avatar-red rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; flex-shrink: 0;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                  </div>
                  <div class="ms-2 overflow-hidden">
                    <div class="fw-bold text-truncate" style="font-size: 0.88rem;">{{ Auth::user()->name }}</div>
                    <div class="text-muted" style="font-size: 0.72rem;">NGH Member</div>
                  </div>
                </div>
              </li>
              <!-- Menu Items -->
              <li><a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ route('account.index') }}" style="font-size: 0.88rem;"><i class="bi bi-speedometer2 text-primary"></i> Dashboard</a></li>
              <li><a class="dropdown-item py-2 px-3 d-flex align-items-center justify-content-between" href="{{ route('account.index') }}?tab=bookings" style="font-size: 0.88rem;">
                <span class="d-flex align-items-center gap-2"><i class="bi bi-calendar-check text-primary"></i> My Bookings</span>
                <span class="badge bg-danger rounded-pill" style="{{ Auth::user()->bookings()->count() > 0 ? '' : 'display:none;' }}">
                  {{ Auth::user()->bookings()->count() }}
                </span>
              </a></li>
              <li><a class="dropdown-item py-2 px-3 d-flex align-items-center justify-content-between" href="{{ route('account.index') }}?tab=favorites" style="font-size: 0.88rem;">
                <span class="d-flex align-items-center gap-2"><i class="bi bi-heart text-danger"></i> Favorites</span>
                <span class="badge bg-danger rounded-pill" id="nav-favorites-count" style="{{ Auth::user()->favorites()->count() > 0 ? '' : 'display:none;' }}">
                  {{ Auth::user()->favorites()->count() }}
                </span>
              </a></li>
              @if(Auth::user()->isAdmin())
                <li><a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}" style="font-size: 0.88rem;"><i class="bi bi-shield-lock text-primary"></i> Admin Panel</a></li>
              @endif
              <li><hr class="dropdown-divider my-1"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item py-2 px-3 text-danger d-flex align-items-center gap-2 border-0 bg-transparent w-100 text-start" style="font-size: 0.88rem;">
                    <i class="bi bi-box-arrow-right"></i> Sign Out
                  </button>
                </form>
              </li>
            </ul>
          </div>
        @else
          <div class="btn-signup ms-3 d-flex align-items-center gap-0 p-0 overflow-hidden ps-3 pe-3 rounded-pill" style="height: 42px;">
            <a href="{{ route('register') }}" class="text-white text-decoration-none px-2 py-2 d-flex align-items-center gap-1"><i class="bi bi-person-plus"></i> Sign Up</a>
            <span class="text-white-50 mx-1">|</span>
            <a href="{{ route('login') }}" class="text-white text-decoration-none px-2 py-2 d-flex align-items-center gap-1"><i class="bi bi-box-arrow-in-right"></i> Log In</a>
          </div>
        @endauth
      </div>

      <div class="dropdown desktop-dropdown d-none d-lg-block ms-2">
        <button class="btn btn-menu-toggle animated-burger-btn" type="button" id="desktopMenuDropdown" aria-expanded="false">
          <div class="burger-icon">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-3 mt-3 p-0" aria-labelledby="desktopMenuDropdown">
          @foreach($navbarItems->where('position', 'dropdown') as $item)
            <li>
              <a class="dropdown-item py-2 px-4" href="{{ url($item->url) }}">
                @if($item->icon)<i class="bi {{ $item->icon }} me-2"></i>@endif
                {{ $item->label }}
              </a>
            </li>
          @endforeach
          <li><hr class="dropdown-divider mx-3"></li>
          <li class="dropdown-submenu px-3">
            <a class="dropdown-item dropdown-toggle py-2 px-2 d-flex align-items-center justify-content-between" href="#" id="currencyMenu">
              <span><i class="bi bi-cash-stack me-2"></i> Currency ({{ $activeCurrency->code }})</span>
            </a>
            <ul class="dropdown-menu shadow border-0 py-2 p-0">
              @foreach($allCurrencies as $currency)
                <li>
                  <a class="dropdown-item py-2 px-4 d-flex align-items-center justify-content-between {{ $activeCurrency->code == $currency->code ? 'active bg-primary text-white' : '' }}" 
                     href="{{ route('currency.switch', $currency->code) }}">
                    <span>{{ $currency->name }} ({{ $currency->code }})</span>
                    <span class="ms-2 fw-bold opacity-75">{{ $currency->symbol }}</span>
                  </a>
                </li>
              @endforeach
            </ul>
          </li>
          <li><hr class="dropdown-divider mx-3"></li>
          <li class="dropdown-submenu px-3">
            <a class="dropdown-item dropdown-toggle py-2 px-2 d-flex align-items-center justify-content-between" href="#" id="languageMenu">
              <span><i class="bi bi-translate me-2"></i> Language</span>
            </a>
            <ul class="dropdown-menu shadow border-0 py-2 p-0">
              <li><a class="dropdown-item py-2 px-4" href="javascript:void(0);" onclick="changeLanguage('en')"><img src="https://flagcdn.com/w40/gb.png" alt="English" class="lang-flag me-2"> English</a></li>
              <li><a class="dropdown-item py-2 px-4" href="javascript:void(0);" onclick="changeLanguage('bn')"><img src="https://flagcdn.com/w40/bd.png" alt="Bengali" class="lang-flag me-2"> Bengali</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>

    <!-- Mobile Menu Toggle -->
    <div class="d-flex align-items-center d-lg-none ms-auto">
      <button class="btn btn-menu-toggle animated-burger-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
        <div class="burger-icon">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </button>
    </div>
  </div>
</nav>
