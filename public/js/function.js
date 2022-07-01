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

$("form").on("submit", () => {
  $("button").attr("disabled", true);
  $("input, textarea").attr("readonly", true);
  return true;
});
