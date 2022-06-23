const validation = new JustValidate("#form", {
  errorFieldCssClass: "is-invalid",
  errorLabelCssClass: "invalid-feedback d-block",
  lockForm: true,
});

validation.addField("#arrival_odo", [{ rule: "required" }]).onSuccess((t) =>
  $("form").submit(function () {
    return true;
  })
);
