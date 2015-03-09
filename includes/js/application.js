$(function() {
	$("#startDate").datetimepicker();
	$("#endDate").datetimepicker();

	$("#add-position").click(function(event) {
		event.preventDefault();

		var positionList = $(".position-template");
		if(positionList.length < 4) {
			var template = $(".position-template").first().clone();
				
			// clear all input fields	
			template.find("input").val("");
			var voterList = template.find("select");
			voterList.val(voterList.find("option:first").val());

			// update all id fileds
			var oldId 	= positionList.length - 1;
			var newId 	= positionList.length;
			template.find("#position-name-" + oldId).attr("id", "position-name-" + newId);
			template.find("#position-slot-" + oldId).attr("id", "position-slot-" + newId);
			template.find("#position-voter-" + oldId).attr("id", "position-voter-" + newId);
			template.find("[for=position-name-" + oldId + "]").attr("for", "position-name-" + newId);
			template.find("[for=position-slot-" + oldId + "]").attr("for", "position-slot-" + newId);
			template.find("[for=position-voter-" + oldId + "]").attr("for", "position-voter-" + newId);
			$(".position-template").last().after(template);	
		}
		
	});

	$("#position-name").on("input", function() {
		$("#position-name-header").text($(this).val());
	});
});