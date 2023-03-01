<footer class="w-100 shadow ba-secondary" style="position: fixed; bottom: 0; z-index: 4">
   <div class="row">
      <a href="{{ route('index') }}"
         class="col {{ Request::is('/') ? 'border-primary' : '' }} d-flex flex-column border-top-3 justify-content-center align-items-center p-2 text-decoration-none text-white">
         <i class="bi {{ Request::is('/') ? 'bi-house-door-fill text-primary' : 'bi-house-door' }} mb-2 fs-3"></i>
      </a>
      <a href="{{ route('driver.menu.profile') }}"
         class="col {{ Request::is('driver/profile') ? 'border-primary' : '' }} d-flex flex-column border-top-3 justify-content-center align-items-center p-2 text-decoration-none text-white">
         <i class="bi {{ Request::is('driver/profile') ? 'bi-person-fill text-primary' : 'bi-person' }} mb-2 fs-3"></i>
      </a>
      @role('driver')
         <a href="{{ route('driver.activity.index') }}"
            class="col {{ Request::is('driver/activities') ? 'border-primary' : '' }} d-flex flex-column border-top-3 justify-content-center align-items-center p-2 text-decoration-none text-white">
            <i
               class="fa-solid fa-clock-rotate-left {{ Request::is('driver/activities') ? 'text-primary' : '' }} mb-2 fs-3"></i>
         </a>
      @endrole
   </div>
</footer>
