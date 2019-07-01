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
		
		for($i = 0; $i <= $MAX_NUM_GUESTS; $i++){
			if($i < 2){
				echo "<option>" . $i . " Guest</option>"; 
			}
			else{
				echo "<option>" . $i . " Guests</option>"; 
			}
		}
		echo "</select>";		
	}
	
	function getFormStatusDropdown($formId){
		echo "<select class='form-control' name='formstatus'>";
		$query = "SELECT FS.FormStatusId AS FormStatusId, Description FROM Form AS F INNER JOIN FormStatus AS FS ON FS.FormStatusId = F.FormStatusId WHERE F.FormId = " . $formId;
		$result = mysqli_query($conn, $query); 
		
		while($row = mysqli_fetch_array($result)){
			if($row["FormStatusId"] = $formStatusId)
				echo "<option value='" . $row["FormStatusId"] . "' selected>" . $row["Description"] . "</option"; 
			else 
				echo "<option value='" . $row["FormStatusId"] . "'>" . $row["Description"] . "</option"; 
		}
	
	}
	
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
		
		error_log("RSVP for attendee no. " . $attendeeId . " have been created."); 		
	}
	
	function approveRSVP($formId){
		error_log("approving RSVP for form no. " . $formId); 
		
		$conn = createConnection(); 
		
		$call = mysqli_prepare($conn, "CALL ApproveRSVP(?)"); 
		mysqli_stmt_bind_param($call, "i", $formId);  
		mysqli_stmt_execute($call); 
		
		$conn->close(); 
		
		error_log("RSVP for attendee no. " . $formId . " have been approved."); 		
	}
	
	function denyRSVP($formId){
		error_log("denying RSVP for form no. " . $formId); 
		
		$conn = createConnection(); 
		
		$call = mysqli_prepare($conn, "CALL DenyRSVP(?)"); 
		mysqli_stmt_bind_param($call, "i", $formId);  
		mysqli_stmt_execute($call); 
		
		$conn->close(); 
		
		error_log("RSVP for attendee no. " . $formId . " have been denied."); 		
	}
	
	function deleteRSVP($formId){
		error_log("deleting RSVP for form no. " . $formId); 
		
		$conn = createConnection(); 
		
		$call = mysqli_prepare($conn, "CALL DeleteRSVP(?)"); 
		mysqli_stmt_bind_param($call, "i", $formId);  
		mysqli_stmt_execute($call); 
		
		$conn->close(); 
		
		error_log("RSVP for attendee no. " . $formId . " have been deleted."); 
	}
	
	function getGuestInformation($attendeeId){
		error_log("getting Guests for attendee no. " . $attendeeId); 
		
		$conn = createConnection(); 
		
		$call = mysqli_prepare($conn, "CALL GetGuests(?)"); 
		
		error_log("viewing guest information for attendee no. " . $attendeeId); 
	}
?>
