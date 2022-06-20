<footer class="w-100 shadow ba-secondary" style="position: fixed; bottom: 0">
  <div class="row">
    <a href="/"
      class="col {{ Request::is('/') ? 'border-primary' : '' }} d-flex flex-column border-3 border-bottom justify-content-center align-items-center p-2 text-decoration-none text-white">
      <i class="bi {{ Request::is('/') ? 'bi-house-fill text-primary' : 'bi-house' }} mb-2 fs-3"></i>
      <span class="{{ Request::is('/') ? 'fw-bold' : '' }}">Home</span>
    </a>
    <a href="/profile"
      class="col {{ Request::is('/profile') ? 'border-primary' : '' }} d-flex flex-column border-3 border-bottom justify-content-center align-items-center p-2 text-decoration-none text-white">
      <i class="bi {{ Request::is('/profile') ? 'bi-person-fill text-primary' : 'bi-person' }} mb-2 fs-3"></i>
      <span class="{{ Request::is('/profile') ? 'fw-bold' : '' }}">Profile</span>
    </a>
  </div>
</footer>
