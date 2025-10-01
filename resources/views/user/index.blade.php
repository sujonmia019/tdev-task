@extends('layouts.app')
@section('title', 'User List')
@push('styles')

@endpush
@section('content')
<div class="row mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header py-2 px-3 border-bottom">
                <h5 class="card-title mb-0">User List</h5>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive text-nowrap">
                    <table class="table table-sm table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Is Verified</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{!! userVerifiedLabel($user->email_verified_at) !!}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-danger text-center">Records not found!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-2">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush
