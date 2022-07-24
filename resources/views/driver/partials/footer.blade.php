<footer class="w-100 shadow ba-secondary" style="position: fixed; bottom: 0; z-index: 4">
  <div class="row">
    <a href="{{ route('index') }}"
      class="col {{ Request::is('/') ? 'border-primary' : '' }} d-flex flex-column border-3 border-bottom justify-content-center align-items-center p-2 text-decoration-none text-white">
      <i class="bi {{ Request::is('/') ? 'bi-house-door-fill text-primary' : 'bi-house-door' }} mb-2 fs-3"></i>
      <span class="{{ Request::is('/') ? 'text-primary fw-bold' : '' }}">Home</span>
    </a>
    <a href="{{ route('driver.menu.profile') }}"
      class="col {{ Request::is('driver/profile') ? 'border-primary' : '' }} d-flex flex-column border-3 border-bottom justify-content-center align-items-center p-2 text-decoration-none text-white">
      <i class="bi {{ Request::is('driver/profile') ? 'bi-person-fill text-primary' : 'bi-person' }} mb-2 fs-3"></i>
      <span class="{{ Request::is('driver/profile') ? 'text-primary fw-bold' : '' }}">Profile</span>
    </a>
  </div>
</footer>
