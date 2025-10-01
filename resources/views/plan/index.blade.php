@extends('layouts.app')
@section('title', 'Plan List')
@push('styles')

@endpush
@section('content')
<div class="row mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header py-2 px-3 border-bottom">
                <h5 class="card-title mb-0 d-flex align-items-center justify-content-between">
                    Plan List
                    <a href="{{ route('admin.plans.create') }}" class="btn btn-sm btn-primary shadow-none">Add Plan</a>
                </h5>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive text-nowrap">
                    <table class="table table-sm table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Currency</th>
                                <th>Duration Day</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($plans as $plan)
                            <tr>
                                <td>{!! tableImage($plan->image,$plan->name) !!}</td>
                                <td>{{ $plan->name }}</td>
                                <td>{{ $plan->price }}</td>
                                <td>{{ $plan->currency }}</td>
                                <td>{{ $plan->duration }}</td>
                                <td>{{ dateFormat($plan->created_at) }}</td>
                                <td>
                                    <a href="{{ route('admin.plans.edit', $plan->id) }}" class="btn btn-xs btn-warning">Edit</a>
                                    <button type="button" class="btn btn-xs btn-danger delete_btn" onclick="deleteItem({{ $plan->id }})">Delete</button>

                                    <form action="{{ route('admin.plans.destroy', $plan->id) }}" class="d-none" id="delete_form_{{ $plan->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-danger text-center">Records not found!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-2">
                        {{ $plans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush
