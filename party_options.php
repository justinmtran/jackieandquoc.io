<?php 
	require_once "config.php"; 
	require_once "modules.php";

	if( isset( $_POST['passcode'] ) ) {
		$passcode = $_POST['passcode']; 
        echo getPartyOptions($passcode);     
	}
?>