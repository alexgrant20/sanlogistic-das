<!DOCTYPE html>
<html>

<head>
   <title>Login</title>

   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no,maximum-scale=1, user-scalable=0">

   <!-- Script -->
   {{-- theme stylesheet --}}
   <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
   <link rel="stylesheet" href="{{ asset('/css/style.default.css') }}" id="theme-stylesheet">
   {{-- Custom Stylesheet --}}
   <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
   <script type='text/javascript' src="{{ asset('/vendor/jquery/jquery-3.6.0.min.js') }}"></script>
   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
</head>


<body>
   <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg-dash-dark-3 px-3 pt-5">
      <div class="row w-100">
         <div class="col-xl-4 m-auto">
            <div class="row flex-column align-items-center">
               <div class="col-xxl-12 text-center">
                  <img src="{{ asset('img/logo.png') }}" class="img-fluid mb-5" height="100px" alt="">
               </div>
               <div class="col-xxl-12">
                  <h1 class="fs-1 text-light">Welcome</h1>
               </div>
               <div class="col-xxl-12">
                  <h2 class="fs-2 text-light">Sign in to continue</h2>
               </div>
            </div>
            <form action="{{ route('login') }}" id="loginForm" method="POST" class="w-100 mt-3" autocomplete="false">
               @csrf
               <div class="row flex-column align-items-center">
                  <div class="col-xxl-12">
                     <div class="mb-3 position-relative text-white">
                        <input type="text" class="w-100 border-none p-3 pe-5 bg-secondary rounded"
                           placeholder="Username" name="username" id="username">
                        <span class="position-absolute" style="top: 16px; right:20px;">
                           <i class="fas fa-lg fa-user"></i>
                        </span>
                     </div>
                  </div>
                  <div class="col-xxl-12">
                     <div class="mb-5 position-relative text-white">
                        <input type="password" class="w-100 border-none p-3 pe-5 bg-secondary rounded"
                           placeholder="Password" name="password" id="password">
                        <span class="position-absolute" style="top: 16px; right:20px;">
                           <i class="fas fa-lg fa-key"></i>
                        </span>
                     </div>
                  </div>
                  <div class="col-xxl-12 d-grid">
                     <button type="submit" id="submitBtn" value="Login" class="btn btn-success fw-bold">Login</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>

   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

   <script>
      $("form").on("submit", () => {
         $("button").attr("disabled", true);
         $("input, textarea").attr("readonly", true);
         return true;
      });
   </script>

   @include('layouts.toastr')
</body>
</html>

