@extends('admin.layouts.main')

@section('container')
  <x-modal id="modal" size="modal-lg">
    <x-slot:body>
      <div class="container-fluid text-center pt-3">
        <div class="mb-4">
          <i class="bi bi-exclamation-circle text-danger display-1"></i>
        </div>
        <p class="display-6 text-white mb-1 fw-bold">Delete permission?</p>
        <p class="fs-3 text-gray-700">You will not able to recover it</p>
        <div class="text-end mt-5">
          <button type="button" class="btn btn-lg btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-lg btn-primary" id="submit">Delete</button>
        </div>
      </div>
    </x-slot:body>
  </x-modal>
  <div class="page-content">
    <div class="bg-dash-dark-2 py-4">
      <div class="container-fluid">
        <h2 class="h5 mb-0">Permission</h2>
      </div>
    </div>
    <section class="container-fluid">
      <table class="table table-bordered table-dark table-striped text-center">
        <thead>
          <tr>
            <th>Permission</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($permissions as $permission)
            <tr>
              <td>{{ $permission->name }}</td>
              <td>
                <a class="btn btn-primary" href="{{ route('admin.permissions.edit', $permission->id) }}">Edit</a>
                <form class="d-none" action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST"
                  id="form">
                  @csrf
                  @method('DELETE')
                </form>
                <button type="submit" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal">Delete</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      {{ $permissions->links() }}
    </section>
  </div>
@endsection
