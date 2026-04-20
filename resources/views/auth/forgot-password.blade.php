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

    /* Custom Styles */
    .verify-box { border: 1px solid #eee; border-radius: 12px; padding: 15px; margin-bottom: 20px; background: #fcfcfc; }
    .verify-option { display: flex; align-items: center; padding: 10px; border: 1px solid transparent; border-radius: 8px; cursor: pointer; transition: all 0.2s; margin-bottom: 5px; }
    .verify-option:hover { background: #fff; border-color: #f7615633; }
    .verify-option.active { border-color: #f76156; background: #fff; }
    .verify-icon { font-size: 1.2rem; color: #f76156; margin-right: 12px; }
    .iti { width: 100%; margin-bottom: 15px; }
    .otp-group { display: none; margin-top: 15px; }
    #recaptcha-container { margin-bottom: 10px; }
    .custom-check:checked { background-color: #f76156; border-color: #f76156; }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/css/intlTelInput.css">
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

                  <!-- Verification Choice -->
                  <div class="verify-box">
                    <p class="small fw-bold text-muted mb-3">Choose Reset Method:</p>
                    
                    <div class="verify-option active" id="opt_email">
                      <input type="radio" name="reset_method" value="email" id="method_email" class="form-check-input custom-check me-2" checked>
                      <label for="method_email" class="d-flex align-items-center cursor-pointer w-100 mb-0">
                        <i class="bi bi-envelope verify-icon"></i>
                        <div>
                          <span class="d-block fw-bold small">Email Link</span>
                          <span class="text-muted" style="font-size: 0.7rem;">Get a reset link in your inbox.</span>
                        </div>
                      </label>
                    </div>

                    <div class="verify-option" id="opt_phone">
                      <input type="radio" name="reset_method" value="phone" id="method_phone" class="form-check-input custom-check me-2">
                      <label for="method_phone" class="d-flex align-items-center cursor-pointer w-100 mb-0">
                        <i class="bi bi-phone verify-icon"></i>
                        <div>
                          <span class="d-block fw-bold small">Phone OTP</span>
                          <span class="text-muted" style="font-size: 0.7rem;">Reset via SMS OTP code.</span>
                        </div>
                      </label>
                    </div>
                  </div>

                  <!-- Email Form -->
                  <form method="POST" action="{{ route('password.email') }}" id="form_email">
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

                  <!-- Phone Form -->
                  <form method="POST" action="{{ route('password.update') }}" id="form_phone" style="display: none;">
                    @csrf
                    <div class="auth-input-group">
                      <input type="tel" id="user_phone" class="form-control auth-input" style="padding-left: 60px !important;" placeholder="Phone Number">
                      <input type="hidden" name="phone" id="full_phone">
                    </div>

                    <div class="otp-group" id="otp_container">
                      <div id="recaptcha-container"></div>
                      <div class="d-flex gap-2">
                        <input type="text" id="otp_code" class="form-control auth-input" placeholder="Enter 6-digit OTP">
                        <button type="button" id="btn_verify_otp" class="btn btn-dark rounded-pill px-4 small">Verify</button>
                      </div>
                      <div id="otp_message" class="small mt-2"></div>
                    </div>

                    <div id="password_fields" style="display: none;">
                       <div class="auth-input-group mt-3">
                          <i class="bi bi-lock auth-input-icon"></i>
                          <input type="password" name="password" id="new_password" class="form-control auth-input" placeholder="New Password" required>
                       </div>
                       <div class="auth-input-group">
                          <i class="bi bi-shield-lock auth-input-icon"></i>
                          <input type="password" name="password_confirmation" class="form-control auth-input" placeholder="Confirm Password" required>
                       </div>
                    </div>

                    <div class="text-center mt-4">
                      <button type="button" id="btn_send_otp" class="btn btn-auth-primary px-5 py-2 w-100">SEND OTP CODE</button>
                      <button type="submit" id="btn_reset_final" class="btn btn-auth-primary px-5 py-2 w-100" style="display: none;">RESET PASSWORD</button>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/js/intlTelInput.min.js"></script>
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-app.js";
    import { getAuth, RecaptchaVerifier, signInWithPhoneNumber } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-auth.js";

    const firebaseConfig = {
        apiKey: "{{ env('FIREBASE_API_KEY') }}",
        authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
        projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
        storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
        messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
        appId: "{{ env('FIREBASE_APP_ID') }}"
    };

    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    auth.languageCode = 'en';

    let confirmationResult;

    document.addEventListener('DOMContentLoaded', function() {
        const methodEmail = document.getElementById('method_email');
        const methodPhone = document.getElementById('method_phone');
        const formEmail = document.getElementById('form_email');
        const formPhone = document.getElementById('form_phone');
        const emailOption = document.getElementById('opt_email');
        const phoneOption = document.getElementById('opt_phone');
        
        const phoneInput = document.querySelector("#user_phone");
        const fullPhoneHidden = document.querySelector("#full_phone");
        
        const iti = window.intlTelInput(phoneInput, {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/js/utils.js",
            initialCountry: "bd",
            separateDialCode: true,
            preferredCountries: ["bd", "us", "sa", "ae"],
        });

        // Toggle Logic
        methodEmail.addEventListener('change', function() {
            formEmail.style.display = 'block';
            formPhone.style.display = 'none';
            emailOption.classList.add('active');
            phoneOption.classList.remove('active');
        });

        methodPhone.addEventListener('change', function() {
            formEmail.style.display = 'none';
            formPhone.style.display = 'block';
            phoneOption.classList.add('active');
            emailOption.classList.remove('active');
            
            if(!window.recaptchaVerifier) {
                window.recaptchaVerifier = new RecaptchaVerifier(auth, 'recaptcha-container', {
                    'size': 'invisible'
                });
            }
        });

        // Send OTP Logic
        document.getElementById('btn_send_otp').addEventListener('click', function() {
            const phoneNumber = iti.getNumber();
            if(!iti.isValidNumber()) {
                alert('Please enter a valid phone number.');
                return;
            }

            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Sending...';

            signInWithPhoneNumber(auth, phoneNumber, window.recaptchaVerifier)
                .then((result) => {
                    confirmationResult = result;
                    document.getElementById('otp_container').style.display = 'block';
                    document.getElementById('otp_message').innerHTML = '<span class="text-success">OTP sent!</span>';
                    this.style.display = 'none';
                }).catch((error) => {
                    this.disabled = false;
                    this.innerHTML = 'SEND OTP CODE';
                    document.getElementById('otp_message').innerHTML = `<span class="text-danger">${error.message}</span>`;
                });
        });

        // Verify OTP Logic
        document.getElementById('btn_verify_otp').addEventListener('click', function() {
            const code = document.getElementById('otp_code').value;
            if(!code) return;

            this.disabled = true;
            this.innerHTML = '...';

            confirmationResult.confirm(code).then((result) => {
                document.getElementById('otp_message').innerHTML = '<span class="text-success fw-bold"><i class="bi bi-check-circle"></i> Phone Verified!</span>';
                document.getElementById('otp_container').style.display = 'none';
                document.getElementById('password_fields').style.display = 'block';
                document.getElementById('btn_reset_final').style.display = 'block';
                fullPhoneHidden.value = iti.getNumber();
            }).catch((error) => {
                this.disabled = false;
                this.innerHTML = 'Verify';
                document.getElementById('otp_message').innerHTML = '<span class="text-danger">Invalid code.</span>';
            });
        });
    });
</script>
@endpush