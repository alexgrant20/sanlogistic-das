<div class="mb-5">
  <h4 class="text-primary fw-bold">Data Kendaraan</h4>
  <hr>
  <div class="row g-5">
    <div class="col-xl-6">
      <div class="row g-2 mb-2">

        <div class="col-xl-6">
          <label for="license_plate" class="form-label">Plat Kendaraan</label>
          <input type="text" class="form-control form-control-lg @error('license_plate') is-invalid @enderror"
            id="license_plate" name="license_plate" value="{{ old('license_plate', $vehicle->license_plate) }}"
            onkeyup="plateNumberHandler(this.value, 'number')" autofocus>
          @error('license_plate')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="vehicle_license_plate_color_id" class="form-label">Warna TNKB</label>
          <select class='form-select form-select-lg @error('license_plate_color') is-invalid @enderror'
            name='vehicle_license_plate_color_id' id="vehicle_license_plate_color_id"
            onchange="plateNumberHandler(this.value, 'color')">
            <option hidden></option>
            @foreach ($vehiclesLPColors as $LPColor)
              @if ($LPColor->id == old('vehicle_license_plate_color_id', $vehicle->vehicle_license_plate_color_id))
                <option value="{{ $LPColor->id }}" selected>{{ $LPColor->name }}</option>
              @else
                <option value="{{ $LPColor->id }}">{{ $LPColor->name }}</option>
              @endif
            @endforeach
          </select>
          @error('license_plate_color')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="area_id" class="form-label">Area</label>
          <select class='form-select form-select-lg  @error('area_id') is-invalid @enderror' name='area_id'
            id="area_id">
            <option hidden></option>
            @foreach ($areas as $area)
              @if ($area->id == old('area_id', $vehicle->area_id))
                <option value="{{ $area->id }}" selected>{{ $area->name }}</option>
              @else
                <option value="{{ $area->id }}">{{ $area->name }}</option>
              @endif
            @endforeach
          </select>
          @error('area_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="project_id" class="form-label">Nama Project</label>
          <select class='form-select form-select-lg  @error('project_id') is-invalid @enderror' name='project_id'>
            <option hidden></option>
            @foreach ($projects as $project)
              @if ($project->id == old('project_id', $vehicle->project_id))
                <option value="{{ $project->id }}" selected>{{ $project->name }}</option>
              @else
                <option value="{{ $project->id }}">{{ $project->name }}</option>
              @endif
            @endforeach
          </select>
          @error('project_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="vehicle_brand_id" class="form-label">Merk</label>
          <select class='form-select form-select-lg @error('vehicle_brand_id') is-invalid @enderror'
            name='vehicle_brand_id' id="vehicle_brand_id">
            <option hidden></option>
            @foreach ($vehiclesBrands as $vehicleBrand)
              @if ($vehicleBrand->id ==
                  old('vehicle_brand_id', $vehicle->vehicleVariety->vehicleType->vehicleBrand->id ?? null))
                <option value="{{ $vehicleBrand->id }}" selected>{{ $vehicleBrand->name }}</option>
              @else
                <option value="{{ $vehicleBrand->id }}">{{ $vehicleBrand->name }}</option>
              @endif
            @endforeach
          </select>
          @error('vehicle_brand_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <input type="hidden" id="type_id"
          value="{{ old('vehicle_type_id', $vehicle->vehicleVariety->vehicleType->id ?? null) }}">
        <div class="col-xl-6">
          <label for="vehicle_type_id" class="form-label">Jenis Kendaraan</label>
          <select class='form-select form-select-lg @error('vehicle_type_id') is-invalid @enderror'
            name='vehicle_type_id' id="vehicle_type_id" disabled>
            <option class=""></option>
          </select>
          @error('vehicle_type_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <input type="hidden" id="variety_id" value="{{ old('vehicle_variety_id', $vehicle->vehicle_variety_id) }}">
        <div class="col-xl-6">
          <label for="vehicle_variety_id" class="form-label">Tipe Kendaraan</label>
          <select class='form-select form-select-lg  @error('vehicle_variety_id') is-invalid @enderror'
            name='vehicle_variety_id' id="vehicle_variety_id" disabled>
            <option class=""></option>
          </select>
          @error('vehicle_variety_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="vehicle_towing_id" class="form-label">Jenis Mobil Penarik</label>
          <select class='form-select form-select-lg  @error('vehicle_towing_id') is-invalid @enderror'
            name='vehicle_towing_id' id="vehicle_towing_id">
            <option hidden></option>
            @foreach ($vehiclesTowings as $vehicleTowing)
              @if ($vehicleTowing->id == old('vehicle_towing_id', $vehicle->vehicle_towing_id))
                <option value="{{ $vehicleTowing->id }}" selected>{{ $vehicleTowing->name }}</option>
              @else
                <option value="{{ $vehicleTowing->id }}">{{ $vehicleTowing->name }}</option>
              @endif
            @endforeach
          </select>
          @error('vehicle_towing_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="address_id" class="form-label">Lokasi Kendaraan</label>
          <select class='form-select form-select-lg @error('address_id') is-invalid @enderror' name='address_id'
            id="address_id">
            <option hidden></option>
            @foreach ($addresses as $address)
              @if ($address->id == old('address_id', $vehicle->address_id))
                <option value="{{ $address->id }}" selected>{{ $address->name }}</option>
              @else
                <option value="{{ $address->id }}">{{ $address->name }}</option>
              @endif
            @endforeach
          </select>
          @error('address_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="owner_id" class="form-label">Pemilik</label>
          <select class='form-select form-select-lg  @error('owner_id') is-invalid @enderror' name='owner_id'
            id="owner_id">
            <option hidden></option>
            @foreach ($companies as $company)
              @if ($company->id == old('owner_id', $vehicle->owner_id))
                <option value="{{ $company->id }}" selected>{{ $company->name }}</option>
              @else
                <option value="{{ $company->id }}">{{ $company->name }}</option>
              @endif
            @endforeach
          </select>
          @error('owner_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="modification" class="form-label">Modifikasi</label>
          <input type="text" class="form-control form-control-lg @error('modification') is-invalid @enderror"
            id="modification" name="modification" value="{{ old('modification', $vehicle->modification) }}">
          @error('modification')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="registration_number" class="form-label">Nomor Registrasi</label>
          <input type="text"
            class="form-control form-control-lg @error('registration_number') is-invalid @enderror"
            id="registration_number" name="registration_number"
            value="{{ old('registration_number', $vehicle->registration_number) }}">
          @error('registration_number')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="frame_number" class="form-label">Nomor Rangka</label>
          <input type="text" class="form-control form-control-lg @error('frame_number') is-invalid @enderror"
            id="frame_number" name="frame_number" value="{{ old('frame_number', $vehicle->frame_number) }}">
          @error('frame_number')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="engine_number" class="form-label">Nomor Mesin</label>
          <input type="text" class="form-control form-control-lg @error('engine_number') is-invalid @enderror"
            id="engine_number" name="engine_number" value="{{ old('engine_number', $vehicle->engine_number) }}">
          @error('engine_number')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-4">
          <label for="capacity" class="form-label">Silinder</label>
          <div class="input-group">
            <input type="number" class="form-control form-control-lg @error('capacity') is-invalid @enderror"
              id="capacity" name="capacity" value="{{ old('capacity', $vehicle->capacity) }}">
            <div class="input-group-text">CC</div>
          </div>
          @error('capacity')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-4">
          <label for="wheel" class="form-label">Jumlah Ban</label>
          <input type="number" class="form-control form-control-lg @error('wheel') is-invalid @enderror"
            id="wheel" name="wheel" value="{{ old('wheel', $vehicle->wheel) }}">
          @error('wheel')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-4">
          <label for="internal_code" class="form-label">Kode Internal</label>
          <input type="text" class="form-control form-control-lg @error('internal_code') is-invalid @enderror"
            id="internal_code" name="internal_code" value="{{ old('internal_code', $vehicle->internal_code) }}">
          @error('internal_code')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-4">
          <label for="registration_year" class="form-label">Tahun Registrasi</label>
          <input type="number" min="1900" max="2099" step="1"
            class="form-control form-control-lg @error('registration_year') is-invalid @enderror"
            id="registration_year" name="registration_year"
            value="{{ old('registration_year', $vehicle->registration_year) }}">
          @error('registration_year')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-4">
          <label for="odo" class="form-label">ODO</label>
          <input type="number" class="form-control form-control-lg @error('odo') is-invalid @enderror"
            id="odo" name="odo" value="{{ old('odo', $vehicle->odo) }}">
          @error('odo')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

      </div>
    </div>
    <div class="col-xl-6 d-flex align-items-center justify-content-center">
      <div class="card rounded bg-white shadow-lg" id="plate">
        <div class="card-body d-flex flex-column align-items-center mw-100 text-truncate p-2">
          <h1 class="display-3 text-dark fw-bold mb-1" id="plateNumber">X XXX XX</h1>
          <hr class="w-100 m-0 mb-1">
          <div class="d-flex justify-content-between w-100">
            <h4 class="text-dark" id="kirYear">XX.XX</h4>
            <h4 class="text-dark" id="stnkYear">XX.XX</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- EOC Data Kendaraan -->

<div class="mb-5">
  <h4 class="text-primary fw-bold">KIR</h4>
  <hr>
  <div class="row g-5">
    <div class="col-xl-6">
      <div class="row g-2">

        <div class="col-xl-6">
          <label for="kir_number" class="form-label">Nomor KIR</label>
          <input type="text" class="form-control form-control-lg  @error('kir_number') is-invalid @enderror"
            id="kir_number" name="kir_number" value="{{ old('kir_number', $kir->number ?? null) }}">
          @error('kir_number')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="kir_expire" class="form-label">Masa Berlaku KIR</label>
          <input type="date" class="form-control form-control-lg @error('kir_expire') is-invalid @enderror"
            id="kir_expire" name="kir_expire" value="{{ old('kir_expire', $kir->expire ?? null) }}"
            onchange="plateNumberHandler(this.value, 'kir')">
          @error('kir_expire')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-12">
          <label for="kir_image" class="form-label">Gambar KIR</label>
          <input type="file" accept="image/*"
            class="form-control form-control-lg @error('kir_image') is-invalid @enderror" id="kir_image"
            name="kir_image" accept="image/*" onchange="previewImage('kir_image')">
          @error('kir_image')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

      </div>
    </div>
    <div class="col-xl-6">
      <div class="w-100 h-100 d-flex justify-content-center align-items-center"
        style="background-color: transparent;">
        <img src="{{ asset('storage/' . ($kir['image'] ?? 'default/default.jpg')) }}"
          class="img-fluid rounded zoom mw-100" style="max-height: 200px" id="kir_image-preview" alt=""
          data-action="zoom">
      </div>
    </div>
  </div>
</div> <!-- EOC KIR -->

<div class="mb-5">
  <h4 class="text-primary fw-bold">STNK</h4>
  <hr>
  <div class="row g-5">
    <div class="col-xl-6">
      <div class="row g-2">

        <div class="col-xl-6">
          <label for="stnk_number" class="form-label">Nomor STNK</label>
          <input type="text" class="form-control form-control-lg @error('stnk_number') is-invalid @enderror"
            id="stnk_number" name="stnk_number" value="{{ old('stnk_number', $stnk->number ?? null) }}">
          @error('stnk_number')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="stnk_expire" class="form-label">Masa Berlaku STNK</label>
          <input type="date" class="form-control form-control-lg @error('stnk_expire') is-invalid @enderror"
            id="stnk_expire" name="stnk_expire" value="{{ old('stnk_expire', $stnk->expire ?? null) }}"
            onchange="plateNumberHandler(this.value, 'stnk')">
          @error('stnk_expire')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-12">
          <label for="stnk_image" class="form-label">Gambar STNK</label>
          <input type="file" accept="image/*"
            class="form-control form-control-lg @error('stnk_image') is-invalid @enderror" id="stnk_image"
            name="stnk_image" onchange="previewImage('stnk_image')">
          @error('stnk_image')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      </div>
    </div>

    <div class="col-xl-6">
      <div class="w-100 h-100 d-flex justify-content-center align-items-center"
        style="background-color: transparent;">
        <img src="{{ asset('storage/' . ($stnk['image'] ?? 'default/default.jpg')) }}"
          class="img-fluid rounded zoom mw-100" style="max-height: 200px" id="stnk_image-preview" alt=""
          data-action="zoom" />
      </div>
    </div>

  </div>
</div>

<div class="mb-5">
  <h4 class="text-primary fw-bold">Gambar Kendaraan</h4>
  <hr>
  <div class="row g-5">

    <div class="col-xl-4">
      <label for="front_image" class="form-label">Gambar Depan</label>
      <input type="file" accept="image/*"
        class="form-control form-control-lg mb-3 @error('front_image') is-invalid @enderror" id="front_image"
        name="front_image" onchange="previewImage('front_image')" />
      @error('front_image')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
      <img src="{{ asset('storage/' . ($front['image'] ?? 'default/default.jpg')) }}"
        class="img-fluid rounded zoom mw-100 mx-auto d-block" style="max-height: 200px" id="front_image-preview"
        alt="" data-action="zoom">
    </div>

    <div class="col-xl-4">
      <label for="right_image" class="form-label">Gambar Kanan</label>
      <input type="file" accept="image/*"
        class="form-control form-control-lg mb-3 @error('right_image') is-invalid @enderror" id="right_image"
        name="right_image" onchange="previewImage('right_image')">
      @error('right_image')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
      <img src="{{ asset('storage/' . ($right['image'] ?? 'default/default.jpg')) }}"
        class="img-fluid rounded zoom mw-100 mx-auto d-block" style="max-height: 200px" id="right_image-preview"
        alt="" data-action="zoom">
    </div>

    <div class="col-xl-4">
      <label for="back_image" class="form-label">Gambar Belakang</label>
      <input type="file" accept="image/*"
        class="form-control form-control-lg mb-3 @error('back_image') is-invalid @enderror" id="back_image"
        name="back_image" onchange="previewImage('back_image')">
      @error('back_image')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
      <img src="{{ asset('storage/' . ($back['image'] ?? 'default/default.jpg')) }}"
        class="img-fluid rounded zoom mw-100 mx-auto d-block" style="max-height: 200px" id="back_image-preview"
        alt="" data-action="zoom">
    </div>

    <div class="col-xl-4">
      <label for="left_image" class="form-label">Gambar Kiri</label>
      <input type="file" accept="image/*"
        class="form-control form-control-lg mb-3 @error('left_image') is-invalid @enderror" id="left_image"
        name="left_image" onchange="previewImage('left_image')">
      @error('left_image')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
      <img src="{{ asset('storage/' . ($left['image'] ?? 'default/default.jpg')) }}"
        class="img-fluid rounded zoom mw-100 mx-auto d-block" style="max-height: 200px" id="left_image-preview"
        alt="" data-action="zoom">
    </div>

  </div>
</div>

<div class="col-xl-6 d-flex flex-column mb-3">
  <label for="note" class="form-label">Comments</label>
  <textarea class="form-control form-control-lg flex-grow-1" id="note" name="note">{{ old('note', $vehicle->note ?? null) }}</textarea>
</div>
