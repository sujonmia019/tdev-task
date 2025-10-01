@extends('layouts.app')
@section('title', 'Dashboard')
@push('styles')

@endpush
@section('content')
<div class="row mb-5">
    <div class="col-md-12">
        @if($subscriptions->count())
        <table class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Plan Name</th>
                    <th>Price</th>
                    <th>Currency</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Payment Gateway</th>
                    <th>Transaction ID</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscriptions as $index => $subscription)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $subscription->plan->name }}</td>
                    <td>{{ $subscription->plan->price }}</td>
                    <td>{{ $subscription->plan->currency }}</td>
                    <td>{{ dateFormat($subscription->start_date, 'd-m-Y') }}</td>
                    <td>{{ dateFormat($subscription->end_date, 'd-m-Y') }}</td>
                    <td>
                        @php
                        $today = now();
                        $status = $subscription->end_date >= $today ? 'Active' : 'Expired';
                        @endphp
                        <span class="badge {{ $status=='Active' ? 'bg-success' : 'bg-danger' }}">
                            {{ $status }}
                        </span>
                    </td>
                    <td>{{ $subscription->payment?->payment_gateway ?? '-' }}</td>
                    <td>{{ $subscription->payment?->transaction_id ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No subscriptions found. <a href="{{ route('user.plans.index') }}">Subscribe now</a></p>
        @endif
    </div>
</div>
@endsection
@push('scripts')

@endpush
