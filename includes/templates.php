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
				<link rel="stylesheet" type="text/css" href="includes/css/bootstrap.min.css">
				<script src="includes/js/jquery-2.1.3.min.js"></script>
				<script src="includes/js/bootstrap.min.js"></script>
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
								<button class="btn btn-default"><span style="font-size:20px">Login with NUS OpenID</span></button>
							</div>
						</form>
					</div>
					<div role="tabpanel" class="tab-pane" id="admin">
						<form class="form-inline" action="" method=POST>
							<div style="text-align:center; margin: 20px">
								<div class="form-group">
									<label class="sr-only" for="pwd">Password</label>
									<input class="form-control" id="pwd" type="password" placeholder="Password">
								</div>
								<button type="submit" class="btn btn-default">Login</button>
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

	function showNewSession() {

	}

?>