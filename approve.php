<?php 
	require_once "config.php"; 
	require_once "modules.php";

	error_log($_POST['formId']); 
	if( isset( $_POST['formId'] ) ) {
		$formId = $_POST['formId']; 
		approveRSVP($formId); 
	}
?>