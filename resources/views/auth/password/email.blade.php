@extends('layouts.auth')
@section('title', 'Reset Password Email')
@push('styles')

@endpush
@section('content')

    <h4 class="mb-2">Forgot Password? 🔒</h4>
    <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
    <form id="formAuthentication" class="mb-3" action="{{ route('password.email') }}" method="POST">
        @csrf
        <x-input name="email" label="Email" placeholder="Enter your email"/>

        <button class="btn btn-primary d-grid w-100">Send Reset Link</button>
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
