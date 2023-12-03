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
  <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">

  {{-- Favicon --}}
  <link rel="shortcut icon" href="{{ asset('/img/favicon.ico') }}">

  {{-- Jquery --}}
  <script type='text/javascript' src="{{ asset('/vendor/jquery/jquery-3.6.0.min.js') }}"></script>

  {{-- Zoom CSS --}}
  <link href="{{ asset('/vendor/zoom/zoom.css') }}" rel="stylesheet">

  {{-- Toastr --}}
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

  {{-- Table Config --}}
  <script type="text/javascript" src="{{ asset('/js/tableConfig.js') }}"></script>

  {{-- Sweet Alert --}}
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  {{-- CSS Datatable --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/datatable/datatables.min.css') }}" />

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

  @include('admin.layouts.jssection')
  @include('layouts.toastr')
  @include('layouts.alert-swal')

  @yield('footJS')
</body>

</html>
