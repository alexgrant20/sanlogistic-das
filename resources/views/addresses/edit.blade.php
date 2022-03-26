@extends('layouts.main')

@section('headJS')
  <script type='text/javascript' src="/vendor/leaflet/js/leaflet/leaflet.js"></script>
  <script type='text/javascript' src="/vendor/leaflet/js/gestureHandling/leaflet-gesture-handling.min.js"></script>
  <script type='text/javascript' src="/vendor/leaflet/js/spin/spin.js"></script>
  <script type='text/javascript' src="/vendor/leaflet/js/spin/leaflet.spin.js"></script>
  <script type='text/javascript' src="/vendor/leaflet/js/esriLeaflet/esri-leaflet-old.js"></script>
  <script type='text/javascript' src="/vendor/leaflet/js/esriLeaflet/esri-leaflet-geocoder-old.js"></script>
@endsection

@section('headCSS')
  <link rel="stylesheet" type="text/css" href="/vendor/leaflet/css/esriLeaflet/esri-leaflet-geocoder-old.css">
  <link rel="stylesheet" href="/vendor/leaflet/css/gestureHandling/leaflet-gesture-handling.min.css" type="text/css">
  <link rel="stylesheet" href="/vendor/leaflet/css/leaflet.css" integrity="" crossorigin="" />
@endsection

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Create Address</h2>
      </div>
    </div>
    <section class="container-fluid">

      @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">
          {{ session('error') }}
        </div>
      @endif

      <form action="{{ url("/addresses/$address->name") }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-5">
          <h4 class="text-primary fw-bold">Data Alamat</h4>
          <hr>
          <div class="row g-2">

            <div class="col-xl-3">
              <label for="name" class="form-label">Nama Alamat</label>
              <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name"
                name="name" value="{{ old('name', $address->name) }}">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-3">
              <label for="area_id" class="form-label">Area</label>
              <select class='form-select form-select-lg @error('area_id') is-invalid @enderror' name='area_id'
                id="area_id">
                <option hidden></option>
                @foreach ($areas as $area)
                  @if ($area->id == old('area_id', $address->area_id))
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

            <div class="col-xl-3">
              <label for="pool_type_id" class="form-label">Jenis Pool</label>
              <select class='form-select form-select-lg @error('pool_type_id') is-invalid @enderror' name='pool_type_id'
                id="pool_type_id">
                <option hidden></option>
                @foreach ($pool_types as $pool_type)
                  @if ($pool_type->id == old('pool_type_id', $address->pool_type_id))
                    <option value="{{ $pool_type->id }}" selected>{{ $pool_type->name }}</option>
                  @else
                    <option value="{{ $pool_type->id }}">{{ $pool_type->name }}</option>
                  @endif
                @endforeach
              </select>
              @error('pool_type_id')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-3">
              <label for="address_type_id" class="form-label">Jenis Alamat</label>
              <select class='form-select form-select-lg  @error('address_type_id') is-invalid @enderror'
                name='address_type_id' id="address_type_id">
                <option hidden></option>
                @foreach ($address_types as $type)
                  @if ($type->id == old('address_type_id', $address->address_type_id))
                    <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                  @else
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                  @endif
                @endforeach
              </select>
              @error('address_type_id')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-3">
              <label for="province_id" class="form-label">Provinsi</label>
              <select class='form-select form-select-lg @error('province_id') is-invalid @enderror' name='province_id'
                id="province_id">
                <option hidden></option>
                @foreach ($provinces as $province)
                  @if ($province->id == old('province_id', $address->subdistrict->district->city->province->id ?? null))
                    <option value="{{ $province->id }}" selected>{{ $province->name }}</option>
                  @else
                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                  @endif
                @endforeach
              </select>
              @error('province_id')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <input type="hidden" id="ci_id"
              value="{{ old('city_id', $address->subdistrict->district->city->id ?? null) }}">
            <div class="col-xl-3">
              <label for="city_id" class="form-label">Kota</label>
              <div class="position-relative">
                <select class='form-select form-select-lg @error('city_id') is-invalid @enderror' name='city_id'
                  id="city_id" disabled>
                  <option hidden></option>
                </select>
                @error('city_id')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>

            <input type="hidden" id="di_id"
              value="{{ old('district_id', $address->subdistrict->district->id ?? null) }}">
            <div class="col-xl-3">
              <label for="district_id" class="form-label">Districts</label>
              <div class="position-relative">
                <select class='form-select form-select-lg @error('district_id') is-invalid @enderror' name='district_id'
                  id="district_id" disabled>
                  <option hidden></option>
                </select>
                @error('district_id')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>

            <input type="hidden" id="su_id" value="{{ old('subdistrict_id', $address->subdistrict_id ?? null) }}">
            <div class="col-xl-3">
              <label for="subdistrict_id" class="form-label">Sub Districts</label>
              <div class="position-relative">
                <select class='form-select form-select-lg @error('subdistrict_id') is-invalid @enderror'
                  name='subdistrict_id' id="subdistrict_id" disabled>
                  <option hidden></option>
                </select>
                @error('subdistrict_id')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-xl-10">
              <label for="full_address" class="form-label">Alamat Lengkap</label>
              <input class="form-control form-control-lg @error('full_address') is-invalid @enderror" type="text"
                name="full_address" id="full_address" value="{{ old('full_address', $address->full_address) }}">
              @error('full_address')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-2">
              <label for="post_number" class="form-label">Kode Pos</label>
              <input class="form-control form-control-lg @error('post_number') is-invalid @enderror" type="number"
                name="post_number" id="post_number" value="{{ old('post_number', $address->post_number) }}">
              @error('post_number')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

          </div>
        </div>
        <div class="mb-5">
          <h4 class="text-primary fw-bold">Lokasi Perusahaan</h4>
          <hr>
          <div class="alert alert-danger d-none" id="alertNotFound" role="alert">
            Lokasi tidak ditemukan, silakan search secara manual !
          </div>
          <div class="row g-2">
            <div class="col-xl-12">
              <div id="map" style="width: 100%; height: 400px;">
              </div>
            </div>

            <div class="col-xl-6">
              <label for="latitude" class="form-label">Latitude</label>
              <input class="form-control form-control-lg @error('latitude') is-invalid @enderror" type="text"
                name="latitude" id="latitude" value="{{ old('latitude', $address->latitude) }}">
              @error('latitude')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-6 mb-2">
              <label for="longitude" class="form-label">Longitude</label>
              <input class="form-control form-control-lg @error('longitude') is-invalid @enderror" type="text"
                name="longitude" id="longitude" value="{{ old('longitude', $address->longitude) }}">
              @error('longitude')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

          </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </section>
  </div>
@endsection

@section('footJS')
  <script src="{{ asset('/js/address.js') }}"></script>
@endsection
