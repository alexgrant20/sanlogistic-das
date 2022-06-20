<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sanlogistic-Driver | {{ $title }}</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">

  {{-- theme stylesheet --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  {{-- Custom Stylesheet --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/driver/global.css') }}" />
  {{-- Favicon --}}
  <link rel="shortcut icon" href="{{ asset('/img/favicon.ico') }}">

  {{-- Jquery --}}
  <script type='text/javascript' src="{{ asset('/vendor/jquery/jquery-3.6.0.min.js') }}"></script>

  {{-- Zoom CSS --}}
  <link href="{{ asset('/vendor/zoom/zoom.css') }}" rel="stylesheet">

  @yield('headCSS')

  @yield('headJS')

</head>

<body class="min-vh-100 min-vw-100 bg-main">
  @include('driver.partials.header')
  <div class="p-5" style="padding-bottom: 120px !important;">

    @yield('container')

  </div>
  @include('driver.partials.footer')

  <script src="{{ asset('/vendor/currency/currency.js') }}"></script>

  <!-- JavaScript files-->
  <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Main File-->
  <script src="{{ asset('/js/function.js') }}"></script>
  {{-- Zoom JS --}}
  <script src="{{ asset('/vendor/zoom/zoom.js') }}"></script>
  <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

  @yield('footJS')

</body>

</html>
