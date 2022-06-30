@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <!-- Page Header-->
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Register</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ route('admin.user.store') }}" method="post" autocomplete="off">
        @csrf
        <div class="mb-5">
          <h4 class="text-primary fw-bold">Data</h4>
          <hr>
          <div class="row g-2 mb-2">

            <input type="hidden" name="person_id" value="{{ $person_id }}">

            <div class="col-xl-4">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control form-control-lg @error('username') is-invalid @enderror"
                id="username" name="username" value="{{ old('username') }}" autofocus>

              @error('username')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-4">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                id="password" name="password">

              @error('password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-4">
              <label for="role_id" class="form-label">Role</label>
              <select name="role_id" id="role_id"
                class="form-select form-select-lg  @error('role_id') is-invalid @enderror">
                <option hidden></option>
                @foreach ($roles as $role)
                  @if ($role['id'] == old('role_id'))
                    <option value="{{ $role['id'] }}" selected>{{ $role['name'] }}</option>
                  @else
                    <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                  @endif
                @endforeach
              </select>

              @error('role_id')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-lg btn-primary">Submit</button>
      </form>
    </section>
  </div>
@endsection
