@extends('layouts.index')

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Activities</h2>
      </div>
    </div>
    <section class="container-fluid">
      @include('partials.index_response')
      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <input type="hidden" id="tableName" value="activities">
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <table class="table table-hover text-center  table-dark nowrap" style="width: 100%" data-display="datatables">
        <thead>
          <tr class="header">
            <th>ID</th>
            <th>Action</th>
            <th>Tanggal</th>
            <th>Nama Pengendara</th>
            <th>Nomor Kendaraan</th>
            <th>Nomor DO</th>
            <th>Lokasi Keberangkatan</th>
            <th>Lokasi Tujuan</th>
            <th>Jenis Aktifitas</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($activities as $activity)
            <tr>
              <td>{{ $activity->id }}</td>
              <td>
                <a href="{{ url("/activities/$activity->id/edit") }}" class="badge bg-primary"><i
                    class="bi bi-pencil"></i></a>
              </td>
              <td>{{ $activity->departure_date }}</td>
              <td>{{ $activity->driver->person->name }}</td>
              <td>{{ $activity->vehicle->license_plate }}</td>
              <td>{{ $activity->do_number }}</td>
              <td>{{ $activity->departureLocation->name }}</td>
              <td>{{ $activity->arrivalLocation->name }}</td>
              <td>{{ $activity->type }}</td>
              <td>{{ $activity->activityStatus->status }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </div>
@endsection
