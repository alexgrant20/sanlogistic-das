<header class="d-flex flex-column justify-content-between align-items-center bg-dash-dark-3">
  <div class="d-flex justify-content-between align-items-center w-100 p-3">
    @if (!Request::is('/'))
      <a href="{{ url()->previous() }}" style="cursor: pointer;">
        <i class='bi bi-caret-left-fill fs-3'></i>
      </a>
    @endif
    <span class="fs-4 fw-bold {{ Request::is('/') ? 'text-center' : 'ms-3' }}" style="flex: 1">
      {{ $title }}
    </span>
    @if (Request::is('/'))
      <form action="/logout" method="POST">
        @csrf
        <button class="btn text-white fs-3" type="submit"><i class="bi bi-box-arrow-right"></i></button>
      </form>
    @endif
  </div>
  <div class="w-100">
    <div class="row">
      <a href="{{ route('index') }}"
        class="col {{ Request::is('/') ? 'border-primary' : '' }} d-flex flex-column border-3 border-bottom justify-content-center align-items-center p-2 text-decoration-none text-white">
        <i class="bi {{ Request::is('/') ? 'bi-house-door-fill text-primary' : 'bi-house-door' }} mb-2 fs-3"></i>
      </a>
      <a href="{{ route('driver.menu.profile') }}"
        class="col {{ Request::is('driver/profile') ? 'border-primary' : '' }} d-flex flex-column border-3 border-bottom justify-content-center align-items-center p-2 text-decoration-none text-white">
        <i class="bi {{ Request::is('driver/profile') ? 'bi-person-fill text-primary' : 'bi-person' }} mb-2 fs-3"></i>
      </a>
      <a href="{{ route('driver.activity.index') }}"
        class="col {{ Request::is('driver/activities') ? 'border-primary' : '' }} d-flex flex-column border-3 border-bottom justify-content-center align-items-center p-2 text-decoration-none text-white">
        <i
          class="fa-solid fa-clock-rotate-left {{ Request::is('driver/activities') ? 'text-primary' : '' }} mb-2 fs-3"></i>
      </a>
    </div>
  </div>
</header>
