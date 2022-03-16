@extends('layouts.main')

@section('headJS')
  <script type='text/javascript' src="/vendor/jquery/jquery-3.6.0.min.js"></script>
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
        <h2 class="h5 mb-0">Edit Address</h2>
      </div>
    </div>
    <section>

    </section>
  </div>
@endsection
