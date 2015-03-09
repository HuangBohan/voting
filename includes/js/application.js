$(function() {
	$("#startDate").datetimepicker();
	$("#endDate").datetimepicker();

	$("#position-name").on("input", function() {
		$("#position-name-header").text($(this).val());
	});
});