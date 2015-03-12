<?php 
	require_once __DIR__ . '/../includes/config.inc';

	$db = new DB();

	class DB
	{
		private $con;
		//CONNECTION
		function __construct(){
			$this->con = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

			if ($this->con->connect_error){   
				die("Connection failed: " . $this->con->connect_error);
			}
		}

		//INSERTION
		function insert_resident($r_matric, $r_name, $r_room, $r_photo){
			$sql = "INSERT INTO resident (r_matric, r_name, r_room, r_photo) VALUES ('$r_matric', '$r_name', '$r_room', '$r_photo')";

			if ($this->con->query($sql)) {
				echo "New resident created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}
		}

		function insert_session($s_id, $s_name, $s_opendate, $s_closedate){
			$sql = "INSERT INTO session (s_id, s_name, s_opendate, s_closedate) VALUES ($s_id, $s_name, $s_opendate, $s_closedate)";

			if ($con->query($sql) === TRUE) {
				echo "New session created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}

		function election_position($p_id, $s_id, $p_slot, $p_name){
			$sql = "INSERT INTO election_position (p_id, s_id, p_slot, p_name) VALUES ($p_id, $s_id, $p_slot, $p_name)";

			if ($con->query($sql) === TRUE) {
				echo "New election position created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}

		function election_position_candidate($p_id, $c_matric){
			$sql = "INSERT INTO position_candidate (p_id, c_matric) VALUES ($p_id, $c_matric)";

			if ($con->query($sql) === TRUE) {
				echo "New election position candidate created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}

		function insert_statistics($p_id, $c_matric, $r_matric, $st_vote){
			$sql = "INSERT INTO  statistics (p_id, c_matric, r_matric, st_vote) VALUES ($p_id, $c_matric, $r_matric, $st_vote)";

			if ($con->query($sql) === TRUE) {
				echo "New statictics created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}
		//RETRIEVE
		function get_resident($r_matric){
			$sql= "SELECT * FROM  resident WHERE r_matric = $r_matric";

			if ($con->query($sql) === TRUE) {
				echo "resident " . $r_matric . " got successfully";
			} else {
				return NULL;
			}

		}
		
		function get_session($s_id){
			$sql = "SELECT * FROM session WHERE s_id = $s_id" ;

			if ($con->query($sql) === TRUE) {
				echo "session " . $s_id . " got successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}

		}

		function get_election_position($s_id, $p_id){
			$sql = "SELECT * FROM election_position WHERE s_id = $s_id and p_id = $p_id" ;

			if ($con->query($sql) === TRUE) {
				echo "election position " . $p_id . " got successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}

		}

		function get_position_candidate($p_id, $c_matric){
			$sql = "SELECT * FROM position_candidate WHERE p_id = $p_id and c_matric = $c_matric" ;

			if ($con->query($sql) === TRUE) {
				echo "position candidate  " . $c_matric . " got successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}

		function get_statictics($p_id, $c_matric){
			$sql = "SELECT * FROM statistics WHERE p_id = $p_id and c_matric = $c_matric" ;

			if ($con->query($sql) === TRUE) {
				echo "statistics " . $p_id . " got successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}	
	}

	
?>
