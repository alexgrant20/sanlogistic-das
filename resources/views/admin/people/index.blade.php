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
            <x-summary-box summaryTitle="Total Person" summaryTotal="{{ $people->count() }}" icon="bi bi-person"
               id="total-person" link="{{ route('admin.people.index') }}" disabled />
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
                           @canany('person-edit')
                              <div class="dropdown">
                                 <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                 </button>
                                 <ul class="dropdown-menu">
                                    @can('person-edit')
                                       <li>
                                          <a href="{{ route('admin.people.edit', $person->id) }}"class="dropdown-item">
                                             Edit
                                          </a>
                                       </li>
                                    @endcan
                                    @can('person-soft-delete')
                                       <li>
                                          <form action="{{ route('admin.people.destroy', $person->id) }}" method="POST">
                                             @method('DELETE')
                                             @csrf
                                             <button class="dropdown-item">
                                                Delete
                                             </button>
                                          </form>
                                       </li>
                                    @endcan
                                 </ul>
                              </div>
                           @endcan
                        </td>
                        <td>
                           {{ $person->name }}

                           @if ($person->user && empty(@$person->user->roles()->first()))
                              <i class="fa-solid fa-user-slash text-danger"></i>
                           @endif

                        </td>
                        <td>{{ @$person->project->name }}</td>
                        <td>{{ $person->phone_number }}</td>
                        <td>{{ @$person->department->name }}</td>
                        <td>
                           @if ($person->user)
                              <a href="{{ route('admin.users.edit', $person->user->id) }}" class="badge bg-warning fs-6">
                                 <i class="bi bi-person-fill"></i>
                              </a>

                              @if ($person->user->hasRole('driver'))
                                 <a href="{{ route('admin.driver.edit-last-location', $person->user->driver->id) }}"
                                    class="badge bg-info fs-6">
                                    <i class="fa-solid fa-location-dot"></i>
                                 </a>
                              @endif

                              {{-- @can('user-role-assign')
                      <a href="{{ route('admin.users.show', $person->user->id) }}" class="badge bg-primary fs-6">
                        <i class="bi bi-person-plus-fill"></i>
                      </a>
                    @endcan --}}
                           @else
                              <a href="{{ route('admin.users.create', $person->id) }}" class="badge bg-info fs-6">
                                 <i class="bi bi-person-plus-fill"></i>
                              </a>
                           @endif
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </section>
   </div>
@endsection
