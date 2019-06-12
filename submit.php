<?php 
	require "config.php"; 
	require "modules.php";
	
	$attendeeId = addAttendee(
		$_POST["first"], 
		$_POST["middle"], 
		$_POST["last"], 
		$_POST["phone"],
		$_POST["email"], 
		$_POST["attendstatus"],
		$_POST["relationship"],
		$_POST["message"],
		$_POST["numofguest"]
	); 
	
	createRSVP($attendeeId); 
?>