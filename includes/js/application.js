$(function() {
	var template = $(".position-template").first().clone();

	$("#startDate").datetimepicker();
	$("#endDate").datetimepicker();

	$("#add-position").click(function(event) {
		event.preventDefault();

		var positionList = $(".position-template");
		if(positionList.length < 4) {
			var tmp = template.clone();

			// update all id fileds
			var oldId 	= positionList.length - 1;
			var newId 	= positionList.length;
			tmp.find("#position-name-" + oldId).attr("id", "position-name-" + newId);
			tmp.find("#position-slot-" + oldId).attr("id", "position-slot-" + newId);
			tmp.find("#position-voter-" + oldId).attr("id", "position-voter-" + newId);
			tmp.find("[for=position-name-" + oldId + "]").attr("for", "position-name-" + newId);
			tmp.find("[for=position-slot-" + oldId + "]").attr("for", "position-slot-" + newId);
			tmp.find("[for=position-voter-" + oldId + "]").attr("for", "position-voter-" + newId);
			$(".position-template").last().after(tmp);	
		}
		
	});

	$("#position-name").on("input", function() {
		$("#position-name-header").text($(this).val());
	});
});