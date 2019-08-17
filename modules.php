
<?php
	require_once "config.php";	

	$servername = SERVER_NAME; 
	$username = USER_NAME; 
	$password = PASSWORD; 
	$dbname = DATABASE_NAME; 

	// ajax request for php function calls. 
	if(isset($_POST['functionName']) && !empty($_POST['functionName'])){
		$functionName = $_POST['functionName']; 
		switch($functionName){
			case 'getPlusOneRelationOptions': echo getPlusOneRelationOptions(); break; 
			case 'getPlusOneTypeOptions' : echo getPlusOneTypeOptions(); break; 
		}
	}
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

	function getPlusOneRelationOptions(){
		$conn = createConnection(); 

		$query = "SELECT R.RelationshipId AS RelationshipId, R.Description AS Description FROM Relationship AS R 
					INNER JOIN RelationshipType AS RT ON RT.RelationshipTypeId = R.RelationshipTypeId
					WHERE RT.Description = 'PlusOne'"; 
		$result = mysqli_query($conn, $query); 

		$options = ""; 
		while($row = mysqli_fetch_array($result)){
			$options .= "<option value='" . $row["RelationshipId"] . "'>" . $row["Description"] . "</option>"; 
		}

		$conn->close(); 

		return $options; 
	}

	function getPlusOneTypeOptions(){
		$conn = createConnection(); 

		$query = "SELECT PlusOneTypeId, Description FROM PlusOneType"; 
		$result = mysqli_query($conn, $query); 

		$options = ""; 
		while($row = mysqli_fetch_array($result)){
			$options .= "<option value='" . $row["PlusOneTypeId"] . "'>" . $row["Description"] . "</option>"; 
		}

		$conn->close(); 
		return $options; 
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

	function getGuestList($formId){
		try{
			$conn = createConnection(); 

			$colors = ["rgb(123,104,238)", "rgb(152,251,152)", "rgb(240,128,128)",
					   "rgb(255,218,185)", "rgb(216,191,216)", "rgb(192,192,192)",
					   "rgb(160,224,208)", "rgb(0,255,255)", "rgb(255,250,205)"];
			$count = 0; 

			$query = "CALL GetGuestList(" . $formId . ")";
			$result = mysqli_query($conn, $query);

			$body .= "<tbody>"; 
			
			while($row = mysqli_fetch_array($result)){
				$body .= "<tr style='background-color:" .  $colors[$count] . ";'>"; 
				$body .= "<td><input type='text' style='text-align:center;' readonly='readonly' value='" . $row["FirstName"] . "'></td>"; 
				$body .= "<td><input type='text' style='text-align:center;' readonly='readonly' value='" . $row["LastName"] . "'></td>"; 
				$body .= "<td><input type='text' style='text-align:center;' readonly='readonly' value='" . $row["PlusOne"] . "'></td>"; 
				$body .= "<td><input type='text' style='text-align:center;' readonly='readonly' value='" . $row["Relation"] . "'></td>"; 
				$body .= "</tr>"; 

				if($row["PlusOne"] == "Has Plus One"){
					$body .= "<tr style='background-color:" . $colors[$count] . ";'>";  
					$body .= "<td><input type='text' style='text-align:center;' readonly='readonly' value='" . $row["PlusOneFirstName"] . "'></td>"; 
					$body .= "<td><input type='text' style='text-align:center;' readonly='readonly' value='" . $row["PlusOneLastName"] . "'></td>"; 
					$body .= "<td></td>"; 
					$body .= "<td><input type='text' style='text-align:center;' readonly='readonly' value='" . $row["PlusOneRelation"] . "'></td>"; 
					$body .= "</tr>"; 
				}
				
				$count++; 
				
			}
		
			$body .= "</tbody>"; 

			$conn->close();

			return $body; 
		}catch(Exception $e){
			error_log("caught exception: " . $e->getMessage()); 
		}
	}
	
	function addAttendee($first, $last, $phone, $email, $attendingStatusId, $relationshipId, $message){	
		try{
			$conn = createConnection();  

			$attendeeId = 0; 

			$call = mysqli_prepare($conn, "CALL AddAttendee(?,?,?,?,?,?,?, @attendeeId)"); 
			mysqli_stmt_bind_param($call, "ssssiis", $first, $last, $phone, $email, $attendingStatusId, $relationshipId, $message); 
			mysqli_stmt_execute($call); 

			$select = mysqli_query($conn, "SELECT @attendeeId"); 
			$result = mysqli_fetch_assoc($select); 

			$attendeeId = $result["@attendeeId"]; 

			$conn->close(); 
			return $attendeeId; 			
		}catch(Exception $e){
			error_log("caught exception: " . $e->getMessage()); 
		}	
	}

	function addGuest($first, $last, $relation, $plusOneType,  $attendeeId, $plusOneId){
		try{
			error_log("adding guest for attendeeId: " + $first + " to the database"); 
			$conn = createConnection(); 

			$call = mysqli_prepare($conn, "CALL AddGuest(?,?,?,?,?,?)"); 
			mysqli_stmt_bind_param($call, "ssiiii", $first, $last, $relation, $plusOneType, $attendeeId, $plusOneId); 
			mysqli_stmt_execute($call); 

			$conn->close(); 
			error_log("completed adding guest: " + $first + " to the database"); 
		}
		catch(Exception $e){
			error_log("caught exception: " . $e->getMessage()); 
		}
	}

	function addPlusOne($first, $last, $relationshipId, $attendeeId){
		try{
			error_log("adding plus one guest: " + $first + " to the database"); 
			$conn = createConnection();

			$plusOneId = 0; 

			$call = mysqli_prepare($conn, "CALL AddPlusOne(?,?,?,?,@plusOneId)"); 
			mysqli_stmt_bind_param($call, "ssii", $first, $last, $relationshipId, $attendeeId); 
			mysqli_stmt_execute($call); 

			$select = mysqli_query($conn, "SELECT @plusOneId"); 
			$result = mysqli_fetch_assoc($select); 

			$plusOneId = $result["@plusOneId"]; 

			$conn->close();
			error_log("completed adding plus one guest: " + $first + " to the database"); 

			return $plusOneId; 
		}
		catch(Exception $e){
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

	function validateCredentials($user, $pass){
		if(!empty($user) || !empty($pass)){
			$conn = createConnection(); 
			$query = "SELECT * FROM Account WHERE Username = '$user'"; 

			$result = mysqli_query($conn, $query); 

			// if username exist
			if(mysqli_num_rows($result) == 1){
				$row = $result->fetch_assoc();

			 	$id = $row["AccountId"]; 
			 	$hashed_password = $row["Password"]; 

				// verify password
			 	if($pass === $hashed_password){
			 		session_start(); 
	
				 	// Store data in session variables
				 	$_SESSION["loggedin"] = true;
				 	$_SESSION["id"] = $id;
				 	$_SESSION["user"] = $user;                            
						
				 	// Redirect user to welcome page
				 	header("location: admin.php");
				 }
				 else{
					 session_destroy(); 
				 }
			}
			$conn->close(); 
		}
	}
?>