@extends('layouts.index')

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">People</h2>
      </div>
    </div>
    <section class="container-fluid">
      @include('partials.index_response')
      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <input type="hidden" id="tableName" value="people">
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <table class="table table-hover text-center  table-dark nowrap" style="width: 100%" data-display="datatables">
        <thead>
          <tr class="header">
            <th>ID</th>
            <th>Action</th>
            <th>Nama Orang</th>
            <th>Nama Perusahaan</th>
            <th>Nomor HP</th>
            <th>Pekerjaan</th>
            <th>User</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($people as $person)
            <tr>
              <td>{{ $person->id }}</td>
              <td>
                <a href="{{ url("/people/$person->id/edit") }}" class="badge bg-primary fs-6">
                  <i class="bi bi-pencil"></i>
                </a>
              </td>
              <td>{{ $person->name }}</td>
              <td>{{ $person->project->name }}</td>
              <td>{{ $person->phone_number }}</td>
              <td>{{ $person->department->name }}</td>
              @if (isset($person->user->username))
                <td>
                  <a href="{{ url('') }}" class="btn badge bg-warning fs-6">
                    <i class="bi bi-person-fill"></i>
                  </a>
                </td>
              @else
                <td>
                  <form action="{{ url('/users/create') }}">
                    <input type="hidden" name="person_id" value="{{ $person->id }}">
                    <button type="submit" class="btn badge bg-info fs-6">
                      <i class="bi bi-person-plus-fill"></i>
                    </button>
                  </form>
                </td>
              @endif
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </div>
@endsection
