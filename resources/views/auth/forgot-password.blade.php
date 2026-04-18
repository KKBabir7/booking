@extends('layouts.main')

@section('navClass', 'sticky-nav-dark')

@push('styles')
    <style>
        .auth-section {
            margin-top: 100px;
        }

        .auth-card {
            background-color: #1e293b;
            /* Dark theme background for card to match image */
            border-radius: 12px;
            position: relative;
            z-index: 1;
        }

        .auth-input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .auth-input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
        }

        .auth-input {
            padding-left: 45px !important;
            border-radius: 8px !important;
            height: 50px;
            background: #0f172a;
            border: 1px solid #334155;
            color: white;
        }

        .auth-input:focus {
            border-color: #f76156;
            background: #0f172a;
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(247, 97, 86, 0.25);
        }

        .auth-input::placeholder {
            color: #64748b;
        }

        .btn-auth-primary {
            background: white;
            border: none;
            color: #0f172a;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            letter-spacing: 0.5px;
        }

        .btn-auth-primary:hover {
            background: #f1f5f9;
            transform: translateY(-2px);
        }

        body {
            background-color: #0f172a;
        }

        /* Dark body background similar to image */
    </style>
@endpush

@section('content')
    <div class="auth-section pb-5" style="min-height: 70vh; display: flex; align-items: center;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <!-- Optional Logo -->
                    <div class="text-center mb-4">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <span class="fs-1 fw-bold text-white"><i class="bi bi-box" style="color: #f76156;"></i>
                                NGH</span>
                        </a>
                    </div>

                    <div class="auth-card shadow p-4 p-md-5">
                        <div class="mb-4 text-sm" style="color: #94a3b8; font-size: 0.95rem; line-height: 1.6;">
                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </div>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="auth-input-group mb-4">
                                <label for="email"
                                    class="form-label text-white-50 small fw-bold mb-2">{{ __('Email') }}</label>
                                <input id="email" type="email" name="email" class="form-control auth-input"
                                    placeholder="Enter your email address" value="{{ old('email') }}" required autofocus>
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-auth-primary px-4 py-2 w-100 uppercase"
                                    style="font-size: 0.85rem;">
                                    {{ __('Email Password Reset Link') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-decoration-none"
                            style="color: #94a3b8; font-size: 0.9rem;">
                            <i class="bi bi-arrow-left me-1"></i> Back to login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection