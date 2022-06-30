<div class="mb-5">
  <h4 class="text-primary fw-bold">Data Pribadi</h4>
  <hr>
  <div class="row">
    <div class="col-xl-6">
      <div class="row g-2 mb-2">

        <div class="col-xl-6">
          <label for="name" class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name"
            name="name" value="{{ old('name', $person->name) }}">
          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="area_id" class="form-label">Area</label>
          <select class='form-select form-select-lg @error('area_id') is-invalid @enderror' name='area_id'
            id="area_id">
            <option value='' hidden></option>
            @foreach ($areas as $area)
              @if ($area->id == old('area_id', $person->area_id))
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
          <label for="department_id" class="form-label">Jabatan</label>
          <select class='form-select form-select-lg @error('department_id') is-invalid @enderror' name='department_id'
            id="department_id">
            <option value='' hidden></option>
            @foreach ($departments as $department)
              @if ($department->id == old('department_id', $person->department_id))
                <option value="{{ $department->id }}" selected>{{ $department->name }}</option>
              @else
                <option value="{{ $department->id }}">{{ $department->name }}</option>
              @endif
            @endforeach
          </select>
          @error('department_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="project_id" class="form-label">Nama Project</label>
          <select class='form-select form-select-lg @error('project_id') is-invalid @enderror' name='project_id'
            id="project_id">
            <option value='' hidden></option>
            @foreach ($projects as $project)
              @if ($project->id == old('project_id', $person->project_id))
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
          <label for="joined_at" class="form-label">Tanggal Bergabung</label>
          <input type="date" class="form-control form-control-lg @error('joined_at') is-invalid @enderror"
            id="joined_at" name="joined_at" value="{{ old('joined_at', $person->joined_at) }}">
          @error('joined_at')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="city_id" class="form-label">Alamat</label>
          <select class='form-select form-select-lg @error('city_id') is-invalid @enderror' name='city_id'
            id="city_id">
            <option value='' hidden></option>
            @foreach ($cities as $city)
              @if ($city->id == old('city_id', $person->city_id))
                <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
              @else
                <option value="{{ $city->id }}">{{ $city->name }}</option>
              @endif
            @endforeach
          </select>
          @error('city_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-4">
          <label for="phone_number" class="form-label">Nomor Telepon</label>
          <input type="text" class="form-control form-control-lg @error('phone_number') is-invalid @enderror"
            id="phone_number" name="phone_number" value="{{ old('phone_number', $person->phone_number) }}">
          @error('phone_number')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-4">
          <label for="place_of_birth" class="form-label">Tempat Lahir</label>
          <input type="text" class="form-control form-control-lg @error('place_of_birth') is-invalid @enderror"
            id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth', $person->place_of_birth) }}">
          @error('place_of_birth')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-4">
          <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
          <input type="date" class="form-control form-control-lg @error('date_of_birth') is-invalid @enderror"
            id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $person->date_of_birth) }}">
          @error('date_of_birth')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-12">
          <label for="full_address" class="form-label">Alamat Lengkap</label>
          <input class="form-control form-control-lg @error('full_address') is-invalid @enderror" type="text"
            accept="full_address/*" name="full_address" value="{{ old('full_address', $person->full_address) }}"
            id="full_address">
          @error('full_address')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-12">
          <label for="image" class="form-label">Gambar Orang</label>
          <input class="form-control form-control-lg @error('image') is-invalid @enderror" type="file"
            accept="image/*" name="image" id="image" onchange="previewImage('image')">
          @error('image')
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
        <img src="{{ asset('storage/' . ($person->image ?? 'default/default.jpg')) }}"
          class="img-fluid rounded mw-100" style="max-height: 200px" id="image-preview" alt=""
          data-action="zoom">
      </div>
    </div>

  </div>
</div> <!-- EOC Data Pribadi -->

<div class="mb-5">
  <h4 class="text-primary fw-bold">Data Kartu Tanda Penduduk</h4>
  <hr>
  <div class="row">
    <div class="col-xl-6">
      <div class="row g-2 mb-2">

        <div class="col-xl-12">
          <label for="ktp" class="form-label">Nomor KTP</label>
          <input type="text" class="form-control form-control-lg @error('ktp') is-invalid @enderror"
            id="ktp" name="ktp" value="{{ old('ktp', $ktp->number ?? null) }}">
          @error('ktp')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-12">
          <label for="ktp_address" class="form-label">Alamat berdasarkan KTP</label>
          <input type="text" class="form-control form-control-lg @error('ktp_address') is-invalid @enderror"
            id="ktp_address" name="ktp_address" value="{{ old('ktp_address', $ktp->address ?? null) }}">
          @error('ktp_address')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-12">
          <label for="ktp_image" class="form-label">Gambar KTP</label>
          <input class="form-control form-control-lg @error('ktp_image') is-invalid @enderror" type="file"
            accept="image/*" name="ktp_image" id="ktp_image" onchange="previewImage('ktp_image')">
          @error('ktp_image')
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
        <img src="{{ asset('storage/' . ($ktp->image ?? 'default/default.jpg')) }}"
          class="img-fluid rounded mw-100" style="max-height: 200px" id="ktp_image-preview" alt=""
          data-action="zoom">
      </div>
    </div>

  </div>
</div> <!-- EOC Data KTP -->

<div class="mb-5">
  <h4 class="text-primary fw-bold">Data Surat Izin Mengemudi</h4>
  <hr>
  <div class="row">
    <div class="col-xl-6">
      <div class="row g-2 mb-2">

        <div class="col-xl-12">
          <label for="sim" class="form-label">Nomor SIM</label>
          <input type="text" class="form-control form-control-lg @error('sim') is-invalid @enderror"
            id="sim" name="sim" value="{{ old('sim', $sim->number ?? null) }}">
          @error('sim')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="sim_type_id" class="form-label">Jenis SIM</label>
          <select class='form-select form-select-lg @error('sim_type_id') is-invalid @enderror' name='sim_type_id'
            id="sim_type_id">
            <option hidden value=''></option>
            @foreach ($simTypes as $simType)
              @if ($simType->id == old('sim_type_id', $sim->specialID ?? null))
                <option value='{{ $simType->id }}' selected>{{ $simType->name }}</option>
              @else
                <option value='{{ $simType->id }}'>{{ $simType->name }}</option>
              @endif
            @endforeach
          </select>
          @error('sim_type_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-6">
          <label for="sim_expire" class="form-label">Masa Berlaku SIM</label>
          <input type="date" class="form-control form-control-lg @error('sim_expire') is-invalid @enderror"
            id="sim_expire" name="sim_expire" value="{{ old('sim_expire', $sim->expire ?? null) }}">
          @error('sim_expire')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-12">
          <label for="sim_address" class="form-label">Alamat Berdasarkan SIM</label>
          <input type="text" class="form-control form-control-lg @error('sim_address') is-invalid @enderror"
            id="sim_address" name="sim_address" value="{{ old('sim_address', $sim->address ?? null) }}">
          @error('sim_address')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="col-xl-12">
          <label for="sim_image" class="form-label">Gambar SIM</label>
          <input class="form-control form-control-lg @error('sim_image') is-invalid @enderror" type="file"
            accept="image/*" name="sim_image" id="sim_image" onchange="previewImage('sim_image')">
          @error('sim_image')
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
        <img src="{{ asset('storage/' . ($sim->image ?? 'default/default.jpg')) }}"
          class="img-fluid rounded mw-100" style="max-height: 200px" id="sim_image-preview" alt=""
          data-action="zoom">
      </div>

    </div>
  </div>
</div> <!-- EOC Data SIM -->

<div class="mb-5">
  <h4 class="text-primary fw-bold">Data Jaminan</h4>
  <hr>
  <div class="row">
    <div class="col-xl-6">

      <div class="mb-2">
        <label for="assurance" class="form-label">Jaminan</label>
        <input class="form-control form-control-lg @error('assurance') is-invalid @enderror" type="text"
          name="assurance" id="assurance" value="{{ old('assurance', $assurance->number ?? null) }}">
        @error('assurance')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="mb-2">
        <label for="assurance_image" class="form-label">Gambar Jaminan</label>
        <input class="form-control form-control-lg @error('assurance_image') is-invalid @enderror" type="file"
          accept="image/*" name="assurance_image" id="assurance_image" onchange="previewImage('assurance_image')">
        @error('assurance_image')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

    </div>

    <div class="col-xl-6">
      <div class="mb-2 w-100 p-2" style="background-color: transparent;">
        <img src="{{ asset('storage/' . ($assurance->image ?? 'default/default.jpg')) }}"
          class="img-fluid rounded mx-auto d-block" style="max-height: 200px" id="assurance_image-preview"
          alt="" data-action="zoom">
      </div>
    </div>

  </div>
</div> <!-- EOC data jaminan -->

<div class="mb-5">
  <h4 class="text-primary fw-bold">Data BPJS Kesehatan</h4>
  <hr>
  <div class="row">
    <div class="col-xl-6">

      <div class="mb-2">
        <label for="bpjs_kesehatan" class="form-label">Nomor BPJS Kesehatan</label>
        <input class="form-control form-control-lg @error('bpjs_kesehatan') is-invalid @enderror" type="text"
          name="bpjs_kesehatan" id="bpjs_kesehatan"
          value="{{ old('bpjs_kesehatan', $bpjs_kesehatan->number ?? null) }}">
        @error('bpjs_kesehatan')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="mb-2">
        <label for="bpjs_kesehatan_image" class="form-label">Gambar Kartu BPJS
          Ketenagakerjaan</label>
        <input class="form-control form-control-lg  @error('bpjs_kesehatan_image') is-invalid @enderror"
          type="file" accept="image/*" name="bpjs_kesehatan_image" id="bpjs_kesehatan_image"
          onchange="previewImage('bpjs_kesehatan_image')">
        @error('bpjs_kesehatan_image')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

    </div>

    <div class="col-xl-6">
      <div class="mb-2 w-100 p-2" style="background-color: transparent;">
        <img src="{{ asset('storage/' . ($bpjs_kesehatan->image ?? 'default/default.jpg')) }}"
          class="img-fluid rounded mx-auto d-block mw-100" style="max-height: 200px"
          id="bpjs_kesehatan_image-preview" alt="" data-action="zoom">
      </div>
    </div>

  </div>
</div> <!-- EOC data BPJS kesehatan -->

<div class="mb-5">
  <h4 class="text-primary fw-bold">Data BPJS Ketanagakerjaan</h4>
  <hr>
  <div class="row">
    <div class="col-xl-6">

      <div class="mb-2">
        <label for="bpjs_ketenagakerjaan" class="form-label">Nomor BPJS
          Ketenagakerjaan</label>
        <input class="form-control form-control-lg  @error('bpjs_ketenagakerjaan') is-invalid @enderror"
          type="text" name="bpjs_ketenagakerjaan" id="bpjs_ketenagakerjaan"
          value="{{ old('bpjs_ketenagakerjaan', $bpjs_ketenagakerjaan->number ?? null) }}">
        @error('bpjs_ketenagakerjaan')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="mb-2">
        <label for="bpjs_ketenagakerjaan_image" class="form-label">Gambar Kartu BPJS
          Ketenagakerjaan</label>
        <input class="form-control form-control-lg  @error('bpjs_ketenagakerjaan_image') is-invalid @enderror"
          type="file" accept="image/*" name="bpjs_ketenagakerjaan_image" id="bpjs_ketenagakerjaan_image"
          onchange="previewImage('bpjs_ketenagakerjaan_image')">
        @error('bpjs_ketenagakerjaan_image')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

    </div>

    <div class="col-xl-6">
      <div class="mb-2 w-100 p-2" style="background-color: transparent;">
        <img src="{{ asset('storage/' . ($bpjs_ketenagakerjaan->image ?? 'default/default.jpg')) }}"
          class="img-fluid rounded mx-auto d-block mw-100" style="max-height: 200px"
          id="bpjs_ketenagakerjaan_image-preview" alt="" data-action="zoom">
      </div>
    </div>

  </div>
</div> <!-- EOC data BPJS Ketanagakerjaan -->

<div class="mb-5">
  <h4 class="text-primary fw-bold">Data Nomor Pokok Wajib Pajak</h4>
  <hr>
  <div class="row">
    <div class="col-xl-6">

      <div class="mb-2">
        <label for="npwp" class="form-label">Nomor Pokok Wajib Pajak</label>
        <input class="form-control form-control-lg @error('npwp') is-invalid @enderror" type="text"
          name="npwp" id="npwp" value="{{ old('npwp', $npwp->number ?? null) }}">
        @error('npwp')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="mb-2">
        <label for="npwp_image" class="form-label">Gambar Kartu NPWP</label>
        <input class="form-control form-control-lg @error('npwp_image') is-invalid @enderror" type="file"
          accept="image/*" name="npwp_image" id="npwp_image" onchange="previewImage('npwp_image')">
        @error('npwp_image')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

    </div>

    <div class="col-xl-6">
      <div class="mb-2 w-100 p-2" style="background-color: transparent;">
        <img src="{{ asset('storage/' . ($npwp->image ?? 'default/default.jpg')) }}"
          class="img-fluid rounded mx-auto d-block mw-100" style="max-height: 200px;" id="npwp_image-preview"
          alt="" data-action="zoom">
      </div>
    </div>

  </div>
</div> <!-- EOC Nomor Pokok Wajib Pajak -->

<div class="form-floating mb-3">
  <textarea class="form-control @error('note') is-invalid @enderror" placeholder="Leave a comment here" id="note"
    name="note" style="height: 100px">{{ old('note', $person->note) }}</textarea>
  <label for="note">Comments</label>
  @error('note')
    <div class="invalid-feedback">
      {{ $message }}
    </div>
  @enderror
</div>
