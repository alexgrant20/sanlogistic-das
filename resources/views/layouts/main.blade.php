<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dark Admin by Bootstrapious.com</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">

  {{-- Google Font --}}
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
  {{-- theme stylesheet --}}
  <link rel="stylesheet" href="/css/style.default.css" id="theme-stylesheet">
  {{-- Custom Stylesheet --}}
  <link rel="stylesheet" href="/css/custom.css">
  {{-- Favicon --}}
  <link rel="shortcut icon" href="/img/favicon.ico">

  {{-- Jquery --}}
  <script type='text/javascript' src="/vendor/jquery/jquery-3.6.0.min.js"></script>

  @yield('headCSS')

  @yield('headJS')

</head>

<body>
  @include('partials.header')
  <div class="d-flex align-items-stretch">
    @include('partials.sidebar')

    @yield('container')

    @include('partials.footer')
  </div>

  <!-- JavaScript files-->
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Main File-->
  <script src="/js/front.js"></script>
  <script src="/js/function.js"></script>
  <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">



  @yield('footJS')

</body>

</html>
