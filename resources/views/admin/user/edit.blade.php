@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Register</h2>
      </div>
    </div>
    <section class="container-fluid">

      @error('person_id')
        <div class="alert alert-danger" role="alert">
          {{ $message }}
        </div>
      @enderror

      <form action=" {{ route('admin.users.update', $user->id) }}" method="POST" id="form">
        @csrf
        @method('PUT')
        <div class="mb-5">
          <div class="row g-2 mb-2">
            <div class="col-xl-4">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control form-control-lg @error('username') is-invalid @enderror"
                id="username" name="username" value="{{ old('username', $user->username) }}" autofocus>

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
              <div class="form-text">Password is not required</div>

              @error('password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="col-xl-4">
              <label for="role" class="form-label">Role</label>
              <select name="role" class="form-select form-select-lg form-control @error('role') is-invalid @enderror"
                id="role">
                <option value="" hidden></option>
                @foreach ($roles as $role)
                  <option value="{{ $role->name }}" @selected(($user->roles->first()->name ?? null) == $role->name)>
                    {{ $role->name }}
                  </option>
                @endforeach
              </select>

              @error('role')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
        </div>

      </form>
      <button type="submit" class="btn btn-lg btn-primary" id="submit">Submit</button>
    </section>
  </div>
@endsection
