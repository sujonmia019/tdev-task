@extends('layouts.auth')
@section('title', 'Reset Password Email')
@push('styles')

@endpush
@section('content')
<!-- /Logo -->
<h4 class="mb-2">Forgot Password? 🔒</h4>
<p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
<form id="formAuthentication" class="mb-3" action="{{ route('password.update') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <x-input type="email" name="email" value="{{ $email ?? old('email') }}" placeholder="Enter your email"/>
    <x-input type="password" name="password" placeholder="New Password" />
    <x-input type="password" name="password_confirmation" placeholder="Confirm Password" />
    <button class="btn btn-primary d-grid w-100">Reset Password</button>
</form>
<div class="text-center">
    <a href="{{ url('login') }}" class="d-flex align-items-center justify-content-center">
        <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
        Back to login
    </a>
</div>
@endsection
@push('scripts')

@endpush
