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

      @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
      @endif

      <!-- Import Modal -->
      <div class="modal fade" id="importExcel" tabindex="-1" aria-labelledby="importExcelLabel" aria-hidden="true">
        <form method="post" action="{{ url('/projects/import/excel') }}" enctype="multipart/form-data">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="importExcelLabel">Import</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                @csrf

                <label class="form-label">Pilih file excel</label>
                <div class="form-group">
                  <input class="form-control" type="file" name="file" required="required">
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Import</button>
              </div>
            </div>
          </div>
        </form>
      </div>

      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <table class="table table-hover text-center table-dark nowrap" style="width: 100%">
        <thead>
          <tr class="header">
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
              <td>
                <a href="{{ url("/projects/$project->name/edit") }}" class="badge bg-primary"><i
                    class="bi bi-pencil"></i></a>
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
