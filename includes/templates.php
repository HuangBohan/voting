<?php 
	require_once __DIR__ . '/config.inc';
	require_once __DIR__ . '/../class/openid.php';

	if (session_status() == PHP_SESSION_NONE) {
    	session_start();
	}

	function showLogin()
	{
		$login = <<<LOGIN
			<form action="" method=POST>
				<input type="hidden" name="openid_identifier" value="https://openid.nus.edu.sg">
				<div style="text-align:center">
					<button class="btn btn-login"><span style="font-size:40px">Login with NUS OpenID</span></button>
				</div>
			</form>
LOGIN;
		return $login;
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
?>