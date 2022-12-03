<div class="mb-3">
  <label for="name" class="form-label">Nama Area</label>
  <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name"
    name="name" value="{{ old('name', $area->name) }}" autofocus>

  @error('name')
    <div class="invalid-feedback">
      {{ $message }}
    </div>
  @enderror
</div>

<div class="mb-3">
  <label for="regional_id" class="form-label">Regional</label>
  <select class='form-select form-select-lg @error('regional_id') is-invalid @enderror' name='regional_id'>
    <option value='' hidden></option>
    @foreach ($regionals as $regional)
      <option value="{{ $regional->id }}" @selected($regional->id == old('regional_id', $area->regional_id))>{{ $regional->name }}</option>
    @endforeach
  </select>

  @error('regional_id')
    <div class="invalid-feedback">
      {{ $message }}
    </div>
  @enderror
</div>

<div class="mb-3">
  <label for="description" class="form-label">Deskripsi</label>

  <div class="input-group">
    <textarea class="form-control" name="description">{{ $area->description }}</textarea>
  </div>

  @error('description')
    <div class="invalid-feedback">
      {{ $message }}
    </div>
  @enderror
</div>
