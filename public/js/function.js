"use strict";

function insertAfter(referenceNode, newNode) {
  referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}

function fetchOption(url, id, depArr, chooseID) {
  const wrapper = document.createElement("div");
  const spinner = document.createElement("div");

  $.ajax({
    url,
    type: "GET",
    dataType: "json",

    beforeSend: function () {
      if (depArr.length > 0) {
        depArr.forEach((id, index) => {
          if (index === 0) {
            const element = document.getElementById(id);
            const parent = element.parentNode;
            wrapper.className = "relative";
            spinner.className = "spinner-border text-primary absolute center";
            parent.replaceChild(wrapper, element);
            wrapper.appendChild(element);
            insertAfter(element, spinner);
          }

          $(`#${id}`).empty();
          $(`#${id}`).prop("disabled", true);
        });
      }
    },

    success: function (data) {
      if (data) {
        $(`#${id}`).removeAttr("disabled");
        $(`#${id}`).append("<option hidden></option>");
        $.each(data, function (key, data) {
          let option = `<option value=${data.id}>${data.name}</option>`;

          if (chooseID && chooseID == data.id) {
            option = `<option value=${data.id} selected>${data.name}</option>`;
          }

          $(`select[name=${id}]`).append(option);
        });
      } else {
        $(`#${id}`).empty();
      }
      spinner.remove();
      wrapper.replaceWith(...wrapper.children);
    },
  });
}

function previewImage(id) {
  const image = document.querySelector(`#${id}`);
  const imgPreview = document.querySelector(`#${id}-preview`);

  let spinner = document.createElement("div");
  spinner.className = "spinner-border m-auto d-block";
  imgPreview.classList.add("d-none");
  insertAfter(imgPreview, spinner);

  if (image.files[0]) {
    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);
    oFReader.onload = function (oFREvent) {
      imgPreview.src = oFREvent.target.result;
      imgPreview.classList.remove("d-none");
      spinner.remove();
    };
  } else {
    imgPreview.src = "";
    spinner.remove();
  }
}
function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(";");
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function plateNumberHandler(value, type) {
  switch (type) {
    case "number":
      $("#plateNumber").text(value);
      break;

    case "color":
      let color;
      // Referesh
      $("#plate").removeClass("bg-white").removeClass("bg-warning");
      if (value === "1") {
        $("#plate").addClass("bg-white");
      } else {
        $("#plate").addClass("bg-warning");
      }
      break;

    case "stnk":
    case "kir":
      const date = value.split("-");
      const year = date[0].substr(2, 2);
      const month = date[1];
      $(`#${type}Year`).text(`${month}.${year}`);
      break;
  }
}

function formatIDR(value) {
  const moneyFormat = {
    symbol: "Rp. ",
    decimal: ",",
    separator: ".",
    precision: 0,
  };

  return currency(value, moneyFormat).format();
}

function calculateCheckBox(id) {
  var numberOfChecked = $("#" + id + " input:checkbox:checked").length;
  var totalCheckboxes = $("#" + id + " input:checkbox").length;
  $("#" + id + "-text").text(`[${numberOfChecked}/${totalCheckboxes}]`);
}

function getVehicleLastStatus() {
  $(".accordion-item").addClass("disable-div");
  $(".switches input").attr("disabled", true);
  $(".submit").attr("disabled", true);

  $(".switches input:checkbox").on("change", function (e) {
    const checkboxMainID = $(this.parentNode.parentNode.parentNode).attr("id");
    calculateCheckBox(checkboxMainID);
  });

  // Use last checklist value
  $("#vehicle_id").on("change", async function (e) {
    $(".accordion-item").addClass("disable-div");
    $(".switches input").attr("disabled", true);
    $(".submit").attr("disabled", true);

    const res = await fetch("/driver/last-statuses/" + e.target.value);
    const data = await res.json();
    if (Object.keys(data).length > 0) {
      Object.keys(data).forEach((key) => {
        $(`#${key}`).prop("checked", data[key] === 0 ? true : false);
      });
    } else {
      $(".switches input:checkbox").each(function () {
        this.checked = true;
      });
    }

    $(".accordion-item").removeClass("disable-div");
    $(".switches input").attr("disabled", false);
    $(".submit").attr("disabled", false);

    $("#checklist_container")
      .children()
      .each(function (e, item) {
        calculateCheckBox(
          $($(item).children()[1]).children().children().attr("id")
        );
      });
  });
}

$("#form").on("submit", () => {
  $("button").attr("disabled", true);
  $("input, textarea").attr("readonly", true);
  $("select").css("pointer-events", "none");

  const spinnerExist = $("#spinner").length != 0;

  if (!spinnerExist) {
    $("#submit").append(
      "<span class='ms-2 spinner-border spinner-border-sm' id='spinner'></span>"
    );
  }

  return true;
});

$("#submit").click(function (e) {
  $("#form").submit();
});

function checkAll(bx, classEl) {
  const checked = $(bx).is(":checked");
  const cbs = document.querySelectorAll("." + classEl);

  cbs.forEach((el) => {
    $(el).prop("checked", checked);

    if (checked) {
      $(el).closest("tr").addClass("selected");
    } else {
      $(el).closest("tr").removeClass("selected");
    }
  });
}
