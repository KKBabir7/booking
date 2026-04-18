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
    .custom-check:checked { background-color: #f76156; border-color: #f76156; }
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
                  <h2 class="auth-title mb-4 text-center fw-bold" style="color: #2d3436;">Sign Up</h2>
                  
                  <div class="social-auth-icons mb-4 text-center">
                    <a href="#" class="social-icon d-inline-flex align-items-center justify-content-center rounded-circle border me-2" style="width: 40px; height: 40px; color: #3b5998;"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="social-icon d-inline-flex align-items-center justify-content-center rounded-circle border me-2" style="width: 40px; height: 40px; color: #db4437;"><i class="bi bi-google"></i></a>
                    <a href="#" class="social-icon d-inline-flex align-items-center justify-content-center rounded-circle border" style="width: 40px; height: 40px; color: #0077b5;"><i class="bi bi-linkedin"></i></a>
                  </div>
                  
                  <p class="text-center text-muted small mb-4">or use your email for registration</p>

                  <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="auth-input-group">
                      <i class="bi bi-person auth-input-icon"></i>
                      <input type="text" name="name" class="form-control auth-input" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
                      <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="auth-input-group">
                      <i class="bi bi-envelope auth-input-icon"></i>
                      <input type="email" name="email" class="form-control auth-input" placeholder="Email" value="{{ old('email') }}" required>
                      <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="auth-input-group">
                      <i class="bi bi-telephone auth-input-icon"></i>
                      <input type="tel" name="phone" class="form-control auth-input" placeholder="Phone" value="{{ old('phone') }}" required>
                      <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                    <div class="auth-input-group">
                      <i class="bi bi-geo-alt auth-input-icon"></i>
                      <input type="text" name="location" class="form-control auth-input" placeholder="Location" value="{{ old('location') }}">
                      <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>
                    <div class="auth-input-group">
                      <i class="bi bi-lock auth-input-icon"></i>
                      <input type="password" name="password" class="form-control auth-input" placeholder="Password" required autocomplete="new-password">
                      <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="auth-input-group">
                      <i class="bi bi-shield-lock auth-input-icon"></i>
                      <input type="password" name="password_confirmation" class="form-control auth-input" placeholder="Confirm Password" required autocomplete="new-password">
                      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="form-check mb-4 d-flex align-items-center justify-content-center">
                      <input class="form-check-input custom-check me-2" type="checkbox" id="terms_agree" required>
                      <label class="form-check-label small text-muted cursor-pointer" for="terms_agree">
                        I agree to the <a href="#" class="text-decoration-none" style="color: #f76156;">Terms & Conditions</a>
                      </label>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-auth-primary px-5 py-2 w-100">SIGN UP</button>
                    </div>
                  </form>
                </div>
              </div>

              <!-- Right: Overlay side -->
              <div class="col-md-6 auth-overlay d-flex align-items-center justify-content-center text-center p-4 p-lg-5" style="background: linear-gradient(135deg, #f76156, #ff8e86); color: white;">
                <div class="overlay-panel">
                  <h2 class="fw-bold text-white mb-3">Welcome Back!</h2>
                  <p class="text-white-50 mb-5">To keep connected with us please login with your personal info</p>
                  <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-5 py-2 fw-bold">SIGN IN</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
