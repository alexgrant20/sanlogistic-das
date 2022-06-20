<nav id="sidebar">
  <!-- Sidebar Header-->
  <div class="sidebar-header d-flex align-items-center p-4">
    <img class="avatar shadow-0 img-fluid rounded-circle"
      src="{{ auth()->user()->person->image ? asset('/storage/' . auth()->user()->person->image) : asset('/storage/userDefault.webp') }}"
      alt="">
    <div class="ms-3 title">
      <h1 class="h5 mb-1">{{ auth()->user()->username }}</h1>
      <p class="text-sm text-capitalize text-gray-700 mb-0 lh-1">{{ auth()->user()->role->name }}</p>
    </div>
  </div>

  <span class="text-uppercase text-gray-600 text-xs heading mb-2 mx-3 text-wrap d-block">General</span>
  <ul class="list-unstyled">

    <li class="sidebar-item {{ Request::is('/') ? 'active' : '' }}">
      <a class="sidebar-link" href="{{ route('index') }}">
        <i class="bi bi-house-door svg-icon svg-icon-sm svg-icon-heavy"></i>
        <span>Home</span>
      </a>
    </li>
  </ul>

  <span class="text-uppercase text-gray-600 text-xs heading mb-2 mx-3 text-wrap d-block">Super Admin</span>
  <ul class="list-unstyled">

    @can('viewAny', 'App\Models\Address')
      <li class="sidebar-item {{ Request::is('admin/addresses*') ? 'active' : '' }}">
        <a class="sidebar-link" href="#addressesDropDown" data-bs-toggle="collapse">
          <i class="bi bi-cursor svg-icon svg-icon-sm svg-icon-heavy"></i>
          <span>Addresses</span>
        </a>
        <ul class="collapse list-unstyled {{ Request::is('admin/addresses*') ? 'show' : '' }}" id="addressesDropDown">
          <li>
            <a class="sidebar-link {{ Route::is('admin.address.create') ? 'text-primary' : '' }}"
              href="{{ route('admin.address.create') }}">
              Add
            </a>
          </li>
          <li>
            <a class="sidebar-link {{ Route::is('admin.address.index') ? 'text-primary' : '' }}"
              href="{{ route('admin.address.index') }}">
              View
            </a>
          </li>
        </ul>
      </li>
    @endcan

    <li class="sidebar-item {{ Request::is('admin/activities*') ? 'active' : '' }}">
      <a class="sidebar-link" href="#activitiesDropDown" data-bs-toggle="collapse">
        <i class="bi bi-list-task svg-icon svg-icon-sm svg-icon-heavy"></i>
        <span>Activities</span>
      </a>
      <ul class="collapse list-unstyled {{ Request::is('admin/activities*') ? 'show' : '' }}"
        id="activitiesDropDown">
        <li>
          <a class="sidebar-link {{ Route::is('admin.activity.create') ? 'text-primary' : '' }}"
            href="{{ route('admin.activity.create') }}">
            Add
          </a>
        </li>
        <li>
          <a class="sidebar-link {{ Route::is('admin.activity.index') ? 'text-primary' : '' }}"
            href="{{ route('admin.activity.index') }}">
            View
          </a>
        </li>
      </ul>
    </li>

    <li class="sidebar-item {{ Request::is('admin/people*') ? 'active' : '' }}">
      <a class="sidebar-link" href="#peopleDropDown" data-bs-toggle="collapse">
        <i class="bi bi-people-fill svg-icon svg-icon-sm svg-icon-heavy"></i>
        <span>People</span>
      </a>
      <ul class="collapse list-unstyled {{ Request::is('admin/people*') ? 'show' : '' }}" id="peopleDropDown">
        <li>
          <a class="sidebar-link {{ Route::is('admin.person.create') ? 'text-primary' : '' }}"
            href="{{ route('admin.person.create') }}">
            Add
          </a>
        </li>
        <li>
          <a class="sidebar-link {{ Route::is('admin.person.index') ? 'text-primary' : '' }}"
            href="{{ route('admin.person.index') }}">
            View
          </a>
        </li>
      </ul>
    </li>

    <li class="sidebar-item {{ Request::is('admin/vehicles*') ? 'active' : '' }}">
      <a class="sidebar-link" href="#vehiclesDropDown" data-bs-toggle="collapse">
        <i class="bi bi-truck svg-icon svg-icon-sm svg-icon-heavy"></i>
        <span>Vehicles</span>
      </a>
      <ul class="collapse list-unstyled {{ Request::is('admin/vehicles*') ? 'show' : '' }}" id="vehiclesDropDown">
        <li>
          <a class="sidebar-link {{ Route::is('admin.vehicle.create') ? 'text-primary' : '' }}"
            href="{{ route('admin.vehicle.create') }}">
            Add
          </a>
        </li>
        <li>
          <a class="sidebar-link {{ Route::is('admin.vehicle.index') ? 'text-primary' : '' }}"
            href="{{ route('admin.vehicle.index') }}">
            View
          </a>
        </li>
      </ul>
    </li>

    <li class="sidebar-item {{ Request::is('admin/companies*') ? 'active' : '' }}">
      <a class="sidebar-link" href="#companiesDropDown" data-bs-toggle="collapse">
        <i class="bi bi-building svg-icon svg-icon-sm svg-icon-heavy"></i>
        <span>Companies</span>
      </a>
      <ul class="collapse list-unstyled {{ Request::is('admin/companies*') ? 'show' : '' }}" id="companiesDropDown">
        <li>
          <a class="sidebar-link {{ Route::is('admin.company.create') ? 'text-primary' : '' }}"
            href="{{ route('admin.company.create') }}">
            Add
          </a>
        </li>
        <li>
          <a class="sidebar-link {{ Route::is('admin.company.index') ? 'text-primary' : '' }}"
            href="{{ route('admin.company.index') }}">
            View
          </a>
        </li>
      </ul>
    </li>

    <li class="sidebar-item {{ Request::is('admin/projects*') ? 'active' : '' }}">
      <a class="sidebar-link" href="#projectsDropDown" data-bs-toggle="collapse">
        <i class="bi bi-kanban svg-icon svg-icon-sm svg-icon-heavy"></i>
        <span>Projects</span>
      </a>
      <ul class="collapse list-unstyled {{ Request::is('admin/projects*') ? 'show' : '' }}" id="projectsDropDown">
        <li>
          <a class="sidebar-link {{ Route::is('admin.project.create') ? 'text-primary' : '' }}"
            href="{{ route('admin.project.create') }}">
            Add
          </a>
        </li>
        <li>
          <a class="sidebar-link {{ Route::is('admin.project.index') ? 'text-primary' : '' }}"
            href="{{ route('admin.project.index') }}">
            View
          </a>
        </li>
      </ul>
    </li>

    <li class="sidebar-item {{ Request::is('admin/finances*') ? 'active' : '' }}">
      <a class="sidebar-link" href="#financesDropDown" data-bs-toggle="collapse">
        <i class="bi bi-currency-dollar svg-icon svg-icon-sm svg-icon-heavy"></i>
        <span>Finance</span>
      </a>
      <ul class="collapse list-unstyled {{ Request::is('admin/finances*') ? 'show' : '' }}" id="financesDropDown">
        <li>
          <a class="sidebar-link {{ Route::is('admin.finance.acceptance') ? 'text-primary' : '' }}"
            href="{{ route('admin.finance.acceptance') }}">
            Acceptance
          </a>
        </li>
        <li>
          <a class="sidebar-link {{ Route::is('admin.finance.payment') ? 'text-primary' : '' }}"
            href="{{ route('admin.finance.payment') }}">
            Payment
          </a>
        </li>
      </ul>
    </li>

  </ul>

</nav>
