
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
		
		$dropdown = "<select class='form-control' name='relationship'>"; 
		$query = "SELECT REL.RelationshipId, REL.Description 
					FROM Relationship AS REL
					INNER JOIN RelationshipType AS RELTYPE ON RELTYPE.RelationshipTypeId = REL.RelationshipTypeId 
					WHERE RELTYPE.Description = 'Attendee'";
		$result = mysqli_query($conn, $query); 
		
		$dropdown .= "<option disabled selected>Your Relationship to Couple*</option>"; 
		while($row = mysqli_fetch_array($result)){
			$dropdown .= "<option value='" . $row["RelationshipId"] . "'>" . $row["Description"] . "</option>";
		}
		$dropdown .= "</select>"; 
		
		$conn->close(); 

		return $dropdown; 
	}
	
	function getAttendingStatusDropdown($attendingStatusId = 0){
		$conn = createConnection(); 
		
		$dropdown = "<select class='form-control' name='attendstatus'>"; 
		$query = "SELECT AttendingStatusId, Description FROM AttendingStatus";
		$result = mysqli_query($conn, $query); 
		
		if($attendingStatusId < 1)
			$dropdown .= "<option disabled selected>Are you attending? *</option>"; 

		while($row = mysqli_fetch_array($result)){
			if($attendingStatusId == $row["AttendingStatusId"])
				$dropdown .= "<option value='" . $row["AttendingStatusId"] . "' selected>" . $row["Description"] . "</option>";
			else 
				$dropdown .= "<option value='" . $row["AttendingStatusId"] . "'>" . $row["Description"] . "</option>";
		}

		$dropdown .= "</select>";
		$conn->close(); 

		return $dropdown; 
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
		$conn = createConnection(); 

		$dropdown .= "<select class='form-control' name='formstatus'>";
		$query = "SELECT FS.FormStatusId AS FormStatusId, Description FROM Form AS F INNER JOIN FormStatus AS FS ON FS.FormStatusId = F.FormStatusId WHERE F.FormId = " . $formId;
		$result = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_array($result)){
			if($row["FormStatusId"] == $formStatusId)
				$dropdown .= "<option value='" . $row["FormStatusId"] . "' selected>" . $row["Description"] . "</option>"; 
			else
				$dropdown .= "<option value='" . $row["FormStatusId"] . "'>" . $row["Description"] . "</option>"; 
		}
		$dropdown .= "</select>";

		$conn->close(); 
		return $dropdown; 
	}

	function getMealTypeDropdown($mealId = 0){
		$conn = createConnection();

		$query = "SELECT MealId, Description FROM Meal"; 
		$result = mysqli_query($conn, $query); 
		
		$dropdown = "<select class='form-control' name='mealtype'>"; 
		
		if($mealId < 1)
			$dropdown .= "<option disabled selected>Meal Choice not selected*</option>";

		while($row = mysqli_fetch_array($result)){
			if($mealId == $row["MealId"])
				$dropdown .= "<option selected value='" . $row["MealId"] . "'>" . $row["Description"] . "</option>"; 
			else
				$dropdown .= "<option value='" . $row["MealId"] . "'>" . $row["Description"] . "</option>"; 
		}
		$dropdown .= "</select>"; 

		$conn->close(); 
		return $dropdown; 
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
				$body .= "<tr style='background-color:" .  $colors[$count] . ";color: white;'>"; 
				$body .= "<td><span>" . $row["FirstName"] . "</span></td>"; 
				$body .= "<td><span>" . $row["LastName"] . "</span></td>"; 
				$body .= "<td><span>" . $row["PlusOne"] . "</span></td>"; 
				$body .= "<td><span>" . $row["Relation"] . "</span></td>"; 
				$body .= "</tr>"; 

				if($row["PlusOne"] == "Has Plus One"){
					$body .= "<tr style='background-color:" . $colors[$count] . ";color:white;'>";  
					$body .= "<td><span>" . $row["PlusOneFirstName"] . "</span></td>"; 
					$body .= "<td><span>" . $row["PlusOneLastName"] . "</span></td>"; 
					$body .= "<td></td>"; 
					$body .= "<td><span>" . $row["PlusOneRelation"] . "</span></td>"; 
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

	function getPartyOptions($passcode){
		$conn = createConnection(); 
		$count = 0; 

		$query = "CALL GetPartyOptions('" . $passcode . "')";
		$result = mysqli_query($conn, $query);

		$body = ""; 

		while($row = mysqli_fetch_array($result)){
			$body .= "<tr>"; 
			$body .= "<td hidden>" . $row["AttendeeInformationId"] . "</td>"; 
			$body .= "<td><span style='padding: 8px;'> " . $row["FirstName"] . "</span></td>"; 
			$body .= "<td><span style='padding: 8px;'> " .$row["LastName"] . "</span></td>"; 

			if(isset($row["AttendingStatusId"]))
				$body .= "<td>" . getAttendingStatusDropdown($row["AttendingStatusId"]) . "</td>"; 
			else
				$body .= "<td>" . getAttendingStatusDropdown() . "</td>"; 

			if(isset($row["MealId"]))
				$body .= "<td>" . getMealTypeDropdown($row["MealId"]) . "</td>";
			else
				$body .= "<td>" . getMealTypeDropdown() . "</td>";

			$body .= "</tr>"; 
		}

		$conn->close();
		
		return $body; 
	}

	// 'message' column in attendee table. 
	function getDietaryRestrction($passcode){
		$conn = createConnection(); 

		$query = "
			SELECT Message 
			FROM Form AS F 
			INNER JOIN Attendee AS A ON A.AttendeeId = F.AttendeeId
			WHERE F.Passcode = UPPER('" . $passcode . "')";
		
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result);

		$conn->close();

		return $row["Message"]; 
	}

	// return main attendee Id
	function getAttendeeId($passcode){
		$conn = createConnection(); 

		$query = "
			SELECT AttendeeId 
			FROM Form
			WHERE Passcode = UPPER('" . $passcode . "')";
		
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result);

		$conn->close();

		return $row["AttendeeId"]; 
	}
	
	function addAttendee($first, $last, $phone, $email, $relationshipId){	
		try{
			$conn = createConnection();  

			$attendeeId = 0; 

			$call = mysqli_prepare($conn, "CALL AddAttendee(?,?,?,?,?, @attendeeId)"); 
			mysqli_stmt_bind_param($call, "ssssi", $first, $last, $phone, $email, $relationshipId); 
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
	
	function pendRSVP($formId){
		error_log("pending RSVP for form no. " . $formId); 

		$conn = createConnection(); 
		
		$call = mysqli_prepare($conn, "CALL PendRSVP(?)"); 
		mysqli_stmt_bind_param($call, "i", $formId);  
		mysqli_stmt_execute($call); 
		
		$conn->close(); 	
		
		error_log("RSVP for attendee no. " . $formId . " have been sent to pending."); 	
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

	function updateMeal($mealId, $attendeeInformationId){
		error_log("updating meal choice for attendeeInfoId " . $attendeeInformationId); 
		
		$conn = createConnection(); 
		
		$call = mysqli_prepare($conn, "UPDATE AttendeeInformation SET MealId = ? WHERE AttendeeInformationId = ?"); 
		mysqli_stmt_bind_param($call, "ii", $mealId, $attendeeInformationId);  
		mysqli_stmt_execute($call); 
		
		$conn->close(); 
		
		error_log("updated meal choice for attendeeInfoId " . $attendeeInformationId); 
	}

	function updateAttendingStatus($attendingStatusId, $attendeeInformationId){
		error_log("updating attending status for attendeeInfoId " . $attendeeInformationId); 
		
		$conn = createConnection(); 
		
		$call = mysqli_prepare($conn, "UPDATE AttendeeInformation SET AttendingStatusId = ? WHERE AttendeeInformationId = ?"); 
		mysqli_stmt_bind_param($call, "ii", $attendingStatusId, $attendeeInformationId);  
		mysqli_stmt_execute($call); 
		
		$conn->close(); 
		
		error_log("updated attending status for attendeeInfoId " . $attendeeInformationId); 
	}

	function updateDietaryRestriction($attendeeId, $dietaryRestriction){
		error_log("updating dietary restriction for attendeeId " . $attendeeId); 
		
		$conn = createConnection(); 
		
		$call = mysqli_prepare($conn, "UPDATE Attendee SET Message = ? WHERE AttendeeId = ?"); 
		mysqli_stmt_bind_param($call, "si", $dietaryRestriction, $attendeeId);  
		mysqli_stmt_execute($call); 
		
		$conn->close(); 
		
		error_log("updated dietary restriction for attendeeId " . $attendeeId); 
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

	function validatePasscode($passcode){
		$conn = createConnection(); 
		$query = "SELECT * FROM Form WHERE Passcode = '$passcode'"; 

		$result = mysqli_query($conn, $query); 

		if(mysqli_num_rows($result) == 1){
			$conn->close(); 
			return true; 
		}
		else{
			$conn->close(); 
			return false; 
		}
	}
?>