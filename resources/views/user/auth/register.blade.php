@extends('user.auth.common.app', ['title' => 'Register'])
@section('content')

    <main class="login-wrapper">
        <div class="container-flud h-100">
            <div class="row align-items-center h-100">
                <div class="col-md-6 col-lg-5 col-xl-4 mx-auto">
                    <div class="login">
                        <div class="login-card">
                            <div class="card-header">
                                <img src="{{ asset('admin/images/logo.svg') }}" class="light-logo" alt="brand-logo" />
                            </div>
                            <div class="login-form">
                                <h1>Register a new account</h1>
                                <p>Welcome! Please fill in the details to create a new account.</p>
                                <form id="register-form" autocomplete="off" action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <!-- Full Name -->
                                    <div class="field mb-3">
                                        <label for="name">Full Name <sup>*</sup></label>
                                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required minlength="3" />
                                        @error('name')
                                            <span id="name-error" class="server-error error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- Email -->
                                    <div class="field mb-3">
                                        <label for="email">Email <sup>*</sup></label>
                                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required />
                                        @error('email')
                                            <span id="email-error" class="server-error error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- Phone Number -->
                                    <div class="field mb-3">
                                        <label for="phone">Phone Number <sup>*</sup></label>
                                        <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required pattern="\d+" />
                                        @error('phone')
                                            <span id="phone-error" class="server-error error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="country_code" id="country_code" value="{{ old('country_code') }}" />
                                   @error('country_code')
                                   <span id="country_code-error" class="server-error error">{{ $message }}</span>
                                   @enderror
                                    <!-- Password -->
                                    <div class="field mb-3">
                                        <label for="password">Password <sup>*</sup></label>
                                        <input type="password" id="password" name="password" class="form-control" required minlength="8" />
                                        <span class="password-toggle-icon"><span class="iconify" id="eye-icon" data-icon="mdi:eye-off" data-inline="false"></span></span>
                                        @error('password')
                                            <span id="password-error" class="server-error error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- Confirm Password -->
                                    <div class="field mb-3">
                                        <label for="password_confirmation">Confirm Password <sup>*</sup></label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required />
                                        @error('password_confirmation')
                                            <span id="password_confirmation-error" class="server-error error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- Accept Terms & Conditions -->
                                    <div class="field mb-3">
                                        <div class="form-check form-check-inline">
                                            <input id="terms" type="checkbox" name="terms" required />
                                            <label for="terms">I accept the Terms & Conditions</label>
                                        </div>
                                        @error('terms')
                                            <span id="terms-error" class="server-error error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button class="btn btn-secondary btn-block w-100 mt-4 mb-4" type="submit" id="register">
                                        Register
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="copyright-text text-center">
                        <p>Ⓒ {{ Carbon\Carbon::now()->year }}  {{ config('app.name') }}. All rights reserved.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-4 ml-auto d-none d-lg-block">
                    <div class="banner-image">
                        <img src="{{ asset('admin/images/login-banner.webp') }}" class="img-fluid" alt="Login Banner" />
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
<script src="{{ asset('user/register.js') }}"></script>
<script>
    const merchantValidationMessages = @json(__('merchant'));
</script>
<script>
    document.getElementById('register-form').addEventListener('submit', function(event) {
        const phoneInput = document.getElementById('phone');
        const countryCodeInput = document.getElementById('country_code');
        const phoneNumber = phoneInput.value;
        const countryCode = phoneNumber.substring(0, phoneNumber.indexOf(' '));
        countryCodeInput.value = countryCode;
    });
</script>
@endsection
