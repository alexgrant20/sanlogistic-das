@extends('admin.layouts.main')

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
  <link rel="stylesheet" href="/vendor/leaflet/css/leaflet.css" />
@endsection

@section('container')
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Update Address</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ route('admin.address.update', $address->name) }}" method="POST" id="form">
        @csrf
        @method('PUT')

        @include('admin.addresses.utils.form-ce')

      </form>
      <button type="submit" class="btn btn-primary" id="submit">Update Address</button>
    </section>
  </div>
@endsection

@section('footJS')
  <script src="{{ asset('/js/address.js') }}"></script>
  {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateAddressRequest', 'form') !!}
@endsection
