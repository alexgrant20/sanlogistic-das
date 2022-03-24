"use strict";

document.addEventListener("DOMContentLoaded", function () {
	$("#myTable tfoot th").each(function () {
		const title = $(this).text();
		$(this).html(
			`<input type="text" class="form-control" placeholder="${title}" />`
		);
	});

	$("#myTable").DataTable({
		initComplete: function () {
			// Apply the search
			this.api()
				.columns()
				.every(function () {
					const that = this;

					$("input", this.footer()).on("keyup change clear", function () {
						if (that.search() !== this.value) {
							that.search(this.value).draw();
						}
					});
				});
		},

		responsive: {
			details: {
				display: $.fn.dataTable.Responsive.display.modal({
					header: function (row) {
						const data = row.data();
						return "Details for " + data[1];
					},
				}),
				renderer: $.fn.dataTable.Responsive.renderer.tableAll({
					tableClass: "table",
				}),
			},
		},
	});
});
