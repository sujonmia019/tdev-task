@extends('layouts.auth')
@section('title', 'OTP')
@push('styles')

@endpush
@section('content')

    <h4 class="mb-2">Enter OTP 🔒</h4>
    <p class="mb-4">Enter your OTP Code that sent on your phone.</p>
    <form id="formAuthentication" class="mb-3" action="{{ route('otp-verify') }}" method="POST">
        @csrf

        <x-input name="otp" label="OTP Code" required="required" placeholder="Enter OTP" />

        <button class="btn btn-primary d-grid w-100">Submit Now</button>
    </form>
    <div class="text-center">
        <a href="{{ url('register') }}" class="d-flex align-items-center justify-content-center">
            <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
            Go Back
        </a>
    </div>

@endsection
