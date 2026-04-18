@extends('layouts.main')

@section('navClass', 'sticky-nav-dark')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/signup.css') }}" />
<style>
    .auth-section { margin-top: 100px; }
    .auth-input-group { position: relative; margin-bottom: 20px; }
    .auth-input-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #adb5bd; }
    .auth-input { padding-left: 45px !important; border-radius: 10px !important; height: 50px; border: 1px solid #eee; }
    .auth-input:focus { border-color: #f76156; box-shadow: 0 0 0 0.25 anonymous rgba(247, 97, 86, 0.1); }
    .btn-auth-primary { background: #f76156; border: none; color: white; border-radius: 50px; font-weight: 600; transition: all 0.3s; }
    .btn-auth-primary:hover { background: #e54b40; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(247, 97, 86, 0.3); color: white; }
</style>
@endpush

@section('content')
<div class="auth-section">
    <div class="container">
      <div class="row min-vh-100 align-items-center justify-content-center py-5">
        <div class="col-lg-10 col-xl-9">
          <div class="auth-card shadow-lg border-0 overflow-hidden" style="border-radius: 20px;">
            <div class="row g-0">
              <!-- Left: Form side -->
              <div class="col-md-6 p-4 p-lg-5 bg-white">
                <div class="auth-box">
                  <h2 class="auth-title mb-1 text-center fw-bold" style="color: #2d3436;">Guest Sign In</h2>
                  <p class="text-center text-muted small mb-4">Portal for visitors and customers</p>
                  
                  <div class="social-auth-icons mb-4 text-center">
                    <a href="#" class="social-icon d-inline-flex align-items-center justify-content-center rounded-circle border me-2" style="width: 40px; height: 40px; color: #3b5998;"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="social-icon d-inline-flex align-items-center justify-content-center rounded-circle border me-2" style="width: 40px; height: 40px; color: #db4437;"><i class="bi bi-google"></i></a>
                    <a href="#" class="social-icon d-inline-flex align-items-center justify-content-center rounded-circle border" style="width: 40px; height: 40px; color: #0077b5;"><i class="bi bi-linkedin"></i></a>
                  </div>
                  
                  <p class="text-center text-muted small mb-4">or use your account</p>

                  <x-auth-session-status class="mb-4" :status="session('status')" />

                  <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="auth-input-group">
                      <i class="bi bi-envelope auth-input-icon"></i>
                      <input type="email" name="email" class="form-control auth-input" placeholder="Email" value="{{ old('email') }}" required autofocus>
                      <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="auth-input-group">
                      <i class="bi bi-lock auth-input-icon"></i>
                      <input type="password" name="password" class="form-control auth-input" placeholder="Password" required autocomplete="current-password">
                      <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                            <label class="form-check-label small text-muted" for="remember_me">Remember me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-muted small text-decoration-none">Forgot password?</a>
                        @endif
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-auth-primary px-5 py-2 w-100">SIGN IN</button>
                    </div>
                  </form>
                </div>
              </div>

              <!-- Right: Overlay side -->
              <div class="col-md-6 auth-overlay d-flex align-items-center justify-content-center text-center p-4 p-lg-5" style="background: linear-gradient(135deg, #f76156, #ff8e86); color: white;">
                <div class="overlay-panel">
                  <h2 class="fw-bold text-white mb-3">Hello, Friend!</h2>
                  <p class="text-white-50 mb-5">Enter your personal details and start journey with us</p>
                  <a href="{{ route('register') }}" class="btn btn-outline-light rounded-pill px-5 py-2 fw-bold">SIGN UP</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
