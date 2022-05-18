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
      <div class="row mb-4">
        <x-summary-box>
          <x-slot name="summaryTitle">Total Activity</x-slot>
          <x-slot name="summaryTotal">{{ $activities->count() }}</x-slot>
          <x-slot name="icon">bi bi-journal-text</x-slot>
          <x-slot name="id">total-project</x-slot>
          <x-slot name="summaryTotalColor">text-primary</x-slot>
          <x-slot name="customCardClass">disabled</x-slot>
        </x-summary-box>
        <x-summary-box>
          <x-slot name="summaryTitle">On Going</x-slot>
          <x-slot name="summaryTotal">{{ $activities->count() }}</x-slot>
          <x-slot name="icon">bi bi-journal-arrow-up</x-slot>
          <x-slot name="id">total-project</x-slot>
          <x-slot name="summaryTotalColor">text-info</x-slot>
          <x-slot name="customCardClass">disabled</x-slot>
        </x-summary-box>
      </div>

      @include('partials.index_response')
      @include('partials.import')

      @if (session()->has('log_data'))
        <x-modal id="my-modal">
          <x-slot name="title">Activity Log</x-slot>
          <x-slot name="class">openModal</x-slot>
          <x-slot name="size">modal-lg</x-slot>
          <x-slot name="body">
            <table class="table table-hover table-dark text-center nowrap" style="width: 100%">
              <tr>
                <th>Status</th>
                <th>By</th>
                <th>Time</th>
              </tr>
              @foreach (session('log_data') as $log)
                <tr>
                  <td>{{ $log->status }}</td>
                  <td>{{ $log->created_user->person->name }}</td>
                  <td>{{ $log->created_at }}</td>
                </tr>
              @endforeach
            </table>
          </x-slot>
          <x-slot name="footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </x-slot>
        </x-modal>
      @endif

      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <input type="hidden" id="tableName" value="activities">
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <table class="table table-hover text-center table-dark nowrap" style="width: 100%" data-display="datatables">
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
                <a href="{{ url("/activities/$activity->id/edit") }}" class="badge bg-primary fs-6">
                  <i class="bi bi-pencil"></i>
                </a>
                <a href="{{ url("/activities/$activity->id") }}" class="badge bg-info fs-6">
                  <i class="bi bi-journal-text"></i>
                </a>
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
