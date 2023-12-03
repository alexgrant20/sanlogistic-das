<script>
  const toastrConfig = {
    positionClass: 'toast-top-right',
    timeOut: 3000, // 3 seconds
    closeButton: true,
    progressBar: true,
  };

  function showToast(message, type) {
    toastr.options = toastrConfig;
    toastr[type](message, type.charAt(0).toUpperCase() + type.slice(1));
  }

  @if ($message = Session::has('toastr-message'))
    const message = "{{ Session::get('toastr-message') }}";
    const type = "{{ Session::get('toastr-type', 'info') }}";

    showToast(message, type);
  @endif
</script>
