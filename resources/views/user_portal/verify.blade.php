@extends('layouts.app')
@section('title', 'Email Verification')
@push('styles')

@endpush
@section('content')
<div class="row">
    <div class="col-12 col-md-6 mx-auto">
        <div class="card border-0 rounded-4">
            <div class="card-body text-center p-5">
                <h3 class="fw-bold mb-3">Verify Your email</h3>
                <p class="text-muted mb-4">
                    We’ve sent a verification link to your email address.
                    Please check your inbox and click the link to continue.
                </p>

                <!-- Resend Button -->
                <form method="POST" action="{{ route('user.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                        Resend The Email
                    </button>
                </form>

                <!-- Extra Info -->
                <div class="mt-4">
                    <small class="text-muted">
                        Didn’t receive the email? Check your spam folder or click resend.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush
