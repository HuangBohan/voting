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
		function select_all_positions($s_id){
			$stmt = $this->con->prepare("SELECT p_id FROM election_position WHERE s_id = ?");
			$stmt->bind_param('s',$s_id);
			if($stmt->execute()){
				$result = array();
				$stmt->bind_result($row);
    			
    			while ($stmt->fetch()) {
        			array_push($result, $row);
    			}

				return $result;
			}
			return array();
		}

		function select_all_candidates($p_id){
			$stmt = $this->con->prepare("SELECT c_matric FROM position_candidate WHERE p_id = ?");
			$stmt->bind_param('i',$p_id);
			if($stmt->execute()){
				$result = array();
				$stmt->bind_result($row);

    			while ($stmt->fetch()) {
        			array_push($result, $row);
    			}

				return $result;
			}
			return array();
		}

		function select_all_statistics($p_id,$c_matric){
			$stmt = $this->con->prepare("SELECT r_matric FROM statistics WHERE p_id = ?, c_matric = ?, st_vote = 1");
			$stmt->bind_param('is',$p_id, $c_matric);
			if($stmt->execute()){
				$result = array();
				$stmt->bind_result($row);

    			while ($stmt->fetch()) {
        			array_push($result, $row);
    			}

				return $result;
			}
			return array();
		}

		function get_votes_candidate($p_id, $c_matric){
			$stmt = $this->con->prepare("SELECT st_vote FROM statistics WHERE p_id = ? and c_matric = ? and st_vote = 1");
			$stmt->bind_param('is', $p_id, $c_matric);
			$sql = "SELECT st_vote FROM statistics WHERE p_id = $p_id and c_matric = $c_matric and st_vote = 1";
			if($stmt->execute()){
				$result = array();
				$stmt->bind_result($row);

    			while ($stmt->fetch()) {
        			array_push($result, $row);
    			}

				return count($result);
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
				return NULL;
			}
		}

		//DELECT
		/*
		function delete_all_resident_statistics($r_matric){
			$stmt = $this->con->prepare("DELETE FROM statistics WHERE r_matric = ?");
			$stmt->bind_param('s', $r_matric);
			$sql = "DELETE FROM statistics WHERE r_matric = '$r_matric'" ;

			if ($stmt->execute()) {
				echo "statistics " . $r_matric . " deleted successfully <br>";
			} else {
				
			}
		}
		*/
		function delete_all_candidate_statistics($p_id, $c_matric){
			$stmt = $this->con->prepare("DELETE FROM statistics WHERE $p_id = ? and c_matric = ?");
			$stmt->bind_param('is', $p_id, $c_matric);
			$sql = "DELETE FROM statistics WHERE p_id = $p_id and c_matric = '$c_matric'" ;

			if ($stmt->execute()) {
				echo "statistics deleted successfully <br>";
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
		/*
		function delete_resident_candidate($r_matric){
			$this->delete_all_candidate_statistics($r_matric);
			$stmt = $this->con->prepare("DELETE FROM position_candidate WHERE c_matric = ?");
			$stmt->bind_param('s', $r_matric);
			$sql = "DELETE FROM position_candidate WHERE r_matric = '$r_matric'" ;

			if ($stmt->execute()) {
				echo "statistics " . $r_matric . " deleted successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}
		*/
		function delete_all_candidates($p_id){
			$candidates = $this->select_all_candidates($p_id);
			foreach ($candidates as $key => $value) {
				$this->delete_all_candidate_statistics($p_id, $value);
			}
			$stmt = $this->con->prepare("DELETE FROM position_candidate WHERE p_id = ?");
			$stmt->bind_param('i', $p_id);
			$sql = "DELETE FROM position_candidate WHERE p_id = '$p_id'";

			if ($stmt->execute()) {
				echo "position candidate  " . $p_id . " deleted successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}

		function delete_position_candidate($p_id,$c_matric){
			$this->delete_all_candidate_statistics($p_id, $c_matric);
			$stmt = $this->con->prepare("DELETE FROM position_candidate WHERE p_id = ? and c_matric = ?");
			$stmt->bind_param('is', $p_id, $c_matric);
			$sql = "DELETE FROM position_candidate WHERE p_id = '$p_id' and c_matric = 'c_matric'";

			if ($stmt->execute()) {
				echo "position candidate  " . $c_matric . " deleted successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}
		}
		/*
		function delete_resident($r_matric){
			$this->delete_all_resident_statistics($r_matric);
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
		*/
		function delete_position($s_id, $p_id){
			$this->delete_all_candidate($p_id);
			$stmt = $this->con->prepare("DELETE FROM election_position WHERE s_id = ? and p_id = ?");
			$stmt->bind_param('si', $s_id, $p_id);
			$sql = "DELETE FROM election_position WHERE s_id = '$s_id' and p_id = '$p_id'" ;

			if ($stmt->execute()) {
				echo "election position " . $p_id . " deleted successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}

		function delete_all_positions($s_id){
			$positions = $this->select_all_positions($s_id);
			foreach ($positions as $key => $value) {
				$this->delete_all_candidates($value);
			}
			$stmt = $this->con->prepare("DELETE FROM election_position WHERE s_id = ?");
			$stmt->bind_param('s', $s_id);
			$sql = "DELETE FROM election_position WHERE s_id = '$s_id'" ;

			if ($stmt->execute()) {
				echo "election position " . $s_id . " deleted successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
		}
		/*
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
		*/
		function delete_session($s_id){
			$this->delete_all_positions($s_id);
			$stmt = $this->con->prepare("DELETE FROM session WHERE s_id = ?");
			$stmt->bind_param('s', $s_id);

			$sql = "DELETE FROM session WHERE s_id = '$s_id'" ;

			if ($stmt->execute()) {
				echo "session " . $s_id . " deleted successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}

		}


		
		//UPDATE
		/*
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
		*/
		/*
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
		*/
		function update_election_position($s_id, $old_p_id, $new_p_id, $p_slots, $p_name){
			$this->delete_position($s_id, $old_p_id);
			$this->insert_election_position($new_p_id,$s_id,$p_slots,$p_name);
		}

		function update_position_candidate($p_id, $old_c_matric, $new_c_matric){
			$this->delete_position_candidate($p_id,$old_c_matric);
			$this->insert_position_candidate($p_id,$new_c_matric);
		}

		function update_statistics($p_id, $c_matric, $r_matric, $new_st_vote){
			$this->delete_statistics($p_id, $c_matric, $r_matric);
			$this->insert_statistics($p_id, $c_matric, $r_matric, $new_st_vote);
			/*
			$sql = "UPDATE  statistics 
					SET st_vote = '$new_st_vote'
					WHERE p_id = '$p_id', c_matric = '$c_matric', r_matric = '$r_matric'";

			if ($this->con->query($sql)) {
				echo "New statistics updated successfully <br>";
			} else {
				echo "Error: " . $sql . "<br>" . $this->con->error;
			}
			*/
		} 			
	}

	
?>
