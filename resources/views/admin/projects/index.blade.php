@extends('admin.layouts.index')

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Projects</h2>
      </div>
    </div>
    <section class="container-fluid">
      <div class="row mb-4">
        <x-summary-box summaryTitle="Total Project" summaryTotal="{{ $projects->count() }}" icon="bi bi-kanban"
          id="total-project" link="{{ route('admin.project.index') }}" disabled />
      </div>

      @include('admin.partials.import')
      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <input type="hidden" id="tableName" value="projects">
      <div class="d-flex mb-5" id="actionContainer"></div>
      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <div class="table-responsive">
        <table class="table table-striped table-dark text-center" data-display="datatables">
          <thead>
            <tr>
              <th>ID</th>
              <th></th>
              <th></th>
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
                <td></td>
                <td>
                  <div class="dropdown">
                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="{{ url("/admin/projects/$project->name/edit") }}" class="dropdown-item">
                          Edit
                        </a>
                      </li>
                      <li>
                        <a href="{{ url("/admin/assign/vehicle/$project->name") }}" class="dropdown-item">
                          Assign Vehicle
                        </a>
                      </li>
                      <li>
                        <a href="{{ url("/admin/assign/address/$project->name") }}" class="dropdown-item">
                          Assign Address
                        </a>
                      </li>
                      <li>
                        <a href="{{ url("/admin/assign/person/$project->name") }}" class="dropdown-item">
                          Assign Person
                        </a>
                      </li>
                    </ul>
                  </div>
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
      </div>
    </section>
  </div>
@endsection
