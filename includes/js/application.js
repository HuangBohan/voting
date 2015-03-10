$(function() {
	var posTemplate = $(".position-template").first().clone();
	var canTemplate = $(".candidate-template").first().clone();
	var canRowTemplate = $(".candidate-row-template").first().clone();

	console.log(canRowTemplate);

	$("#startDate").datetimepicker();
	$("#endDate").datetimepicker();

	$("#add-position").click(function(event) {
		event.preventDefault();

		var positionList = $(".position-template");
		if(positionList.length < 4) {
			var newPos = posTemplate.clone();
			var newCanRow = canRowTemplate.clone();

			// update all id fileds
			var oldId 	= positionList.length - 1;
			var newId 	= positionList.length;
			newPos.find("#position-name-" + oldId).attr("id", "position-name-" + newId);
			newPos.find("#position-slot-" + oldId).attr("id", "position-slot-" + newId);
			newPos.find("#position-voter-" + oldId).attr("id", "position-voter-" + newId);
			newPos.find("[for=position-name-" + oldId + "]").attr("for", "position-name-" + newId);
			newPos.find("[for=position-slot-" + oldId + "]").attr("for", "position-slot-" + newId);
			newPos.find("[for=position-voter-" + oldId + "]").attr("for", "position-voter-" + newId);
			$(".position-template").last().after(newPos);	

			$(".candidate-row-template").last().after(newCanRow);
		}
		
	});

	$("#add-candidate").click(function(event) {
		event.preventDefault();
		var candidateList = $(".row candidate-templdate");
	});

	$("#position-name").on("input", function() {
		$("#position-name-header").text($(this).val());
	});
});