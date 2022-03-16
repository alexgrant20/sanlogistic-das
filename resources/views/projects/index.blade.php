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
                <a href="/projects/{{ $project->name }}/edit" class="badge bg-primary"><i class="bi bi-pencil"></i></a>
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
