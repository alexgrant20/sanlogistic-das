<!-- JavaScript files-->
<script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

{{-- Zoom JS --}}
<script src="{{ asset('/vendor/zoom/zoom.js') }}"></script>

{{-- Currency --}}
<script src="{{ asset('/vendor/currency/currency.js') }}"></script>

<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/jsvalidation.min.js') }}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="{{ asset('/js/front.js') }}"></script>
<script src="{{ asset('/js/function.js') }}"></script>

{{-- Select 2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<script src="https://kit.fontawesome.com/2d78a8b052.js" crossorigin="anonymous"></script>

{{-- Datatable --}}
<script type="text/javascript" src="{{ asset('/vendor/datatable/datatables.min.js') }}"></script>

<script src="{{ asset('/js/front.js') }}"></script>
<script src="{{ asset('/js/function.js') }}"></script>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      width: 'resolve'
    });
  });
</script>
