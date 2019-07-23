<?php 
	require "config.php"; 
	require "modules.php"; 

	$list = $_POST["guest"];

	$attendeeId = addAttendee(
		$_POST["first"],  
		$_POST["last"], 
		$_POST["phone"],
		$_POST["email"], 
		$_POST["attendstatus"],
		$_POST["relationship"],
		$_POST["message"]
	);

	foreach($list as $guest){
		$plusOneId = null; 
		if(!empty($guest["PlusOneRelation"])){
			$plusOneId = addPlusOne(
				$guest["PlusOneFirst"],
				$guest["PlusOneLast"],
				$guest["PlusOneRelation"],
				$attendeeId
			); 
		}
		
		addGuest(
			$guest["GuestFirst"],
			$guest["GuestLast"],
			$guest["GuestRelation"],
			$guest["PlusOneType"], 
			$attendeeId, 
			$plusOneId 
		); 
	}
	
	createRSVP($attendeeId); 
?>