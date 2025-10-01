@extends('layouts.auth')
@section('title', 'Register')
@push('styles')

@endpush
@section('content')

    <h4 class="mb-2">Adventure starts here 🚀</h4>
    <p class="mb-4">Make your app management easy and fun!</p>

    <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
        @csrf

        <x-input label="Username" name="username" required="required" value="{{ old('username') }}" placeholder="Enter your username"/>
        <x-input type="email" label="Email" name="email" required="required" value="{{ old('email') }}" placeholder="Enter your email"/>
        <x-input type="tel" label="Phone" name="phone" required="required" value="{{ old('phone') }}" placeholder="Enter your phone"/>

        <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password">Password</label>
            <div class="input-group input-group-sm input-group-merge">
                <input type="password" id="password" class="form-control" name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
            @error('password')
                <small class="text-danger d-block">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                <label class="form-check-label" for="terms-conditions">
                    I agree to
                    <a href="javascript:void(0);">privacy policy & terms</a>
                </label>
            </div>
            @error('terms')
                <small class="text-danger d-block">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary d-grid w-100">Sign up</button>
    </form>

    <p class="text-center">
        <span>Already have an account?</span>
        <a href="{{ url('login') }}">
            <span>Sign in instead</span>
        </a>
    </p>

@endsection
@push('scripts')

@endpush
