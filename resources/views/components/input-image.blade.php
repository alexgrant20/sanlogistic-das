<div class="d-flex flex-column">
  <div class="mb-3">
    <label for="{{ $id }}" class="form-label fs-5 text-primary">{{ $label }}</label>
    <input name="{{ $id }}" class="form-control form-dark form-control-lg @error("$id") is-invalid @enderror"
      id="{{ $id }}" type="file" accept=".png, .jpeg, .jpg" {{ isset($required) ? 'required' : '' }}
      onchange="previewImage('{{ $id }}')">

    @error("$id")
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <img src="{{ isset($imagePath) ? asset("/storage/$imagePath") : asset('/img/default.jpg') }}" style="height: 300px;"
    class="img-fluid zoom m-auto d-block mw-100" alt="" id="{{ $id }}-preview" data-action="zoom">
</div>
