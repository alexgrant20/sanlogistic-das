@extends('admin.layouts.main')

@section('container')
   <div class="page-content">
      <!-- Page Header-->
      <div class="bg-dash-dark-2 py-4">
         <div class="container-fluid">
            <h2 class="h5 mb-0">Dashboard</h2>
         </div>
      </div>
   </div>
@endsection

@section('footJS')
   <script src="/vendor/chart.js/Chart.min.js"></script>
   <script src="/js/charts-home.js"></script>
@endsection
