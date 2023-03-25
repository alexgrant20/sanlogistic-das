<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sanlogistic | {{ $title }}</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">

  {{-- Google Font --}}
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
  {{-- theme stylesheet --}}
  <link rel="stylesheet" href="{{ asset('/css/style.default.css') }}" id="theme-stylesheet">
  {{-- Custom Stylesheet --}}
  <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
  {{-- Favicon --}}
  <link rel="shortcut icon" href="{{ asset('/img/favicon.ico') }}">

  {{-- Jquery --}}
  <script type='text/javascript' src="{{ asset('/vendor/jquery/jquery-3.6.0.min.js') }}"></script>

  {{-- Zoom CSS --}}
  <link href="{{ asset('/vendor/zoom/zoom.css') }}" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  @yield('headCSS')

  @yield('headJS')

</head>

<body>
  @include('admin.partials.header')
  <div class="d-flex align-items-stretch">
    @include('admin.partials.sidebar')

    @yield('container')

    @include('admin.partials.footer')
  </div>

  <!-- JavaScript files-->
  <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Main File-->
  <script src="{{ asset('/js/front.js') }}"></script>
  <script src="{{ asset('/js/function.js') }}"></script>

  {{-- Zoom JS --}}
  <script src="{{ asset('/vendor/zoom/zoom.js') }}"></script>

  {{-- Currency --}}
  <script src="{{ asset('/vendor/currency/currency.js') }}"></script>

  <!-- Laravel Javascript Validation -->
  <script type="text/javascript" src="{{ asset('vendor/jsvalidation/jsvalidation.min.js') }}"></script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script>
    $(document).ready(function() {
      $('.select2').select2({
        width: 'resolve'
      });
    });

    @if ($message = Session::has('message'))
      var type = "{{ Session::get('alert-type', 'info') }}"
      switch (type) {
        case 'info':
          toastr.info(" {{ $message }} ");
          break;
        case 'success':
          toastr.success(" {{ $message }} ");
          break;
        case 'warning':
          toastr.warning(" {{ $message }} ");
          break;
        case 'error':
          toastr.error(" {{ $message }} ");
          break;
      }
    @endif
  </script>



  @if ($message = Session::get('success-swal'))
    <script>
      swal("Success", '{{ $message }}', "success");
    </script>
  @endif

  @if ($message = Session::get('error-swal'))
    <script>
      swal("Failed", '{{ $message }}', "error");
    </script>
  @endif

  @if ($message = Session::get('warning-swal'))
    <script>
      swal("Warning", '{{ $message }}', "warning");
    </script>
  @endif

  <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <script src="https://kit.fontawesome.com/2d78a8b052.js" crossorigin="anonymous"></script>


  @yield('footJS')

</body>

</html>
