@extends('layouts.main')

@section('navClass', 'sticky-nav-dark')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/signup.css') }}" />
<style>
    .auth-section { margin-top: 0px; }
    .auth-card { border-radius: 20px; overflow: hidden; background: white; }
    .btn-auth-primary { background: #f76156; border: none; color: white; border-radius: 50px; font-weight: 600; transition: all 0.3s; }
    .btn-auth-primary:hover { background: #e54b40; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(247, 97, 86, 0.3); color: white; }
    .verification-icon { width: 80px; height: 80px; background: rgba(247, 97, 86, 0.1); color: #f76156; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; font-size: 35px; }
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
              <!-- Left: Message side -->
              <div class="col-md-7 p-4 p-lg-5">
                <div class="auth-box text-center">
                  <div class="verification-icon">
                    <i class="bi bi-envelope-check"></i>
                  </div>
                  
                  <h2 class="fw-bold mb-3" style="color: #2d3436;">Verify Your Email</h2>
                  
                  <p class="text-muted mb-4">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?') }}
                  </p>

                  @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success border-0 shadow-sm mb-4" style="background: rgba(40, 167, 69, 0.1); color: #28a745; border-radius: 12px;">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </div>
                  @endif

                  <div class="d-flex flex-column gap-3">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-auth-primary px-5 py-2 w-100">
                            {{ __('RESEND VERIFICATION EMAIL') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted text-decoration-none small">
                            <i class="bi bi-box-arrow-right me-1"></i> {{ __('Log Out') }}
                        </button>
                    </form>
                  </div>
                </div>
              </div>

              <!-- Right: Theme Overlay side -->
              <div class="col-md-5 auth-overlay d-flex align-items-center justify-content-center text-center p-4 p-lg-5">
                <div class="overlay-panel">
                  <h2 class="fw-bold text-white mb-3">Almost There!</h2>
                  <p class="text-white-50">Checking your email is the last step to unlock all features of the Nice Guest House.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
