@extends('layouts.main')

@section('headCSS')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css" />
@endsection

@section('headJS')
  <script type="text/javascript" src="/js/tableConfig.js"></script>
@endsection

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Activities</h2>
      </div>
    </div>
    <section class="container-fluid">
      <table class="table table-hover text-center  table-dark table-striped" id="myTable">
        <thead>
          <tr class="header">
            <th>Tanggal</th>
            <th>Nama Pengendara</th>
            <th>Nomor Kendaraan</th>
            <th>Nomor DO</th>
            <th>Lokasi Keberangkatan</th>
            <th>Lokasi Tujuan</th>
            <th>Jenis Aktifitas</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($activities as $activity)
            <tr>
              <td>{{ $activity->departure_date }}</td>
              <td>{{ $activity->driver->person->name }}</td>
              <td>{{ $activity->vehicle->license_plate }}</td>
              <td>{{ $activity->do_number }}</td>
              <td>{{ $activity->departureLocation->name }}</td>
              <td>{{ $activity->arrivalLocation->name }}</td>
              <td>{{ $activity->type }}</td>
              <td>{{ $activity->status }}</td>
              <td>
                <a href="/activities/{{ $activity->id }}/edit" class="badge bg-primary"><i class="bi bi-pencil"></i></a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </div>
@endsection

@section('footJS')
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
@endsection
