"use strict";

document.addEventListener("DOMContentLoaded", function () {
	const table = $("table").DataTable({
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

		buttons: [
			{
				extend: "excelHtml5",
				exportOptions: {
					columns: [":visible"],
				},
			},
			{
				extend: "pdfHtml5",
				exportOptions: {
					columns: [":visible"],
				},
			},
			{
				extend: "searchBuilder",
				config: {
					depthLimit: 2,
				},
			},
			"colvis",
		],
		dom: "Bfrtip",
	});
});
