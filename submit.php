<?php 
	require "config.php"; 
	require "modules.php"; 

	$list = $_POST["guest"];

	$attendeeId = addAttendee(
		$_POST["first"],  
		$_POST["last"], 
		$_POST["phone"],
		$_POST["email"], 
		$_POST["relationship"]
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
			(!empty($guest["GuestRelation"])) ? $guest["GuestRelation"] : null,
			(!empty($guest["PlusOneType"])) ? $guest["PlusOneType"] : null, 
			$attendeeId, 
			$plusOneId 
		); 
	}
	
	createRSVP($attendeeId); 
?>