<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sanlogistic | {{ $title }}</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no,maximum-scale=1, user-scalable=0">
  <meta name="robots" content="all,follow">

  @livewireStyles

  {{-- theme stylesheet --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  {{-- theme stylesheet --}}
  <link rel="stylesheet" href="{{ asset('/css/style.sea.css') }}" id="theme-stylesheet">
  {{-- Custom Stylesheet --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/driver/global.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/custom.css') }}" />
  {{-- Favicon --}}
  <link rel="shortcut icon" href="{{ asset('/img/favicon.ico') }}">

  {{-- Jquery --}}
  <script type='text/javascript' src="{{ asset('/vendor/jquery/jquery-3.6.0.min.js') }}"></script>

  {{-- Toastr --}}
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

  {{-- Zoom CSS --}}
  <link href="{{ asset('/vendor/zoom/zoom.css') }}" rel="stylesheet">

  @yield('headCSS')

  @yield('headJS')

</head>

<body class="min-vh-100 min-vw-100 background">
  @include('driver.partials.header')
  <div class="px-3" style="padding-bottom: 120px">
    @yield('content')
  </div>
  @include('driver.partials.footer')

  <script src="{{ asset('/vendor/currency/currency.js') }}"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    @if (Session::has('message'))
      toastr.options = {
        "progressBar": true,
      }
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

    $(document).ready(function() {
      $('.select2').select2({
        width: 'resolve'
      });
    });
  </script>

  <!-- JavaScript files-->
  <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Main File-->
  <script src="{{ asset('/js/function.js') }}" defer></script>
  <script src="{{ asset('/js/front.js') }}" defer></script>

  {{-- Zoom JS --}}
  <script src="{{ asset('/vendor/zoom/zoom.js') }}"></script>

  {{-- Currency --}}
  <script src="{{ asset('/vendor/currency/currency.js') }}"></script>

  <!-- Laravel Javascript Validation -->
  <script type="text/javascript" src="{{ asset('vendor/jsvalidation/jsvalidation.min.js') }}"></script>


  <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <script src="https://kit.fontawesome.com/2d78a8b052.js" crossorigin="anonymous"></script>

  @yield('footJS')
  @livewireScripts
</body>

</html>
