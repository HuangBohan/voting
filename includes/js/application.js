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
			newCanRow.find("[id*=position-header-0]").attr("id", "position-header-" + newId);
			newCanRow.find("[id*=candidate-matric-0]").attr("id", "candidate-matric-" + newId);
			newCanRow.find("[id*=candidate-photo-0]").attr("id", "candidate-photo-" + newId);
			newCanRow.find("[for*=candidate-matric-0]").attr("for", "candidate-matric-" + newId);
			newCanRow.find("[for*=candidate-photo-0]").attr("for", "candidate-photo-" + newId);
			canRowList.last().after(newCanRow);

			initPreviewPhoto();
			bindPositionHeader();
			initAddCandidateButtons(canTemplate);
		}
		
	});

	initPreviewPhoto();
	bindPositionHeader();
	initAddCandidateButtons(canTemplate);

	$("#position-name").on("input", function() {
		$("#position-name-header").text($(this).val());
	});
});

function initAddCandidateButtons (canTemplate) {
	$(".add-candidate").click(function(event) {
		event.preventDefault();
		var tmpCan = canTemplate.clone();
		var canRow = $(this).parent().parent();
		var canList = canRow.find(".candidate-template");

		var posId = $(".candidate-row-template").length;

		if(canList.length < 4) {
			// update ids for new candidate
			var newId = canList.length;
			tmpCan.find("[id*=candidate-matric-]").attr("id", "candidate-matric-" + posId + "-" + newId + "]");
			tmpCan.find("[id*=candidate-photo-]").attr("id", "candidate-photo-" + posId + "-" + newId + "]");
			tmpCan.find("[for*=candidate-matric-]").attr("for", "candidate-matric-" + posId + "-" + newId + "]");
			tmpCan.find("[for*=candidate-photo-]").attr("for", "candidate-photo-" + posId + "-" + newId + "]");
			
			canList.last().after(tmpCan);
			initPreviewPhoto();
		}
	});
}

function initPreviewPhoto() {
	$("[id*=candidate-photo-]").change(function(event) {
		var imgDiv = $(this).parent().parent().find("img");
		if(this.files && this.files[0]) {
			imgDiv.attr("src", URL.createObjectURL(event.target.files[0]));
		}
	});
}

function bindPositionHeader() {
	$("[id*=position-name-]").each(function() {
		var posId = $(this).attr("id").split("-");
		posId = posId[2];
		
		$(this).on("input", function() {
			$("#position-header-" + posId).text($(this).val());
		});
	});
}



