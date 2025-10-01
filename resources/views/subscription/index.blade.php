@extends('layouts.app')
@section('title', 'Dashboard')
@push('styles')

@endpush
@section('content')
<div class="row mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header py-2 px-3 border-bottom">
                <h5 class="card-title mb-0">User Subscriptions</h5>
            </div>
            <div class="card-body p-3">
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Price</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Payment Gateway</th>
                            <th>Transaction ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $sub)
                        <tr>
                            <td>{{ $sub->user->username }}</td>
                            <td>{{ $sub->plan->name }}</td>
                            <td>{{ $sub->plan->price }} {{ $sub->plan->currency }}</td>
                            <td>{{ dateFormat($sub->start_date, 'd-m-Y') }}</td>
                            <td>{{ dateFormat($sub->end_date, 'd-m-Y') }}</td>
                            <td>
                                @php
                                    $status = $sub->end_date >= now() ? 'Active' : 'Expired';
                                @endphp
                                <span class="badge {{ $status=='Active' ? 'bg-success' : 'bg-danger' }}">{{ $status }}</span>
                            </td>
                            <td>{{ $sub->payment?->payment_gateway ?? '-' }}</td>
                            <td>{{ $sub->payment?->transaction_id ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No subscriptions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush
