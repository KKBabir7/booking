@extends('layouts.main')

@section('navClass', 'sticky-nav-dark')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/signup.css') }}" />
<style>
    .auth-section { margin-top: 0px; }
    .auth-input-group { position: relative; margin-bottom: 20px; }
    .auth-input-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #adb5bd; z-index: 10; }
    .auth-input { padding-left: 45px !important; border-radius: 10px !important; height: 50px; border: 1px solid #eee; }
    .auth-input:focus { border-color: #f76156; box-shadow: 0 0 0 0.25rem rgba(247, 97, 86, 0.1); }
    .auth-input.is-invalid { border-color: #dc3545 !important; }
    .auth-input.is-invalid:focus { box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.1) !important; }
    .email-feedback { font-size: 0.75rem; color: #dc3545; display: none; margin-top: 4px; padding-left: 15px; }
    .btn-auth-primary { background: #f76156; border: none; color: white; border-radius: 50px; font-weight: 600; transition: all 0.3s; }
    .btn-auth-primary:hover { background: #e54b40; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(247, 97, 86, 0.3); color: white; }
    .custom-check:checked { background-color: #f76156; border-color: #f76156; }
    
    /* International Phone Input Styles */
    .iti { width: 100%; }
    .iti__flag-container { padding-left: 10px; }
    .iti__selected-flag { background: transparent !important; }
    .iti--allow-dropdown .iti__flag-container:hover .iti__selected-flag { background: rgba(0,0,0,0.05) !important; }
    .iti input { padding-left: 60px !important; }
    .iti__country-list, .iti--inline-dropdown .iti__dropdown-content { z-index: 12 !important; background-color: white !important; }

    /* Location Autocomplete Styles */
    .location-wrapper { position: relative; }
    .location-suggestions { 
        position: absolute; 
        top: 100%; 
        left: 0; 
        width: 100%; 
        background: white; 
        border: 1px solid #eee; 
        border-radius: 10px; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
        z-index: 1000; 
        max-height: 250px; 
        overflow-y: auto; 
        display: none;
        margin-top: 5px;
    }
    .suggestion-item { 
        padding: 12px 15px; 
        cursor: pointer; 
        transition: all 0.2s; 
        border-bottom: 1px solid #f8f9fa;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .suggestion-item:last-child { border-bottom: none; }
    .suggestion-item:hover { background: #f8f9fa; color: #f76156; }
    .suggestion-item i { color: #adb5bd; }
    .location-loading { padding: 10px; font-size: 0.8rem; color: #666; text-align: center; }

    /* Verification Toggle Styles */
    .verify-box {
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
        background: #fcfcfc;
    }
    .verify-option {
        display: flex;
        align-items: center;
        padding: 10px;
        border: 1px solid transparent;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 5px;
    }
    .verify-option:hover { background: #fff; border-color: #f7615633; }
    .verify-option.active { border-color: #f76156; background: #fff; }
    .verify-icon { font-size: 1.2rem; color: #f76156; margin-right: 12px; }
    .otp-group { display: none; margin-top: 15px; }
    #recaptcha-container { margin-bottom: 10px; }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/css/intlTelInput.css">
@endpush

@section('content')
<div class="auth-section">
    <div class="container">
      <div class="row min-vh-100 align-items-center justify-content-center py-5">
        <div class="col-lg-12 col-xl-12">
          <div class="auth-card shadow-lg border-0 overflow-hidden" style="border-radius: 20px;">
            <div class="row g-0">
              <!-- Left: Form side -->
              <div class="col-md-6 p-4 p-lg-5 bg-white">
                <div class="auth-box">
                  <h2 class="auth-title mb-4 text-center fw-bold" style="color: #2d3436;">Sign Up</h2>
                  
                  <div class="mb-4"></div>

                  <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="auth-input-group">
                      <i class="bi bi-person auth-input-icon"></i>
                      <input type="text" name="name" class="form-control auth-input" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
                      <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="auth-input-group">
                      <i class="bi bi-envelope auth-input-icon"></i>
                      <input type="email" name="email" id="user_email" class="form-control auth-input" placeholder="Email" value="{{ old('email') }}" required>
                      <div class="email-feedback" id="email_error">Please enter a valid email address (e.g., name@example.com)</div>
                      <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="auth-input-group">
                      <input type="tel" id="user_phone" name="phone_input" class="form-control auth-input" style="padding-left: 60px !important;" placeholder="Phone" value="{{ old('phone') }}" required>
                      <input type="hidden" name="phone" id="full_phone">
                      <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                    <div class="auth-input-group location-wrapper">
                      <i class="bi bi-geo-alt auth-input-icon"></i>
                      <input type="text" name="location" id="location_field" class="form-control auth-input" placeholder="Location" value="{{ old('location') }}" autocomplete="off">
                      <div id="location_suggestions" class="location-suggestions"></div>
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

                    <!-- Verification Choice -->
                    <div class="verify-box">
                      <p class="small fw-bold text-muted mb-3">Choose Verification Method:</p>
                      
                      <div class="verify-option active" id="opt_email">
                        <input type="radio" name="verify_method" value="email" id="method_email" class="form-check-input custom-check me-2" checked>
                        <label for="method_email" class="d-flex align-items-center cursor-pointer w-100 mb-0">
                          <i class="bi bi-envelope verify-icon"></i>
                          <div>
                            <span class="d-block fw-bold small">Email Verification</span>
                            <span class="text-muted" style="font-size: 0.7rem;">We'll send a link to your email.</span>
                          </div>
                        </label>
                      </div>

                      <div class="verify-option" id="opt_phone">
                        <input type="radio" name="verify_method" value="phone" id="method_phone" class="form-check-input custom-check me-2">
                        <label for="method_phone" class="d-flex align-items-center cursor-pointer w-100 mb-0">
                          <i class="bi bi-phone verify-icon"></i>
                          <div>
                            <span class="d-block fw-bold small">Phone OTP</span>
                            <span class="text-muted" style="font-size: 0.7rem;">Get code via SMS (Quick & Secure).</span>
                          </div>
                        </label>
                      </div>

                      <!-- Phone OTP Group -->
                      <div class="otp-group" id="otp_container">
                        <div id="recaptcha-container"></div>
                        <div class="d-flex gap-2">
                          <input type="text" id="otp_code" class="form-control auth-input" placeholder="Enter 6-digit OTP">
                          <button type="button" id="btn_verify_otp" class="btn btn-dark rounded-pill px-4 small">Verify</button>
                        </div>
                        <div id="otp_message" class="small mt-2"></div>
                      </div>
                    </div>

                    <input type="hidden" name="is_phone_verified" id="is_phone_verified" value="0">

                    <div class="form-check mb-4 d-flex align-items-center justify-content-center">
                      <input class="form-check-input custom-check me-2" type="checkbox" id="terms_agree" required>
                      <label class="form-check-label small text-muted cursor-pointer" for="terms_agree">
                        I agree to the <a href="#" class="text-decoration-none" style="color: #f76156;">Terms & Conditions</a>
                      </label>
                    </div>

                    <div class="text-center">
                      <button type="submit" id="btn_submit_main" class="btn btn-auth-primary px-5 py-2 w-100">SIGN UP</button>
                      <button type="button" id="btn_send_otp" class="btn btn-auth-primary px-5 py-2 w-100" style="display: none;">GET OTP CODE</button>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/js/intlTelInput.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.querySelector("#user_phone");
        const fullPhoneHidden = document.querySelector("#full_phone");
        
        const iti = window.intlTelInput(phoneInput, {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/js/utils.js",
            initialCountry: "bd",
            separateDialCode: true,
            preferredCountries: ["bd", "us", "gb", "sa", "ae"],
        });

        // Set initial value if exists
        if (phoneInput.value) {
            fullPhoneHidden.value = iti.getNumber();
        }

        const handleChange = () => {
            if (iti.isValidNumber()) {
                fullPhoneHidden.value = iti.getNumber();
            } else {
                fullPhoneHidden.value = phoneInput.value;
            }
        };

        phoneInput.addEventListener('change', handleChange);
        phoneInput.addEventListener('keyup', handleChange);
        
        // Final update on submit
        phoneInput.closest('form').addEventListener('submit', function() {
            fullPhoneHidden.value = iti.getNumber();
        });

        // Email Validation Logic
        const emailInput = document.querySelector("#user_email");
        const emailError = document.querySelector("#email_error");
        
        const validateEmail = (email) => {
            return String(email)
                .toLowerCase()
                .match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
        };

        emailInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                if (!validateEmail(this.value)) {
                    this.classList.add('is-invalid');
                    emailError.style.display = 'block';
                } else {
                    this.classList.remove('is-invalid');
                    emailError.style.display = 'none';
                }
            } else {
                this.classList.remove('is-invalid');
                emailError.style.display = 'none';
            }
        });

        // Location Autocomplete Logic
        const locationInput = document.querySelector("#location_field");
        const suggestionsBox = document.querySelector("#location_suggestions");
        let debounceTimer;

        locationInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const query = this.value.trim();
            
            if (query.length < 2) {
                suggestionsBox.style.display = 'none';
                return;
            }

            suggestionsBox.innerHTML = '<div class="location-loading"><i class="bi bi-arrow-repeat spin"></i> Searching...</div>';
            suggestionsBox.style.display = 'block';

            debounceTimer = setTimeout(() => {
                fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&limit=5`)
                    .then(response => response.json())
                    .then(data => {
                        suggestionsBox.innerHTML = '';
                        if (data.features && data.features.length > 0) {
                            data.features.forEach(feature => {
                                const city = feature.properties.city || feature.properties.name || '';
                                const country = feature.properties.country || '';
                                const state = feature.properties.state || '';
                                const fullLocation = [city, state, country].filter(item => item !== '').join(', ');

                                const div = document.createElement('div');
                                div.className = 'suggestion-item';
                                div.innerHTML = `<i class="bi bi-geo-alt"></i> <span>${fullLocation}</span>`;
                                div.onclick = () => {
                                    locationInput.value = fullLocation;
                                    suggestionsBox.style.display = 'none';
                                };
                                suggestionsBox.appendChild(div);
                            });
                            suggestionsBox.style.display = 'block';
                        } else {
                            suggestionsBox.style.display = 'none';
                        }
                    })
                    .catch(err => console.error('Location API Error:', err));
            }, 300);
        });

        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!locationInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.style.display = 'none';
            }
        });
    });
</script>

<!-- Firebase SDK -->
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
        const otpContainer = document.getElementById('otp_container');
        const btnSubmit = document.getElementById('btn_submit_main');
        const btnSendOtp = document.getElementById('btn_send_otp');
        const phoneOption = document.getElementById('opt_phone');
        const emailOption = document.getElementById('opt_email');
        const phoneInput = document.getElementById('full_phone');
        const isPhoneVerified = document.getElementById('is_phone_verified');

        // Toggle Logic
        methodEmail.addEventListener('change', function() {
            otpContainer.style.display = 'none';
            btnSubmit.style.display = 'block';
            btnSendOtp.style.display = 'none';
            emailOption.classList.add('active');
            phoneOption.classList.remove('active');
        });

        methodPhone.addEventListener('change', function() {
            otpContainer.style.display = 'block';
            btnSubmit.style.display = 'none';
            btnSendOtp.style.display = 'block';
            phoneOption.classList.add('active');
            emailOption.classList.remove('active');
            
            if(!window.recaptchaVerifier) {
                window.recaptchaVerifier = new RecaptchaVerifier(auth, 'recaptcha-container', {
                    'size': 'invisible'
                });
            }
        });

        // Send OTP Logic
        btnSendOtp.addEventListener('click', function() {
            const phoneNumber = phoneInput.value;
            if(!phoneNumber) {
                alert('Please enter a valid phone number first.');
                return;
            }

            btnSendOtp.disabled = true;
            btnSendOtp.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Sending...';

            signInWithPhoneNumber(auth, phoneNumber, window.recaptchaVerifier)
                .then((result) => {
                    confirmationResult = result;
                    document.getElementById('otp_message').innerHTML = '<span class="text-success">OTP sent to your phone!</span>';
                    btnSendOtp.style.display = 'none';
                }).catch((error) => {
                    btnSendOtp.disabled = false;
                    btnSendOtp.innerHTML = 'GET OTP CODE';
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
                isPhoneVerified.value = "1";
                document.getElementById('otp_message').innerHTML = '<span class="text-success fw-bold"><i class="bi bi-check-circle"></i> Phone Verified!</span>';
                document.getElementById('otp_container').innerHTML = '';
                btnSubmit.style.display = 'block';
                btnSubmit.innerHTML = 'COMPLETE SIGN UP';
            }).catch((error) => {
                this.disabled = false;
                this.innerHTML = 'Verify';
                document.getElementById('otp_message').innerHTML = '<span class="text-danger">Invalid code. Try again.</span>';
            });
        });

        // Form Submit Shield
        document.getElementById('btn_submit_main').closest('form').addEventListener('submit', function(e) {
            if(methodPhone.checked && isPhoneVerified.value === "0") {
                e.preventDefault();
                alert('Please verify your phone number first.');
            }
        });
    });
</script>
@endpush
