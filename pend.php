<?php 
	require_once "config.php"; 
	require_once "modules.php";

	if( isset( $_POST['formId'] ) ) {
		$formId = $_POST['formId']; 
		pendRSVP($formId); 
	}
?>