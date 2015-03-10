$(function() {
	var posTemplate = $(".position-template").first().clone();
	var canTemplate = $(".candidate-template").first().clone();
	var canRowTemplate = $(".candidate-row-template").first().clone();

	$("#startDate").datetimepicker();
	$("#endDate").datetimepicker();

	$(".add-position").click(function(event) {
		event.preventDefault();

		var positionList = $(".position-template");
		var canRowList = $(".candidate-row-template");
		if(positionList.length < 4) {
			var newPos = posTemplate.clone();
			var newCanRow = canRowTemplate.clone();

			// update all id fileds for new position
			var newId 	= positionList.length;
			newPos.find("#position-name-0").attr("id", "position-name-" + newId);
			newPos.find("#position-slot-0").attr("id", "position-slot-" + newId);
			newPos.find("#position-voter-0").attr("id", "position-voter-" + newId);
			newPos.find("[for=position-name-0]").attr("for", "position-name-" + newId);
			newPos.find("[for=position-slot-0]").attr("for", "position-slot-" + newId);
			newPos.find("[for=position-voter-0]").attr("for", "position-voter-" + newId);
			positionList.last().after(newPos);	

			// update all id fields for new candidate row
			newId = canRowList.length;
			newCanRow.attr("id", "position-" + newId); 
			newCanRow.find("[id*=candidate-matric-0]").attr("id", "candidate-matric-" + newId + "-0]");
			newCanRow.find("[id*=candidate-photo-0]").attr("id", "candidate-photo-" + newId + "-0]");
			newCanRow.find("[for*=candidate-matric-0]").attr("for", "candidate-matric-" + newId + "-0]");
			newCanRow.find("[for*=candidate-photo-0]").attr("for", "candidate-photo-" + newId + "-0]");
			canRowList.last().after(newCanRow);

			initAddCandidateButtons(canTemplate);
		}
		
	});

	initAddCandidateButtons(canTemplate);

	$("#position-name").on("input", function() {
		$("#position-name-header").text($(this).val());
	});
});

function initAddCandidateButtons (canTemplate) {
	$(".add-candidate").click(function(event) {
		event.preventDefault();
		var tmp = canTemplate.clone();
		var canList = $(this).parent().parent().find(".candidate-template");
		
		if(canList.length < 4) {
			canList.last().after(tmp);
		}
	});
}