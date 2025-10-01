@extends('layouts.app')
@section('title', 'Plan List')
@push('styles')

@endpush
@section('content')
<div class="row mb-5">
    <div class="col-md-6 col-12 mx-auto">
        <div class="card">
            <div class="card-header py-2 px-3 border-bottom">
                <h5 class="card-title mb-0 d-flex align-items-center justify-content-between">
                    New Plan
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-sm btn-danger shadow-none">Back</a>
                </h5>
            </div>
            <div class="card-body p-3">
                <form action="{{ route('admin.plans.update-or-store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @isset($plan)
                    <input type="hidden" name="update_id" value="{{ $plan->id }}">
                    @endisset
                    <x-input name="name" label="Name" required="required" value="{{ $plan->name ?? old('name') }}" placeholder="Enter plan name"/>
                    <x-input name="price" label="Price" required="required" value="{{ $plan->price ?? old('price') }}" placeholder="Enter price"/>
                    <x-input name="currency" label="Currency" required="required" value="{{ $plan->currency ?? old('currency') }}" placeholder="Enter currency"/>
                    <x-input name="data_limit" label="Data Limit" required="required" value="{{ $plan->data_limit ?? old('data_limit') }}" placeholder="Enter data limit"/>
                    <x-input name="duration" label="Duration" required="required" value="{{ $plan->duration ?? old('duration') }}" placeholder="Enter duration day"/>
                    <x-input type="file" name="image" label="Image" required="required"/>
                    <input type="hidden" name="old_image" value="{{ $plan->image ?? '' }}">
                    <div class="text-end">
                        <button type="submit" class="btn btn-sm btn-primary">
                            @isset($plan)
                                Update
                            @else
                                Save
                            @endisset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush