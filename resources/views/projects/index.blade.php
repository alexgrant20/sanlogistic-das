@extends('layouts.index')

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Projects</h2>
      </div>
    </div>
    <section class="container-fluid">
      @include('partials.index_response')
      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <input type="hidden" id="tableName" value="projects">
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <table class="table table-hover text-center table-dark nowrap" style="width: 100%" data-display="datatables">
        <thead>
          <tr class="header">
            <th>ID</th>
            <th>Action</th>
            <th>Customer</th>
            <th>Project Name</th>
            <th>Location</th>
            <th>Start Date</th>
            <th>End Date</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($projects as $project)
            <tr>
              <td>{{ $project->id }}</td>
              <td>
                <a href="{{ url("/projects/$project->name/edit") }}" class="badge bg-primary fs-6">
                  <i class="bi bi-pencil"></i>
                </a>
              </td>
              <td>{{ $project->company->name }}</td>
              <td>{{ $project->name }}</td>
              <td>Unkown</td>
              <td>{{ $project->date_start }}</td>
              <td>{{ $project->date_end }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </div>
@endsection
