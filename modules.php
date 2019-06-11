<?php	
	$servername = SERVER_NAME; 
	$username = USER_NAME; 
	$password = PASSWORD; 
	$dbname = DATABASE_NAME; 
	
	// constants 
	$MAX_NUM_GUESTS = 9; 
?>

<?php
	function createConnection(){
		global $servername;
		global $username; 
		global $password; 
		global $dbname;
		
		// create connection 
		$conn = new mysqli($servername, $username, $password, $dbname); 

		// check connection
		if($conn->connect_error){
			die("Connection failed"); 
		}
		else{
			return $conn; 
		}
	}
	
	function getRelationDropdown(){
		$conn = createConnection(); 
		
		echo "<select class='form-control' name='relationship'>"; 
		$query = "SELECT REL.RelationshipId, REL.Description 
					FROM Relationship AS REL
					INNER JOIN RelationshipType AS RELTYPE ON RELTYPE.RelationshipTypeId = REL.RelationshipTypeId 
					WHERE RELTYPE.Description = 'Attendee'";
		$result = mysqli_query($conn, $query); 
		
		echo "<option disabled selected>Your Relationship to Couple*</option>"; 
		while($row = mysqli_fetch_array($result)){
			echo "<option value='" . $row["RelationshipId"] . "'>" . $row["Description"] . "</option>";
		}
		echo "</select>"; 
		
		$conn->close(); 
	}
	
	function getAttendingStatusDropdown(){
		$conn = createConnection(); 
		
		echo "<select class='form-control' name='attendstatus'>"; 
		$query = "SELECT AttendingStatusId, Description FROM AttendingStatus";
		$result = mysqli_query($conn, $query); 
		
		echo "<option disabled selected>Are you attending? *</option>"; 
		while($row = mysqli_fetch_array($result)){
			echo "<option value='" . $row["AttendingStatusId"] . "'>" . $row["Description"] . "</option>";
		}
		echo "</select>";
		
		$conn->close(); 
	}
	
	function getNumOfGuestsDropdown(){
		global $MAX_NUM_GUESTS; 
		
		echo "<select class='form-control' name='numofguest'>";
		echo "<option value='0' disabled selected>Number Of Guest*</option>";
		
		for($i = 1; $i <= $MAX_NUM_GUESTS; $i++){
			if($i < 2){
				echo "<option>" . $i . " Guest</option>"; 
			}
			else{
				echo "<option>" . $i . " Guests</option>"; 
			}
		}
		echo "</select>";		
	}
?>
