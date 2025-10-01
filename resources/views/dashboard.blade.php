@extends('layouts.app')
@section('title', 'Dashboard')
@push('styles')

@endpush
@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="card-text fs-4">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Active Subscriptions</h5>
                <p class="card-text fs-4">{{ $activeSubs }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Revenue</h5>
                <p class="card-text fs-4">${{ number_format($totalRevenue,2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Pending Payments</h5>
                <p class="card-text fs-4">{{ $pendingPayments }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header py-2 px-3 border-bottom">
                <h5 class="card-title mb-0">Latest Subscriptions</h5>
            </div>
            <div class="card-body p-3">
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Payment Gateway</th>
                            <th>Transaction ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestSubscriptions as $index => $sub)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $sub->user->name }}</td>
                            <td>{{ $sub->plan->name }}</td>
                            <td>{{ dateFormat($sub->start_date, 'd-m-Y') }}</td>
                            <td>{{ dateFormat($sub->end_date, 'd-m-Y') }}</td>
                            <td>
                                @php $status = $sub->end_date >= now() ? 'Active' : 'Expired'; @endphp
                                <span class="badge {{ $status=='Active' ? 'bg-success' : 'bg-danger' }}">{{ $status }}</span>
                            </td>
                            <td>{{ $sub->payment?->payment_gateway ?? '-' }}</td>
                            <td>{{ $sub->payment?->transaction_id ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header py-2 px-3 border-bottom">
                <h5 class="card-title mb-0">Latest Payments</h5>
            </div>
            <div class="card-body p-3">
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Payment Gateway</th>
                            <th>Status</th>
                            <th>Transaction ID</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestPayments as  $pay)
                        <tr>
                            <td>{{ $pay->user->username }}</td>
                            <td>{{ $pay->amount }}</td>
                            <td>{{ $pay->currency }}</td>
                            <td>{{ $pay->payment_gateway }}</td>
                            <td>
                                <span class="badge
                                    {{ $pay->status == \App\Constants\Enum::COMPLETE ? 'bg-success' : ($pay->status==\App\Constants\Enum::FAILED ? 'bg-danger' : 'bg-warning') }}">
                                    {{ \App\Constants\Enum::PAYMENT_STATUS_LABEL[$pay->status] }}
                                </span>
                            </td>
                            <td>{{ $pay->transaction_id ?? '-' }}</td>
                            <td>{{ dateFormat($pay->created_at) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <p><strong>Default Payment Gateway:</strong> {{ $defaultGateway->name ?? 'Not set' }}</p>
    </div>
</div>
@endsection
@push('scripts')

@endpush
