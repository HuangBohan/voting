<?php 
	require_once __DIR__ . '/config.inc';
	require_once __DIR__ . '/../class/openid.php';

	if (session_status() == PHP_SESSION_NONE) {
    	session_start();
	}

	function showPage($content) {
		return showHeader() . $content . showFooter();
	}

	function showHeader() {
		return <<<HEADER
		<!DOCTYPE HTML>
		<html lang="en">
			<head>
				<title>Eusoff Hall Election System</title>

				<link rel="stylesheet" type="text/css" href="includes/css/datepicker.min.css">
				<link rel="stylesheet" type="text/css" href="includes/css/bootstrap.min.css">
				
				<script type="text/javascript" src="includes/js/jquery-2.1.0.min.js"></script>
				<script type="text/javascript" src="includes/js/bootstrap.min.js"></script>
				<script type="text/javascript" src="includes/js/moments.js"></script>
				<script type="text/javascript" src="includes/js/bootstrap-datetimepicker.min.js"></script>		
				<script type="text/javascript" src="includes/js/application.js"></script>
			</head>
			<body>
				<div class="container">
					<h1 style="text-align:center">Eusoff Hall Election System</h1>
HEADER;
	}

	function showFooter()
	{
		return <<<FOOTER
				</div>
			</body>
			<footer style="text-align:center">
				<p>Copyright &#169; 2015 EusoffWorks</p>
			</footer>
		</html>
FOOTER;
	}

	function showLogin()
	{
		return <<<LOGIN
		<div class="row">
			<div class="col-md-4 col-md-offset-4" role="tabpanel">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#student" aria-controls="student" role="tab" data-toggle="tab">Student Login</a></li>
					<li role="presentation"><a href="#admin" aria-controls="admin" role="tab" data-toggle="tab">Admin Login</a></li>
				</ul>

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="student">
						<form action="" method=POST>
							<input type="hidden" name="openid_identifier" value="https://openid.nus.edu.sg">
							<div style="text-align:center; margin: 20px">
								<button class="btn btn-default"><span style="font-size:20px">Login with NUS ID</span></button>
							</div>
						</form>
					</div>
					<div role="tabpanel" class="tab-pane" id="admin">
						<form class="form-inline" action="" method=POST>
							<input type="hidden" name="login" value="admin">
							<div style="text-align:center; margin: 20px">
								<div class="form-group">
									<label class="sr-only" for="pwd">Password</label>
									<input class="form-control" id="pwd" type="password" placeholder="Password">
								</div>
								<input type="submit" class="btn btn-default" name="adminLogin" value="Login">
							</div>
						</form>	
					</div>
			</div>
		</div>
LOGIN;
	}

	function processLogin() {
		try {
			$openid = new LightOpenID(HOST);
			if(!$openid->mode) {
				if (isset($_POST['nusnet_id'])) {
					$openid->identity = "https://openid.nus.edu.sg/".$_POST['nusnet_id'];
				}
				elseif (isset($_POST['openid_identifier'])) {
					$openid->identity = $_POST['openid_identifier'];
				}
	        	# The following two lines request email, full name, and a nickname
	        	# from the provider. Remove them if you don't need that data.
				$openid->optional = array('namePerson', 'namePerson/friendly', 'contact/email');
				header('Location: ' . $openid->authUrl());
			}
			else if($openid->mode == 'cancel') {
				
			}
			else {
				$attrs = $openid->getAttributes();
				$_SESSION['USER'] = $attrs['namePerson/friendly'];
				header('Location:' . '?user=' . $attrs['namePerson/friendly']);
			}
		} catch(ErrorException $e) {
			
		}	
	}

	function showAddButton($label, $class) {
		return <<<ADD_BUTTON
		<div class="col-md-2" style="margin: 0 15px">
			<button class="add-$class btn btn-default">Add $label</button><br><br>
			<button class="delete-$class btn btn-danger">Delete $label</button>
		</div>
ADD_BUTTON;
	}

	function showNewPosition() {
		return <<<NEW_POSITION
		<div class="position-template col-md-2" style="border: 1px solid #e1e1e8; border-radius: 4px; margin: 0 15px">
			<div class="form-group">
				<label for="position-name-0">Position Name</label>
				<input type="text" class="form-control" id="position-name-0">
			</div>
			<div class="form-group">
				<label for="position-slot-0">Number of slot</label>
				<input type="text" class="form-control" id="position-slot-0">
			</div>
			<div class="form-group">
				<label for="position-voter-0">Who can vote</label>
				<select class="form-control" id="position-voter-0">
					<option value="-">All Residents</option>
					<option value="A">A Block</option>
					<option value="B">B Block</option>
					<option value="C">C Block</option>
					<option value="D">D Block</option>
					<option value="E">E Block</option>
				</select>
			</div>
		</div>
NEW_POSITION;
	}

	function showNewCandidate() {
		return <<<NEW_CANDIDATE
		<div class="candidate-template col-md-2" style="border: 1px solid #e1e1e8; border-radius: 4px; margin: 0 15px; overflow: hidden;">
			<div style="margin: 5px">
				<img src="includes/image/default.jpg" alt="Profile Image" width=150 height=150>
			</div>
			<div class="form-group">
				<label for="candidate-matric-0-0">Candidate Matric</label>
				<input type="text" class="form-control" id="candidate-matric-0-0">
			</div>
			<div class="form-group">
			    <label for="candidate-photo-0-0">Upload photo</label>
			    <input type="file" id="candidate-photo-0-0">
			</div>
		</div>
NEW_CANDIDATE;
	}

	function showCandidateRow() {
		$candidate = showNewCandidate();
		$addButton = showAddButton("Candidate", "candidate");
		$output = <<<CANDIDATE_ROW
		<div class="candidate-row-template" id="position-0">
			<hr>
			<div class="row">
				<h3 id="position-header-0" style="text-align: center"></h3>
			</div>
			<div class="row">
				$candidate
				$addButton
			</div>
			<hr>
		</div>
CANDIDATE_ROW;
		
		return $output;
	}

	function showNewSession() {
		$output = <<<NEW_SESSION
		<div class="row">
			<div class="col-md-12">
				<form method=POST>
					<div class="row">
						<div class="form-group col-md-6">
						    <label for="session-name">Session Name</label>
						    <input type="text" class="form-control" id="session-name" placeholder="Enter session name">
						</div>
					</div>
						
					<p class="help-block">Election session submission open and close date.</p>
					<div class="row">
						<div class="form-group col-md-4">
							<label for="open-date">Open Date</label>
						  	<div class="input-group date" id="startDate">
							  	<input type="text" class="form-control" id="open-date" name="startDate">
							  	<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-md-4 col-md-offset-1">
							<label for="close-date">Close Date</label>
						  	<div class="input-group date" id="endDate">
						  		<input type="text" class="form-control" id="close-date" name="endDate">
						  		<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						  	</div>
						</div>
					</div>
					<p class="help-block">Add New Position</p>
					<div class="position-list row">
NEW_SESSION;
		
		$output .= showNewPosition();
		$output .= showAddButton("Position", "position");
		$output .= "</div>";

		$output .= showCandidateRow();
		$output .= <<<NEW_SESSION
					</div>
					<input type="submit" class="btn btn-default" name="newSession" value="Submit">
				</form>
			</div>
		</div>
NEW_SESSION;

		return $output;
	}

?>