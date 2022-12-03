@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Permission</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ route('admin.permissions.update', $permission->id) }}" method="post" id="form">
        @method('PUT')
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Permission Name</label>
          <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name"
            name="name" value="{{ old('name', $permission->name) }}">
          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      </form>
      <button class="btn btn-primary" id="submit">Update Permission</button>
    </section>
    <section class="container-fluid">
      <h3>Permission Role</h3>
      <div class="my-3">
        @if ($permission->roles)
          @foreach ($permission->roles as $permission_role)
            <form class="d-inline"
              action="{{ route('admin.roles.permissions.remove', [$permission->id, $permission_role->id]) }}"
              method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-info">
                {{ $permission_role->name }}
              </button>
            </form>
          @endforeach
        @endif
      </div>

      <form action="{{ route('admin.permissions.roles', $permission->id) }}" method="post">
        @csrf
        <div class="mb-3">
          <label for="role" class="form-label">Role</label>
          <select name="role" class="form-select form-control" id="role">
            <option value="" hidden></option>
            @foreach ($roles as $role)
              <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
          </select>
          @error('role')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Add Permission Role</button>
      </form>
    </section>
  </div>
@endsection
