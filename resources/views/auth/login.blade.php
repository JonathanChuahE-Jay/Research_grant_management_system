@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" >
    <div class="login-container" style="width: 100%; max-width: 400px; padding: 2rem; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h1 class="text-center mb-4">{{ __('Login') }}</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group mb-3">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
                <a href="{{ route('password.request') }}" style="text-decoration: none;">{{ __('Forgot Password?') }}</a>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">{{ __('Login') }}</button>

            <a class="btn btn-outline-secondary w-100" href="{{ route('register') }}">{{ __('Register') }}</a>
        </form>

        <div class="text-center mt-3">
            <small>&copy; {{ date('Y') }}  Research Grant Management System</small>
        </div>
    </div>
</div>
@endsection
