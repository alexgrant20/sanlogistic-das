@extends('admin.layouts.index')

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Companies</h2>
      </div>
    </div>
    <section class="container-fluid">
      <div class="row mb-4">
        <x-summary-box summaryTitle="Total Company" summaryTotal="{{ $companies->count() }}" icon="bi bi-building"
          id="total-company" link="{{ route('admin.company.index') }}" disabled />
      </div>

      @include('admin.partials.import')
      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <input type="hidden" id="tableName" value="companies">
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <div class="table-responsive">
        <table class="table table-striped table-dark text-center" data-display="datatables">
          <thead>
            <tr class="header">
              <th>ID</th>
              <th></th>
              <th></th>
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
                <td></td>
                <td>
                  <div class="dropdown">
                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="{{ route('admin.company.edit', $company->name) }}" class="dropdown-item">
                          Edit
                        </a>
                      </li>
                    </ul>
                  </div>
                </td>
                <td>{{ $company->name }}</td>
                <td>Active</td>
                <td>{{ $company->director }}</td>
                <td>{{ $company->city->name }}</td>

                @if ($company->companyDocuments->contains('type', 'siup'))
                  <td>{{ $company->companyDocuments->where('type', 'siup')->first()->number }}</td>
                @else
                  <td>No Data</td>
                @endif

                @if ($company->companyDocuments->contains('type', 'sipa'))
                  <td>{{ $company->companyDocuments->where('type', 'sipa')->first()->number }}</td>
                @else
                  <td>No Data</td>
                @endif

              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>
  </div>
@endsection
