$(document).ready(function () {
	const PROV_ID = $("#province_id").val();
	const CITY_ID = $("#ci_id").val();
	const DIS_ID = $("#di_id").val();
	const SUBDIS_ID = $("#su_id").val();

	if (PROV_ID) {
		if (CITY_ID) {
			fetchOption(
				`/option/city/${PROV_ID}`,
				"city_id",
				["city_id", "district_id", "subdistrict_id"],
				CITY_ID
			);
		} else {
			fetchOption(`/option/city/${PROV_ID}`, "city_id", [
				"city_id",
				"district_id",
				"subdistrict_id",
			]);
		}
	}

	if (CITY_ID) {
		if (DIS_ID) {
			fetchOption(
				`/option/district/${CITY_ID}`,
				"district_id",
				["district_id", "subdistrict_id"],
				DIS_ID
			);
		} else {
			fetchOption(`/option/district/${CITY_ID}`, "district_id", [
				"district_id",
				"subdistrict_id",
			]);
		}
	}

	if (DIS_ID) {
		if (SUBDIS_ID) {
			fetchOption(
				`/option/sub-district/${DIS_ID}`,
				"subdistrict_id",
				["subdistrict_id"],
				SUBDIS_ID
			);
		} else {
			fetchOption(`/option/sub-district/${DIS_ID}`, "subdistrict_id", [
				"subdistrict_id",
			]);
		}
	}

	$("#province_id").on("change", function () {
		const provinceID = $(this).val();
		if (provinceID) {
			fetchOption(`/option/city/${provinceID}`, "city_id", [
				"city_id",
				"district_id",
				"subdistrict_id",
			]);
		} else {
			$("#city_id").empty();
		}
	});

	$("#city_id").on("change", function () {
		const cityID = $(this).val();
		if (cityID) {
			fetchOption(`/option/district/${cityID}`, "district_id", [
				"district_id",
				"subdistrict_id",
			]);
		} else {
			$("#district_id").empty();
		}
	});

	$("#district_id").on("change", function () {
		const district_id = $(this).val();
		if (district_id) {
			fetchOption(`/option/sub-district/${district_id}`, "subdistrict_id", [
				"subdistrict_id",
			]);
		} else {
			$("#subdistrict_id").empty();
		}
	});
});
