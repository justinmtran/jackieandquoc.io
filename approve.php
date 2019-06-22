<?php 
	require_once "config.php"; 
	require_once "module.php"; 

	if( isset( $_GET['id'] ) ) {
		$formId = $_GET['id']; 
		approveRSVP($formId); 
	}
?>