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
        <h2 class="h5 mb-0">Companies</h2>
      </div>
    </div>
    <section class="container-fluid">

      @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
      @endif

      @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">
          {{ session('error') }}
        </div>
      @endif

      @if (!$imagesMigrated)
        <form action="/companies/migrate/image" class="mb-3">
          @csrf
          <button class="btn btn-primary">Migrate</button>
        </form>
      @endif


      <table class="table table-hover text-center  table-dark table-striped" id="myTable">
        <thead>
          <tr class="header">
            <th>No</th>
            <th>Company Name</th>
            <th>Status</th>
            <th>Director</th>
            <th>Nama Alamat</th>
            <th>SIUP</th>
            <th>SIPA</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($companies as $company)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $company->name }}</td>
              <td>Active</td>
              <td>{{ $company->director }}</td>
              <td>{{ $company->address->name }}</td>

              @if ($company->companyDocuments->contains('type', 'siup'))
                <td>{{ $company->companyDocuments->where('type', 'siup')->first()->number }}</td>
              @else
                <td></td>
              @endif

              @if ($company->companyDocuments->contains('type', 'sipa'))
                <td>{{ $company->companyDocuments->where('type', 'sipa')->first()->number }}</td>
              @else
                <td></td>
              @endif

              <td>
                <a href="/companies/{{ $company->name }}/edit" class="badge bg-primary"><i
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
