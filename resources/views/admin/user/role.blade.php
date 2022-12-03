@extends('admin.layouts.main')

@section('container')
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Permission</h2>
      </div>
    </div>
    <section class="container-fluid">
      <h3>Permission From Role : {{ $user->roles->first()->name }}</h3>
      @foreach ($user->getPermissionsViaRoles() as $permission)
        <span class="badge bg-info">{{ $permission->name }}</span>
      @endforeach
      <span></span>
      {{-- <div class="my-3">
        @if ($user->roles)
          @foreach ($user->roles as $user_role)
            <form class="d-inline" action="{{ route('admin.users.roles.remove', [$user->id, $user_role->id]) }}"
              method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-info">
                {{ $user_role->name }}
              </button>
            </form>
          @endforeach
        @endif
      </div> --}}

      {{-- <form action="{{ route('admin.users.roles', $user->id) }}" method="post">
        @csrf
        <div class="mb-3">
          <label for="role" class="form-label">Roles</label>
          <select name="role" class="form-select form-control" id="role">
            <option value="" hidden></option>
            @foreach ($roles as $role)
              <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
          </select>
          @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Assign</button>
      </form> --}}
    </section>

    <section class="container-fluid">
      <h3>Permissions</h3>
      <div class="my-3">
        @if ($user->permissions)
          @foreach ($user->permissions as $user_permissions)
            <form class="d-inline"
              action="{{ route('admin.users.permissions.revoke', [$user->id, $user_permissions->id]) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-info">
                {{ $user_permissions->name }}
              </button>
            </form>
          @endforeach
        @endif
      </div>

      <form action="{{ route('admin.users.permissions', $user->id) }}" method="post">
        @csrf
        <div class="mb-3">
          <label for="permission" class="form-label">Permissions</label>
          <select name="permission" class="form-select form-control" id="permission">
            <option value="" hidden></option>
            @foreach ($permissions as $permission)
              <option value="{{ $permission->name }}">{{ $permission->name }}</option>
            @endforeach
          </select>
          @error('permission')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Assign</button>
      </form>
    </section>
  </div>
@endsection
