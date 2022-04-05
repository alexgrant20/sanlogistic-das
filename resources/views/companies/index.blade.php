@extends('layouts.index')

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Companies</h2>
      </div>
    </div>
    <section class="container-fluid">
      @include('partials.index_response')
      @include('partials.import')
      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <input type="hidden" id="tableName" value="companies">
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <table class="table table-hover text-center  table-dark nowrap" style="width: 100%" data-display="datatables">
        <thead>
          <tr class="header">
            <th>ID</th>
            <th>Action</th>
            <th>Company Name</th>
            <th>Status</th>
            <th>Director</th>
            <th>Nama Alamat</th>
            <th>SIUP</th>
            <th>SIPA</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($companies as $company)
            <tr>
              <td>{{ $company->id }}</td>
              <td>
                <a href="{{ url("/companies/$company->name/edit") }}" class="badge bg-primary fs-6">
                  <i class="bi bi-pencil"></i>
                </a>
              </td>
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

            </tr>
          @endforeach
        </tbody>
      </table>
    </section>
  </div>
@endsection
