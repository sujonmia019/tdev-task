<div class="mb-3 {{ $groupClass ?? '' }}">
    @if (!empty($label))
        <label for="{{ $name }}" class="form-label {{ $required ?? '' }}">{{ $label }}</label>
    @endif
    <input type="{{ $type ?? 'text' }}" class="form-control form-control-sm {{ $class ?? '' }}" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder ?? '' }}" autocomplete="off" @if(!empty($value)) value="{{ $value }}" @endif />
    @error($name)
        <small class="text-danger d-block">{{ $message }}</small>
    @enderror
</div>
