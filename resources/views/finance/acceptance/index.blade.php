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
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <table class="table table-responsive table-hover text-center  table-dark nowrap" style="width: 100%"
        data-display="datatables">
        <thead>
          <tr class="header">
            <th>ID</th>
            <th>Check</th>
            <th>Action</th>
            <th>Tanggal</th>
            <th>Nomor DO</th>
            <th>Nama Pengendara</th>
            <th>BBM</th>
            <th>Toll</th>
            <th>Parkir</th>
            <th>Retribusi</th>
          </tr>
        </thead>
        <tbody class="selectable align-items-center">
          @foreach ($activities as $activity)
            <tr class="my-auto">
              <td>{{ $activity->id }}</td>
              <td>
                <input type="checkbox" id="btncheck1" class="form-check-input">
              </td>
              <td>
                <a href="{{ url("/finances/acceptance/$activity->id/edit") }}" class="badge bg-primary fs-6">
                  <i class="bi bi-currency-dollar"></i>
                </a>
              </td>
              <td>{{ $activity->departure_date }}</td>
              <td>{{ $activity->do_number }}</td>
              <td>{{ $activity->driver->person->name }}</td>
              <td>@money($activity->bbm_amount)</td>
              <td>@money($activity->bbm_amount)</td>
              <td>@money($activity->parking)</td>
              <td>@money($activity->retribution_amount)</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </div>
@endsection
