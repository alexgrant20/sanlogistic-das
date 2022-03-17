"use strict";

function fetch_option(url, val, type, ids, idSelected = false) {
    $.ajax({
        type: "post",
        url,
        data: {
            get_option: val,
            type,
            idSelected,
        },
        beforeSend: function () {
            ids.forEach((id, index) => {
                if (index === 0) {
                    $(`#${id}`)
                        .siblings(".spinner-border")
                        .removeClass("d-none");
                }
                $(`#${id} option:gt(0)`).remove();
                $(`#${id}`).attr("disabled", "true");
            });
        },
        success: function (response) {
            ids.forEach((id, index) => {
                if (index === 0) {
                    $(`#${id}`).append(response);
                    $(`#${id}`).removeAttr("disabled");
                    $(`#${id}`).siblings(".spinner-border").addClass("d-none");
                }
            });
        },
    });
}

function fetchOption(url, id, depArr, chooseID) {
    $.ajax({
        url,
        type: "GET",
        dataType: "json",

        beforeSend: function () {
            if (depArr.length > 0) {
                depArr.forEach((id, index) => {
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
        },
    });
}

function insertAfter(referenceNode, newNode) {
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
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
