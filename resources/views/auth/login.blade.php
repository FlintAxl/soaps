@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>

    /* Login page specific styles to match the white and light purple theme */

/* Custom variables to match theme */
:root {
    --primary-purple: #9370DB;
    --light-purple: #D8BFD8;
    --very-light-purple: #E6E6FA;
    --hover-purple: #B794F4;
    --text-purple: #4B0082;
}

/* Card styling */
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(147, 112, 219, 0.1);
    overflow: hidden;
}

.card-header {
    background-color: white;
    border-bottom: 1px solid var(--very-light-purple);
    font-weight: 600;
    color: var(--text-purple);
    font-size: 1.2rem;
    padding: 1rem 1.5rem;
}

.card-body {
    padding: 2rem;
    background-color: white;
}

/* Form controls */
.form-control {
    border: 1px solid var(--light-purple);
    border-radius: 6px;
    padding: 0.75rem 1rem;
    transition: all 0.3s;
}

.form-control:focus {
    border-color: var(--primary-purple);
    box-shadow: 0 0 0 0.2rem rgba(147, 112, 219, 0.25);
}

.form-control.is-invalid {
    border-color: #FF6B81;
}

.invalid-feedback {
    color: #FF6B81;
}

/* Labels */
.col-form-label {
    color: #555;
    font-weight: 500;
}

/* Checkbox */
.form-check-input {
    border-color: var(--light-purple);
}

.form-check-input:checked {
    background-color: var(--primary-purple);
    border-color: var(--primary-purple);
}

.form-check-label {
    color: #555;
}

/* Buttons */
.btn-primary {
    background-color: var(--primary-purple);
    border-color: var(--primary-purple);
    padding: 0.5rem 1.5rem;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-primary:hover {
    background-color: var(--hover-purple);
    border-color: var(--hover-purple);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(147, 112, 219, 0.2);
}

.btn-primary:active {
    transform: translateY(0);
    box-shadow: 0 2px 4px rgba(147, 112, 219, 0.1);
}

.btn-link {
    color: var(--primary-purple);
    text-decoration: none;
    transition: all 0.3s;
}

.btn-link:hover {
    color: var(--hover-purple);
    text-decoration: underline;
}

/* Container spacing */
.container {
    margin-top: 2rem;
    margin-bottom: 2rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }

    .col-form-label.text-md-end {
        text-align: left !important;
        margin-bottom: 0.5rem;
    }

    .offset-md-4 {
        margin-left: 0;
    }
}

/* Animation for form elements */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.card {
    animation: fadeIn 0.5s ease-out;
}

.row.mb-3 {
    animation: fadeIn 0.5s ease-out;
    animation-fill-mode: both;
}

.row.mb-3:nth-child(1) {
    animation-delay: 0.1s;
}

.row.mb-3:nth-child(2) {
    animation-delay: 0.2s;
}

.row.mb-3:nth-child(3) {
    animation-delay: 0.3s;
}

.row.mb-0 {
    animation: fadeIn 0.5s ease-out;
    animation-delay: 0.4s;
    animation-fill-mode: both;
}
</style>
@endsection
