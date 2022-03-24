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
        <form method="post" action="/projects/import/excel" enctype="multipart/form-data">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="importExcelLabel">Modal title</h5>
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
      <div class="d-flex mb-5">
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
          <form action="/projects/export/excel">
            @csrf
            <button class="btn btn-success">Export Excel</button>
          </form>

          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importExcel">
            Import Excel
          </button>

        </div>
      </div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <table class="table table-hover text-center table-dark table-striped" id="myTable">
        <thead>
          <tr class="header">
            <th>No</th>
            <th>Customer</th>
            <th>Project Name</th>
            <th>Location</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($projects as $project)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $project->company->name }}</td>
              <td>{{ $project->name }}</td>
              <td>Unkown</td>
              <td>{{ $project->date_start }}</td>
              <td>{{ $project->date_end }}</td>
              <td>
                <a href="/projects/{{ $project->name }}/edit" class="badge bg-primary"><i
                    class="bi bi-pencil"></i></a>
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
