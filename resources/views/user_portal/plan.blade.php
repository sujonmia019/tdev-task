@extends('layouts.app')
@section('title', 'Dashboard')
@push('styles')

@endpush
@section('content')
<div class="row mb-5">
    @forelse ($plans as $plan)
    <div class="col-md-6 col-lg-4 mb-3">
        <div class="card h-100">
            <img class="card-img-top" src="../assets/img/elements/2.jpg" alt="Card image cap" />
            <div class="card-body">
                <h5 class="card-title">{{ $plan->name }}</h5>
                <p class="card-text">
                    {{ $plan->description }}
                </p>
                <a href="{{ route('user.plans.subscribe', $plan->id) }}" class="btn btn-outline-primary"><i
                        class="tf-icons bx bx-cart-alt me-1"></i>Subscribe Now</a> <span
                    style="float: right; font-size: 20px; font-weight: 700;">{{ CURRENCY[$plan->currency] }} {{ $plan->price }}</span>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center text-danger fw-bold">Not Available Plans</div>
    </div>
    @endforelse
</div>
@endsection
@push('scripts')

@endpush
