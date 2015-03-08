<?php 
	require_once('includes/templates.php');
	
	if (session_status() == PHP_SESSION_NONE) {
    	session_start();
	}

	if(isset($_GET['user'])) {
		echo($_GET['user']);
		echo($_SESSION['USER']);
	}
	else if(isset($_POST['login']) && $_POST['login'] == 'admin') {
		echo showPage(showNewSession());
	}
	else {
		processLogin();
		echo showPage(showLogin());
	}
?>