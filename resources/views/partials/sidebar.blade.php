<nav id="sidebar">
  <!-- Sidebar Header-->
  <div class="sidebar-header d-flex align-items-center p-4"><img class="avatar shadow-0 img-fluid rounded-circle"
      src="img/avatar-6.jpg" alt="...">
    <div class="ms-3 title">
      <h1 class="h5 mb-1">{{ auth()->user()->username }}</h1>
      <p class="text-sm text-gray-700 mb-0 lh-1">Web Designer</p>
    </div>
  </div>

  <span class="text-uppercase text-gray-600 text-xs mx-3 px-2 heading mb-2">General</span>
  <ul class="list-unstyled">

    <li class="sidebar-item {{ Request::is('/') ? 'active' : '' }}">
      <a class="sidebar-link" href="/">
        <i class="bi bi-house-door svg-icon svg-icon-sm svg-icon-heavy">
          <use xlink:href="#home"> </use>
        </i>
        <span>Home</span>
      </a>
    </li>
  </ul>

  <span class="text-uppercase text-gray-600 text-xs mx-3 px-2 heading mb-2">Super Admin</span>
  <ul class="list-unstyled">

    <li class="sidebar-item {{ Request::is('addresses*') ? 'active' : '' }}">
      <a class="sidebar-link" href="#addressesDropDown" data-bs-toggle="collapse">
        <i class="bi bi-cursor svg-icon svg-icon-sm svg-icon-heavy">
          <use xlink:href="#addresses"> </use>
        </i>
        <span>Addresses</span>
      </a>
      <ul class="collapse list-unstyled {{ Request::is('addresses*') ? 'show' : '' }}" id="addressesDropDown">
        <li><a class="sidebar-link" href="/addresses/create">Add</a></li>
        <li><a class="sidebar-link" href="/addresses">View</a></li>
      </ul>
    </li>

    <li class="sidebar-item {{ Request::is('activities*') ? 'active' : '' }}">
      <a class="sidebar-link" href="#activitiesDropDown" data-bs-toggle="collapse">
        <i class="bi bi-list-task svg-icon svg-icon-sm svg-icon-heavy">
          <use xlink:href="#activities"> </use>
        </i>
        <span>Activities</span>
      </a>
      <ul class="collapse list-unstyled {{ Request::is('activities*') ? 'show' : '' }}" id="activitiesDropDown">
        <li><a class="sidebar-link" href="/activities">View</a></li>
      </ul>
    </li>

    <li class="sidebar-item {{ Request::is('people*') ? 'active' : '' }}">
      <a class="sidebar-link" href="#peopleDropDown" data-bs-toggle="collapse">
        <i class="bi bi-people-fill svg-icon svg-icon-sm svg-icon-heavy">
          <use xlink:href="#people"> </use>
        </i>
        <span>People</span>
      </a>
      <ul class="collapse list-unstyled {{ Request::is('people*') ? 'show' : '' }}" id="peopleDropDown">
        <li><a class="sidebar-link" href="/people/create">Add</a></li>
        <li><a class="sidebar-link" href="/people">View</a></li>
      </ul>
    </li>

    <li class="sidebar-item {{ Request::is('vehicles*') ? 'active' : '' }}">
      <a class="sidebar-link" href="#vehiclesDropDown" data-bs-toggle="collapse">
        <i class="bi bi-truck svg-icon svg-icon-sm svg-icon-heavy">
          <use xlink:href="#vehicles"> </use>
        </i>
        <span>Vehicles</span>
      </a>
      <ul class="collapse list-unstyled {{ Request::is('vehicles*') ? 'show' : '' }}" id="vehiclesDropDown">
        <li><a class="sidebar-link" href="/vehicles/create">Add</a></li>
        <li><a class="sidebar-link" href="/vehicles">View</a></li>
      </ul>
    </li>

    <li class="sidebar-item {{ Request::is('companies*') ? 'active' : '' }}">
      <a class="sidebar-link" href="#companiesDropDown" data-bs-toggle="collapse">
        <i class="bi bi-building svg-icon svg-icon-sm svg-icon-heavy">
          <use xlink:href="#companies"> </use>
        </i>
        <span>Companies</span>
      </a>
      <ul class="collapse list-unstyled {{ Request::is('companies*') ? 'show' : '' }}" id="companiesDropDown">
        <li><a class="sidebar-link" href="/companies/create">Add</a></li>
        <li><a class="sidebar-link" href="/companies">View</a></li>
      </ul>
    </li>

    <li class="sidebar-item {{ Request::is('projects*') ? 'active' : '' }}">
      <a class="sidebar-link" href="#projectsDropDown" data-bs-toggle="collapse">
        <i class="bi bi-kanban svg-icon svg-icon-sm svg-icon-heavy">
          <use xlink:href="#projects"> </use>
        </i>
        <span>Projects</span>
      </a>
      <ul class="collapse list-unstyled {{ Request::is('projects*') ? 'show' : '' }}" id="projectsDropDown">
        <li><a class="sidebar-link" href="/projects/create">Add</a></li>
        <li><a class="sidebar-link" href="/projects">View</a></li>
      </ul>
    </li>

  </ul>

</nav>
