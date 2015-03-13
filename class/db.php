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

		//INSERTION (ALL PASSED)
		function insert_resident($r_matric, $r_name, $r_room, $r_photo){
			$stmt = $this->con->prepare("INSERT INTO resident (r_matric, r_name, r_room, r_photo) VALUES (?, ?, ?, ?)");
			$stmt->bind_param('ssss',$r_matric, $r_name, $r_room, $r_photo);
			$sql = "INSERT INTO resident (r_matric, r_name, r_room, r_photo) VALUES ('$r_matric', '$r_name', '$r_room', '$r_photo')";

			if ($stmt->execute()) {
				echo "New resident created successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}
		}

		function insert_session($s_id, $s_name, $s_opendate, $s_closedate){
			$stmt = $this->con->prepare("INSERT INTO session (s_id, s_name, s_opendate, s_closedate) VALUES (?, ?, ?, ?)");
			$stmt->bind_param('ssss',$s_id, $s_name, $s_opendate, $s_closedate);
			$sql = "INSERT INTO session (s_id, s_name, s_opendate, s_closedate) VALUES ('$s_id', '$s_name', '$s_opendate', '$s_closedate')";

			if ($stmt->execute()) {
				echo "New session created successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}
		}

		function insert_election_position($p_id, $s_id, $p_slots, $p_name){
			$stmt = $this->con->prepare("INSERT INTO election_position (p_id, s_id, p_slots, p_name) VALUES (?, ?, ?, ?)");
			$stmt->bind_param('isis',$p_id, $s_id, $p_slots, $p_name);
			$sql = "INSERT INTO election_position (p_id, s_id, p_slots, p_name) VALUES ('$p_id', '$s_id', '$p_slots', '$p_name')";
		
			if ($stmt->execute()) {
				echo "New election position created successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}
			
		}

		function insert_position_candidate($p_id, $c_matric){
			$stmt = $this->con->prepare("INSERT INTO position_candidate (p_id, c_matric) VALUES (?, ?)");
			$stmt->bind_param('ss',$p_id, $c_matric);
			$sql = "INSERT INTO position_candidate (p_id, c_matric) VALUES ('$p_id', '$c_matric')";

			if ($stmt->execute()) {
				echo "New election position candidate created successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}
		}

		function insert_statistics($p_id, $c_matric, $r_matric, $st_vote){
			$stmt = $this->con->prepare("INSERT INTO  statistics (p_id, c_matric, r_matric, st_vote) VALUES (?, ?, ?, ?)");
			$stmt->bind_param('issi',$p_id, $c_matric, $r_matric, $st_vote);
			$sql = "INSERT INTO  statistics (p_id, c_matric, r_matric, st_vote) VALUES ('$p_id', '$c_matric', '$r_matric', '$st_vote')";

			if ($stmt->execute()) {
				echo "New statistics created successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}
		}

		//SELECT		
		function select_session_position($s_id){
			$stmt = $this->con->prepare("SELECT p_id FROM election_position WHERE s_id = ?");
			$stmt->bind_param('s',$s_id);
			$sql = "SELECT * FROM election_position WHERE s_id = '$s_id'" ;
			$result = $stmt->execute();
			$positions = array();

			if($result){
				$stmt->store_result();
				echo "Number of rows: ", $stmt->num_rows, "<br>" ;
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}

			return $positions;
			
		}

		function select_position_candidate(){
		}

		//DELECT
		function delete_resident_statistics($r_matric){
			$stmt = $this->con->prepare("DELETE FROM statistics WHERE r_matric = ?");
			$stmt->bind_param('s', $r_matric);
			$sql = "DELETE FROM statistics WHERE r_matric = '$r_matric'" ;

			if ($stmt->execute()) {
				echo "statistics " . $r_matric . " deleted successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}
		
		function delete_candidate_statistics($c_matric){
			$stmt = $this->con->prepare("DELETE FROM statistics WHERE c_matric = ?");
			$stmt->bind_param('s', $c_matric);
			$sql = "DELETE FROM statistics WHERE c_matric = '$c_matric'" ;

			if ($stmt->execute()) {
				echo "statistics " . $c_matric . " deleted successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}

		function delete_statistics($p_id, $c_matric, $r_matric){
			$stmt = $this->con->prepare("DELETE FROM statistics WHERE p_id = ? and c_matric = ? and r_matric = ?");
			$stmt->bind_param('iss', $p_id, $c_matric, $r_matric);
			$sql = "DELETE FROM statistics WHERE p_id = $p_id and c_matric = '$c_matric' and r_matric = '$r_matric'" ;

			if ($stmt->execute()) {
				echo "statistics deleted successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}

		function delete_resident_candidate($r_matric){
			$this->delete_candidate_statistics($r_matric);
			$stmt = $this->con->prepare("DELETE FROM position_candidate WHERE c_matric = ?");
			$stmt->bind_param('s', $r_matric);
			$sql = "DELETE FROM position_candidate WHERE r_matric = '$r_matric'" ;

			if ($stmt->execute()) {
				echo "statistics " . $r_matric . " deleted successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}

		function delete_position_candidate($p_id){
			$stmt = $this->con->prepare("DELETE FROM position_candidate WHERE p_id = ?");
			$stmt->bind_param('i', $p_id);
			$sql = "DELETE FROM position_candidate WHERE p_id = '$p_id'";

			if ($stmt->execute()) {
				echo "position candidate  " . $p_id . " deleted successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}

		function delete_resident($r_matric){
			$this->delete_resident_statistics($r_matric);
			$this->delete_resident_candidate($r_matric);
			$stmt = $this->con->prepare("DELETE FROM resident WHERE r_matric = ?");
			$stmt->bind_param('s', $r_matric);
			$sql = "DELETE FROM  resident WHERE r_matric = '$r_matric'";

			if ($stmt->execute()) {
				echo "resident " . $r_matric . " deleted successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}

		}

		function delete_session_position($s_id){
			$positions = $this->select_session_position($s_id);
			$stmt = $this->con->prepare("DELETE FROM election_position WHERE s_id = ?");
			$stmt->bind_param('s', $s_id);
			$sql = "DELETE FROM election_position WHERE s_id = '$s_id'" ;

			if ($stmt->execute()) {
				echo "election position " . $s_id . " deleted successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}

		function delete_election_position($s_id, $p_id){
			$stmt = $this->con->prepare("DELETE FROM election_position WHERE s_id = ? and p_id = ?");
			$stmt->bind_param('ss', $s_id, $p_id);
			$sql = "DELETE FROM election_position WHERE s_id = '$s_id' and p_id = '$p_id'" ;

			if ($stmt->execute()) {
				echo "election position " . $p_id . " deleted successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}
		
		function delete_session($s_id){
			$stmt = $this->con->prepare("DELETE FROM resident WHERE r_matric = ?");
			$stmt->bind_param('s', $r_matric);

			$sql = "DELETE FROM session WHERE s_id = '$s_id'" ;

			if ($con->query($sql)) {
				echo "session " . $s_id . " deleted successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}

		}



		//UPDATE
		function update_resident($r_matric, $r_name, $r_room, $r_photo){
			$sql = "UPDATE resident 
					SET r_matric = '$r_matric', r_name = '$r_name', r_room = '$r_room', r_photo = '$r_photo'
					WHERE r_matric = '$r_matric'";

			if ($this->con->query($sql)) {
				echo "New resident updated successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}
		}

		function update_session($s_id, $s_name, $s_opendate, $s_closedate){
			$sql = "UPDATE session
					SET s_id = '$s_id', s_name = '$s_name', s_opendate = '$s_opendate', s_closedate = '$s_closedate'
					WHERE s_id = '$s_id'";

			if ($this->con->query($sql)) {
				echo "New session updated successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}
		}

		function update_election_position($p_id, $s_id, $p_slot, $p_name){
			$sql = "UPDATE election_position 
					SET p_id = '$p_id', s_id = '$s_id', p_slot = '$p_slot', p_name = '$p_name' 
					WHERE p_id = '$p_id'";

			if ($this->con->query($sql)) {
				echo "New election position updated successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}
		}

		function update_election_position_candidate($p_id, $c_matric){
			$sql = "UPDATE position_candidate 
					SET p_id = '$p_id', c_matric = '$c_matric'
					WHERE c_matric = '$c_matric' and p_id = '$p_id'";

			if ($this->con->query($sql)) {
				echo "New election position candidate created successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}
		}

		function update_statistics($p_id, $c_matric, $r_matric, $st_vote){
			$sql = "UPDATE  statistics 
					SET p_id = '$p_id', c_matric = '$c_matric', r_matric = '$r_matric', st_vote = '$st_vote'
					WHERE p_id = '$p_id', c_matric = '$c_matric', r_matric = '$r_matric'";

			if ($this->con->query($sql)) {
				echo "New statistics created successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}
		} 			
	}

	
?>
