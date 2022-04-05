"use strict";

document.addEventListener("DOMContentLoaded", function () {
  const table = $('table[data-display="datatables"]').DataTable({
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
    columnDefs: [
      {
        targets: [0],
        visible: false,
        searchable: false,
      },
    ],
  });

  $.fn.dataTable.Buttons.defaults.dom.button.className =
    "btn btn-outline-primary";

  new $.fn.dataTable.Buttons(table, {
    buttons: [
      {
        extend: "collection",
        text: "Import",
        buttons: [
          {
            text: "Excel",
            action: function () {
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
            text: "Excel",
            action: function (param) {
              let ids = "";
              const data = table.rows({ filter: "applied" }).data();

              data.map((e) => {
                ids += e[0] + ",";
              });

              const tableName = $("#tableName").val();

              window.location.replace(tableName + "/export/excel?ids=" + ids);
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
