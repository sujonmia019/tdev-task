@extends('layouts.app')
@section('title', 'Gateway')
@push('styles')

@endpush
@section('content')
    <div class="row mb-5">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header py-2 px-3 border-bottom">
                    <h5 class="card-title mb-0">New Gateway</h5>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('admin.gateways.store') }}" method="POST">
                        @csrf

                        <x-select name="name" label="Name" required="required">
                            <option value="">-- Select Payment --</option>
                            @foreach (PAYMENT_GATEWAY as $key=>$value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </x-select>
                        <x-input name="public_key" label="Public Key" required="required"/>
                        <x-input name="secret_key" label="Secret Key" required="required"/>

                        <div class="form-check mb-3">
                            <input type="checkbox" name="is_default" class="form-check-input" id="is_default">
                            <label for="is_default" class="form-check-label">Set as Default</label>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header py-2 px-3 border-bottom">
                    <h5 class="card-title mb-0">Gateway List</h5>
                </div>
                <div class="card-body p-3">
                    <table class="table table-sm table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Default</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gateways as $gateway)
                            <tr>
                                <td>{{ $gateway->name }}</td>
                                <td>{{ $gateway->is_default ? 'Yes' : 'No' }}</td>
                                <td>
                                    @if(!$gateway->is_default)
                                        <form action="{{ route('admin.gateways.default', $gateway->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-xs btn-success">Set Default</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-danger text-center" colspan="3">Gateway not found</td>
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