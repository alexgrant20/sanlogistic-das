<div class="d-flex flex-column">
  <div class="mb-3">
    <label for="{{ $name }}" class="form-label fs-5 text-primary">{{ $label }}</label>
    <input name="{{ $name }}" class="form-control form-dark form-control-lg @error($name) is-invalid @enderror"
      id="{{ $name }}" type="file" accept=".png, .jpeg, .jpg" wire:model="image">

    @error($name)
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div wire:loading.flex wire:target="image">
    <div class="w-100 text-center">
      <div class="spinner-border" role="status"></div>
    </div>
  </div>

  <img src="{{ $image ? $image->temporaryUrl() : asset('/img/default.jpg') }}" style="height: 300px;"
    class="img-fluid zoom m-auto d-block mw-100" alt="" data-action="zoom">
</div>
