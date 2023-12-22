<script>
  function generateSwalPayload(title, message, icon) {
    const form = document.createElement("div");
    form.innerHTML = message;
    return {
      icon,
      color: "#ddd",
      title,
      html: form,
      confirmButtonText: "Tutup"
    }
  }
</script>

@if ($message = Session::get('success-swal'))
  <script>
    Swal.fire(generateSwalPayload("Success", `{!! $message !!}`, "success"));
  </script>
@endif

@if ($message = Session::get('error-swal'))
  <script>
    Swal.fire(generateSwalPayload("Failed", `{!! $message !!}`, "error"));
  </script>
@endif

@if ($message = Session::get('warning-swal'))
  <script>
    Swal.fire(generateSwalPayload("Warning", `{!! $message !!}`, "warning"));
  </script>
@endif

@if ($message = Session::get('info-swal-html'))
  <script>
    Swal.fire(generateSwalPayload("Info", `{!! $message !!}`, "info"));
  </script>
@endif
