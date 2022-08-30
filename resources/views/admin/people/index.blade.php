@extends('admin.layouts.index')

@section('container')
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">People</h2>
      </div>
    </div>
    <section class="container-fluid">
      <div class="row mb-4">
        <x-summary-box summaryTitle="Total Person" summaryTotal="{{ $people->count() }}" icon="bi bi-person" id="total-person"
          link="{{ route('admin.person.index') }}" disabled />
      </div>
      @include('admin.partials.import')
      <h4 class="text-primary fw-bold">Action</h4>
      <hr>
      <input type="hidden" id="tableName" value="people">
      <div class="d-flex mb-5" id="actionContainer"></div>

      <h4 class="text-primary fw-bold">Table</h4>
      <hr>
      <div class="table-responsive">
        <table class="table table-hover text-center  table-dark nowrap" style="width: 100%" data-display="datatables">
          <thead>
            <tr class="header">
              <th>ID</th>
              <th></th>
              <th></th>
              <th>Nama Orang</th>
              <th>Nama Project</th>
              <th>Nomor HP</th>
              <th>Pekerjaan</th>
              <th>User</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($people as $person)
              <tr>
                <td>{{ $person->id }}</td>
                <td></td>
                <td>
                  <div class="dropdown">
                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="{{ url("/admin/people/$person->id/edit") }}"class="dropdown-item"s>
                          Edit
                        </a>
                      </li>
                    </ul>
                  </div>
                </td>
                <td>{{ $person->name }}</td>
                <td>{{ $person->project->name ?? null }}</td>
                <td>{{ $person->phone_number }}</td>
                <td>{{ $person->department->name ?? null }}</td>
                @if (isset($person->user->username))
                  <td>
                    <a href="{{ url("/admin/users/{$person->user->id}/edit") }}" class="btn badge bg-warning fs-6">
                      <i class="bi bi-person-fill"></i>
                    </a>
                  </td>
                @else
                  <td>
                    <form action="{{ route('admin.user.create') }}">
                      <input type="hidden" name="person_id" value="{{ $person->id }}">
                      <button type="submit" class="btn badge bg-info fs-6">
                        <i class="bi bi-person-plus-fill"></i>
                      </button>
                    </form>
                  </td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>
  </div>
@endsection
