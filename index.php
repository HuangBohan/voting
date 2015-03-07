<?php 
	require_once('includes/templates.php');
	
	if (session_status() == PHP_SESSION_NONE) {
    	session_start();
	}

	if(isset($_GET['user'])) {
		echo($_GET['user']);
		echo($_SESSION['USER']);
	}
	else {
		processLogin();
		echo showPage(showLogin());
	}
?>