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
        <h2 class="h5 mb-0">People</h2>
      </div>
    </div>
    <section class="container-fluid">

      @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">
          {{ session('error') }}
        </div>
      @endif

      @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
      @endif

      <table class="table table-hover text-center  table-dark table-striped" id="myTable">
        <thead>
          <tr class="header">
            <th>Nama Orang</th>
            <th>Nama Perusahaan</th>
            <th>Nomor HP</th>
            <th>Pekerjaan</th>
            <th>User</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($people as $person)
            <tr>
              <td>{{ $person->name }}</td>
              <td>{{ $person->project->name }}</td>
              <td>{{ $person->phone_number }}</td>
              <td>{{ $person->department->name }}</td>
              @if (isset($person->user->username))
                <td>{{ $person->user->username }}</td>
              @else
                <td>None</td>
              @endif
              <td>
                <a href="/people/{{ $person->id }}/edit" class="badge bg-primary"><i class="bi bi-pencil"></i></a>
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
