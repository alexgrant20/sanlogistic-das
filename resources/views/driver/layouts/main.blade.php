<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sanlogistic | @yield('title')</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no,maximum-scale=1, user-scalable=0">
  <meta name="robots" content="all,follow">

  @livewireStyles

  {{-- theme stylesheet --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  {{-- Favicon --}}
  <link rel="shortcut icon" href="{{ asset('/img/favicon.ico') }}">

  {{-- Jquery --}}
  <script type='text/javascript' src="{{ asset('/vendor/jquery/jquery-3.6.0.min.js') }}"></script>


  {{-- Zoom CSS --}}
  <link href="{{ asset('/vendor/zoom/zoom.css') }}" rel="stylesheet">

  {{-- theme stylesheet --}}
  <link rel="stylesheet" href="{{ asset('/css/style.sea.css') }}" id="theme-stylesheet">

  {{-- Toastr --}}
  {{-- Toastr must be below theme stylesheet --}}
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

  <link rel="stylesheet" type="text/css" href="{{ asset('/css/driver/global.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/custom.css') }}" />

  @yield('headCSS')
  @yield('headJS')
</head>

<body class="min-vh-100 min-vw-100 background">
  @include('driver.partials.header')
  <div class="px-3" style="padding-bottom: 120px">
    @yield('content')
  </div>
  @include('driver.partials.footer')

  @include('driver.layouts.jssection')
  @include('layouts.alert-swal')
  @include('layouts.toastr')

  @yield('footJS')

  @livewireScripts
</body>

</html>
