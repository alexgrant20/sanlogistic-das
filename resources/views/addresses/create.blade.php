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
      <form action="/address" method="POST" id="myForm">
        <div class="mb-5">
          <h4 class="text-primary fw-bold">Data Alamat</h4>
          <hr>
          <div class="row g-2">
            <div class="col-xl-3">
              <label for="address_name" class="form-label">Nama Alamat</label>
              <input type="text" class="form-control form-control-lg" id="address_name" name="address_name" value=""
                required>
            </div>
            <div class="col-xl-3">
              <label for="area_id" class="form-label">Area</label>
              <select class='form-select form-select-lg' name='area_id' id="area_id" required>
                <option value='' class="d-none"></option>
              </select>
            </div>
            <div class="col-xl-3">
              <label for="pool_type_id" class="form-label">Jenis Pool</label>
              <select class='form-select form-select-lg' name='pool_type_id' id="pool_type_id" required>
                <option value='1' class="d-none">Test</option>
                <option value='2' class="d-none">Test</option>
                <option value='3' class="d-none">Test</option>

              </select>
            </div>
            <div class="col-xl-3">
              <label for="address_type_id" class="form-label">Jenis Alamat</label>
              <select class='form-select form-select-lg' name='address_type_id' id="address_type_id" required>
                <option value='' class="d-none"></option>

              </select>
            </div>
            <div class="col-xl-3">
              <label for="province_id" class="form-label">Provinsi</label>
              <select class='form-select form-select-lg' name='province_id' id="province_id" required>
                <option value='' class="d-none"></option>
              </select>
            </div>
            <div class="col-xl-3">
              <label for="city_id" class="form-label">Kota</label>
              <div class="position-relative">
                <select class='form-select form-select-lg' name='city_id' id="city_id" required>
                  <option value='' class="d-none"></option>
                </select>
                <div class="spinner-border spinner-border-sm text-primary d-none spinner-input" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </div>
            <div class="col-xl-3">
              <label for="dist_id" class="form-label">Districts</label>
              <div class="position-relative">
                <select class='form-select form-select-lg' name='dist_id' id="dist_id" required>
                  <option value='' class="d-none"></option>
                </select>
                <div class="spinner-border spinner-border-sm text-primary d-none spinner-input" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </div>
            <div class="col-xl-3">
              <label for="subdis_id" class="form-label">Sub Districts</label>
              <div class="position-relative">
                <select class='form-select form-select-lg' name='subdis_id' id="subdis_id" required>
                  <option value='' class="d-none"></option>
                </select>
                <div class="spinner-border spinner-border-sm text-primary d-none spinner-input" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </div>
            <div class="col-xl-10">
              <label for="full_address" class="form-label">Alamat Lengkap</label>
              <input class="form-control form-control-lg" type="text" name="full_address" id="full_address" value=""
                required>
            </div>
            <div class="col-xl-2">
              <label for="address_postnumber" class="form-label">Kode Pos</label>
              <input class="form-control form-control-lg" type="number" name="address_postnumber" id="address_postnumber"
                value="" required>
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
              <input class="form-control form-control-lg" type="text" name="latitude" id="latitude" value="" required>
            </div>
            <div class="col-xl-6">
              <div class="mb-2">
                <label for="longitude" class="form-label">Longitude</label>
                <input class="form-control form-control-lg" type="text" name="longitude" id="longitude" value="" required>
              </div>
            </div>
          </div>
        </div>
      </form>
    </section>
  </div>
  <script src="/js/addAddress.js"></script>
@endsection
