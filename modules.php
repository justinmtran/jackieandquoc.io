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
		
		
		error_log("creating connection"); 
		// create connection 
		$conn = new mysqli($servername, $username, $password, $dbname); 

		// check connection
		if($conn->connect_error){
			die("Connection failed"); 
		}
		else{
			error_log("connection successful"); 
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
	
	// function addAttendeeInfo($first, $middle, $last, $phone, $email){
		// $conn = createConnection();  
	
		// $attendeeInfoId = 0; 
	
		// $call = mysqli_prepare($conn, "CALL AddAttendeeInformation(?,?,?,?,?, @attendeeInfoId)"); 
		// mysqli_stmt_bind_param($call, "sssis", $first, $middle, $last, $phone, $email);  
		// mysqli_stmt_execute($call); 

		// $select = mysqli_query($conn, "SELECT @attendeeInfoId"); 
		// $result = mysqli_fetch_assoc($select); 

		// $attendeeInfoId = $result["@attendeeInfoId"]; 

		// $conn->close(); 
		
		// return $attendeeInfoId; 
	// }
	
	function addAttendee($first, $middle, $last, $phone, $email, $attendingStatusId, $relationshipId, $message, $numOfGuests){
		error_log("adding attendee " . $first . "to the database"); 	
		
		try{
			$conn = createConnection();  

			$attendeeId = 0; 

			$call = mysqli_prepare($conn, "CALL AddAttendee(?,?,?,?,?,?,?,?,?, @attendeeId)"); 
			mysqli_stmt_bind_param($call, "sssisiisi", $first, $middle, $last, $phone, $email, $attendingStatusId, $relationshipId, $message, $numOfGuests);  
			mysqli_stmt_execute($call); 

			$select = mysqli_query($conn, "SELECT @attendeeId"); 
			$result = mysqli_fetch_assoc($select); 

			$attendeeId = $result["@attendeeId"]; 

			$conn->close(); 
			
			error_log("completed adding attendee " . $first . "to the database"); 

			return $attendeeId; 			
		}catch(Exception $e){
			error_log("caught exception: " . $e->getMessage()); 
		}
		
			
	}
	
	function createRSVP($attendeeId){	
		error_log("creating RSVP for attendee no. " . $attendeeId); 
		
		$conn = createConnection();  

		$call = mysqli_prepare($conn, "CALL CreateRSVP(?)"); 
		mysqli_stmt_bind_param($call, "i", $attendeeId);  
		mysqli_stmt_execute($call); 

		$conn->close();		
		
		error_log("completed RSVP for attendee no. " . $attendeeId); 		
	}
?>
