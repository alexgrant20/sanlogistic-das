@extends('admin.layouts.main')

@section('headCSS')
  <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/datatable/datatables.min.css') }}" />
  @yield('add_headCSS')
@endsection

@section('headJS')
  @yield('add_headJS')
@endsection

@section('container')
  @yield('container')
@endsection

@section('footJS')
  <script type="text/javascript" src="{{ asset('/vendor/datatable/datatables.min.js') }}"></script>
  @yield('add_footJS')
@endsection
