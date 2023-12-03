{{-- Currency --}}
<script src="{{ asset('/vendor/currency/currency.js') }}"></script>

{{-- Toastr --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

{{-- Select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- Sweet Alert --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Bootsrap --}}
<script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

{{-- Zoom JS --}}
<script src="{{ asset('/vendor/zoom/zoom.js') }}"></script>

{{-- Laravel Javascript Validation --}}
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/jsvalidation.min.js') }}"></script>

{{-- Bootsrap Icon --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

{{-- FontAwesome CSS --}}
<script src="https://kit.fontawesome.com/2d78a8b052.js" crossorigin="anonymous"></script>

<script src="{{ asset('/js/function.js') }}" defer></script>
<script src="{{ asset('/js/front.js') }}" defer></script>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      width: 'resolve'
    });
  });
</script>