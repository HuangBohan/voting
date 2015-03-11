<?php 
	require_once('includes/templates.php');
	require_once('class/db.php');
	
	if (session_status() == PHP_SESSION_NONE) {
    	session_start();
	}

	if(isset($_SESSION['USER'])) {
		echo $_SESSION['USER'];
	}
	else if (isset($_SESSION['ADMIN'])) {
		if(isset($_POST['newSession']))
			echo showPage("Thanks for your submission");
		else
			echo showPage(showNewSession());	
	}
	else if(isset($_POST['adminLogin'])) {
		$_SESSION['ADMIN'] = true;
		header('Location: ' . HOST);
	}
	else {
		processLogin();
		echo showPage(showLogin());
	}
?>