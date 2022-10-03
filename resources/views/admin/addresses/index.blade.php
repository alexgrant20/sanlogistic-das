@extends('admin.layouts.index')

@section('add_headJS')
  <script type='text/javascript' src="{{ asset('/vendor/leaflet/js/leaflet/leaflet.js') }}"></script>
  <script type='text/javascript' src="{{ asset('/vendor/leaflet/js/gestureHandling/leaflet-gesture-handling.min.js') }}">
  </script>
  <script type='text/javascript' src="{{ asset('/vendor/leaflet/js/spin/spin.js') }}"></script>
  <script type='text/javascript' src="{{ asset('/vendor/leaflet/js/spin/leaflet.spin.js') }}"></script>
  <script type='text/javascript' src="{{ asset('/vendor/leaflet/js/esriLeaflet/esri-leaflet-old.js') }}"></script>
  <script type='text/javascript' src="{{ asset('/vendor/leaflet/js/esriLeaflet/esri-leaflet-geocoder-old.js') }}">
  </script>
@endsection

@section('add_headCSS')
  <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/leaflet/css/esriLeaflet/esri-leaflet-geocoder-old.css') }}">
  <link rel="stylesheet" href="{{ asset('/vendor/leaflet/css/gestureHandling/leaflet-gesture-handling.min.css') }}"
    type="text/css">
  <link rel="stylesheet" href="{{ asset('/vendor/leaflet/css/leaflet.css') }}" />
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
      <div class="row mb-5 g-3">
        <div class="col-xl-8">
          <h4 class="text-primary fw-bold">Address Location</h4>
          <hr>
          <div id='map' class="w-100 rounded" style="height: 600px"></div>
        </div>
        <div class="col-xl-4">
          <h4 class="text-primary fw-bold">Address Summary</h4>
          <hr>
          <div class="row">
            <x-summary-box size="col-12" summaryTitle="Total Addresses" summaryTotal="{{ $addresses->count() }}"
              icon="bi bi-building" id="total-address" link="{{ route('admin.addresses.index') }}" disabled />
          </div>
        </div>
      </div>
      @include('admin.partials.import')
      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <input type="hidden" id="tableName" value="addresses">
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <div class="table-responsive">
        <table class="table table-striped table-dark text-center" data-display="datatables">
          <thead>
            <tr class="header">
              <th>ID</th>
              <th></th>
              <th></th>
              <th>Name</th>
              <th>Type</th>
              <th>Address</th>
              <th>City</th>
              <th>Province</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($addresses as $address)
              <tr>
                <td>{{ $address->id }}</td>
                <td></td>
                <td>
                  @canany('address-edit')
                    <div class="dropdown">
                      <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots"></i>
                      </button>
                      <ul class="dropdown-menu">
                        {{-- IF OTHER MENU EXISTS UNCOMENT THIS --}}
                        {{-- @can('address-edit') --}}
                        <li>
                          <a href="{{ route('admin.addresses.edit', $address->name) }}" class="dropdown-item">
                            Edit
                          </a>
                        </li>
                        {{-- @endcan --}}
                      </ul>
                    </div>
                  @endcan
                </td>
                <td>{{ $address->name }}</td>
                <td>{{ $address->address_types_name }}</td>
                <td class="text-truncate" style="max-width: 120px">{{ $address->full_address }}</td>
                <td>{{ $address->cities_name }}</td>
                <td>{{ $address->provinces_name }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
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
        const res = await fetch('{{ route('admin.addresses.locations') }}', {
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
