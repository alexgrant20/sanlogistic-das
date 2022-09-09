@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Role</h2>
      </div>
    </div>
    <section class="container-fluid">
      <form action="{{ route('admin.roles.update', $role->id) }}" method="post" id="form">
        @method('PUT')
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Role Name</label>
          <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name"
            name="name" value="{{ old('name', $role->name) }}">
          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      </form>
      <button type="submit" class="btn btn-primary" id="submit">Update Role</button>
    </section>
    <section class="container-fluid">
      <h3>Role Permission</h3>
      <div class="my-3">
        @if ($role->permissions)
          @foreach ($role->permissions as $role_permission)
            <form class="d-inline"
              action="{{ route('admin.roles.permissions.revoke', [$role->id, $role_permission->id]) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-info">
                {{ $role_permission->name }}
              </button>
            </form>
          @endforeach
        @endif
      </div>

      <form action="{{ route('admin.roles.permissions', $role->id) }}" method="post">
        @csrf
        <div class="mb-3">
          <label for="permission" class="form-label">Permission</label>
          <select name="permission" class="form-select form-control" id="permission">
            <option value="" hidden></option>
            @foreach ($permissions as $permission)
              <option value="{{ $permission->name }}">{{ $permission->name }}</option>
            @endforeach
          </select>
          @error('permission')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Role</button>
      </form>
    </section>
  </div>
@endsection
