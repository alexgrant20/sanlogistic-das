@extends('layouts.main')

@section('headJS')
  <script type="text/javascript" src="/js/tableConfig.js"></script>
@endsection

@section('headCSS')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css" />
@endsection

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Addresses</h2>
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

      <table class="table table-hover text-center  table-dark table-striped" id="myTable">
        <thead>
          <tr class="header">
            <th>No</th>
            <th>Name</th>
            <th>Type</th>
            <th>Address</th>
            <th>City</th>
            <th>Province</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($addresses as $address)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $address->name }}</td>
              <td>{{ $address->addressType->name }}</td>
              <td class="text-truncate" style="max-width: 120px">{{ $address->full_address }}</td>
              <td>{{ $address->subdistrict->district->city->name }}</td>
              <td>{{ $address->subdistrict->district->city->province->name }}</td>
              <td>
                <a href="/projects/{{ $address->name }}/edit" class="badge bg-primary"><i
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
