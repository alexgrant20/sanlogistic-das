<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sanlogistic | {{ $title }}</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">

  @livewireStyles

  {{-- theme stylesheet --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  {{-- theme stylesheet --}}
  <link rel="stylesheet" href="{{ asset('/css/style.sea.css') }}" id="theme-stylesheet">
  {{-- Custom Stylesheet --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/driver/global.css') }}" />
  {{-- Favicon --}}
  <link rel="shortcut icon" href="{{ asset('/img/favicon.ico') }}">

  <script src="https://kit.fontawesome.com/2d78a8b052.js" crossorigin="anonymous"></script>

  {{-- Jquery --}}
  <script type='text/javascript' src="{{ asset('/vendor/jquery/jquery-3.6.0.min.js') }}"></script>

  {{-- Toastr --}}
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

  {{-- Zoom CSS --}}
  <link href="{{ asset('/vendor/zoom/zoom.css') }}" rel="stylesheet">

  @yield('headCSS')

  @yield('headJS')

</head>

<body class="min-vh-100 min-vw-100 bg-main">
  @include('driver.partials.header')
  <div class="px-3 py-5">

    @yield('content')

  </div>

  <script src="{{ asset('/vendor/currency/currency.js') }}"></script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
  </script>

  <!-- JavaScript files-->
  <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Main File-->
  <script src="{{ asset('/js/front.js') }}"></script>
  <script src="{{ asset('/js/function.js') }}"></script>
  {{-- Zoom JS --}}
  <script src="{{ asset('/vendor/zoom/zoom.js') }}"></script>
  <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

  @yield('footJS')
  @livewireScripts
</body>

</html>
