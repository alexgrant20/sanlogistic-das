<header class="header">
   <nav class="navbar navbar-expand-lg py-3 bg-dash-dark-2 border-bottom border-dash-dark-1 z-index-10">
      <div class="search-panel">
         <div class="search-inner d-flex align-items-center justify-content-center">
            <div class="close-btn d-flex align-items-center position-absolute top-0 end-0 me-4 mt-2 cursor-pointer">
               <span>Close </span>
               <svg class="svg-icon svg-icon-md svg-icon-heavy text-gray-700 mt-1">
                  <use xlink:href="#close-1"> </use>
               </svg>
            </div>
         </div>
      </div>
      <div class="container-fluid d-flex align-items-center justify-content-between py-1">
         <div class="navbar-header d-flex align-items-center">
            <a class="navbar-brand text-uppercase text-reset" href="{{ route('index') }}">
               <img class="w-auto" src="{{ asset('img/logo.png') }}" alt="" style="height: 50px">
            </a>
            <button class="sidebar-toggle">
               <i class="bi bi-caret-left-fill"></i>
            </button>
         </div>

         <li class="list-inline-item logout px-lg-2">
            <form action="{{ route('logout') }}" method="POST">
               @csrf
               <button type="submit" class="btn">
                  {{-- <i class="fa-solid fa-right-from-bracket fs-4 text-light"></i> --}}
                  <i class="fa-solid fa-right-from-bracket text-light"></i>
               </button>
            </form>
         </li>
         </ul>
      </div>
   </nav>
</header>
