<script>
	function generateSwalPayload(title, message, icon) {
		 let form = document.createElement("div");
		 form.innerHTML = message;
		 return {
				icon,
				title,
				html: true,
				content: form,
				confirmButtonText: "Tutup"
		 }
	}
</script>

@if ($message = Session::get('success-swal'))
	<script>
		 swal(generateSwalPayload("Success", `{!! $message !!}`, "success"));
	</script>
@endif

@if ($message = Session::get('error-swal'))
	<script>
		 swal(generateSwalPayload("Failed", `{!! $message !!}`, "error"));
	</script>
@endif

@if ($message = Session::get('warning-swal'))
	<script>
		 swal(generateSwalPayload("Warning", `{!! $message !!}`, "warning"));
	</script>
@endif

@if ($message = Session::get('info-swal-html'))
	<script>
		 swal(generateSwalPayload("Info", `{!! $message !!}`, "info"));
	</script>
@endif
