<!DOCTYPE html>
<html>

<head>
  <title>Login</title>

  <!-- Script -->
  <script src="https://kit.fontawesome.com/2d78a8b052.js" crossorigin="anonymous"></script>
  {{-- theme stylesheet --}}
  <link rel="stylesheet" href="{{ asset('/css/style.default.css') }}" id="theme-stylesheet">
  {{-- Custom Stylesheet --}}
  <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
  <script type='text/javascript' src="{{ asset('/vendor/jquery/jquery-3.6.0.min.js') }}"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
</head>


<body>
  {{-- @if (session()->has('message'))
    @dd(session('message'))
  @endif --}}
  <div class="container-fluid position-relative p-0">
    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg-dash-dark-3 p-5">
      <div class="w-100" style="max-width: 500px">
        <div class="row flex-column align-items-center">
          <div class="col-xxl-12">
            <img src="https://www.freepnglogos.com/uploads/eagle-png-logo/lakes-eagles-png-logo-14.png"
              class="img-fluid mb-5" style="max-height: 120px; max-width: 120px" alt="">
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
                <input type="text" class="w-100 border-none p-3 pe-5 bg-secondary rounded" placeholder="Username"
                  name="username" id="username">
                <span class="position-absolute" style="top: 16px; right:20px;">
                  <i class="fas fa-lg fa-user"></i>
                </span>
              </div>
            </div>
            <div class="col-xxl-12">
              <div class="mb-5 position-relative text-white">
                <input type="password" class="w-100 border-none p-3 pe-5 bg-secondary rounded" placeholder="Password"
                  name="password" id="password">
                <span class="position-absolute" style="top: 16px; right:20px;">
                  <i class="fas fa-lg fa-key"></i>
                </span>
              </div>
            </div>
            <div class="col-xxl-12">
              <input type="submit" id="submitBtn" value="Login" class="btn btn-primary w-100 py-2 fs-5 fw-bold" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
  $('#loginForm').on('submit', () => {
    $('#submitBtn').attr('disabled', true);
  })
  @if (Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}"
    switch (type) {
      case 'info':
        toastr.info(" {{ Session::get('message') }} ");
        break;
      case 'success':
        toastr.success(" {{ Session::get('message') }} ");
        break;
      case 'warning':
        toastr.warning(" {{ Session::get('message') }} ");
        break;
      case 'error':
        toastr.error(" {{ Session::get('message') }} ");
        break;
    }
  @endif
</script>
