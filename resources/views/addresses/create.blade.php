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
            <form action="/address" method="POST">
                <div class="mb-5">
                    <h4 class="text-primary fw-bold">Data Alamat</h4>
                    <hr>
                    <div class="row g-2">

                        <div class="col-xl-3">
                            <label for="name" class="form-label">Nama Alamat</label>
                            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}">
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
                                    @if ($area == old('area_id'))
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
                            <select class='form-select form-select-lg @error('pool_type_id') is-invalid @enderror'
                                name='pool_type_id' id="pool_type_id">
                                <option hidden></option>
                                @foreach ($pool_types as $pool_type)
                                    @if ($pool_type == old('pool_type_id'))
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
                                    @if ($type == old('address_type_id'))
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
                            <select class='form-select form-select-lg @error('province_id') is-invalid @enderror'
                                name='province_id' id="province_id">
                                <option hidden></option>
                            </select>
                            @error('province_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-xl-3">
                            <label for="city_id" class="form-label">Kota</label>
                            <div class="position-relative">
                                <select class='form-select form-select-lg @error('city_id') is-invalid @enderror'
                                    name='city_id' id="city_id">
                                    <option hidden></option>
                                </select>
                                @error('city_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <label for="dist_id" class="form-label">Districts</label>
                            <div class="position-relative">
                                <select class='form-select form-select-lg @error('dist_id') is-invalid @enderror'
                                    name='dist_id' id="dist_id">
                                    <option hidden></option>
                                </select>
                                @error('dist_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <label for="subdis_id" class="form-label">Sub Districts</label>
                            <div class="position-relative">
                                <select class='form-select form-select-lg @error('subdis_id') is-invalid @enderror'
                                    name='subdis_id' id="subdis_id">
                                    <option hidden></option>
                                </select>
                                @error('subdis_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-10">
                            <label for="full_address" class="form-label">Alamat Lengkap</label>
                            <input class="form-control form-control-lg @error('full_address') is-invalid @enderror"
                                type="text" name="full_address" id="full_address" value="{{ old('full_address') }}">
                            @error('full_address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-xl-2">
                            <label for="postnumber" class="form-label">Kode Pos</label>
                            <input class="form-control form-control-lg @error('postnumber') is-invalid @enderror"
                                type="number" name="postnumber" id="postnumber" value="{{ old('postnumber') }}">
                            @error('postnumber')
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
                    <div class="alert alert-danger" role="alert" id="alertNotFound">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-triangle fa-lg"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Lokasi Tidak Ditemukan! Search Menggunakan Search Box/Manual</strong>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-xl-12">
                            <div id="map" style="width: 100%; height: 400px;">
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input class="form-control form-control-lg @error('latitude') is-invalid @enderror" type="text"
                                name="latitude" id="latitude" value="{{ old('latitude') }}">
                            @error('latitude')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-xl-6 mb-2">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input class="form-control form-control-lg @error('longitude') is-invalid @enderror"
                                type="text" name="longitude" id="longitude" value="{{ old('longitude') }}">
                            @error('longitude')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                </div>
            </form>
        </section>
    </div>
    <script src="/js/addAddress.js"></script>
@endsection
