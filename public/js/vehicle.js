$(document).ready(function () {
	const brandID = $("#vehicle_brand_id").val();
	const typeID = $("#type_id").val();
	const varietyID = $("#variety_id").val();

	if (brandID) {
		if (typeID) {
			fetchOption(
				`/option/vehicle-type/${brandID}`,
				"vehicle_type_id",
				["vehicle_type_id"],
				typeID
			);
		} else {
			fetchOption(`/option/vehicle-type/${brandID}`, "vehicle_type_id", [
				"vehicle_type_id",
			]);
		}
	}

	if (typeID) {
		if (varietyID) {
			fetchOption(
				`/option/vehicle-variety/${typeID}`,
				"vehicle_variety_id",
				["vehicle_variety_id"],
				varietyID
			);
		} else {
			fetchOption(`/option/vehicle-variety/${typeID}`, "vehicle_variety_id", [
				"vehicle_variety_id",
			]);
		}
	}

	$("#vehicle_brand_id").on("change", function () {
		const brandID = $(this).val();
		if (brandID) {
			fetchOption(`/option/vehicle-type/${brandID}`, "vehicle_type_id", [
				"vehicle_type_id",
				"vehicle_variety_id",
			]);
		} else {
			$("#vehicle_type_id").empty();
		}
	});

	$("#vehicle_type_id").on("change", function () {
		const typeID = $(this).val();
		if (typeID) {
			fetchOption(`/option/vehicle-variety/${typeID}`, "vehicle_variety_id", [
				"vehicle_variety_id",
			]);
		} else {
			$("#vehicle_variety_id").empty();
		}
	});
});
