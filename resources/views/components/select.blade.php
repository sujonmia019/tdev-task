<div class="mb-3 {{ $groupClass ?? '' }}">
    @if (!empty($label))
        <label for="{{ $name }}" class="form-label {{ $required ?? '' }}">{{ $label }}</label>
    @endif
    <select class="form-control form-control-sm {{ $class ?? '' }}" id="{{ $name }}" name="{{ $name }}" @if(!empty($value)) value="{{ $value }}" @endif>
        {{ $slot }}
    </select>
    @error($name)
        <small class="text-danger d-block">{{ $message }}</small>
    @enderror
</div>
