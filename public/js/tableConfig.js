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
	});

	// new $.fn.dataTable.Buttons(table, {
	// 	buttons: {
	// 		dom: {
	// 			button: {
	// 				className: "btn btn-primary me-2", //Primary class for all buttons
	// 			},
	// 		},
	// 		buttons: [
	// 			{
	// 				extend: "collection",
	// 				text: "Export",
	// 				buttons: [
	// 					{
	// 						extend: "excelHtml5",
	// 						exportOptions: {
	// 							columns: [":visible"],
	// 						},
	// 					},
	// 					{
	// 						extend: "pdfHtml5",
	// 						exportOptions: {
	// 							columns: [":visible"],
	// 						},
	// 					},
	// 					{
	// 						extend: "searchBuilder",
	// 						config: {
	// 							depthLimit: 2,
	// 						},
	// 					},
	// 					"colvis",
	// 				],
	// 			},
	// 		],
	// 	},
	// 	dom: "Bfrtip",
	// });

	$.fn.dataTable.Buttons.defaults.dom.button.className = "btn btn-primary";
	new $.fn.dataTable.Buttons(table, {
		buttons: [
			{
				extend: "collection",
				text: "Import",
				buttons: [
					{
						text: "Excel",
						action: function (e, dt, node, config) {
							$("#importExcel").modal("show");
						},
					},
				],
			},
			{
				extend: "collection",
				text: "Export",
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
				],
			},
			"searchBuilder",
			"colvis",
		],
	});

	table.buttons(0, null).containers().appendTo("#actionContainer");
});
