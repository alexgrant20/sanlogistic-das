@extends('layouts.main')

@section('headJS')
  <script type="text/javascript" src="/js/tableConfig.js"></script>
  <script type='text/javascript' src="/vendor/leaflet/js/leaflet/leaflet.js"></script>
  <script type='text/javascript' src="/vendor/leaflet/js/gestureHandling/leaflet-gesture-handling.min.js"></script>
  <script type='text/javascript' src="/vendor/leaflet/js/spin/spin.js"></script>
  <script type='text/javascript' src="/vendor/leaflet/js/spin/leaflet.spin.js"></script>
  <script type='text/javascript' src="/vendor/leaflet/js/esriLeaflet/esri-leaflet-old.js"></script>
  <script type='text/javascript' src="/vendor/leaflet/js/esriLeaflet/esri-leaflet-geocoder-old.js"></script>
@endsection

@section('headCSS')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css" />
  <link rel="stylesheet" type="text/css" href="/vendor/leaflet/css/esriLeaflet/esri-leaflet-geocoder-old.css">
  <link rel="stylesheet" href="/vendor/leaflet/css/gestureHandling/leaflet-gesture-handling.min.css" type="text/css">
  <link rel="stylesheet" href="/vendor/leaflet/css/leaflet.css" integrity="" crossorigin="" />
@endsection

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Addresses</h2>
      </div>
    </div>
    <section class="container-fluid">

      @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
      @endif

      @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">
          {{ session('error') }}
        </div>
      @endif

      <div id='map' class="w-100 mb-5" style="height: 600px"></div>

      <table class="table table-hover text-center  table-dark table-striped" id="myTable">
        <thead>
          <tr class="header">
            <th>No</th>
            <th>Name</th>
            <th>Type</th>
            <th>Address</th>
            <th>City</th>
            <th>Province</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($addresses as $address)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $address->name }}</td>
              <td>{{ $address->addressType->name }}</td>
              <td class="text-truncate" style="max-width: 120px">{{ $address->full_address }}</td>
              <td>{{ $address->subdistrict->district->city->name ?? null }}</td>
              <td>{{ $address->subdistrict->district->city->province->name ?? null }}</td>
              <td>
                <a href="/addresses/{{ $address->name }}/edit" class="badge bg-primary"><i
                    class="bi bi-pencil"></i></a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </div>
  <script>
    const map = L.map('map', {
      scrollWheelZoom: false,
      gestureHandling: true,
      gestureHandlingOptions: {
        duration: 1000, //1 secs
      },
    }).setView([-3.654935965153248, 111.29150390625001], 5);

    mapLink =
      '<a href="http://openstreetmap.org">OpenStreetMap</a>';
    L.tileLayer(
      'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; ' + mapLink + ' Contributors',
        maxZoom: 18,
      }).addTo(map);

    const getLocation = async () => {
      try {
        const res = await fetch('/api/addresses/location', {
          method: 'GET'
        });
        const data = await res.json();
        const locations = data.map(el => Object.values(el));

        for (var i = 0; i < locations.length; i++) {
          marker = new L.marker([locations[i][1], locations[i][2]])
            .bindPopup(locations[i][0])
            .addTo(map);
        }
      } catch (err) {
        return err.message;
      }
    }
    getLocation();
  </script>
@endsection

@section('footJS')
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
@endsection
