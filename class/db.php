<?php 

	function db_connection() {
		$servername = "servername";
		$database="database";
		$username="username";
		$password="password";
		$con = mysql_connect($servername,$username,$password);
		if (!$con)
		{   
			die("Connection failed: " . mysqli_connect_error());
		}
		return $con;
	}

	//INSERTION
	function insert_resident($r_matric, $r_name, $r_room, $r_photo){
		$con = db_connection();
		mysql_select_db(database, $con);

		$query = "INSERT INTO " . resident . "(r_matric, r_name, r_room, r_photo) VALUES ($r_matric, $r_name, $r_room, $r_photo)";
		$result = mysql_query($query);

		mysql_close($con);

		if ($result) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function insert_session($s_id, $s_name, $s_opendate, $s_closedate){
		$con = db_connection();
		mysql_select_db(database, $con);

		$query = "INSERT INTO " . session . "(s_id, s_name, s_opendate, s_closedate) VALUES ($s_id, $s_name, $s_opendate, $s_closedate)";
		$result = mysql_query($query);

		mysql_close($con);

		if ($result) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function election_position($p_id, $s_id, $p_slot, $p_name){
		$con = db_connection();
		mysql_select_db(database, $con);

		$query = "INSERT INTO " . election_position . "(p_id, s_id, p_slot, p_name) VALUES ($p_id, $s_id, $p_slot, $p_name)";
		$result = mysql_query($query);

		mysql_close($con);

		if ($result) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function election_position_candidate($p_id, $c_matric){
		$con = db_connection();
		mysql_select_db(database, $con);

		$query = "INSERT INTO " . position_candidate . "(p_id, c_matric) VALUES ($p_id, $c_matric)";
		$result = mysql_query($query);

		mysql_close($con);

		if ($result) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function insert_statistics($p_id, $c_matric, $r_matric, $st_vote){
		$con = db_connection();
		mysql_select_db(database, $con);

		$query = "INSERT INTO " . statistics . "(p_id, c_matric, r_matric, st_vote) VALUES ($p_id, $c_matric, $r_matric, $st_vote)";
		$result = mysql_query($query);

		mysql_close($con);

		if ($result) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	//RETRIEVE
	function get_resident($r_matric){
		$con = db_connection();
		mysql_select_db(database, $con);

		$query = "SELECT * FROM " . resident . "WHERE r_matric = $r_matric" ;
		$result = mysql_query($query);

		mysql_close($con);

		if ($result) {
			$result = mysql_fetch_array($result);
			return $result;
		} else {
			return NULL;
		}

	}
	
	function get_session($s_id){
		$con = db_connection();
		mysql_select_db(database, $con);

		$query = "SELECT * FROM " . session . "WHERE s_id = $s_id" ;
		$result = mysql_query($query);

		mysql_close($con);

		if ($result) {
			$result = mysql_fetch_array($result);
			return $result;
		} else {
			return NULL;
		}

	}

	function get_election_position($s_id, $p_id){
		$con = db_connection();
		mysql_select_db(database, $con);

		$query = "SELECT * FROM " . election_position . "WHERE s_id = $s_id and p_id = $p_id" ;
		$result = mysql_query($query);

		mysql_close($con);

		if ($result) {
			$result = mysql_fetch_array($result);
			return $result;
		} else {
			return NULL;
		}

	}

	function get_position_candidate($p_id, $c_matric){
		$con = db_connection();
		mysql_select_db(database, $con);

		$query = "SELECT * FROM " . position_candidate . "WHERE p_id = $p_id and c_matric = $c_matric" ;
		$result = mysql_query($query);

		mysql_close($con);

		if ($result) {
			$result = mysql_fetch_array($result);
			return $result;
		} else {
			return NULL;
		}
	}

	function statictics($p_id, $c_matric){
		$con = db_connection();
		mysql_select_db(database, $con);

		$query = "SELECT * FROM " . statistics . "WHERE p_id = $p_id and c_matric = $c_matric" ;
		$result = mysql_query($query);

		mysql_close($con);

		if ($result) {
			$result = mysql_fetch_array($result);
			return $result;
		} else {
			return NULL;
		}
	}
?>
