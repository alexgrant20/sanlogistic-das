<div class="{{ $container ?? 'mb-3' }}">
  <label for="{{ $id }}" class="form-label {{ $labelStyle ?? 'fs-5 text-primary' }}">{{ __($label) }}</label>
  <input type="{{ $type ?? 'text' }}" id="{{ $id }}" name="{{ $id }}" value="{{ $value ?? null }}"
    class="form-control {{ $inputStyle ?? 'form-control-lg form-dark' }}" {{ isset($disabled) ? 'disabled' : '' }}
    {{ isset($readonly) ? 'readonly' : '' }}>

  @error('{{ $id }}')
    <div class="invalid-feedback d-block">
      {{ $message }}
    </div>
  @enderror
</div>
