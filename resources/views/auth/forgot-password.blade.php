@extends('layouts.main')

@section('navClass', 'sticky-nav-dark')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/signup.css') }}" />
<style>
    .auth-section { margin-top: 0px; }
    .auth-card { border-radius: 20px; overflow: hidden; background: white; }
    .auth-input-group { position: relative; margin-bottom: 20px; }
    .auth-input-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #adb5bd; z-index: 10; }
    .auth-input { padding-left: 45px !important; border-radius: 10px !important; height: 50px; border: 1px solid #eee; }
    .auth-input:focus { border-color: #f76156; box-shadow: 0 0 0 0.25rem rgba(247, 97, 86, 0.1); }
    .btn-auth-primary { background: #f76156; border: none; color: white; border-radius: 50px; font-weight: 600; transition: all 0.3s; }
    .btn-auth-primary:hover { background: #e54b40; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(247, 97, 86, 0.3); color: white; }
    .verification-icon { width: 80px; height: 80px; background: rgba(247, 97, 86, 0.1); color: #f76156; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; font-size: 35px; }
    .auth-overlay { background: linear-gradient(135deg, #f76156, #ff8e86); color: white; }
</style>
@endpush

@section('content')
<div class="auth-section">
    <div class="container">
      <div class="row min-vh-100 align-items-center justify-content-center py-5">
        <div class="col-lg-10 col-xl-9">
          <div class="auth-card shadow-lg border-0">
            <div class="row g-0">
              <!-- Left: Form side -->
              <div class="col-md-7 p-4 p-lg-5 bg-white">
                <div class="auth-box">
                  <div class="verification-icon">
                    <i class="bi bi-shield-lock"></i>
                  </div>
                  
                  <h2 class="fw-bold mb-3 text-center" style="color: #2d3436;">Forgot Password?</h2>
                  
                  <p class="text-center text-muted small mb-4">
                    {{ __('No problem. Just let us know your email address and we will email you a password reset link.') }}
                  </p>

                  <!-- Session Status -->
                  <x-auth-session-status class="mb-4" :status="session('status')" />

                  <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="auth-input-group">
                      <i class="bi bi-envelope auth-input-icon"></i>
                      <input id="email" type="email" name="email" class="form-control auth-input" placeholder="Enter your email address" value="{{ old('email') }}" required autofocus>
                      <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="text-center mt-4">
                      <button type="submit" class="btn btn-auth-primary px-5 py-2 w-100">
                        {{ __('SEND RESET LINK') }}
                      </button>
                    </div>
                  </form>

                  <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-decoration-none small text-muted hover-coral">
                      <i class="bi bi-arrow-left me-1"></i> Back to Login
                    </a>
                  </div>
                </div>
              </div>

              <!-- Right: Overlay side -->
              <div class="col-md-5 auth-overlay d-flex align-items-center justify-content-center text-center p-4 p-lg-5">
                <div class="overlay-panel">
                  <h2 class="fw-bold text-white mb-3">Recover Access!</h2>
                  <p class="text-white-50">Locked out? Don't worry. We'll help you get back to your account in no time.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection